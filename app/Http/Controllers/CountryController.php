<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$search = '';
        $countries = Country::paginate(10);
		return view('form/country/index',compact('countries','search'));
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function searchIndex(Request $request)
    {
        $search = '';
		if($request->search){
			$search = $request->search;
			$string ='%'.$search.'%' ;
		}
		if($search){
			$countries = Country::where('code', 'like', $string)
			->orWhere('name_eng', 'like', $string)
			->orWhere('name_kh','like',$string)
			->paginate(10);
		}else{
			$countries = Country::paginate(10);
			return view('form/country/index',compact('countries','search'));
		}


		return view('form/country/index',compact('countries','search'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$request->validate([
            'country_code' => 'required',
			'country_eng' => 'required',
        ]);

		DB::transaction(function () use ($request) {
			/**check if code is already exist */
			$country = Country::where('code',$request->country_code)->first();
			if(!$country){
				Country::create([
					'code'=>$request->country_code,
					'name_eng'=>$request->country_eng,
					'name_kh'=>$request->country_kh
				]);
			}
		});

		$search = $request->country_eng;
		$countries = Country::where('name_eng', $search)
			->paginate(10);
		return view('form/country/index',compact('countries','search'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
		$request->validate([
            'country_code' => 'required',
			'country_eng' => 'required',
        ]);
		DB::transaction(function () use ($request) {
			Country::where('id',$request->id)->update([
				'code'=>$request->country_code,
				'name_eng'=>$request->country_eng,
				'name_kh'=>$request->country_kh
			]);
		});

		$search = $request->country_eng;
		$countries = Country::where('name_eng', $search)
			->paginate(10);
		return view('form/country/index',compact('countries','search'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
