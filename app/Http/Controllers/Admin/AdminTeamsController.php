<?php

namespace App\Http\Controllers\Admin;

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

class AdminTeamsController extends Controller
{

	/*Admin Associated Organizations List*/
    public function organizations($c_id = '', $r_id = '')
    {
    	$data['organizations'] = DB::table('organizations')
                                ->select('organizations.*', 'countries.name as country_name', 'states.name as region_name')
                                ->join('countries', 'countries.id', '=', 'organizations.country_id')
                                ->join('states', 'states.id', 'organizations.region_id')
                                ->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
                                ->where('admin_to_orgs.user_id', '=', Auth::user()->id)
                                ->if($c_id, 'organizations.country_id', '=', $c_id)
                                ->if($r_id, 'organizations.region_id', '=', $r_id)
                                ->get();
        return view('admin/admin_orgs', $data);
    }


    /*Admin Associated Teams List*/
    public function teams(Request $request = NULL)
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
    	$data['teams'] = DB::table('teams')
                        ->select('teams.*', 'countries.name as country_name', 'states.name as region_name', 'organizations.org_name')
                        ->join('countries', 'countries.id', '=', 'teams.country_id')
                        ->join('states', 'states.id', 'teams.region_id')
                        ->join('organizations', 'organizations.id', '=', 'teams.org_id')
                        ->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
                        ->join('admin_to_teams', 'admin_to_teams.team_id', '=', 'teams.id')
                        ->where('admin_to_orgs.user_id', '=', Auth::user()->id)
                        ->where('admin_to_teams.user_id', '=', Auth::user()->id)
                        ->if($c_id, 'teams.country_id', '=', $c_id)
                        ->if($r_id, 'teams.region_id', '=', $r_id)
                        ->if($o_id, 'teams.org_id', '=', $o_id)
                        ->get();

        $data['orgs'] = DB::table('organizations')->select('organizations.*')
        				->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
        				->where('admin_to_orgs.user_id', '=', Auth::user()->id)->get();
                    	
    	return view('admin.admin_teams', $data);
    }

    /*Add New Team*/
    public function add_team()
    {
    	$data['orgs'] = DB::table('organizations')->select('organizations.org_name', 'organizations.id', 'organizations.country_id as org_country', 'organizations.region_id as org_region')
        				->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
        				->where('admin_to_orgs.user_id', '=', Auth::user()->id)->get();

    	return view('admin.admin_add_team', $data);
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
    		DB::table('admin_to_teams')->insert($data);
    	}
    	return redirect()->back()->with('message', ling('team').' '.ling('added_succ'));	
    }


    /*Edit Team*/
    public function edit_team($id)
    {

    	$data['team_data'] = DB::table('teams')->select('teams.*')
    						->join('admin_to_teams', 'admin_to_teams.team_id', '=', 'teams.id')
    						->where('admin_to_teams.user_id', '=', Auth::user()->id)
                            ->where('admin_to_teams.team_id', '=', $id)->get()->first();


    	$data['orgs'] = DB::table('organizations')->select('organizations.org_name', 'organizations.id', 'organizations.country_id as org_country', 'organizations.region_id as org_region')
        				->join('admin_to_orgs', 'admin_to_orgs.org_id', '=', 'organizations.id')
        				->where('admin_to_orgs.user_id', '=', Auth::user()->id)->get();

    	return view('admin.admin_edit_team', $data);
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

    	$data = array(
            'team_name'  => $request->input('name'),
            'org_id'  => $request->input('org_id'),
            'country_id'  => $request->input('country_id'),
            'region_id'   =>  $request->input('region_id')
        );

        Team::where('id', $request->input('team_id'))->update($data);
        return redirect()->back()->with('message', ling('updated_succ'));
    }


    /*Delete Team*/
    public function delete_team($id)
    {  	
    	$delete_rel = DB::table('admin_to_teams')->where('team_id', '=', $id)->where('user_id', '=', Auth::user()->id)->delete();
    	if($delete_rel)
    	{
    		Team::where('id', '=', $id)->delete();
    	}
        return redirect()->back()->with('message', ling('deleted_succ')); 
    }
}
