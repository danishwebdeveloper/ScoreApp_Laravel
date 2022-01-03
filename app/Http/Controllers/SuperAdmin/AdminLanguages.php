<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Language;
use App\Translation;
use Session;

class AdminLanguages extends Controller
{
	/*Load All Languages*/
	public function locales()
	{
		$data['locales'] = Language::all();
		return view('super_admin.locales', $data);
	}


	/*Add New Language*/
    public function add_language(Request $request)
    {
    	$language = new Language;

    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'locale' => 'required',
            'copy_locale' => 'required'
        ]);

        if ($validator->passes()) 
        {
			if (Language::where('locale', '=', $request->input('locale'))->count() > 0) 
			{
				return response()->json(['error' => 1, 'type' => 'single', 'message' => ling('locale_already_err')]);
			}
			else
			{
				$filename = '';
				if(!empty($request->file('icon')))
				{
					$image = $request->file('icon');
					$filename = time().'.'.$image->getClientOriginalExtension();
        			$image->move(public_path('web/assets/uploads/assets'), $filename);
				}

				$language->name = $request->input('name');
				$language->locale = $request->input('locale');
				$language->icon = $filename;
				if($language->save())
				{
					$trans_copy = Translation::where('locale', '=', $request->input('copy_locale'))->get();
					if(count($trans_copy) > 0)
					{
						foreach ($trans_copy as $key => $value) 
						{
							$data = array(
								'locale'	=> $request->input('locale'),
								'key'		=> $value->key,
								'translation' => $value->translation
							);

							Translation::insert($data);
						}
					}

					return response()->json(['success' => 1, 'message' => ling('language').' '.ling('added_succ')]);
				}
				else
				{
					return response()->json(['error' => 1, 'type' => 'single', 'message' => ling('went_wrong_err')]);
				}

				
			}	
        }
        else
        {
        	return response()->json(['error' => 1, 'type' => 'multi', 'message' => $validator->errors()->all()]);
        }
    }


    /*Edit Language*/
    public function edit_language($id)
    {
    	$result = Language::find($id);
    	if(count($result) > 0)
    	{
    		return response()->json(['success' => 1, 'data' => $result]);
    	}
    	else
    	{
    		return response()->json(['error' => 1, 'type' => 'single', 'message' => 'Sorry, No record found...!']);
    	}
    }


    /*Update Language*/
    public function update_language(Request $request)
    {
    	$language = new Language;

    	$validator = Validator::make($request->all(), [
            'name' => 'required',
            'locale' => 'required'
        ]);

        if ($validator->passes()) 
        {
			if(!empty($request->file('icon')))
			{
				$image = $request->file('icon');
				$filename = time().'.'.$image->getClientOriginalExtension();
    			$image->move(public_path('web/assets/uploads/assets'), $filename);
			}
			else
			{
				$filename = $request->input('pre_icon');
			}

			$data = array(
				'name'	=> $request->input('name'),
				'locale' => $request->input('locale'),
				'icon'	=> $filename
			);
			
			$language->where('id', $request->input('lang_id'))->update($data);
			return response()->json(['success' => 1, 'message' => ling('language').' '.ling('updated_succ')]);	
	    }
        else
        {
        	return response()->json(['error' => 1, 'type' => 'multi', 'message' => $validator->errors()->all()]);
        }
	}

	/*Delete Language*/
	public function delete_language($id)
	{
		$language = Language::findOrFail($id);
		$locale = $language->locale;
        $language->delete();
        Translation::where('locale', '=', $locale)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully!');
	}



	/*Translations*/
	public function translations($id)
	{
		$data['locales'] = Language::all();
		$data['translations'] = Translation::where('locale', $id)->get();
		
		return view('super_admin.translations', $data);
	}

	/*Add New Translation*/
	public function add_translations()
	{
		$data['locales'] = Language::all();
		
		return view('super_admin/add_translation', $data);
	}

	/**/
	public function add_new_translations(Request $request)
	{
		
		$this->validate($request, [
            'key'      => 'required',
            'locale'	=> 'required'
        ]);

		$res = array();
        for($i = 0 ; $i < count($request->input('locale')) ; $i++)
	    {
	    	$res[] = array(
		        "key" => $request->input('key'),
		        "locale" => $request->input('locale')[$i],
		        "translation" => $request->input('translation')[$i]
	       );
	    }

	    foreach ($res as $key => $trans) 
	    {
	    	$translation = new Translation;

	    	$translation->locale = $trans['locale'];
	    	$translation->key = $trans['key'];
	    	$translation->translation = $trans['translation'];

	    	$translation->save();
	    }
	    set_language(Session::get('lang'));
	    return redirect()->back()->with('message', 'Translation added successfully!');
	}


	/*Edit Translation*/
	public function edit_translation($id)
	{
		$data['translation'] = Translation::find($id);

    	return view('super_admin.edit_translation', $data);
	}


	/*Update Translation*/
	public function update_translation(Request $request)
	{
		$this->validate($request, [
			'translation' => 'required',
			'lang_id'	=> 'required'
		]);

		Translation::where('id', '=', $request->input('lang_id'))->update(array('translation' => $request->input('translation')));
		return redirect()->back()->with('message', 'Translation Updated successfully!');
	}


	/*Delete Translation*/
	public function delete_translation($id)
	{
		$result = Translation::find($id);
		$result->delete();
		return redirect()->back()->with('message', 'Translation Deleted successfully!');
	}
}
