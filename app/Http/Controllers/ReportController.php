<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Country;

class ReportController extends Controller
{
    //public function userReport(Request $request){
	//	return view('form/report/userReport');
	//}
	//public function summaryCaseReportByCountry(Request $request){
	//	$countries = Country::get();
	//	return view('form/report/reportCaseByCountry',compact('countries'));
	//}
	//public function summaryCaseReport(Request $request){
	//	return view('form/report/summaryCaseReport');
	//}
	//public function caseReportQuery(Request $request){
	//	return view('form/report/reportCase');
	//}
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
		$user = $request->user;

		$where = [];
		$params = [];
		if (!empty($fromDate)) {
			$where[] = "DATE(a.created_at) >= ?";
			$params[] = Carbon::parse($fromDate)->format('Y-m-d');
		}
	
		if (!empty($toDate)) {
			$where[] = "DATE(a.created_at) <= ?";
			$params[] = Carbon::parse($toDate)->format('Y-m-d');
		}
	
		if (!empty($user)) {
			$where[] = "(b.first_name LIKE ? OR b.last_name LIKE ?)";
			$params[] = "%{$user}%";
			$params[] = "%{$user}%";
		}
		$sql = "
			SELECT
				a.id,
				a.role,
				IFNULL(a.email,'') AS email,
				CASE b.gender
					WHEN 'M' THEN 'ប្រុស'
					ELSE 'ស្រី'
				END AS gender,
				IFNULL(b.first_name,'') AS first_name,
				IFNULL(b.last_name,'') AS last_name,
				IFNULL(b.skill,'') AS skill,
				IFNULL(b.education,'') AS education,
				(
					SELECT COUNT(*)
					FROM case_information ci
					WHERE ci.created_by = a.id
					AND ci.id NOT IN (SELECT case_id FROM case_info_khs)
				) AS total_case_yet_to_translate,
				(
					SELECT COUNT(*)
					FROM case_info_khs kh
					WHERE kh.created_by = a.id
				) AS total_translate_kh,
				a.created_at
			FROM users a
			INNER JOIN user_profiles b
				ON b.id = a.profileable_id
		";

		if (!empty($where)) {
			$sql .= " WHERE " . implode(" AND ", $where);
		}

		$users = DB::select($sql, $params);
		$totalNotYetKH = collect($users)->sum('total_case_yet_to_translate');
		$totalTranslated = collect($users)->sum('total_translate_kh');

		return response()->json([
			'users' => $users,
			'totalNotYetKH' => $totalNotYetKH,
			'totalTranslated' => $totalTranslated,
		]);

	}
	private function getCaseSummaryCaseReport($activity, $fromDate = null, $toDate = null)
	{
		$where = ["a.activities = ?"];
		$params = [$activity];

		if ($fromDate) {
			$where[] = "DATE(a.created_at) >= ?";
			$params[] = Carbon::parse($fromDate)->format('Y-m-d');
		}

		if ($toDate) {
			$where[] = "DATE(a.created_at) <= ?";
			$params[] = Carbon::parse($toDate)->format('Y-m-d');
		}

		$sql = "
			SELECT
				a.causing_case,
				COUNT(*) AS total_case,
				IFNULL(SUM(a.death),0) AS total_death,
				IFNULL(SUM(a.injure),0) AS total_injure
			FROM case_information a
			WHERE " . implode(' AND ', $where) . "
			GROUP BY a.causing_case
		";

		return DB::select($sql, $params);
	}
	public function searchSummaryCaseReport(Request $request){
		
		$fromDate = $request->from_date;
		$toDate = $request->to_date;

		$causingCases = $this->getCaseSummaryCaseReport('show_causing_case', $fromDate, $toDate);
		$crackDownCases = $this->getCaseSummaryCaseReport('show_crackdown_case', $fromDate, $toDate);
		$otherCases = $this->getCaseSummaryCaseReport('other_case', $fromDate, $toDate);

		//'show_causing_case' -- ការវាយប្រហារ
		$totalAllCase = collect($causingCases)->sum('total_case');
		$totalAllDeath = collect($causingCases)->sum('total_death');
		$totalAllInjure = collect($causingCases)->sum('total_injure');
		//'show_crackdown_case' -- ការបង្ក្រាប
		$totalAllSupressorCase = collect($crackDownCases)->sum('total_case');
		$totalAllSupressorDeath = collect($crackDownCases)->sum('total_death');
		$totalAllSupressorInjure = collect($crackDownCases)->sum('total_injure');
		//'other_case'-- ផ្សេងៗ
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

	}
	public function searchCaseByCountry(Request $request){

		$fromDate = $request->from_date;
		$toDate   = $request->to_date;
		$country  = $request->country;
	
		$where = ["a.id is not null"];
		$params = [];
	
		if (!empty($fromDate)) {
			$where[] = "DATE(a.created_at) >= ?";
			$params[] = Carbon::parse($fromDate)->format('Y-m-d');
		}
	
		if (!empty($toDate)) {
			$where[] = "DATE(a.created_at) <= ?";
			$params[] = Carbon::parse($toDate)->format('Y-m-d');
		}
	
		if (!empty($country)) {
			//$where[] = "a.country = ?";
			//$params[] = $country;
			$where[] = "a.country LIKE ?";
			$params[] = "%{$country}%";
		}
	
		$sql = "
			SELECT
				a.country,
				a.activities,
				CASE
					WHEN a.activities = 'show_crackdown_case' THEN 'ការបង្ក្រាប'
					WHEN a.activities = 'show_causing_case' THEN 'ការវាយប្រហារ'
					ELSE 'ផ្សេងៗ'
				END AS activities_description,
				a.causing_case,
				COUNT(*) AS total_causing_case,
				IFNULL(SUM(a.death), 0) AS total_death,
				IFNULL(SUM(a.injure), 0) AS total_injure
			FROM case_information a
			WHERE " . implode(' AND ', $where) . "
			GROUP BY
				a.country,
				a.activities,
				a.causing_case
			ORDER BY
				a.country,
				a.activities,
				a.causing_case
		";
	
		$records = DB::select($sql, $params);
		$totalCausingCase = collect($records)->sum('total_causing_case');


		return response()->json([
			'totalCausingCase' => $totalCausingCase,
			'groupedData' => collect($records)->groupBy('country'),
			'fromDate'    => $fromDate,
			'toDate'      => $toDate,
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