<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Action;

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
		$actions = Action::get();
		return view('form/report/summaryCaseReport',compact('actions'));
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

	private function getCaseSummaryCaseReport($fromDate = null, $toDate = null, $activity = null,$releasedFromDate= null,$releasedToDate= null,$actualFromDate= null,$actualToDate = null)
	{
		$query = DB::table('case_information as a')
		    ->leftJoin('case_info_khs as b', 'b.case_id', '=', 'a.id')
			->selectRaw("
			    a.created_at,
				a.released_date,
				a.actual_date,
			    a.case_number,
				a.activities,
				COALESCE(b.title, a.causing_case) AS causing_case,
				1 as total_case,
				COALESCE(a.death,0) as total_death,
				COALESCE(a.injure,0) as total_injure
			");

		//កាលបរិច្ឆេទចុះបញ្ជី
		if ($fromDate) {
			$query->where('a.created_at', '>=', Carbon::parse($fromDate)->startOfDay());
		}
		if ($toDate) {
			$query->where('a.created_at', '<=', Carbon::parse($toDate)->endOfDay());
		}
		//កាលបរិច្ឆេទចុះផ្សាយ
		if ($releasedFromDate) {
			$query->where('a.released_date', '>=', Carbon::parse($releasedFromDate)->startOfDay());
		}
		if ($releasedToDate) {
			$query->where('a.released_date', '<=', Carbon::parse($releasedToDate)->endOfDay());
		}
		//កាលបរិច្ឆេទជាក់ស្តែង
		if ($actualFromDate) {
			$query->where('a.actual_date', '>=', Carbon::parse($actualFromDate)->startOfDay());
		}
		if ($actualToDate) {
			$query->where('a.actual_date', '<=', Carbon::parse($actualToDate)->endOfDay());
		}

		if ($activity) {
			$query->where('a.activities', '=', $activity);
		}

		//$releasedFromDate,$releasedToDate,$actualFromDate,$actualToDate
		return $query
			->orderBy('a.activities')
			->get();
	}

	public static function getActivityName($activity, $dynamicActions = [])
    {
        $static = [
            'show_none'            => 'N/A',
            'other_case'           => 'ផ្សេងៗ',
            'show_causing_case'    => 'ការវាយប្រហារ',
            'show_crackdown_case'  => 'ការបង្ក្រាប',
        ];

        if (isset($static[$activity])) {
            return $static[$activity];
        }

        return $dynamicActions[$activity] ?? $activity;
    }
	public function searchSummaryCaseReport(Request $request){

		// Load all dynamic actions once
		$actions = DB::table('actions')
			->pluck('name', 'id')
			->toArray();
	
		// កាលបរិច្ឆេទចុះបញ្ជី
		$fromDate = $request->from_date;
		$toDate = $request->to_date;
		// កាលបរិច្ឆេទចុះផ្សាយ
		$releasedFromDate = $request->released_fromDate;
		$releasedToDate = $request->released_toDate;
		//កាលបរិច្ឆេទជាក់ស្តែង
		$actualFromDate = $request->actual_fromDate;
		$actualToDate = $request->actual_toDate;

		$activity = $request->activities;
		$rows = $this->getCaseSummaryCaseReport($fromDate, $toDate, $activity,$releasedFromDate,$releasedToDate,$actualFromDate,$actualToDate);
	
		// Group by activity
		$activities = $rows->groupBy('activities');

		$totalRows = 0;
		$result = [];
	
		foreach ($activities as $activity => $cases) {
	
			$rowCount = $cases->count();

			$totalRows += $rowCount;

			$result[] = [
	
				'activity_code' => $activity,
				'activity_name' => $this->getActivityName(
					$activity,
					$actions
				),
	
				'cases' => $cases->values(),
	
				'total_case' => $cases->sum('total_case'),
	
				'total_death' => $cases->sum('total_death'),
	
				'total_injure' => $cases->sum('total_injure'),
	
			];
		}


		return response()->json([
			'caseActivities' => $result,
			'fromDate'=>$fromDate,
			'toDate'=>$toDate,
			'totalRows'=>$totalRows
		]);

	}

	private function getCaseSummaryCaseReportByCountry(
		$fromDate = null, 
		$toDate = null, 
		$country = null,
		$releasedFromDate= null,
		$releasedToDate= null,
		$actualFromDate= null,
		$actualToDate = null)
	{
		$query = DB::table('case_information as a')
		    ->leftJoin('case_info_khs as b', 'b.case_id', '=', 'a.id')
			->leftJoin('actions as ac', 'b.activities', '=', 'ac.id')
			->selectRaw("
			    COALESCE(a.country,'N/A' ) as country,
			    a.created_at,
				a.released_date,
				a.actual_date,
			    a.case_number,
				a.activities,
				CASE b.activities
					WHEN 'show_none' THEN 'N/A'
					WHEN 'other_case' THEN 'ផ្សេងៗ'
					WHEN 'show_causing_case' THEN 'ការវាយប្រហារ'
					WHEN 'show_crackdown_case' THEN 'ការបង្ក្រាប'
					ELSE ac.name
				END AS activity_name,
				COALESCE(b.title, a.causing_case) AS causing_case,
				1 as total_case,
				COALESCE(a.death,0) as total_death,
				COALESCE(a.injure,0) as total_injure
			");
		

		//កាលបរិច្ឆេទចុះបញ្ជី
		if ($fromDate) {
			$query->where('a.created_at', '>=', Carbon::parse($fromDate)->startOfDay());
		}
		if ($toDate) {
			$query->where('a.created_at', '<=', Carbon::parse($toDate)->endOfDay());
		}
		//កាលបរិច្ឆេទចុះផ្សាយ
		if ($releasedFromDate) {
			$query->where('a.released_date', '>=', Carbon::parse($releasedFromDate)->startOfDay());
		}
		if ($releasedToDate) {
			$query->where('a.released_date', '<=', Carbon::parse($releasedToDate)->endOfDay());
		}
		//កាលបរិច្ឆេទជាក់ស្តែង
		if ($actualFromDate) {
			$query->where('a.actual_date', '>=', Carbon::parse($actualFromDate)->startOfDay());
		}
		if ($actualToDate) {
			$query->where('a.actual_date', '<=', Carbon::parse($actualToDate)->endOfDay());
		}
		if ($country) {
			$query->where('a.country', 'LIKE', "%{$country}%");
		}
		//return $query;
		return $query
			->orderBy('a.activities')
			->get();
	}
	public function searchCaseByCountry(Request $request){
		
		//កាលបរិច្ឆេទចុះបញ្ជី
		$fromDate = $request->from_date;
		$toDate   = $request->to_date;
		// កាលបរិច្ឆេទចុះផ្សាយ
		$releasedFromDate = $request->released_fromDate;
		$releasedToDate = $request->released_toDate;
		//កាលបរិច្ឆេទជាក់ស្តែង
		$actualFromDate = $request->actual_fromDate;
		$actualToDate = $request->actual_toDate;
		//Country
		$country  = $request->country;
		$rows = $this->getCaseSummaryCaseReportByCountry(
			$fromDate, 
			$toDate, 
			$country,
			$releasedFromDate,
			$releasedToDate,
			$actualFromDate,
			$actualToDate);

		// Group by activity
		$caseGropCountryList = $rows->groupBy('country');
		$result = [];
		$totalRows = 0;
		
		foreach ($caseGropCountryList as $country => $cases) {
		
			$rowCount = $cases->count();
			$totalRows += $rowCount;
		
			$result[] = [
				'country'       => $country,
				'cases'         => $cases->values(),
		
				'total_case'    => $cases->sum('total_case'),
				'total_death'   => $cases->sum('total_death'),
				'total_injure'  => $cases->sum('total_injure'),
			];
		}

		return response()->json([
			'caseGropCountryList'=>$result,
			'totalRows'=>$totalRows,
			//កាលបរិច្ឆេទចុះបញ្ជី
			'fromDate'    => $fromDate,
			'toDate'      => $toDate,
			// កាលបរិច្ឆេទចុះផ្សាយ
			'releasedFromDate'    => $releasedFromDate,
			'releasedToDate'      => $releasedToDate,
			//កាលបរិច្ឆេទជាក់ស្តែង
			'actualFromDate'    => $actualFromDate,
			'actualToDate'      => $actualToDate,
		]);
	}
	private function getFilterCaseReport(
		$fromDate = null, 
		$toDate = null, 
		$title = null,
		$releasedFromDate= null,
		$releasedToDate= null,
		$actualFromDate= null,
		$actualToDate = null)
	{
		$query = DB::table('case_information as a')
		    ->leftJoin('case_info_khs as b', 'b.case_id', '=', 'a.id')
			->leftJoin('actions as ac', 'b.activities', '=', 'ac.id')
			->selectRaw("
			    COALESCE(a.country,'N/A' ) as country,
			    a.created_at,
				a.released_date,
				a.actual_date,
			    a.case_number,
				a.activities,
				CASE b.activities
					WHEN 'show_none' THEN 'N/A'
					WHEN 'other_case' THEN 'ផ្សេងៗ'
					WHEN 'show_causing_case' THEN 'ការវាយប្រហារ'
					WHEN 'show_crackdown_case' THEN 'ការបង្ក្រាប'
					ELSE ac.name
				END AS activity_name,
				COALESCE(b.title, a.causing_case) AS causing_case,
				1 as total_case,
				COALESCE(a.death,0) as total_death,
				COALESCE(a.injure,0) as total_injure
			");
		

		//កាលបរិច្ឆេទចុះបញ្ជី
		if ($fromDate) {
			$query->where('a.created_at', '>=', Carbon::parse($fromDate)->startOfDay());
		}
		if ($toDate) {
			$query->where('a.created_at', '<=', Carbon::parse($toDate)->endOfDay());
		}
		//កាលបរិច្ឆេទចុះផ្សាយ
		if ($releasedFromDate) {
			$query->where('a.released_date', '>=', Carbon::parse($releasedFromDate)->startOfDay());
		}
		if ($releasedToDate) {
			$query->where('a.released_date', '<=', Carbon::parse($releasedToDate)->endOfDay());
		}
		//កាលបរិច្ឆេទជាក់ស្តែង
		if ($actualFromDate) {
			$query->where('a.actual_date', '>=', Carbon::parse($actualFromDate)->startOfDay());
		}
		if ($actualToDate) {
			$query->where('a.actual_date', '<=', Carbon::parse($actualToDate)->endOfDay());
		}
		if ($title) {
			$query->where('a.causing_case', 'LIKE', "%{$title}%");
		}
		//return $query;
		return $query
			->orderBy('a.activities')
			->get();
	}
	public function caseReportSearch(Request $request){
		
		//កាលបរិច្ឆេទចុះបញ្ជី
		$fromDate = $request->from_date;
		$toDate   = $request->to_date;
		// កាលបរិច្ឆេទចុះផ្សាយ
		$releasedFromDate = $request->released_fromDate;
		$releasedToDate = $request->released_toDate;
		//កាលបរិច្ឆេទជាក់ស្តែង
		$actualFromDate = $request->actual_fromDate;
		$actualToDate = $request->actual_toDate;
		//filterCase
		$filterCase  = $request->filterCase;

		$cases = $this->getFilterCaseReport(
			$fromDate, 
			$toDate, 
			$filterCase,
			$releasedFromDate,
			$releasedToDate,
			$actualFromDate,
			$actualToDate);
		$rowCount = $cases->count();
		return response()->json([
			'cases'=>$cases,
			'totalRows'=>$rowCount,
			//កាលបរិច្ឆេទចុះបញ្ជី
			'fromDate'    => $fromDate,
			'toDate'      => $toDate,
			// កាលបរិច្ឆេទចុះផ្សាយ
			'releasedFromDate'    => $releasedFromDate,
			'releasedToDate'      => $releasedToDate,
			//កាលបរិច្ឆេទជាក់ស្តែង
			'actualFromDate'    => $actualFromDate,
			'actualToDate'      => $actualToDate,
		]);
	}
}