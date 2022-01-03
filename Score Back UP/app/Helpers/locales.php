<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
/**
*
* Chage the user language, 
* Change default language, 
* Translate pages
*
*/

/*Load all languages*/
function load_languages()
{
	return DB::table('languages')->get();
}


/*Set Language for User*/
function set_language($locale = '')
{
	$trans = DB::table('translations')
			->where('locale', '=', $locale)->get();

	if(count($trans) > 0)
	{
		$langs = array();
		foreach ($trans as $key => $single) {
			$langs[$single->key] = $single->translation;
		}
		Session::put('lang', $locale);
		Session::put('locale', $langs);
		return response()->json(['success' => 1]);
	}
}


/*Translate Keys*/
function ling($trans_key)
{
	$trans = Session::get('locale');
	return $trans[$trans_key];
}

/*Language Info*/
function lang_info($locale)
{
	return DB::table('languages')->where('locale', '=', $locale)->get()->first();
}


/**/
function user_default_lang($loc)
{
	$userID = Auth::user()->id;
	if(DB::table('user_language')->where('user_id', '=', $userID)->count() > 0)
	{
		DB::table('user_language')->where('user_id', '=', $userID)->update(array('locale' => $loc));
	}
	else
	{
		$data = array(
			'user_id'	=> $userID,
			'locale'	=> $loc
		);
		DB::table('user_language')->insert($data);
	}
	set_language($loc);
	return response()->json(['success' => 1]);
}