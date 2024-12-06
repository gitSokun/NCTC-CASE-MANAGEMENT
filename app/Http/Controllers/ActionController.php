<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$actions = Action::paginate(10);
		return view('form/action/index',compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'action_name' => 'required'
        ]);

		DB::transaction(function () use ($request) {
			/**check if code is already exist */
			$action = Action::where('name',$request->action_name)->first();
			if(!$action){
				Action::create([
					'name'=>$request->action_name
				]);
			}
		});
		$actions = Action::paginate(10);
		return view('form/action/index',compact('actions'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Action $action)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Action $action)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Action $action)
    {
		$request->validate([
            'action_name' => 'required'
        ]);
		DB::transaction(function () use ($request) {
			Action::where('id',$request->id)->update([
				'name'=>$request->action_name
			]);
		});
		$actions = Action::paginate(10);
		return view('form/action/index',compact('actions'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        //
    }
}
