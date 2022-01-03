<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Auth;
use Carbon\Carbon;
use App\User;
use App\Organization;
use App\Team;
use DB;
/*
* Register a custom if condition in Query Builder
*/
Builder::macro('if', function ($condition, $column, $operator, $value) {
    if ($condition) {
        return $this->where($column, $operator, $value);
    }
    return $this;
});

class AdminManagersController extends Controller
{
    /*Add New Manager*/
	public function add_manager()
	{
		$data['orgs'] = DB::table('organizations')
                        ->select('organizations.*')
                        ->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
                        ->where('admin_to_orgs.user_id', '=', Auth::user()->id)
                        ->get();

		return view('admin.admin_add_manager', $data);
	}

	/**/
	public function add_new_manager(Request $request)
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
	        'org'		=> 'required'
	    ], $messages);

		$filename = '';
		if(!empty($request->file('user_image')))
		{
			$image = $request->file('user_image');
			$filename = time().'.'.$image->getClientOriginalExtension();
     		$image->move(public_path('web/assets/uploads/user_images'), $filename);
		}

		if(count(User::where('email', '=', $request->email)->get()->first()) > 0)
		{
			return redirect()->back()->with('error', ling('email_already_exist'));
		}

		/*Adding as User*/
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
			/*Assigning Role*/
			$role = DB::table('roles')->where('role_name', '=', 'manager')->select('id')->get()->first();
			DB::table('user_roles')->insert(array('user_id' => $user->id, 'role_id' => $role->id));

			/*Assign Manager to Admin*/
			$data_assign = array(
				'admin_id'		=> Auth::user()->id,
				'manager_id'	=> $user->id
			);
			DB::table('managers_to_admin')->insert($data_assign);

			/*Assigning Organization*/
			$data_org = array(
				'user_id' => $user->id,
				'org_id'  => $request->org
			);
			DB::table('managers_to_orgs')->insert($data_org);

			/*Assigning Teams*/
			if($request->teams == 'all' || empty($request->teams))
			{
				$teams = Team::where('org_id', '=', $request->org)->select('id')->get();
				foreach ($teams as $key => $team) 
				{
					$data_team = array(
						'user_id'  => $user->id,
						'org_id'   => $request->org,
						'team_id'  => $team->id
					);
					DB::table('managers_to_teams')->insert($data_team);
				}
			}
			else
			{
				foreach ($request->teams as $key => $team) 
				{
					$data_team = array(
						'user_id'  => $user->id,
						'org_id'   => $request->org,
						'team_id'  => $team
					);
					DB::table('managers_to_teams')->insert($data_team);
				}
			}
		}	
		return redirect('admin/managers_list')->with('success', ling('added_succ'));	
	}


	/*Managers List*/
	public function managers_list(Request $request = NULL)
	{
		$c_id = '';
    	$r_id = '';
    	$o_id = '';
    	if($request)
    	{
    		$c_id = $request->c_id;
    		$r_id = $request->r_id;
    		$o_id = $request->o_id;
    	}

		$data['managers'] = DB::table('users')
							->select('users.name', 'users.seen', 'users.email', 'users.id as user_id', 'user_roles.role_id', 'countries.name as country_name', 'states.name as region', 'organizations.org_name')
							->join('user_roles', 'user_roles.user_id', '=', 'users.id')
							->join('roles', 'roles.id', '=', 'user_roles.role_id')
							->join('managers_to_admin', 'managers_to_admin.manager_id', '=', 'users.id')
							->join('countries', 'countries.id', '=', 'users.country_id')
							->join('states', 'states.id', '=', 'users.region_id')
							->join('managers_to_orgs', 'managers_to_orgs.user_id', '=', 'users.id')
							->join('organizations', 'organizations.id', '=', 'managers_to_orgs.org_id')
							->if($c_id, 'organizations.country_id', '=', $c_id)
	                        ->if($r_id, 'organizations.region_id', '=', $r_id)
	                        ->if($o_id, 'managers_to_orgs.org_id', '=', $o_id)
	                        ->where('managers_to_admin.admin_id', '=', Auth::user()->id)
							->where('roles.role_name', '=', 'manager')->get();
						
		$data['orgs'] 		= DB::table('organizations')
	                        ->select('organizations.*')
	                        ->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
	                        ->where('admin_to_orgs.user_id', '=', Auth::user()->id)
	                        ->get();

		return view('admin.admin_managers_list', $data);
	}


	/*Edit Manager*/
	public function edit_manager($id)
	{
		User::where('id', '=', $id)->update(array('seen' => 1));
		$data['orgs'] = DB::table('organizations')
                        ->select('organizations.*')
                        ->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
                        ->where('admin_to_orgs.user_id', '=', Auth::user()->id)
                        ->get();
		$data['manager_data'] = User::where('id', '=', $id)->get()->first();
		$data['manager_org'] = DB::table('managers_to_orgs')->select('org_id')->where('user_id', '=', $id)->get()->first();
		$data_teams = DB::table('managers_to_teams')->select('team_id')->where('user_id', '=', $id)->where('org_id', '=', $data['manager_org']->org_id)->get();
		$data['teams'] = DB::table('teams')->where('org_id', '=', $data['manager_org']->org_id)->get();

		$data['manager_teams'] = array();
		foreach ($data_teams as $key => $team) 
		{
		   	$data['manager_teams'][$key] = $team->team_id;
		}

		return view('admin.admin_edit_manager', $data);
	}


	/*Update Manager*/
	public function update_manager(Request $request)
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
	        'org'		=> 'required',
	        'manager_id' => 'required'
	    ], $messages);

		$filename = '';
		if(!empty($request->file('user_image')))
		{
			$image = $request->file('user_image');
			$filename = time().'.'.$image->getClientOriginalExtension();
     		$image->move(public_path('web/assets/uploads/user_images'), $filename);
		}
		elseif(!empty($request->pre_image))
		{
			$filename = $request->pre_image;
		}

		/*Updating as User*/
		$admin_data = array(
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'gender' => $request->gender,
			'date_of_birth' => Carbon::parse($request->date_of_birth)->format('Y-m-d'),
			'country_id' => $request->country_id,
			'region_id' => $request->region_id,
			'city' => $request->city
		);
		
		if(User::where('id', '=', $request->manager_id)->update($admin_data))
		{
			DB::table('managers_to_teams')->where('user_id', '=', $request->manager_id)->delete();
			/*Assigning Organization*/
			$data_org = array(
				'org_id'  => $request->org
			);
			DB::table('managers_to_orgs')->where('user_id','=', $request->manager_id)->update($data_org);

			/*Assigning Teams*/
			if($request->teams == 'all' || empty($request->teams))
			{
				$teams = Team::where('org_id', '=', $request->org)->select('id')->get();
				foreach ($teams as $key => $team) 
				{
					$data_team = array(
						'user_id'  => $request->manager_id,
						'org_id'   => $request->org,
						'team_id'  => $team->id
					);
					DB::table('managers_to_teams')->insert($data_team);
				}
			}
			else
			{
				foreach ($request->teams as $key => $team) 
				{
					$data_team = array(
						'user_id'  => $request->manager_id,
						'org_id'   => $request->org,
						'team_id'  => $team
					);
					DB::table('managers_to_teams')->insert($data_team);
				}
			}
		}	
		return redirect()->back()->with('message', ling('updated_succ'));	
	}


	/*Delete Manager*/
	public function delete_manager($id)
	{
		$user = User::findOrFail($id);
		if($user->delete())
		{
			DB::table('managers_to_orgs')->where('user_id', '=', $id)->delete();
			DB::table('managers_to_teams')->where('user_id', '=', $id)->delete();
			DB::table('managers_to_admin')->where(['manager_id' => $id, 'admin_id' => Auth::user()->id])->delete();
		}
		return redirect()->back()->with('message', ling('deleted_succ'));
	}
}
