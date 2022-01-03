<?php 
use Illuminate\Support\Facades\DB;

function countries()
{
	return DB::table('countries')->get();
}

/**/
function get_regions($id)
{
	$result = DB::table('states')->where('country_id', '=', $id)->get();
	if(count($result) > 0)
	{
		$options = array();
		foreach ($result as $key => $state) 
		{
			$options[0] = '<option value="">All Regions</option>';
			$options[$key+1] = '<option value="'.$state->id.'">'.$state->name.'</option>';
		}

		return array('success' => 1, 'data' => $options);
	}
}

/**/
function get_regions_simp($id)
{
	return DB::table('states')->where('country_id', '=', $id)->get();
	
}


/**/
function get_teams($id)
{
	$result = DB::table('teams')->where('org_id', '=', $id)->get();
	if(count($result) > 0)
	{
		$options = array();
		foreach ($result as $key => $team) 
		{
			$options[$key] = '<option value="'.$team->id.'">'.$team->team_name.'</option>';
		}

		return array('success' => 1, 'data' => $options);
	}
}