<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class TestsLevelsController extends Controller
{
    /*Add New Exercise*/
    public function add_exercise()
    {
    	$data['tests'] = DB::table('tests')->get()->all();
    	return view('super_admin.add_exercise', $data);
    }

    /**/
    public function add_new_exercise(Request $request)
    {
    	$messages = [
	    'required' => ling('the').' :attribute '.ling('required_field_msg'),
	   	];

		$this->validate($request, [
	        'name'      => 'required',
	        'test_id'     => 'required'
        ], $messages);

        $data = array(
        	'test_id' =>  $request->test_id,
        	'exercise_name' => $request->name 
        );

        DB::table('test_exercises')->insert($data);

        return redirect('admin_panel/exercises')->with('success', ling('added_succ'));
    }

    /*Exercises List*/
    public function exercises()
    {
    	$data['exercises'] = DB::table('test_exercises')->select('test_exercises.*', 'tests.test_name')
    						->join('tests', 'tests.id', '=', 'test_exercises.test_id')
    						->get();
    	return view('super_admin.exercises', $data);
    }

    /*Edit Exercise*/
    public function edit_exercise($id)
    {
    	$data['exercise_data'] = DB::table('test_exercises')->where('id', '=', $id)->get()->first();
    	$data['tests'] = DB::table('tests')->get()->all();
    	return view('super_admin.edit_exercise', $data);
    }

    /*Update Exercise*/
    public function update_exercise(Request $request)
    {
    	$messages = [
	    'required' => ling('the').' :attribute '.ling('required_field_msg'),
	   	];

		$this->validate($request, [
	        'name'      => 'required',
	        'test_id'     => 'required',
	        'exercise_id' => 'required'
        ], $messages);

        $data = array(
        	'test_id' =>  $request->test_id,
        	'exercise_name' => $request->name 
        );

        DB::table('test_exercises')->where('id', '=', $request->exercise_id)->update($data);

        return redirect('admin_panel/exercises')->with('success', ling('updated_succ'));
    }

    /*Delete Exercise*/
    public function delete_exercise($id)
    {
    	DB::table('test_exercises')->where('id', '=', $id)->delete();

        return redirect()->back()->with('success', ling('deleted_succ'));
    }

    /*Add Points Levels*/
    public function add_points_levels()
    {
    	return view('super_admin.add_points_levels');
    }
}
