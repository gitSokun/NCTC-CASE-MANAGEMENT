<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function userReport(Request $request){
		return view('form/report/userReport');
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

}
