<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\Organization;
use App\Team;
use DB;

class AdminsController extends Controller
{

	/*Add New Admin*/
	public function add_admin()
	{
		$data['orgs'] = DB::table('organizations')->get()->all();
		return view('super_admin.add_admin', $data);
	}

	/**/
	public function add_new_admin(Request $request)
	{
		$messages = [
	    'required' => ling('the').' :attribute '.ling('required_field_msg'),
	   ];
		$this->validate($request, [
        'name'      => 'required',
        'email'     => 'required',
        'gender'     => 'required',
        'country_id'     => 'required',
        'region_id'     => 'required',
        'city'     => 'required',
        'password'     => 'required',
        'c_password'     => 'required|same:password',
        'orgs'		=> 'required'
        ], $messages);

		$filename = '';
		if(!empty($request->file('user_image')))
		{
			$image = $request->file('user_image');
			$filename = time().'.'.$image->getClientOriginalExtension();
     	$image->move(public_path('web/assets/uploads/user_images'), $filename);
		}

		$user = new User;
		$user->uuid = strtoupper(uniqid('USR_'));
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->gender = $request->gender;
		$user->date_of_birth = $request->date_of_birth;
		$user->country_id = $request->country_id;
		$user->region_id = $request->region_id;
		$user->city = $request->city;
		$user->profile_image = $filename;
		
		if($user->save())
		{
			$role = DB::table('roles')->where('role_name', '=', 'admin')->select('id')->get()->first();
			DB::table('user_roles')->insert(array('user_id' => $user->id, 'role_id' => $role->id));

			$teams = array();
			foreach ($request->orgs as $key => $org) 
			{
				$data_org = array(
					'user_id' => $user->id,
					'org_id'  => $org
				);
				DB::table('admin_to_orgs')->insert($data_org);

				$teams = Team::where('org_id', '=', $org)->select('id')->get();
				foreach ($teams as $key => $team) 
				{
					$data_team = array(
						'user_id'  => $user->id,
						'org_id'   => $org,
						'team_id'  => $team->id
					);
					DB::table('admin_to_teams')->insert($data_team);
				}
			}
		}	

		return redirect('admin_panel/admins')->with('success', ling('admin_added_succ'));	
	}

	/*Admins Listing*/
	public function admins()
	{
		$data['admins'] = DB::table('users')->select('users.name', 'users.email', 'users.id as user_id', 'users.seen', 'user_roles.role_id', 'countries.name as country_name', 'states.name as region')
							->join('user_roles', 'user_roles.user_id', '=', 'users.id')
							->join('roles', 'roles.id', '=', 'user_roles.role_id')
							->join('countries', 'countries.id', '=', 'users.country_id')
							->join('states', 'states.id', '=', 'users.region_id')
							->where('roles.role_name', '=', 'admin')->get();

		return view('super_admin.admins_list', $data);
	}


	/*Edit Admin*/
	public function edit_admin($id)
	{
		User::where('id', '=', $id)->update(array('seen' => 1));
		$data['orgs'] = DB::table('organizations')->get()->all();
		$data['admin_data'] = User::where('id', '=', $id)->get()->first();
		$data_orgs = DB::table('admin_to_orgs')->select('org_id')->where('user_id', '=', $id)->get();

		$data['admin_orgs'] = array();
		foreach ($data_orgs as $key => $org) 
		{
		   	$data['admin_orgs'][$key] = $org->org_id;
		}

		return view('super_admin.edit_admin', $data);
	}


	/**/
	public function update_admin(Request $request)
	{
		$messages = [
		    'required' => ling('the').' :attribute '.ling('required_field_msg'),
		];
		$this->validate($request, [
        'name'      => 'required',
        'email'     => 'required',
        'gender'     => 'required',
        'country_id'     => 'required',
        'region_id'     => 'required',
        'city'     => 'required',
        'orgs'		=> 'required',
        'user_id'		=> 'required'
    ], $messages);

    if(!empty($request->password))
    {
    	$this->validate($request, [
    		'c_password'     => 'required|same:password',
    	], $messages);
    }

    $filename = '';
		if(!empty($request->file('user_image')))
		{
			$image = $request->file('user_image');
			$filename = time().'.'.$image->getClientOriginalExtension();
     	$image->move(public_path('web/assets/uploads/user_images'), $filename);
		}
		else
		{
			$filename = $request->pre_image;
		}

		$data = array(
			'name'			=> $request->name,
			'email'			=> $request->email,
			'password'		=> bcrypt($request->password),
			'gender'		=> $request->gender,
			'date_of_birth'	=> $request->date_of_birth,
			'country_id'	=> $request->country_id,
			'region_id'		=> $request->region_id,
			'city'			=> $request->city,
			'profile_image'	=> $filename

		);
		if(User::where('id', '=', $request->user_id)->update($data))
		{
			DB::table('admin_to_orgs')->where('user_id', '=', $request->user_id)->delete();
			DB::table('admin_to_teams')->where('user_id', '=', $request->user_id)->delete();

			$teams = array();
			foreach ($request->orgs as $key => $org) 
			{
				$data_org = array(
					'user_id' => $request->user_id,
					'org_id'  => $org
				);
				DB::table('admin_to_orgs')->insert($data_org);

				$teams = Team::where('org_id', '=', $org)->select('id')->get();
				foreach ($teams as $key => $team) 
				{
					$data_team = array(
						'user_id'  => $request->user_id,
						'org_id'   => $org,
						'team_id'  => $team->id
					);
					DB::table('admin_to_teams')->insert($data_team);
				}
			}

		}

		return redirect()->back()->with('message', ling('admin_updated_succ'));
	}


	/*Delete Admin*/
	public function delete_admin($id)
	{
		$user = User::findOrFail($id);
		if($user->delete())
		{
			DB::table('admin_to_orgs')->where('user_id', '=', $id)->delete();
			DB::table('admin_to_teams')->where('user_id', '=', $id)->delete();
		}
		return redirect()->back()->with('message', ling('deleted_succ'));
	}
}
