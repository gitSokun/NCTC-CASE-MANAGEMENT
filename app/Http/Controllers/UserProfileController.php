<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		/** exclude admin from the list */
		$user = User::where('email','admin@gmail.com')->first();
		if($user){
			$userProfiles = UserProfile::where('id','<>',$user->profileable_id)->paginate(10);
			return view('form/user_profile/index',compact('userProfiles'));
		}

		$userProfiles = UserProfile::where('','<>','Admin')->paginate(10);
		return view('form/user_profile/index',compact('userProfiles'));
		
    }

	public function uploadMyPicture(Request $request){

		$request->validate([
            'profile_image' => 'required',
			'profile_id'=>'required'
        ]);
		if($request->hasFile('profile_image')){
			$folder_name = "USER_PROFILE".$request->profile_id;
			if(!\Storage::disk('local')->exists($folder_name)){
				\Storage::disk('local')->makeDirectory($folder_name, 0775, true);
			}
			$pictureProfile = $request->file('profile_image');
			$file_name = $pictureProfile->getClientOriginalName();
			$destinationPath = $folder_name.'/'.$file_name;

			/** store file in directory */
			\Storage::disk('local')->put($destinationPath,file_get_contents($pictureProfile->getRealPath()));

			/** update user profile picture */
			UserProfile::where('id',$request->profile_id)->update([
				'file_name' => $file_name,
				'file_path' => $destinationPath
			]);
			
		}

		return redirect()->route('my-profile')->with('success', "staff data created successfully");
	}
	public function myProfile(){
		$user = Auth::user();
		$userProfile = $user->profile;

		if($user->role == 'USER'){
			return view('form/user_profile/my_profile_user_role',compact('userProfile'));
		}
		return view('form/user_profile/my_profile',compact('userProfile'));
	}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form/user_profile/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gender' => 'required',
            'first_name' => 'required|max:255',
			'last_name'=>'required|max:255',
			'skill'=>'max:255',
			'education'=>'max:300',
			'remark'=>'max:1000',
			'username'=>'required|max:255',
			'email'=>'required|max:255',
			'password'=>'required|min:6',
			'role'=>'required'
        ]);

		/** validate if new user email already exist */
		$exitUser = User::where('email',$request->email)->first();
		if($exitUser){
			$message = "Sorry! Email $exitUser->email is alreay used by other people";
			return redirect()->back()->withSuccess($message);
		}

		/** validate if new username is already exist */
		$exitUserName = User::where('name',$request->username)->first();
		if($exitUserName){
			$message = "Sorry! Username $exitUserName->name is alreay used by other people";
			return redirect()->back()->withSuccess($message);
		}

		DB::transaction(function () use ($request) {
			/** create profile */
            $userprofile = UserProfile::create([
				'gender'  => $request->gender,
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'skill' => $request->skill,
				'education'  => $request->education,
				'remark'  => $request->remark
				
			]);

			/** create user */
			$user = $userprofile->user()->create([
				'name' => $request->username,
				'role'=>$request->role,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'status'=>'active'
			]);

			

        });

		return redirect()->route('user-list')->with('success', "staff data created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
		$profileId = Crypt::decrypt($request->id);
		$userProfile = UserProfile::find($profileId);
        return view('form/user_profile/show',compact('userProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $profileId = Crypt::decrypt($request->id);
		$userProfile = UserProfile::find($profileId);
        return view('form/user_profile/edit',compact('userProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
		$request->validate([
            'gender' => 'required',
            'first_name' => 'required|max:255',
			'last_name'=>'required|max:255',
			'skill'=>'max:255',
			'education'=>'max:300',
			'remark'=>'max:1000',
        ]);

		$userProfile = UserProfile::where('id',$request->id)->update([
			'gender'  => $request->gender,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'skill' => $request->skill,
			'education'  => $request->education,
			'remark'  => $request->remark,
		]);

		$user = Auth::user();
		$userProfile = $user->profile;

		if($user->role == 'USER'){
			return view('form/user_profile/my_profile_user_role',compact('userProfile'));
		}
		return view('form/user_profile/my_profile',compact('userProfile'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}