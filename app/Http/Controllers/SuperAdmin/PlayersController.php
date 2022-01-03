<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Http\Controllers\Controller;
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

class PlayersController extends Controller
{
    public function players_list(Request $request = NULL)
    {
    	$c_id = '';
    	$r_id = '';
    	$o_id = '';
    	$t_id = '';
    	if($request)
    	{
    		$c_id = $request->c_id;
    		$r_id = $request->r_id;
    		$o_id = $request->o_id;
    		$t_id = $request->t_id;
    	}

    	$data['players'] = DB::table('players')->select('players.*', 'organizations.org_name', 'teams.team_name', 'countries.name as country', 'states.name as region', 'users.name', 'users.seen', 'users.id as user_id')
	    						->join('users', 'users.id', '=', 'players.player_id')
	    						->join('organizations', 'organizations.id', 'players.org_id')
	    						->join('teams', 'teams.id', '=', 'players.team_id')
	    						->join('countries', 'countries.id', '=', 'users.country_id')
	    						->join('states', 'states.id', '=', 'users.region_id')
	    						->if($c_id, 'teams.country_id', '=', $c_id)
		                        ->if($r_id, 'teams.region_id', '=', $r_id)
		                        ->if($o_id, 'teams.org_id', '=', $o_id)
	    						->get();

		$data['orgs'] = Organization::get()->all();

		return view('super_admin.players_list', $data);
    }
}
