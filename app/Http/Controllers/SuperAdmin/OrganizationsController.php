<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organization;
use App\Team;
use Illuminate\Database\Query\Builder;
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

class OrganizationsController extends Controller
{

    public function organizations($c_id = '', $r_id = '')
    {
        $data['organizations'] = DB::table('organizations')
                                ->select('organizations.*', 'countries.name as country_name', 'states.name as region_name')
                                ->join('countries', 'countries.id', '=', 'organizations.country_id')
                                ->join('states', 'states.id', 'organizations.region_id')
                                ->if($c_id, 'organizations.country_id', '=', $c_id)
                                ->if($r_id, 'organizations.region_id', '=', $r_id)
                                ->orderByRaw('FIELD(seen, 1)')
                                ->get();

    	return view('super_admin.organizations', $data);
    }


    /*Add New Organization*/
    public function add_organization()
    {
    	return view('super_admin.add_organization');
    }


    /**/
    public function add_new_organization(Request $request)
    {
    	$organization = new Organization;
    	$messages = [
		    'required' => ling('the').' :attribute '.ling('required_field_msg'),
		];
    	$this->validate($request, [
    		'name'	=> 'required',
    		'country_id'  => 'required|int',
    		'region_id'	  => 'required|int'
    	], $messages);

    	$organization->uu_id = strtoupper(uniqid('ORG_'));
    	$organization->org_name = $request->input('name');
    	$organization->country_id = $request->input('country_id');
    	$organization->region_id = $request->input('region_id');
    	
    	$organization->save();
    	return redirect('admin_panel/organizations')->with('success', ling('org_added_succ'));	
    }


    /*Update Organization*/
    public function edit_organization($id)
    {
        Organization::where('id', '=', $id)->update(array('seen' => 1));

        $data['org_data'] = Organization::where('id', '=', $id)->get()->first();
        return view('super_admin.edit_organization', $data);
    }


    /**/
    public function update_organization(Request $request)
    {
        $organization = new Organization;
        $messages = [
            'required' => ling('the').' :attribute '.ling('required_field_msg'),
        ];
        $this->validate($request, [
            'name'  => 'required',
            'country_id'  => 'required|int',
            'region_id'   => 'required|int',
            'org_id'    => 'required|int'
        ], $messages);

        $data = array(
            'org_name'  => $request->input('name'),
            'country_id'  => $request->input('country_id'),
            'region_id'   =>  $request->input('region_id')
        );

        Organization::where('id', $request->input('org_id'))->update($data);
        return redirect()->back()->with('message', ling('org_updated_succ'));
    }


    /**/
    public function delete_organization($id)
    {
        Organization::where('id', '=', $id)->delete();
        DB::table('admin_to_orgs')->where('org_id', '=', $id)->delete();
        Team::where('org_id', '=', $id)->delete();
        DB::table('admin_to_teams')->where('org_id', '=', $id)->delete();
        return redirect()->back()->with('message', ling('deleted_succ')); 
    }


    /*View Team*/
    public function view_org($id)
    {
        Organization::where('id', '=', $id)->update(array('seen' => 1));

        $data['org'] = DB::table('organizations')->select('organizations.*', 'countries.name as country', 'states.name as region')
                        ->join('countries', 'countries.id', '=', 'organizations.country_id')
                        ->join('states', 'states.id', '=', 'organizations.region_id')
                        ->where('organizations.id', '=', $id)
                        ->get()->first();

        $data['teams'] = DB::table('teams')->select('teams.*', 'countries.name as country', 'states.name as region')
                         ->join('countries', 'countries.id', '=', 'teams.country_id')
                         ->join('states', 'states.id', '=', 'teams.region_id')
                         ->where('teams.org_id', '=', $id)
                         ->get();
                         /*dd($data);*/
        return view('super_admin.view_org', $data);
    }

}
