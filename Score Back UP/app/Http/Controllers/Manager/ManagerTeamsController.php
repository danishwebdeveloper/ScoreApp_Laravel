<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use DB;
use Auth;
use App\Team;

/*
* Register a custom if condition in Query Builder
*/
Builder::macro('if', function ($condition, $column, $operator, $value) {
    if ($condition) {
        return $this->where($column, $operator, $value);
    }
    return $this;
});

class ManagerTeamsController extends Controller
{
    /*Manager Associated Organization*/
    public function organization()
    {
    	$data['org'] = DB::table('organizations')
                                ->select('organizations.*', 'countries.name as country_name', 'states.name as region_name')
                                ->join('countries', 'countries.id', '=', 'organizations.country_id')
                                ->join('states', 'states.id', 'organizations.region_id')
                                ->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
                                ->where('managers_to_orgs.user_id', '=', Auth::user()->id)
                                ->get()->first();
        return view('managers/managers_org', $data);
    }


    /*Manager Associated Teams*/
    public function teams(Request $request = NULL)
    {
    	$c_id = '';
    	$r_id = '';
    	if($request)
    	{
    		$c_id = $request->c_id;
    		$r_id = $request->r_id;
    	}
    	$data['teams'] = DB::table('teams')
                        ->select('teams.*', 'countries.name as country_name', 'states.name as region_name', 'organizations.org_name')
                        ->join('countries', 'countries.id', '=', 'teams.country_id')
                        ->join('states', 'states.id', 'teams.region_id')
                        ->join('organizations', 'organizations.id', '=', 'teams.org_id')
                        ->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
                        ->join('managers_to_teams', 'managers_to_teams.team_id', '=', 'teams.id')
                        ->where('managers_to_orgs.user_id', '=', Auth::user()->id)
                        ->where('managers_to_teams.user_id', '=', Auth::user()->id)
                        ->if($c_id, 'teams.country_id', '=', $c_id)
                        ->if($r_id, 'teams.region_id', '=', $r_id)
                        ->get();

        $data['orgs'] = DB::table('organizations')->select('organizations.*')
        				->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
        				->where('managers_to_orgs.user_id', '=', Auth::user()->id)->get();
                    	
    	return view('managers.manager_teams', $data);
    }


    /*Add New Team*/
    public function add_team()
    {
    	$data['org'] = DB::table('organizations')->select('organizations.org_name', 'organizations.id', 'organizations.country_id as org_country', 'organizations.region_id as org_region')
        				->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
        				->where('managers_to_orgs.user_id', '=', Auth::user()->id)->get()->first();

    	return view('managers.manager_add_team', $data);
    }


    /**/
    public function add_new_team(Request $request)
    {
    	$team = new Team;
    	$messages = [
		    'required' => ling('the').' :attribute '.ling('required_field_msg'),
		];
    	$this->validate($request, [
    		'name'	=> 'required',
    		'org_id'  => 'required|int',
    		'country_id'  => 'required|int',
    		'region_id'	  => 'required|int'
    	], $messages);

    	$org_check = DB::table('managers_to_orgs')->where(['org_id' => $request->input('org_id'), 'user_id' => Auth::user()->id])->get()->first();
    	if(count($org_check) > 0)
    	{
	    	$team->uu_id = strtoupper(uniqid('TM_'));
	    	$team->team_name = $request->input('name');
	    	$team->country_id = $request->input('country_id');
	    	$team->region_id = $request->input('region_id');
	    	$team->org_id = $request->input('org_id');

	    	if($team->save())
	    	{
	    		$data = array(
	    			'user_id'	=> Auth::user()->id,
	    			'org_id'	=> $request->input('org_id'),
	    			'team_id'	=> $team->id
	    		);
	    		DB::table('managers_to_teams')->insert($data);
	    	}
	    	return redirect()->back()->with('message', ling('team').' '.ling('added_succ'));
	    }
	    else
	    {
	    	return redirect()->back()->with('error', ling('went_wrong_err'));
	    }	
    }


    /*Edit Team*/
    public function edit_team($id)
    {

    	$data['team_data'] = DB::table('teams')->select('teams.*')
    						->join('managers_to_teams', 'managers_to_teams.team_id', '=', 'teams.id')
    						->where('managers_to_teams.user_id', '=', Auth::user()->id)
    						->where('managers_to_teams.team_id', '=', $id)->get()->first();

    	$data['org'] = DB::table('organizations')->select('organizations.org_name', 'organizations.id', 'organizations.country_id as org_country', 'organizations.region_id as org_region')
        				->join('managers_to_orgs', 'managers_to_orgs.org_id', '=', 'organizations.id')
        				->where('managers_to_orgs.user_id', '=', Auth::user()->id)->get()->first();

    	return view('managers.manager_edit_team', $data);
    }

    /**/
    public function update_team(Request $request)
    {
    	$messages = [
		    'required' => ling('the').' :attribute '.ling('required_field_msg'),
		];
    	$this->validate($request, [
    		'name'	=> 'required',
    		'org_id'  => 'required|int',
    		'country_id'  => 'required|int',
    		'region_id'	  => 'required|int',
    		'team_id'	=> 'required|int'
    	], $messages);

    	$org_check = DB::table('managers_to_orgs')->where(['org_id' => $request->input('org_id'), 'user_id' => Auth::user()->id])->get()->first();
    	if(count($org_check) > 0)
    	{
	    	$data = array(
	            'team_name'  => $request->input('name'),
	            'org_id'  => $request->input('org_id'),
	            'country_id'  => $request->input('country_id'),
	            'region_id'   =>  $request->input('region_id')
	        );

	        Team::where('id', $request->input('team_id'))->update($data);
	        return redirect()->back()->with('message', ling('updated_succ'));
    	}
    	else
    	{
    		return redirect()->back()->with('error', ling('went_wrong_err'));
    	}
    }


    /*Delete Team*/
    public function delete_team($id)
    {  	
    	$delete_rel = DB::table('managers_to_teams')->where('team_id', '=', $id)->where('user_id', '=', Auth::user()->id)->delete();
    	if($delete_rel)
    	{
    		Team::where('id', '=', $id)->delete();
    	}
        return redirect()->back()->with('message', ling('deleted_succ')); 
    }
}
