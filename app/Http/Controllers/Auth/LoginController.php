<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseInformation;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
	public function login()
    {
        return view('auth.login');
    }
	public function dashboard(){
		return view('form/dashboard');
	}
	public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials,$request->remember))
        {
            $request->session()->regenerate();
			$user = Auth::user();
			if($user->role == 'ADMIN'){
				return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
			}elseif($user->role == 'REPORTER'){
				return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
			}elseif($user->role == 'USER'){
				return redirect()->route('user-search-case')
                ->withSuccess('You have successfully logged in!');
			}
           
        }
		return redirect()->back()->withSuccess('Sorry! You have entered invalid credentials');

    } 

	public function changePassword(){
		$user = Auth::user();
		$userProfile = $user->profile;

		if($user->role == 'USER'){
			return view('form/change_password_user_role',compact('userProfile'));
		}
		return view('form/change_password',compact('userProfile'));
		
	}

	public function updatePassword(Request $request){
		$request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
			'new_password_confirmation'=>'required',
        ]);

		/** check new password and confirm must be the same */
		if($request->new_password != $request->new_password_confirmation){
			return back()->with("error", "លេខសំងាត់​ថ្មី និង បញ្ជាក់ពាក្យសម្ងាត់ ត្រូវតែដូចគ្នា (New password and confirm password must be the same)");
		}

		#Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "ពាក្យសម្ងាត់ចាស់មិនត្រឹមត្រូវទេ។ (older password is not correct)");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "ប្តូរលេខសម្ងាត់ដោយជោគជ័យ! (Password changed successfully!)");

	}

	public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}
