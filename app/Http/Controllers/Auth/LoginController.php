<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseInformation;
use App\Models\CaseInfoKh;
use Illuminate\Support\Facades\Hash;
use DB;

class LoginController extends Controller
{
	public function login()
    {
        return view('auth.login');
    }
	public function dashboard(){
		//other_case: ផ្សេងៗ / show_none: ''
		$totalOtherCase = CaseInformation::whereIn('activities',['other_case','show_none'])->count();
		//show_causing_case: ការវាយប្រហារ
		$totalCausingCase = CaseInformation::whereIn('activities',['show_causing_case'])->count();
		//show_crackdown_case: ការបង្ក្រាប
		$totalCrackdownCase = CaseInformation::whereIn('activities',['show_crackdown_case'])->count();
		//ចំនួនព្រឹត្តិការណ៍សរុប
		$totalCases = $totalOtherCase+$totalCausingCase+$totalCrackdownCase;
		//ចំនួនព្រឹត្តិការណ៍មិនទាន់បកប្រែ
		$totalOriginalCase = CaseInformation::whereNotIn('id', function ($query) {
			$query->select('case_id')
				  ->from('case_info_khs');
		})->count();
		//ចំនួនព្រឹត្តិការណ៍បកប្រែរួចរាល់
		$totalCaseTranslated=CaseInfoKh::count();
		//------------ ចំនួនព្រឹត្តិការណ៍ --------------
		$data = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
		->whereYear('created_at', date('Y'))
		->groupByRaw('MONTH(created_at)')
		->pluck('total', 'month');
		$monthlyCases = [];
		for ($i = 1; $i <= 12; $i++) {
			$monthlyCases[] = $data[$i] ?? 0;
		}
		//------------ ចំនួនផ្សេងៗ --------------
		$otherCases = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
		->whereYear('created_at', date('Y'))
		->whereIn('activities',['other_case','show_none'])
		->groupByRaw('MONTH(created_at)')
		->pluck('total', 'month');
		$monthlyOtherCases = [];
		for ($i = 1; $i <= 12; $i++) {
			$monthlyOtherCases[] = $otherCases[$i] ?? 0;
		}
		//------------ ចំនួនការវាយប្រហារ --------------
		$CausingCases = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
		->whereYear('created_at', date('Y'))
		->whereIn('activities',['show_causing_case'])
		->groupByRaw('MONTH(created_at)')
		->pluck('total', 'month');
		$monthlyCausingCases = [];
		for ($i = 1; $i <= 12; $i++) {
			$monthlyCausingCases[] = $CausingCases[$i] ?? 0;
		}
		//------------ ចំនួនការបង្ក្រាប --------------
		$CrackdownCase = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
		->whereYear('created_at', date('Y'))
		->whereIn('activities',['show_causing_case'])
		->groupByRaw('MONTH(created_at)')
		->pluck('total', 'month');
		$monthlyCrackdownCase = [];
		for ($i = 1; $i <= 12; $i++) {
			$monthlyCrackdownCase[] = $CrackdownCase[$i] ?? 0;
		}
		//--current year
		$currentYear = date('Y');

		return view('form/dashboard',compact(
			'currentYear',
			'totalOtherCase',
			'totalCausingCase',
			'totalCrackdownCase',
			'totalCases',
			'totalOriginalCase',
			'totalCaseTranslated',
			'monthlyCases',//ចំនួនព្រឹត្តិការណ៍
			'monthlyOtherCases',//ចំនួនផ្សេងៗ
			'monthlyCausingCases',//ចំនួនការវាយប្រហារ
			'monthlyCrackdownCase'//ចំនួនការបង្ក្រាប
		));
	}
	public function dashboardSearchByYear(Request $request){
		if($request->chart_date){
			//other_case: ផ្សេងៗ / show_none: ''
			$totalOtherCase = CaseInformation::whereIn('activities',['other_case','show_none'])->count();
			//show_causing_case: ការវាយប្រហារ
			$totalCausingCase = CaseInformation::whereIn('activities',['show_causing_case'])->count();
			//show_crackdown_case: ការបង្ក្រាប
			$totalCrackdownCase = CaseInformation::whereIn('activities',['show_crackdown_case'])->count();
			//ចំនួនព្រឹត្តិការណ៍សរុប
			$totalCases = $totalOtherCase+$totalCausingCase+$totalCrackdownCase;
			//ចំនួនព្រឹត្តិការណ៍មិនទាន់បកប្រែ
			$totalOriginalCase = CaseInformation::whereNotIn('id', function ($query) {
				$query->select('case_id')
					->from('case_info_khs');
			})->count();
			//ចំនួនព្រឹត្តិការណ៍បកប្រែរួចរាល់
			$totalCaseTranslated=CaseInfoKh::count();
			//============= query for chart ============
			//------------ ចំនួនព្រឹត្តិការណ៍ --------------
			$data = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', $request->chart_date)
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyCases = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyCases[] = $data[$i] ?? 0;
			}
			//------------ ចំនួនផ្សេងៗ --------------
			$otherCases = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', $request->chart_date)
			->whereIn('activities',['other_case','show_none'])
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyOtherCases = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyOtherCases[] = $otherCases[$i] ?? 0;
			}
			//------------ ចំនួនការវាយប្រហារ --------------
			$CausingCases = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', $request->chart_date)
			->whereIn('activities',['show_causing_case'])
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyCausingCases = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyCausingCases[] = $CausingCases[$i] ?? 0;
			}
			//------------ ចំនួនការបង្ក្រាប --------------
			$CrackdownCase = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', $request->chart_date)
			->whereIn('activities',['show_causing_case'])
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyCrackdownCase = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyCrackdownCase[] = $CrackdownCase[$i] ?? 0;
			}
			//--current year
			$currentYear = $request->chart_date;

			return view('form/dashboard',compact(
				'currentYear',
				'totalOtherCase',
				'totalCausingCase',
				'totalCrackdownCase',
				'totalCases',
				'totalOriginalCase',
				'totalCaseTranslated',
				'monthlyCases',//ចំនួនព្រឹត្តិការណ៍
				'monthlyOtherCases',//ចំនួនផ្សេងៗ
				'monthlyCausingCases',//ចំនួនការវាយប្រហារ
				'monthlyCrackdownCase'//ចំនួនការបង្ក្រាប
			));

		}else{
			//other_case: ផ្សេងៗ / show_none: ''
			$totalOtherCase = CaseInformation::whereIn('activities',['other_case','show_none'])->count();
			//show_causing_case: ការវាយប្រហារ
			$totalCausingCase = CaseInformation::whereIn('activities',['show_causing_case'])->count();
			//show_crackdown_case: ការបង្ក្រាប
			$totalCrackdownCase = CaseInformation::whereIn('activities',['show_crackdown_case'])->count();
			//ចំនួនព្រឹត្តិការណ៍សរុប
			$totalCases = $totalOtherCase+$totalCausingCase+$totalCrackdownCase;
			//ចំនួនព្រឹត្តិការណ៍មិនទាន់បកប្រែ
			$totalOriginalCase = CaseInformation::whereNotIn('id', function ($query) {
				$query->select('case_id')
					->from('case_info_khs');
			})->count();
			//ចំនួនព្រឹត្តិការណ៍បកប្រែរួចរាល់
			$totalCaseTranslated=CaseInfoKh::count();
			//============= query for chart ============
			//------------ ចំនួនព្រឹត្តិការណ៍ --------------
			$data = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', date('Y'))
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyCases = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyCases[] = $data[$i] ?? 0;
			}
			//------------ ចំនួនផ្សេងៗ --------------
			$otherCases = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', date('Y'))
			->whereIn('activities',['other_case','show_none'])
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyOtherCases = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyOtherCases[] = $otherCases[$i] ?? 0;
			}
			//------------ ចំនួនការវាយប្រហារ --------------
			$CausingCases = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', date('Y'))
			->whereIn('activities',['show_causing_case'])
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyCausingCases = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyCausingCases[] = $CausingCases[$i] ?? 0;
			}
			//------------ ចំនួនការបង្ក្រាប --------------
			$CrackdownCase = CaseInformation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
			->whereYear('created_at', date('Y'))
			->whereIn('activities',['show_causing_case'])
			->groupByRaw('MONTH(created_at)')
			->pluck('total', 'month');
			$monthlyCrackdownCase = [];
			for ($i = 1; $i <= 12; $i++) {
				$monthlyCrackdownCase[] = $CrackdownCase[$i] ?? 0;
			}
			//--current year
			$currentYear = date('Y');

			return view('form/dashboard',compact(
				'currentYear',
				'totalOtherCase',
				'totalCausingCase',
				'totalCrackdownCase',
				'totalCases',
				'totalOriginalCase',
				'totalCaseTranslated',
				'monthlyCases',//ចំនួនព្រឹត្តិការណ៍
				'monthlyOtherCases',//ចំនួនផ្សេងៗ
				'monthlyCausingCases',//ចំនួនការវាយប្រហារ
				'monthlyCrackdownCase'//ចំនួនការបង្ក្រាប
			));
		}

	}

	public function dashboardReporter(){
		return view('form/dashboard-reporter');
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
				return redirect()->route('dashboard-reporter')
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
