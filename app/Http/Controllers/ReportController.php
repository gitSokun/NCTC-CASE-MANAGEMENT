<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Country;

class ReportController extends Controller
{
    public function userReport(Request $request){
		return view('form/report/userReport');
	}
	public function summaryCaseReportByCountry(Request $request){
		$countries = Country::get();
		return view('form/report/reportCaseByCountry',compact('countries'));
	}
	public function summaryCaseReport(Request $request){
		return view('form/report/summaryCaseReport');
	}
	public function caseReportQuery(Request $request){
		return view('form/report/reportCase');
	}
	
	public function searchUserReport(Request $request){
		$fromDate = $request->from_date;
		$toDate = $request->to_date;

		if($fromDate && $toDate ){
			$formatFromDate = Carbon::parse($fromDate)->format('Y-m-d');
			$formatToDate = Carbon::parse($toDate)->format('Y-m-d');
			$users = DB::SELECT("
				SELECT 
				a.role,
				IFNULL(a.email,'') as email,
				case b.gender
					when 'M' then 'ប្រុស'
					else 'ស្រី'
				end gender,
				IFNULL(b.first_name,'') as first_name,
				IFNULL(b.last_name,'') as last_name,
				IFNULL(b.skill,'') as skill,
				IFNULL(b.education,'') as education,
				(select count(*) from case_information ci where ci.created_by = a.id and ci.id not in (select case_id from case_info_khs))  as total_case_yet_to_translate,
				(select count(*) from case_info_khs kh where kh.created_by = a.id) as total_translate_kh
				FROM users a
				inner join user_profiles b on b.id = a.profileable_id
				where a.created_at BETWEEN ? AND ?
			",[$formatFromDate,$formatToDate]);

			$totalNotYetKH = collect($users)->sum('total_case_yet_to_translate');
			$totalTranslated = collect($users)->sum('total_translate_kh');
			return response()->json([
				'users' => $users,
				'totalNotYetKH'=>$totalNotYetKH,
				'totalTranslated'=>$totalTranslated,
				'fromDate'=>$formatFromDate,
				'toDate'=>$formatToDate
				]);
		}else{
			$users = DB::SELECT("
				SELECT 
				a.role,
				IFNULL(a.email,'') as email,
				case b.gender
					when 'M' then 'ប្រុស'
					else 'ស្រី'
				end gender,
				IFNULL(b.first_name,'') as first_name,
				IFNULL(b.last_name,'') as last_name,
				IFNULL(b.skill,'') as skill,
				IFNULL(b.education,'') as education,
				(select count(*) from case_information ci where ci.created_by = a.id and ci.id not in (select case_id from case_info_khs))  as total_case_yet_to_translate,
				(select count(*) from case_info_khs kh where kh.created_by = a.id) as total_translate_kh
				FROM users a
				inner join user_profiles b on b.id = a.profileable_id
			");

			$totalNotYetKH = collect($users)->sum('total_case_yet_to_translate');
			$totalTranslated = collect($users)->sum('total_translate_kh');
			return response()->json([
				'users' => $users,
				'totalNotYetKH'=>$totalNotYetKH,
				'totalTranslated'=>$totalTranslated,
				'fromDate'=>'',
				'toDate'=>''
				]);
		}
	}
	public function searchSummaryCaseReport(Request $request){
		$fromDate = $request->from_date;
		$toDate = $request->to_date;
		if($fromDate && $toDate){
			$formatFromDate = Carbon::parse($fromDate)->format('Y-m-d');
			$formatToDate = Carbon::parse($toDate)->format('Y-m-d');

			//'show_causing_case' -- ការវាយប្រហារ
			$causingCases = DB::SELECT("
				select 
					a.causing_case,
					count(a.causing_case) as total_case,
					sum(a.death) as total_death,
					sum(a.injure) as total_injure
				from case_information a 
				where a.activities = 'show_causing_case'
				and DATE(a.created_at) BETWEEN ? AND ?
				group by a.causing_case
			",[$formatFromDate,$formatToDate]);
			$totalAllCase = collect($causingCases)->sum('total_case');
			$totalAllDeath = collect($causingCases)->sum('total_death');
			$totalAllInjure = collect($causingCases)->sum('total_injure');

			//'show_crackdown_case'){//ការបង្ក្រាប
			$crackDownCases = DB::SELECT("
				select 
					a.causing_case,
					count(a.causing_case) as total_case,
					sum(a.death) as total_death,
					sum(a.injure) as total_injure
				from case_information a 
				where a.activities = 'show_crackdown_case'
				and DATE(a.created_at) BETWEEN ? AND ?
				group by a.causing_case
			",[$formatFromDate,$formatToDate]);
			$totalAllSupressorCase = collect($crackDownCases)->sum('total_case');
			$totalAllSupressorDeath = collect($crackDownCases)->sum('total_death');
			$totalAllSupressorInjure = collect($crackDownCases)->sum('total_injure');

			//'other_case'-- ផ្សេងៗ
			$otherCases = DB::SELECT("
				select 
					a.causing_case,
					count(a.causing_case) as total_case,
					sum(a.death) as total_death,
					sum(a.injure) as total_injure
				from case_information a 
				where a.activities = 'other_case'
				and DATE(a.created_at) BETWEEN ? AND ?
				group by a.causing_case
			",[$formatFromDate,$formatToDate]);
			$totalOtherCase = collect($otherCases)->sum('total_case');
			$totalOtherDeath = collect($otherCases)->sum('total_death');
			$totalOtherInjure = collect($otherCases)->sum('total_injure');

			return response()->json([
				// ការវាយប្រហារ
				'causingCases' => $causingCases,
				'totalAllCase'=>$totalAllCase,
				'totalAllDeath'=>$totalAllDeath,
				'totalAllInjure'=>$totalAllInjure,
				//ការបង្ក្រាប
				'crackDownCases'=>$crackDownCases,
				'totalAllSupressorCase'=>$totalAllSupressorCase,
				'totalAllSupressorDeath'=>$totalAllSupressorDeath,
				'totalAllSupressorInjure'=>$totalAllSupressorInjure,
				//ផ្សេងៗ
				'otherCases'=>$otherCases,
				'totalOtherCase'=>$totalOtherCase,
				'totalOtherDeath'=>$totalOtherDeath,
				'totalOtherInjure'=>$totalOtherInjure,

				'fromDate'=>$fromDate,
				'toDate'=>$toDate
			]);
		}else{
			return response()->json([
				// ការវាយប្រហារ
				'causingCases' => [],
				'totalAllCase'=>0,
				'totalAllDeath'=>0,
				'totalAllInjure'=>0,
				//ការបង្ក្រាប
				'crackDownCases'=>[],
				'totalAllSupressorCase'=>0,
				'totalAllSupressorDeath'=>0,
				'totalAllSupressorInjure'=>0,
				//ផ្សេងៗ
				'otherCases'=>[],
				'totalOtherCase'=>0,
				'totalOtherDeath'=>0,
				'totalOtherInjure'=>0,

				'fromDate'=>$fromDate,
				'toDate'=>$toDate
			]);
		}

	}
	public function searchCaseByCountry(Request $request){
		$fromDate = $request->from_date;
		$toDate = $request->to_date;
		$country =  $request->country;

		$query = "
			select 
				a.country,
				a.activities,
				CASE 
				WHEN a.activities = 'show_crackdown_case' THEN 'ការបង្ក្រាប'
				WHEN a.activities = 'show_causing_case' THEN 'ការវាយប្រហារ'
				ELSE 'ផ្សេងៗ'
				END activities_description,
				a.causing_case,
				count(a.causing_case) total_causing_case,
				sum(a.death) as total_death,
				sum(a.injure) as total_injure
			from case_information a 
			where a.country is not null
		";
        $params = [];
		$formatFromDate = '';
		$formatToDate = '';
		if($fromDate && $toDate){
			$formatFromDate = Carbon::parse($fromDate)->format('Y-m-d');
			$formatToDate = Carbon::parse($toDate)->format('Y-m-d');

			$query .= " AND DATE(a.created_at) BETWEEN ? AND ? ";
			$params[] = $formatFromDate;
			$params[] = $formatToDate;
		}
		if($country){
			$query .= " AND a.country = ? ";
			$params[] = $country;
		}
		$query .= " group by a.country,a.activities,a.causing_case order by a.country; ";
		$records = DB::select($query, $params);
		$groupedData = collect($records)->groupBy('country');

		return response()->json([
			'groupedData'=>$groupedData,
			'fromDate'=>$formatFromDate,
			'toDate'=>$formatToDate
		]);	
	}
	public function caseReportSearch(Request $request){
		
		$formatFromDate = Carbon::now()->subDays(30)->format('Y-m-d');  // 30 days ago
		$formatToDate = Carbon::now()->format('Y-m-d');           // Current date
		if($request->from_date && $request->to_date){
			$formatFromDate = Carbon::parse($request->from_date)->format('Y-m-d');
			$formatToDate = Carbon::parse($request->to_date)->format('Y-m-d');
		}

		$list = DB::SELECT("
			select 
				a.title,
				a.released_date,
				IFNULL(a.activities,'') as activities,
				IFNULL(a.causing_case,'') as causing_case,
				IFNULL(a.country,'') as country,
				IFNULL(a.province_city,'') as province_city,
				IFNULL(a.area,'') as area,
				IFNULL(a.death,0) as death,
				IFNULL(a.injure,0) as injure
			from case_information a
			WHERE DATE(a.released_date) BETWEEN ? AND ? 
		",[$formatFromDate,$formatToDate]);
		return response()->json([
			'list'=>$list,
			'fromDate'=>$formatFromDate,
			'toDate'=>$formatToDate
		]);	
	}
}
