<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use App\Team;
use App\Organization;
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

class TeamsController extends Controller
{

	/*Add New Team*/
    public function add_team(Request $request = NULL)
    {
        $org = '';
        $data['org_info'] = array();
        $data['org_region'] = array();
        if(!empty($request->org))
        {
            $org = $request->org;
            $data['org_info'] = DB::table('organizations')->select('organizations.*', 'countries.id as c_id', 'states.id as r_id')
                                ->join('countries', 'countries.id', '=', 'organizations.country_id')
                                ->join('states', 'states.id', '=', 'organizations.region_id')
                                ->where('organizations.id', '=', $request->org)
                                ->get()->first();
            $data['org_region'] = DB::table('states')->where('country_id', '=', $data['org_info']->c_id)->get();

        }
        
    	$data['orgs'] = Organization::select('org_name', 'id', 'country_id as org_country', 'region_id as org_region')->get()->all();
    	return view('super_admin.add_team', $data);
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
    		'region_id'	  => 'required|int',
            'city'   => 'required'
    	], $messages);

    	$team->uu_id = strtoupper(uniqid('TM_'));
    	$team->team_name = $request->input('name');
    	$team->country_id = $request->input('country_id');
    	$team->region_id = $request->input('region_id');
        $team->city = $request->input('city');
    	$team->org_id = $request->input('org_id');

    	$team->save();

        if($request->has_org == 1)
        {
            return redirect('admin_panel/view_organization/'.$team->org_id)->with('success', ling('team').' '.ling('added_succ')); 
        }
        else
        {
            return redirect('admin_panel/teams')->with('success', ling('team').' '.ling('added_succ')); 
        }
    }


    /*Teams List*/
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
        if($o_id)
        {
            Organization::where('id', '=', $o_id)->update(array('seen' => 1));
        }
    	$data['teams'] = DB::table('teams')
                        ->select('teams.*', 'countries.name as country_name', 'states.name as region_name', 'organizations.org_name')
                        ->join('countries', 'countries.id', '=', 'teams.country_id')
                        ->join('states', 'states.id', 'teams.region_id')
                        ->join('organizations', 'organizations.id', '=', 'teams.org_id')
                        ->if($c_id, 'teams.country_id', '=', $c_id)
                        ->if($r_id, 'teams.region_id', '=', $r_id)
                        ->if($o_id, 'teams.org_id', '=', $o_id)
                        ->get();

        $data['orgs'] = Organization::get()->all();
                    	
    	return view('super_admin.teams', $data);
    }

    /*Edit Team*/
    public function edit_team($id)
    {
        Team::where('id', '=', $id)->update(array('seen' => 1));
    	$data['team_data'] = Team::where('id', '=', $id)->get()->first();
    	$data['orgs'] = Organization::select('org_name', 'id', 'country_id as org_country', 'region_id as org_region')->get()->all();

    	return view('super_admin.edit_team', $data);
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
            'city'   => 'required',
    		'team_id'	=> 'required|int'
    	], $messages);

    	$data = array(
            'team_name'  => $request->input('name'),
            'org_id'  => $request->input('org_id'),
            'country_id'  => $request->input('country_id'),
            'region_id'   =>  $request->input('region_id'),
            'city'   =>  $request->input('city'),
        );

        Team::where('id', $request->input('team_id'))->update($data);
        return redirect()->back()->with('message', ling('updated_succ'));
    }

    /*Delete Team*/
    public function delete_team($id)
    {  
        Team::where('id', '=', $id)->delete();
        DB::table('admin_to_teams')->where('team_id', '=', $id)->delete();
        return redirect()->back()->with('message', ling('deleted_succ')); 
    }

}
