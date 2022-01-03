<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Auth Routes*/
Route::get('/', function () {
    return redirect('/login');
});
Auth::routes();

/*Global Routes*/
Route::group(['middleware' => 'auth'], function() {
	Route::get('/set_language/{loc}', function($loc) {
		return set_language($loc);
	});
	Route::get('/user_default_lang/{loc}', function($loc) {
		return user_default_lang($loc);
	});
	Route::get('/get_regions/{id?}', function($id = 0) {
		return get_regions($id);
	});
	Route::get('/get_teams/{id?}', function($id = 0) {
		return get_teams($id);
	});
});

/*
|--------------------------------------
| Super Admin Routes
|--------------------------------------
*/
Route::group(['prefix' => 'admin_panel', 'middleware' => ['super_admin', 'auth'], ], function () {
   	Route::get('/dashboard', function () {
	    return view('super_admin.home');
	})->name('dashboard');
	/*Languages*/
	Route::get('/locales', 'SuperAdmin\AdminLanguages@locales')->name('locales');
	Route::post('/add_language', 'SuperAdmin\AdminLanguages@add_language');
	Route::get('/edit_language/{id}', 'SuperAdmin\AdminLanguages@edit_language')->where('id', '[0-9]+')->name('edit_language');
	Route::post('/update_language', 'SuperAdmin\AdminLanguages@update_language');
	Route::get('/delete_language/{id}', 'SuperAdmin\AdminLanguages@delete_language')->where('id', '[0-9]+')->name('delete_language');
	Route::get('/translations/{id}', 'SuperAdmin\AdminLanguages@translations')->name('translations/$1');
	Route::get('/add_translations', 'SuperAdmin\AdminLanguages@add_translations')->name('add_translations');
	Route::post('/add_new_translations', 'SuperAdmin\AdminLanguages@add_new_translations');
	Route::get('/edit_translation/{id}', 'SuperAdmin\AdminLanguages@edit_translation')->where('id', '[0-9]+')->name('edit_translation/$1');
	Route::post('/update_translation', 'SuperAdmin\AdminLanguages@update_translation')->name('update_translation');
	Route::get('/delete_translation/{id}', 'SuperAdmin\AdminLanguages@delete_translation')->where('id', '[0-9]+')->name('delete_translation/$1');
	/*End Languages*/
	/*Organizations*/
	Route::get('/organizations/{c_id?}/{r_id?}', 'SuperAdmin\OrganizationsController@organizations')->name('organizations');
	Route::get('/add_organization', 'SuperAdmin\OrganizationsController@add_organization')->name('add_organization');
	Route::post('/add_new_organization', 'SuperAdmin\OrganizationsController@add_new_organization')->name('add_new_organization');
	Route::get('/edit_organization/{id}', 'SuperAdmin\OrganizationsController@edit_organization')->where('id', '[0-9]+')->name('edit_organization/$1');
	Route::post('/update_organization', 'SuperAdmin\OrganizationsController@update_organization');
	Route::get('/delete_organization/{id}', 'SuperAdmin\OrganizationsController@delete_organization')->where('id', '[0-9]+')->name('delete_organization/$1');
	Route::get('/view_organization/{id}', 'SuperAdmin\OrganizationsController@view_org')->where('id', '[0-9]+')->name('view_organization/$1');
	/*End Organizations*/
	/*Teams*/
	Route::get('/add_team', 'SuperAdmin\TeamsController@add_team')->name('add_team');
	Route::post('/add_new_team', 'SuperAdmin\TeamsController@add_new_team')->name('add_new_team');
	Route::get('/teams/{c_id?}/{r_id?}/{o_id?}', 'SuperAdmin\TeamsController@teams')->name('teams');
	Route::get('/edit_team/{id}', 'SuperAdmin\TeamsController@edit_team')->where('id', '[0-9]+')->name('edit_team/$1');
	Route::post('/update_team', 'SuperAdmin\TeamsController@update_team');
	Route::get('/delete_team/{id}', 'SuperAdmin\TeamsController@delete_team')->where('id', '[0-9]+')->name('delete_team/$1');
	/*End Teams*/
	/*Admins*/
	Route::get('/add_admin', 'SuperAdmin\AdminsController@add_admin')->name('add_admin');
	Route::post('/add_new_admin', 'SuperAdmin\AdminsController@add_new_admin')->name('add_new_admin');
	Route::get('/admins', 'SuperAdmin\AdminsController@admins')->name('admins');
	Route::get('/edit_admin/{id}', 'SuperAdmin\AdminsController@edit_admin')->where('id', '[0-9]+')->name('edit_admin/$1');
	Route::post('/update_admin', 'SuperAdmin\AdminsController@update_admin')->name('update_admin');
	Route::get('/delete_admin/{id}', 'SuperAdmin\AdminsController@delete_admin')->where('id', '[0-9]+')->name('delete_admin/$1');
	/*End Admins*/
	/*Managers*/
	Route::get('/add_manager', 'SuperAdmin\ManagersController@add_manager')->name('add_manager');
	Route::post('/add_new_manager', 'SuperAdmin\ManagersController@add_new_manager')->name('add_new_manager');
	Route::get('/managers_list', 'SuperAdmin\ManagersController@managers_list')->name('managers_list');
	Route::get('/edit_manager/{id}', 'SuperAdmin\ManagersController@edit_manager')->where('id', '[0-9]+')->name('edit_manager/$1');
	Route::post('/update_manager', 'SuperAdmin\ManagersController@update_manager')->name('update_manager');
	Route::get('/delete_manager/{id}', 'SuperAdmin\ManagersController@delete_manager')->where('id', '[0-9]+')->name('delete_manager/$1');
	/*End Managers*/
	/*Players*/
	Route::get('/players_list', 'SuperAdmin\PlayersController@players_list')->name('players_list');
	/*End Players*/
	/*Tests Levels*/
	Route::get('/add_exercise', 'SuperAdmin\TestsLevelsController@add_exercise')->name('add_exercise');
	Route::post('/add_new_exercise', 'SuperAdmin\TestsLevelsController@add_new_exercise')->name('add_new_exercise');
	Route::get('/exercises', 'SuperAdmin\TestsLevelsController@exercises')->name('exercises');
	Route::get('/edit_exercise/{id}', 'SuperAdmin\TestsLevelsController@edit_exercise')->where('id', '[0-9]+')->name('edit_exercise/$1');
	Route::post('/update_exercise', 'SuperAdmin\TestsLevelsController@update_exercise')->name('update_exercise');
	Route::get('/delete_exercise/{id}', 'SuperAdmin\TestsLevelsController@delete_exercise')->where('id', '[0-9]+')->name('delete_exercise/$1');
	Route::get('/add_points_levels', 'SuperAdmin\TestsLevelsController@add_points_levels')->name('add_points_levels');
	/*End Tests Levels*/

});


/*
|--------------------------------------
| Admin Routes
|--------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth'], ], function () {
   	Route::get('/dashboard', function () {
	    return view('admin.home');
	})->name('dashboard');

	/*Organizations+Teams*/
	Route::get('/organizations/{c_id?}/{r_id?}', 'Admin\AdminTeamsController@organizations')->name('organizations');
	Route::get('/add_team', 'Admin\AdminTeamsController@add_team')->name('add_team');
	Route::post('/add_new_team', 'Admin\AdminTeamsController@add_new_team')->name('add_new_team');
	Route::get('/teams/{c_id?}/{r_id?}/{o_id?}', 'Admin\AdminTeamsController@teams')->name('teams');
	Route::get('/edit_team/{id}', 'Admin\AdminTeamsController@edit_team')->where('id', '[0-9]+')->name('edit_team/$1');
	Route::post('/update_team', 'Admin\AdminTeamsController@update_team');
	Route::get('/delete_team/{id}', 'Admin\AdminTeamsController@delete_team')->where('id', '[0-9]+')->name('delete_team/$1');
	/*End Organizations+Teams*/
	/*Managers*/
	Route::get('/add_manager', 'Admin\AdminManagersController@add_manager')->name('add_manager');
	Route::post('/add_new_manager', 'Admin\AdminManagersController@add_new_manager')->name('add_new_manager');
	Route::get('/managers_list', 'Admin\AdminManagersController@managers_list')->name('managers_list');
	Route::get('/edit_manager/{id}', 'Admin\AdminManagersController@edit_manager')->where('id', '[0-9]+')->name('edit_manager/$1');
	Route::post('/update_manager', 'Admin\AdminManagersController@update_manager')->name('update_manager');
	Route::get('/delete_manager/{id}', 'Admin\AdminManagersController@delete_manager')->where('id', '[0-9]+')->name('delete_manager/$1');
	/*Managers*/
	/*Players*/
	Route::get('/add_player', 'Admin\AdminPlayersController@add_player')->name('add_player');
	Route::post('/add_new_player', 'Admin\AdminPlayersController@add_new_player')->name('add_new_player');
	Route::get('/players', 'Admin\AdminPlayersController@players')->name('players');
	Route::get('/edit_player/{id}', 'Admin\AdminPlayersController@edit_player')->where('id', '[0-9]+')->name('edit_player');
	Route::post('/update_player', 'Admin\AdminPlayersController@update_player')->name('update_player');
	Route::get('/delete_player/{id}', 'Admin\AdminPlayersController@delete_player')->where('id', '[0-9]+')->name('delete_player');
});


/*
|--------------------------------------
| Manager Routes
|--------------------------------------
*/
Route::group(['prefix' => 'manager', 'middleware' => ['manager', 'auth'], ], function () {
   	Route::get('/dashboard', function () {
	    return view('managers.home');
	})->name('dashboard');

	/*Manager Teams*/
	Route::get('/organization', 'Manager\ManagerTeamsController@organization')->name('organization');
	Route::get('/teams/{c_id?}/{r_id?}', 'Manager\ManagerTeamsController@teams')->name('teams');
	Route::get('/add_team', 'Manager\ManagerTeamsController@add_team')->name('add_team');
	Route::post('/add_new_team', 'Manager\ManagerTeamsController@add_new_team')->name('add_new_team');
	Route::get('/edit_team/{id}', 'Manager\ManagerTeamsController@edit_team')->where('id', '[0-9]+')->name('edit_team/$1');
	Route::post('/update_team', 'Manager\ManagerTeamsController@update_team');
	Route::get('/delete_team/{id}', 'Manager\ManagerTeamsController@delete_team')->where('id', '[0-9]+')->name('delete_team/$1');
	/*End Manager Teams*/
	/*Players*/
	Route::get('/add_player', 'Manager\ManagerPlayersController@add_player')->name('add_player');
	Route::post('/add_new_player', 'Manager\ManagerPlayersController@add_new_player')->name('add_new_player');
	Route::get('/players', 'Manager\ManagerPlayersController@players')->name('players');
	Route::get('/edit_player/{id}', 'Manager\ManagerPlayersController@edit_player')->where('id', '[0-9]+')->name('edit_player');
	Route::post('/update_player', 'Manager\ManagerPlayersController@update_player')->name('update_player');
	Route::get('/delete_player/{id}', 'Manager\ManagerPlayersController@delete_player')->where('id', '[0-9]+')->name('delete_player');
});


/*
|--------------------------------------
| Players Routes
|--------------------------------------
*/
Route::group(['prefix' => 'player', 'middleware' => ['player', 'auth'], ], function () {
   	Route::get('/dashboard', function () {
	    return view('players.home');
	})->name('dashboard');
});
