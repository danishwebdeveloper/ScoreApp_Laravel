<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\Organization;
use App\User;
use App\Team;
use Auth;
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

class ManagerPlayersController extends Controller
{
    /*Add New Player*/
    public function add_player()
    {
    	$data['org'] = DB::table('organizations')->select('organizations.org_name', 'organizations.id', 'organizations.country_id as org_country', 'organizations.region_id as org_region')
        				->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
        				->where('managers_to_orgs.user_id', '=', Auth::user()->id)->get()->first();

		return view('managers.manager_add_player', $data);
    }

    /**/
	public function add_new_player(Request $request)
	{
		$messages = [
	    	'required' => ling('the').' :attribute '.ling('required_field_msg'),
		];

		$this->validate($request, [
	        'name'       => 'required',
	        'email'      => 'required',
	        'gender'     => 'required',
	        'country_id' => 'required',
	        'region_id'  => 'required',
	        'city'     	 => 'required',
	        'password'   => 'required',
	        'c_password' => 'required|same:password',
	        'org'		 => 'required',
	        'team'		 => 'required'
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
		$user->uuid = strtoupper(uniqid('PLR_'));
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
			$role = DB::table('roles')->where('role_name', '=', 'player')->select('id')->get()->first();
			DB::table('user_roles')->insert(array('user_id' => $user->id, 'role_id' => $role->id));

			/*Add as Player*/
			$data_player = array(
				'player_id'		=> $user->id,
				'org_id'		=> $request->org,
				'team_id'		=> $request->team,
				'manager_id'	=> Auth::user()->id
			);

			DB::table('players')->insert($data_player);
		}	
		return redirect('manager/players')->with('success', ling('added_succ'));	
	}


	/*Players List*/
	public function players(Request $request = NULL)
	{
		$c_id = '';
    	$r_id = '';
    	if($request)
    	{
    		$c_id = $request->c_id;
    		$r_id = $request->r_id;
    	}

    	$data['players'] = DB::table('users')->select('users.id as user_id', 'users.name', 'users.seen', 'countries.name as country', 'states.name as region', 'teams.team_name', 'organizations.org_name', 'players.*')
    						->join('countries', 'countries.id', '=', 'users.country_id')
    						->join('states', 'states.id', '=', 'users.region_id')
    						->join('players', 'players.player_id', '=', 'users.id')
    						->join('organizations', 'organizations.id', '=', 'players.org_id')
    						->join('teams', 'teams.id', '=', 'players.team_id')
    						->if($c_id, 'users.country_id', '=', $c_id)
	                        ->if($r_id, 'users.region_id', '=', $r_id)
    						->where('players.manager_id', '=', Auth::user()->id)
    						->get();

		return view('managers.manager_players_list', $data);
	}


	/*Edit Player*/
	public function edit_player($id)
	{
		User::where('id', '=', $id)->update(array('seen' => 1));
		$data['org'] = DB::table('organizations')->select('organizations.org_name', 'organizations.id', 'organizations.country_id as org_country', 'organizations.region_id as org_region')
        				->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
        				->where('managers_to_orgs.user_id', '=', Auth::user()->id)->get()->first();
        $data['player_info'] = DB::table('players')->where('player_id', '=', $id)->get()->first();
        $data['player_data'] = User::where('id', '=', $id)->get()->first();
        $data['teams'] = DB::table('teams')->where('org_id', '=', $data['player_info']->org_id)->get();

        return view('managers.manager_edit_player', $data);
	}


	/*Update Manager*/
	public function update_player(Request $request)
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
	        'player_id' => 'required'
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
		$player_data = array(
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'gender' => $request->gender,
			'date_of_birth' => $request->date_of_birth,
			'country_id' => $request->country_id,
			'region_id' => $request->region_id,
			'city' => $request->city
		);
		
		if(User::where('id', '=', $request->player_id)->update($player_data))
		{
			$data_player = array(
				'org_id'		=> $request->org,
				'team_id'		=> $request->team,
				'manager_id'	=> Auth::user()->id
			);

			DB::table('players')->where('player_id', '=', $request->player_id)->update($data_player);
		}	
		return redirect()->back()->with('message', ling('updated_succ'));	
	}


	/*Delete Player*/
	public function delete_player($id)
	{
		$user = User::findOrFail($id);
		if($user->delete())
		{
			DB::table('players')->where('player_id', '=', $id)->delete();
		}
		return redirect()->back()->with('message', ling('deleted_succ'));
	}
}
