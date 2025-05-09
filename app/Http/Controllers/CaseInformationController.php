<?php

namespace App\Http\Controllers;

use DB;
use App\Models\CaseInformation;
use App\Models\CaseInfoKh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\CausingCase;
use App\Models\Country;
use App\Models\CaseUpload;
use App\Models\Action;
use Carbon\Carbon;
Use Exception;

class CaseInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$search = '';
		$user = Auth::user();
		$isRoleAdmin = false;

		if($user->role == 'ADMIN'){
			$cases = CaseInformation::select(
				'case_information.*',
				'case_information.created_by as user_id_created_case',
				'case_info_khs.created_by as user_id_created_caseKh', 
				'case_info_khs.id as case_id_kh',
				'case_info_khs.title as title_kh',
				'case_info_khs.case_number as case_number_kh',
				'case_info_khs.description as description_kh',
				'case_info_khs.country as country_kh',
				'case_info_khs.province_city as province_city_kh',
				'case_info_khs.area as area_kh'
				)
			->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
			->where('case_information.status','=','Active')
			->orderBy('case_information.created_at', 'DESC')
			->paginate(10);
			$isRoleAdmin = true;
			return view('form/case/index',compact('cases','user','isRoleAdmin','search'));
		}

		$cases = CaseInformation::select(
			'case_information.*',
			'case_information.created_by as user_id_created_case',
			'case_info_khs.created_by as user_id_created_caseKh', 
			'case_info_khs.id as case_id_kh',
			'case_info_khs.title as title_kh',
			'case_info_khs.case_number as case_number_kh',
			'case_info_khs.description as description_kh',
			'case_info_khs.country as country_kh',
			'case_info_khs.province_city as province_city_kh',
			'case_info_khs.area as area_kh'
			)
		->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
		->where('case_information.created_by',$user->id)
		->orWhere('case_info_khs.created_by',$user->id)
		->where('case_information.status','=','Active')
		->orderBy('case_information.created_at', 'DESC')
		->paginate(10);

		return view('form/case/index',compact('cases','user','isRoleAdmin','search'));
    }
	public function searchIndex(Request $request){

		$search = '';
		if($request->search){
			$search = $request->search;
			$string ='%'.$search.'%' ;
		}

		$user = Auth::user();
		$isRoleAdmin = false;
        
		if($search){
			if($user->role == 'ADMIN'){
				$cases = CaseInformation::select(
					'case_information.*',
					'case_information.created_by as user_id_created_case',
					'case_info_khs.created_by as user_id_created_caseKh', 
					'case_info_khs.id as case_id_kh',
					'case_info_khs.title as title_kh',
					'case_info_khs.case_number as case_number_kh',
					'case_info_khs.description as description_kh',
					'case_info_khs.country as country_kh',
					'case_info_khs.province_city as province_city_kh',
					'case_info_khs.area as area_kh'
					)
				->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
				->where('case_information.status','=','Active')
	
				->where('case_information.title', 'like', $string)
				->orWhere('case_information.description', 'like', $string)
				->orWhere('case_information.case_number','like',$string)
	
				->orWhere('case_info_khs.title', 'like', $string)
				->orWhere('case_info_khs.description', 'like', $string)
				->orWhere('case_info_khs.case_number','like',$string)
	
				->orderBy('case_information.created_at', 'DESC')
				->paginate(10);
				$isRoleAdmin = true;
				return view('form/case/index',compact('cases','user','isRoleAdmin','search'));
			}
	
			$cases = CaseInformation::select(
				'case_information.*',
				'case_information.created_by as user_id_created_case',
				'case_info_khs.created_by as user_id_created_caseKh', 
				'case_info_khs.id as case_id_kh',
				'case_info_khs.title as title_kh',
				'case_info_khs.case_number as case_number_kh',
				'case_info_khs.description as description_kh',
				'case_info_khs.country as country_kh',
				'case_info_khs.province_city as province_city_kh',
				'case_info_khs.area as area_kh'
				)
			->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
			->where('case_information.created_by',$user->id)
			->orWhere('case_info_khs.created_by',$user->id)
			->where('case_information.status','=','Active')
	
			->where('case_information.title', 'like', $string)
			->orWhere('case_information.description', 'like', $string)
			->orWhere('case_information.case_number','like',$string)
	
			->orWhere('case_info_khs.title', 'like', $string)
			->orWhere('case_info_khs.description', 'like', $string)
			->orWhere('case_info_khs.case_number','like',$string)
	
			->orderBy('case_information.created_at', 'DESC')
			->paginate(10);
	
			return view('form/case/index',compact('cases','user','isRoleAdmin','search'));
		}else{
			if($user->role == 'ADMIN'){
				$cases = CaseInformation::select(
					'case_information.*',
					'case_information.created_by as user_id_created_case',
					'case_info_khs.created_by as user_id_created_caseKh', 
					'case_info_khs.id as case_id_kh',
					'case_info_khs.title as title_kh',
					'case_info_khs.case_number as case_number_kh',
					'case_info_khs.description as description_kh',
					'case_info_khs.country as country_kh',
					'case_info_khs.province_city as province_city_kh',
					'case_info_khs.area as area_kh'
					)
				->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
				->where('case_information.status','=','Active')
				->orderBy('case_information.created_at', 'DESC')
				->paginate(10);
				$isRoleAdmin = true;
				return view('form/case/index',compact('cases','user','isRoleAdmin','search'));
			}
	
			$cases = CaseInformation::select(
				'case_information.*',
				'case_information.created_by as user_id_created_case',
				'case_info_khs.created_by as user_id_created_caseKh', 
				'case_info_khs.id as case_id_kh',
				'case_info_khs.title as title_kh',
				'case_info_khs.case_number as case_number_kh',
				'case_info_khs.description as description_kh',
				'case_info_khs.country as country_kh',
				'case_info_khs.province_city as province_city_kh',
				'case_info_khs.area as area_kh'
				)
			->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
			->where('case_information.created_by',$user->id)
			->orWhere('case_info_khs.created_by',$user->id)
			->where('case_information.status','=','Active')
			->orderBy('case_information.created_at', 'DESC')
			->paginate(10);
	
			return view('form/case/index',compact('cases','user','isRoleAdmin','search'));
		}

		
	}

	public function download($id){
		try{
			$case = CaseUpload::find($id);
			return \Storage::disk('local')->download($case->file_path);  
		}catch (\Exception $exception){
			abort(404);
		}
		
	}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$actions = Action::get();
		$causingCases = CausingCase::get();
		$countries = Country::get();

		$caseInfo = new CaseInformation();
		$caseNumber = $caseInfo->getCaseNumber();

		return view('form/case/create',compact('actions','causingCases','countries','caseNumber'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createKhmerCase(Request $request)
    {
		$caseId = Crypt::decrypt($request->id);
		$case = CaseInformation::find($caseId);
		$countries = Country::get();
		$caseInfo = new CaseInfoKh();
		$caseNumber = $caseInfo->getCaseNumber();

			if($case->released_date){
				$khmerMonths =['','មករា','កុម្ភៈ','មិនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
				$date = Carbon::parse($case->released_date);
				$Formatdate = $date->format('Y-m-d');
	
				$releaseDates = explode('-', $Formatdate);
				$case->releaseYear = $releaseDates[0];
				$case->releaseMonth = $khmerMonths[ltrim($releaseDates[1], '0')];
				$case->releaseDay = $releaseDates[2];
			}else{
				$case->releaseYear = '';
				$case->releaseMonth = '';
				$case->releaseDay = '';
			}
	
			$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();
	
			/** find related news */
			$relatedCases = CaseInformation::where('related_case_number',$case->case_number)->whereNotNull('related_case_number')->get();
	
			$latestCases = CaseInformation::orderBy('created_at', 'DESC')->paginate(5);
			$actions = Action::get();
			return view('form/case/create-khmer-case',compact('case','actions','countries','caseUploads','relatedCases','latestCases','caseNumber'));
		
    }
	public function storeKhmerCase(Request $request){
		$request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
		DB::transaction(function () use ($request) {

		/** អ្នកបង្រ្កាប */
		$suppressors = collect([]);
		$suprressorNum = 0;
		$suppressorOrgs   = $request->suppressors_orgs;
		$suppressorGroups = $request->suppressor_groups;
		foreach($suppressorOrgs as $suppressorOrg){
			if($suppressorOrg != null || $suppressorGroups[$suprressorNum] != null){
				$suppressors->push([
					'suppressors_org'=>$suppressorOrg,
					'suppressor_group'=>$suppressorGroups[$suprressorNum]
				]);
			}
			
			$suprressorNum ++;
		}

		/** អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ  */
		$attackers = collect([]);
		$attackerIndex = 0;
		$attackOrgs   = $request->attack_orgs;
		$attackGroups   = $request->attack_groups;
		foreach($attackOrgs as $attackOrg){
			if($attackOrg != null || $attackGroups[$attackerIndex] != null){
				$attackers->push([
					'attack_org'=>$attackOrg,
					'attack_group'=>$attackGroups[$attackerIndex]
				]);
			}
			$attackerIndex ++;
		}


		/** អ្នកដែលត្រូវបានបង្ក្រាប */
		$suppresseds = collect([]);
		$suppressedOrgs   = $request->suppressed_orgs;
		$suppressedGroups   = $request->suppressed_groups;
		$suppressedIndex = 0;
		foreach($suppressedOrgs as $suppressedOrg){
			if($suppressedOrg != null || $suppressedGroups[$suppressedIndex] != null){
				$suppresseds->push([
					'suppressed_org'=>$suppressedOrg,
					'suppressed_group'=>$suppressedGroups[$suppressedIndex],
				]);
				$suppressedIndex ++;
			}
		}


		/** អ្នករងគ្រោះ */
		$victims = collect([]);
		$victimOrgs   = $request->victim_orgs;
		$victimGroups   = $request->victim_groups;
		$victimIndex = 0;
		foreach($victimOrgs as $victimOrg){
			if($victimOrg != null || $victimGroups[$victimIndex] != null){
				$victims->push([
					'victim_org'=>$victimOrg,
					'victim_group'=>$victimGroups[$victimIndex],
				]);
			}
			$victimIndex ++;
		}

		/** ទីតាំងបង្ក្រាប */
		$crackdowns = collect([]);
		$crackdownCountries   = $request->crackdown_countries;
		$crackdownProvinces   = $request->crackdown_provinces;
		$crackdownAreas   = $request->crackdown_areas;
		$crackdownIndex = 0;
		foreach($crackdownCountries as $crackdownCountry){
			if($crackdownCountry != null || $crackdownProvinces[$crackdownIndex] != null || $crackdownAreas[$crackdownIndex] != null){
				$crackdowns->push([
					'crackdown_country'=>$crackdownCountry,
					'crackdown_province'=>$crackdownProvinces[$crackdownIndex],
					'crackdown_area'=>$crackdownAreas[$crackdownIndex]
				]);
			}
			$crackdownIndex ++;
		}

		/** ទីតាំងវាយប្រហារ */
		$attacks = collect([]);
		$attackedCountries   = $request->attacked_countries;
		$attackedProvinces   = $request->attacked_provinces;
		$attackedAreas   = $request->attacked_areas;
		$attackIndex = 0;
		foreach($attackedCountries as $attackedCountry){
			if($attackedCountry != null || $attackedProvinces[$attackIndex] != null || $attackedAreas[$attackIndex] != null){
				$attacks->push([
					'attacked_country'=>$attackedCountry,
					'attacked_province'=>$attackedProvinces[$attackIndex],
					'attacked_area'=>$attackedAreas[$attackIndex]
				]);
			}
			$attackIndex ++;
		}


			/** get case_number */
			$caseInfo = new CaseInfoKh();
			$caseNumber = $caseInfo->getCaseNumber();

			/** find existing case number of kh or not */
			$existCase = CaseInfoKh::where('case_id', $request->case_id)->first();
			if($existCase){
				CaseInfoKh::where('id',$existCase->id)->update([
					'title' => $request->title,
					'description'=>$request->description,
					'released_date'=>$request->released_date,
					'actual_date'=>$request->actual_date,
					'death'=>$request->death,
					'injure'=>$request->injure,
					'activities'=>$request->activities,
					'causing_case'=>$request->causing_case,
					'country'=>$request->country,
					'province_city'=>$request->province_city,
					'area'=>$request->area,
					'provocative_group'=>$request->provocative_group,
					'victim'=>$request->victim,
					'perpetrator_name'=>$request->perpetrator_name,
					'victim_name'=>$request->victim_name,

					'detention'=>$request->detention,//ចំនួនឃុំខ្លួន
					'relocate'=>$request->relocate,//ផ្លាស់ទីលំនៅ
					'migration'=>$request->migration,//ចំណាកស្រុក
					'provocative_case'=>$request->provocative_case,//ករណីបង្កហេតុ
					'suppressors'=>$suppressors,//ករណីបង្កហេតុ
					'attackers'=>$attackers,//្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
					'suppressed'=>$suppresseds,// អ្នកដែលត្រូវបានបង្ក្រាប 
					'victims'=>$victims,// អ្នករងគ្រោះ 
					'crackdowns'=>$crackdowns,//ទីតាំងបង្ក្រាប 
					'attackeds'=>$attacks,//ទីតាំងវាយប្រហារ 
					'other_material'=>$request->other_material,
					'other_losses'=>$request->other_losses,

					'status'=>'Active'
				]);
			}else{
				/** create case information */
				$case = CaseInfoKh::create([
					'case_number'=>$caseNumber,
					'case_id'=>$request->case_id,
					'title' => $request->title,
					'description'=>$request->description,
					'released_date'=>$request->released_date,
					'actual_date'=>$request->actual_date,
					'death'=>$request->death,
					'injure'=>$request->injure,
					'activities'=>$request->activities,
					'causing_case'=>$request->causing_case,
					'country'=>$request->country,
					'province_city'=>$request->province_city,
					'area'=>$request->area,
					'provocative_group'=>$request->provocative_group,
					'victim'=>$request->victim,
					'perpetrator_name'=>$request->perpetrator_name,
					'victim_name'=>$request->victim_name,

					'detention'=>$request->detention,//ចំនួនឃុំខ្លួន
					'relocate'=>$request->relocate,//ផ្លាស់ទីលំនៅ
					'migration'=>$request->migration,//ចំណាកស្រុក
					'provocative_case'=>$request->provocative_case,//ករណីបង្កហេតុ
					'suppressors'=>$suppressors,//ករណីបង្កហេតុ
					'attackers'=>$attackers,//្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
					'suppressed'=>$suppresseds,// អ្នកដែលត្រូវបានបង្ក្រាប 
					'victims'=>$victims,// អ្នករងគ្រោះ 
					'crackdowns'=>$crackdowns,//ទីតាំងបង្ក្រាប 
					'attackeds'=>$attacks,//ទីតាំងវាយប្រហារ 
					'other_material'=>$request->other_material,
					'other_losses'=>$request->other_losses,
					
					'status'=>'Active'
				]);

				/** upload file for case */
				if($request->hasFile('photos')){
					$dt = Carbon::now();
					$date_time = $dt->toDayDateTimeString();
					$folder_name=$case->case_number;

					if(!\Storage::disk('local')->exists($folder_name)){
						/** create one directory based on name */
						\Storage::disk('local')->makeDirectory($folder_name, 0775, true);

						$photos = $request->file('photos');
						foreach ($photos as $photo){
							$file_name = $photo->getClientOriginalName();
							$destinationPath = $folder_name.'/'.$file_name;

							/** store file in directory */
							\Storage::disk('local')->put($destinationPath,file_get_contents($photo->getRealPath()));

							/** create file upload */
							CaseUpload::create([
								'case_number'=>$case->case_number,
								'file_name'=>$file_name,
								'original_name'=>$file_name,
								'file_path'=>$destinationPath
							]);
						}
					}
				}
			}
		});
		
		
		return redirect()->route('CaseList')->with('success', "case information data created successfully");
	}
	
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$request->validate([
            'title' => 'required',
			'original_source' => 'required',
        ]);

		/** ករណីបង្ក្រាប -> អ្នកបង្រ្កាប */
		$suppressors = collect([]);
		$suprressorNum = 0;
		$suppressorOrgs   = $request->suppressors_orgs;//អង្គភាព
		$suppressorGroups = $request->suppressor_groups;//ក្រុម
		$suppressorIndividuals = $request->suppressor_individuals;//បុគ្គល

		foreach($suppressorOrgs as $suppressorOrg){
			if($suppressorOrg != null || $suppressorGroups[$suprressorNum] != null){
				$suppressors->push([
					'suppressors_org'	=>	$suppressorOrg,
					'suppressor_group'	=>	$suppressorGroups[$suprressorNum],
					'suppressor_indiv'	=>	$suppressorIndividuals[$suprressorNum]
				]);
			}
			
			$suprressorNum ++;
		}

		/** ករណីបង្ក្រាប ->  អ្នកដែលត្រូវបានបង្ក្រាប */
		$suppresseds = collect([]);
		$suppressedOrgs   = $request->suppressed_orgs;//អង្គភាព
		$suppressedGroups   = $request->suppressed_groups;//ក្រុម
		$suppressedIndividuals = $request->suppressed_individuals;//បុគ្គល

		$suppressedIndex = 0;
		foreach($suppressedOrgs as $suppressedOrg){
			if($suppressedOrg != null || $suppressedGroups[$suppressedIndex] != null){
				$suppresseds->push([
					'suppressed_org'	=>	$suppressedOrg,
					'suppressed_group'	=>	$suppressedGroups[$suppressedIndex],
					'suppressed_indiv'	=>	$suppressedIndividuals[$suppressedIndex],
				]);
				$suppressedIndex ++;
			}
		}

		/** ករណីបង្ក្រាប -> ទីតាំងបង្ក្រាប */
		$crackdowns = collect([]);
		$crackdownCountries   = $request->crackdown_countries;
		$crackdownProvinces   = $request->crackdown_provinces;
		$crackdownAreas   = $request->crackdown_areas;

		$crackdownIndex = 0;
		foreach($crackdownCountries as $crackdownCountry){
			if($crackdownCountry != null || $crackdownProvinces[$crackdownIndex] != null || $crackdownAreas[$crackdownIndex] != null){
				$crackdowns->push([
					'crackdown_country'	=>	$crackdownCountry,
					'crackdown_province'=>	$crackdownProvinces[$crackdownIndex],
					'crackdown_area'	=>	$crackdownAreas[$crackdownIndex]
				]);
			}
			$crackdownIndex ++;
		}
		
		/**  ករណីបង្ក -> អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ  */
		$attackers = collect([]);
		$attackerIndex = 0;
		$attackOrgs   = $request->attack_orgs;//អង្គភាព
		$attackGroups   = $request->attack_groups;//ក្រុម
		$attackIndividuals = $request->attack_individuals;//បុគ្គល

		foreach($attackOrgs as $attackOrg){
			if($attackOrg != null || $attackGroups[$attackerIndex] != null){
				$attackers->push([
					'attack_org'	=>	$attackOrg,
					'attack_group'	=>	$attackGroups[$attackerIndex],
					'attack_indiv'	=>	$attackIndividuals[$attackerIndex]
				]);
			}
			$attackerIndex ++;
		}

		/** ករណីបង្ក -> អ្នករងគ្រោះ */
		$victims = collect([]);
		$victimOrgs   = $request->victim_orgs;//អង្គភាព
		$victimGroups   = $request->victim_groups;//ក្រុម
		$victimIndividuals = $request->victim_individuals;//បុគ្គល

		$victimIndex = 0;
		foreach($victimOrgs as $victimOrg){
			if($victimOrg != null || $victimGroups[$victimIndex] != null){
				$victims->push([
					'victim_org'	=>	$victimOrg,
					'victim_group'	=>	$victimGroups[$victimIndex],
					'victim_indiv' 	=> 	$victimIndividuals[$victimIndex]
				]);
			}
			$victimIndex ++;
		}

		/** ករណីបង្ក -> ទីតាំងវាយប្រហារ */
		$attacks = collect([]);
		$attackedCountries   = $request->attacked_countries;
		$attackedProvinces   = $request->attacked_provinces;
		$attackedAreas   = $request->attacked_areas;
		$attackIndex = 0;
		foreach($attackedCountries as $attackedCountry){
			if($attackedCountry != null || $attackedProvinces[$attackIndex] != null || $attackedAreas[$attackIndex] != null){
				$attacks->push([
					'attacked_country'	=>	$attackedCountry,
					'attacked_province'	=>	$attackedProvinces[$attackIndex],
					'attacked_area'		=>	$attackedAreas[$attackIndex]
				]);
			}
			$attackIndex ++;
		}

		//----- clean សកម្មភាព -----
		$activity = '';
		if($request->activities == 'other_case'){ //ផ្សេងៗ
			$activity = 'ផ្សេងៗ';
			$suppressors = collect([]);// អ្នកបង្រ្កាប
			$suppresseds = collect([]);// អ្នកដែលត្រូវបានបង្ក្រាប 
			$crackdowns  = collect([]);// ទីតាំងបង្ក្រាប 

			$attackers   = collect([]);// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
			$victims     = collect([]);// អ្នករងគ្រោះ 
			$attacks     = collect([]);//ទីតាំងវាយប្រហារ 

		}elseif($request->activities == 'show_causing_case'){//ការវាយប្រហារ
			$activity = 'ការវាយប្រហារ';
			$suppressors = collect([]);// អ្នកបង្រ្កាប
			$suppresseds = collect([]);// អ្នកដែលត្រូវបានបង្ក្រាប 
			$crackdowns  = collect([]);// ទីតាំងបង្ក្រាប 

		}elseif($request->activities == 'show_crackdown_case'){//ការបង្ក្រាប
			$activity = 'ការបង្ក្រាប';
			$attackers   = collect([]);// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
			$victims     = collect([]);// អ្នករងគ្រោះ 
			$attacks     = collect([]);//ទីតាំងវាយប្រហារ 

		}


		DB::transaction(function () use ($request, $suppressors, $attackers, $suppresseds, $victims, $crackdowns, $attacks) {

			/** get case_number */
			$caseInfo = new CaseInformation();
			$caseNumber = $caseInfo->getCaseNumber();

			/** create case information */
			$case = CaseInformation::create([
				'case_number'=>$caseNumber,
				'related_case_number'=>$request->related_case_number,
				'title' => $request->title,//ចំណងជើង
				'description'=>$request->original_source,//ខ្លឹមសារដើម
				'original_source'=>$request->original_source,//ខ្លឹមសារដើម
				'released_date'=>$request->released_date,//កាលបរិច្ឆេទចុះផ្សាយ
				'actual_date'=>$request->actual_date,//កាលបរិច្ឆេទជាក់ស្តែង
				'death'=>$request->death,//ចំនួនស្លាប់
				'injure'=>$request->injure,//ចំនួនរបួស
				'detention'=>$request->detention,//ចំនួនឃុំខ្លួន
				'relocate'=>$request->relocate,//ផ្លាស់ទីលំនៅ
				'migration'=>$request->migration,//ចំណាកស្រុក
				'activities'=>$request->activities,//សកម្មភាព
				'causing_case'=>$request->causing_case,//ករណីបង្ក
				'country'=>$request->country,//ប្រទេស
				'province_city'=>$request->province_city,//ខេត្ត
				'area'=>$request->area,//តំបន់
				'provocative_group'=>$request->provocative_group,//ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ
				'victim'=>$request->victim,//ក្រុមរងគ្រោះ
				'perpetrator_name'=>$request->perpetrator_name,//ឈ្មោះជនបង្ក
				'victim_name'=>$request->victim_name,//ឈ្មោះជនរងគ្រោះ
				'provocative_case'=>$request->provocative_case,//ករណីបង្កហេតុ

				//------------ករណីបង្ក្រាប------------
				'suppressors'=>$suppressors,//អ្នកបង្រ្កាប
				'suppressed'=>$suppresseds,// អ្នកដែលត្រូវបានបង្ក្រាប 
				'crackdowns'=>$crackdowns,//ទីតាំងបង្ក្រាប 

				//------------ករណីបង្ក---------------
				'attackers'=>$attackers,// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
				'victims'=>$victims,// អ្នករងគ្រោះ 
				'attackeds'=>$attacks,//ទីតាំងវាយប្រហារ 

				//-------------សកម្មភាព ផ្សេងៗ -------
				'other_activities'=>$request->other_activities,//សកម្មភាព ផ្សេងៗ

				'other_material'=>$request->other_material,//សម្ភារៈផ្សេងទៀត
				'other_losses'=>$request->other_losses,//ការខាតបង់ផ្សេងទៀត
				'is_kh'=>false,
				'is_publish'=>true,
				'status'=>'Active'

			]);

			/** upload file for case */
			if($request->hasFile('photos')){
				$dt = Carbon::now();
				$date_time = $dt->toDayDateTimeString();
				$folder_name=$case->case_number;

				if(!\Storage::disk('local')->exists($folder_name)){
					/** create one directory based on name */
					\Storage::disk('local')->makeDirectory($folder_name, 0775, true);

					$photos = $request->file('photos');
					foreach ($photos as $photo){
						$file_name = $photo->getClientOriginalName();
						$destinationPath = $folder_name.'/'.$file_name;

						/** store file in directory */
						\Storage::disk('local')->put($destinationPath,file_get_contents($photo->getRealPath()));

						/** create file upload */
						CaseUpload::create([
							'case_number'=>$case->case_number,
							'file_name'=>$file_name,
							'original_name'=>$file_name,
							'file_path'=>$destinationPath
						]);
					}

				}
			}
		});
		
		
		return redirect()->route('CaseList')->with('success', "case information data created successfully");
    }

	public function userShowCase(Request $request){
		$caseId = Crypt::decrypt($request->id);
		$case = CaseInformation::find($caseId);

		
		if($case->released_date){
			$khmerMonths =['','មករា','កុម្ភៈ','មិនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
			$date = Carbon::parse($case->released_date);
		    $Formatdate = $date->format('Y-m-d');

			$releaseDates = explode('-', $Formatdate);
			$case->releaseYear = $releaseDates[0];
			$case->releaseMonth = $khmerMonths[ltrim($releaseDates[1], '0')];
			$case->releaseDay = $releaseDates[2];
		}else{
		$case->releaseYear = '';
		$case->releaseMonth = '';
		$case->releaseDay = '';
		}

		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();

		/** case kH list */
		$caseKH = CaseInfoKh::where('case_id',$case->id)->first();

		/** find related news */
		$relatedCases = CaseInformation::where('related_case_number',$case->case_number)
		->whereNotNull('related_case_number')
		->get();

		$latestCases = CaseInformation::orderBy('created_at', 'DESC')->paginate(5);
		return view('form/case/user-show',compact('case','caseUploads','relatedCases','latestCases','caseKH'));
	}
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $caseId = Crypt::decrypt($request->id);
		$case = CaseInformation::find($caseId);

		if($case->released_date){
			$khmerMonths =['','មករា','កុម្ភៈ','មិនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
			$date = Carbon::parse($case->released_date);
		    $Formatdate = $date->format('Y-m-d');

			$releaseDates = explode('-', $Formatdate);
			$case->releaseYear = $releaseDates[0];
			$case->releaseMonth = $khmerMonths[ltrim($releaseDates[1], '0')];
			$case->releaseDay = $releaseDates[2];
		}else{
		$case->releaseYear = '';
		$case->releaseMonth = '';
		$case->releaseDay = '';
		}

		/** case upload files */
		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();

		/** case kH list */
		$caseKH = CaseInfoKh::where('case_id',$case->id)->first();

		/** find related news */
		$relatedCases = CaseInformation::where('related_case_number',$case->case_number)->whereNotNull('related_case_number')->get();

		$latestCases = CaseInformation::orderBy('created_at', 'DESC')->paginate(5);
		return view('form/case/show',compact('case','caseUploads','relatedCases','latestCases','caseKH'));
    }
	public function showForDeletion(Request $request)
    {
        $caseId = Crypt::decrypt($request->id);
		$case = CaseInformation::find($caseId);

		if($case->released_date){
			$khmerMonths =['','មករា','កុម្ភៈ','មិនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
			$date = Carbon::parse($case->released_date);
		    $Formatdate = $date->format('Y-m-d');

			$releaseDates = explode('-', $Formatdate);
			$case->releaseYear = $releaseDates[0];
			$case->releaseMonth = $khmerMonths[ltrim($releaseDates[1], '0')];
			$case->releaseDay = $releaseDates[2];
		}else{
		$case->releaseYear = '';
		$case->releaseMonth = '';
		$case->releaseDay = '';
		}

		/** case upload files */
		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();

		/** case kH list */
		$caseKH = CaseInfoKh::where('case_id',$case->id)->first();

		/** find related news */
		$relatedCases = CaseInformation::where('related_case_number',$case->case_number)->whereNotNull('related_case_number')->get();

		$latestCases = CaseInformation::orderBy('created_at', 'DESC')->paginate(5);
		return view('form/case/show-for-delete',compact('case','caseUploads','relatedCases','latestCases','caseKH'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
		$caseId = Crypt::decrypt($request->id);
		$case = CaseInformation::find($caseId);
		$suppressors = json_decode($case->suppressors, true)??[];
		$attackers = json_decode($case->attackers, true)??[];
		$suppresseds = json_decode($case->suppressed, true)??[];
		$victims = json_decode($case->victims, true)??[];
		$crackdowns = json_decode($case->crackdowns, true)??[];
		$attackeds = json_decode($case->attackeds, true)??[];
		
		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();

		$activities = Activity::get();
		$causingCases = CausingCase::get();
		$countries = Country::get();
		$actions = Action::get();


        return view('form/case/edit',compact(
			'case',
			'actions',
			'activities',
			'causingCases',
			'countries',
			'caseUploads',
			'suppressors',
			'attackers',
			'suppresseds',
			'victims',
			'crackdowns',
			'attackeds'
		));
    }

	/** edit khmer case information */
	public function editKhmerCase(Request $request){
		$caseKHId = Crypt::decrypt($request->id);
		$caseKH = CaseInfoKh::find($caseKHId);
	
		$suppressors = json_decode($caseKH->suppressors, true)??[];
		$attackers = json_decode($caseKH->attackers, true)??[];
		$suppresseds = json_decode($caseKH->suppressed, true)??[];
		$victims = json_decode($caseKH->victims, true)??[];
		$crackdowns = json_decode($caseKH->crackdowns, true)??[];
		$attackeds = json_decode($caseKH->attackeds, true)??[];

		$countries = Country::get();
		$case = CaseInformation::find($caseKH->case_id);
		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();
		$actions = Action::get();

		return view('form/case/edit-khmer-case',compact(
			'case',
			'actions',
			'countries',
			'caseKH',
			'caseUploads',
			'suppressors',
			'attackers',
			'suppresseds',
			'victims',
			'crackdowns',
			'attackeds'
		));
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
		$request->validate([
            'title' => 'required',
            'original_source' => 'required',
        ]);

		try{
			/** ករណីបង្ក្រាប -> អ្នកបង្រ្កាប */
			$suppressors = collect([]);
			$suprressorNum = 0;
			$suppressorOrgs   = $request->suppressors_orgs;//អង្គភាព
			$suppressorGroups = $request->suppressor_groups;//ក្រុម
			$suppressorIndividuals = $request->suppressor_individuals;//បុគ្គល

			foreach($suppressorOrgs as $suppressorOrg){
				if($suppressorOrg != null || $suppressorGroups[$suprressorNum] != null){
					$suppressors->push([
						'suppressors_org'	=>	$suppressorOrg,
						'suppressor_group'	=>	$suppressorGroups[$suprressorNum],
						'suppressor_indiv'	=>	$suppressorIndividuals[$suprressorNum]
					]);
				}
				
				$suprressorNum ++;
			}
			/** ករណីបង្ក្រាប ->  អ្នកដែលត្រូវបានបង្ក្រាប */
			$suppresseds = collect([]);
			$suppressedOrgs   = $request->suppressed_orgs;//អង្គភាព
			$suppressedGroups   = $request->suppressed_groups;//ក្រុម
			$suppressedIndividuals = $request->suppressed_individuals;//បុគ្គល

			$suppressedIndex = 0;
			foreach($suppressedOrgs as $suppressedOrg){
				if($suppressedOrg != null || $suppressedGroups[$suppressedIndex] != null){
					$suppresseds->push([
						'suppressed_org'	=>	$suppressedOrg,
						'suppressed_group'	=>	$suppressedGroups[$suppressedIndex],
						'suppressed_indiv'	=>	$suppressedIndividuals[$suppressedIndex],
					]);
					$suppressedIndex ++;
				}
			}
			/** ករណីបង្ក្រាប -> ទីតាំងបង្ក្រាប */
			$crackdowns = collect([]);
			$crackdownCountries   = $request->crackdown_countries;
			$crackdownProvinces   = $request->crackdown_provinces;
			$crackdownAreas   = $request->crackdown_areas;

			$crackdownIndex = 0;
			foreach($crackdownCountries as $crackdownCountry){
				if($crackdownCountry != null || $crackdownProvinces[$crackdownIndex] != null || $crackdownAreas[$crackdownIndex] != null){
					$crackdowns->push([
						'crackdown_country'	=>	$crackdownCountry,
						'crackdown_province'=>	$crackdownProvinces[$crackdownIndex],
						'crackdown_area'	=>	$crackdownAreas[$crackdownIndex]
					]);
				}
				$crackdownIndex ++;
			}


			/**  ករណីបង្ក -> អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ  */
			$attackers = collect([]);
			$attackerIndex = 0;
			$attackOrgs   = $request->attack_orgs;//អង្គភាព
			$attackGroups   = $request->attack_groups;//ក្រុម
			$attackIndividuals = $request->attack_individuals;//បុគ្គល

			foreach($attackOrgs as $attackOrg){
				if($attackOrg != null || $attackGroups[$attackerIndex] != null){
					$attackers->push([
						'attack_org'	=>	$attackOrg,
						'attack_group'	=>	$attackGroups[$attackerIndex],
						'attack_indiv'	=>	$attackIndividuals[$attackerIndex]
					]);
				}
				$attackerIndex ++;
			}
			/** ករណីបង្ក -> អ្នករងគ្រោះ */
			$victims = collect([]);
			$victimOrgs   = $request->victim_orgs;//អង្គភាព
			$victimGroups   = $request->victim_groups;//ក្រុម
			$victimIndividuals = $request->victim_individuals;//បុគ្គល

			$victimIndex = 0;
			foreach($victimOrgs as $victimOrg){
				if($victimOrg != null || $victimGroups[$victimIndex] != null){
					$victims->push([
						'victim_org'	=>	$victimOrg,
						'victim_group'	=>	$victimGroups[$victimIndex],
						'victim_indiv' 	=> 	$victimIndividuals[$victimIndex]
					]);
				}
				$victimIndex ++;
			}
			/** ករណីបង្ក -> ទីតាំងវាយប្រហារ */
			$attacks = collect([]);
			$attackedCountries   = $request->attacked_countries;
			$attackedProvinces   = $request->attacked_provinces;
			$attackedAreas   = $request->attacked_areas;
			$attackIndex = 0;
			foreach($attackedCountries as $attackedCountry){
				if($attackedCountry != null || $attackedProvinces[$attackIndex] != null || $attackedAreas[$attackIndex] != null){
					$attacks->push([
						'attacked_country'	=>	$attackedCountry,
						'attacked_province'	=>	$attackedProvinces[$attackIndex],
						'attacked_area'		=>	$attackedAreas[$attackIndex]
					]);
				}
				$attackIndex ++;
			}
			//----- clean សកម្មភាព -----
			$activity = '';
			if($request->activities == 'other_case'){ //ផ្សេងៗ
				$activity = 'ផ្សេងៗ';
				$suppressors = collect([]);// អ្នកបង្រ្កាប
				$suppresseds = collect([]);// អ្នកដែលត្រូវបានបង្ក្រាប 
				$crackdowns  = collect([]);// ទីតាំងបង្ក្រាប 

				$attackers   = collect([]);// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
				$victims     = collect([]);// អ្នករងគ្រោះ 
				$attacks     = collect([]);//ទីតាំងវាយប្រហារ 

			}elseif($request->activities == 'show_causing_case'){//ការវាយប្រហារ
				$activity = 'ការវាយប្រហារ';
				$suppressors = collect([]);// អ្នកបង្រ្កាប
				$suppresseds = collect([]);// អ្នកដែលត្រូវបានបង្ក្រាប 
				$crackdowns  = collect([]);// ទីតាំងបង្ក្រាប 

			}elseif($request->activities == 'show_crackdown_case'){//ការបង្ក្រាប
				$activity = 'ការបង្ក្រាប';
				$attackers   = collect([]);// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
				$victims     = collect([]);// អ្នករងគ្រោះ 
				$attacks     = collect([]);//ទីតាំងវាយប្រហារ 

			}

			CaseInformation::where('id',$request->id)->update([
				'related_case_number'=>$request->related_case_number,
				'title' => $request->title,//ចំណងជើង
				'description'=>$request->original_source,//ខ្លឹមសារដើម
				'original_source'=>$request->original_source,//ខ្លឹមសារដើម
				
				'released_date'=>$request->released_date,//កាលបរិច្ឆេទចុះផ្សាយ
				'actual_date'=>$request->actual_date,//កាលបរិច្ឆេទជាក់ស្តែង
				'death'=>$request->death,//ចំនួនស្លាប់
				'injure'=>$request->injure,//ចំនួនរបួស
				'detention'=>$request->detention,//ចំនួនឃុំខ្លួន
				'relocate'=>$request->relocate,//ផ្លាស់ទីលំនៅ
				'migration'=>$request->migration,//ចំណាកស្រុក
				'activities'=>$request->activities,//សកម្មភាព
				'causing_case'=>$request->causing_case,//ករណីបង្ក
				'country'=>$request->country,//ប្រទេស
				'province_city'=>$request->province_city,//ខេត្ត
				'area'=>$request->area,//តំបន់
				'provocative_group'=>$request->provocative_group,//ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ
				'victim'=>$request->victim,//ក្រុមរងគ្រោះ
				'perpetrator_name'=>$request->perpetrator_name,//ឈ្មោះជនបង្ក
				'victim_name'=>$request->victim_name,//ឈ្មោះជនរងគ្រោះ
				'provocative_case'=>$request->provocative_case,//ករណីបង្កហេតុ

				//------------ករណីបង្ក្រាប------------
				'suppressors'=>$suppressors,//អ្នកបង្រ្កាប
				'suppressed'=>$suppresseds,// អ្នកដែលត្រូវបានបង្ក្រាប 
				'crackdowns'=>$crackdowns,//ទីតាំងបង្ក្រាប 

				//------------ករណីបង្ក---------------
				'attackers'=>$attackers,// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
				'victims'=>$victims,// អ្នករងគ្រោះ 
				'attackeds'=>$attacks,//ទីតាំងវាយប្រហារ 

				//-------------សកម្មភាព ផ្សេងៗ -------
				'other_activities'=>$request->other_activities,//សកម្មភាព ផ្សេងៗ

				'other_material'=>$request->other_material,
				'other_losses'=>$request->other_losses,
				'status'=>'Active'
			]);

			/** upload file for case */
			$case = CaseInformation::find($request->id);
			if($request->hasFile('photos')){
				$dt = Carbon::now();
				$date_time = $dt->toDayDateTimeString();
				$folder_name=$case->case_number;
	
				/** create one directory based on name */
				\Storage::disk('local')->makeDirectory($folder_name, 0775, true);
	
				$photos = $request->file('photos');
				foreach ($photos as $photo){
					$file_name = $photo->getClientOriginalName();
					$destinationPath = $folder_name.'/'.$file_name;
	
					/** store file in directory */
					\Storage::disk('local')->put($destinationPath,file_get_contents($photo->getRealPath()));
	
					/** create file upload */
					CaseUpload::create([
						'case_number'=>$case->case_number,
						'file_name'=>$file_name,
						'original_name'=>$file_name,
						'file_path'=>$destinationPath
					]);
				}
			}
	
			return redirect()->route('CaseList')->with('success', "case information data created successfully");
		}catch (Exception $e) {
			return redirect()->route('CaseList')->with('success', "case information data created successfully");
		}
		
    }
	public function deleteCaseInfo(Request $request)
    {
		CaseInformation::where('id',$request->id)->update([
			'status'=>'Inactive'
		]);
		return redirect()->route('CaseList')->with('success', "case information data created successfully");
    }


	    /**
     * Update the specified resource in storage.
     */
    public function updateKhmerCase(Request $request)
    {
		$request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
		try{


			/** អ្នកបង្រ្កាប */
		$suppressors = collect([]);
		$suprressorNum = 0;
		$suppressorOrgs   = $request->suppressors_orgs;
		$suppressorGroups = $request->suppressor_groups;
		foreach($suppressorOrgs as $suppressorOrg){
			if($suppressorOrg != null || $suppressorGroups[$suprressorNum] != null){
				$suppressors->push([
					'suppressors_org'=>$suppressorOrg,
					'suppressor_group'=>$suppressorGroups[$suprressorNum]
				]);
			}
			
			$suprressorNum ++;
		}
		
		/** អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ  */
		$attackers = collect([]);
		$attackerIndex = 0;
		$attackOrgs   = $request->attack_orgs;
		$attackGroups   = $request->attack_groups;
		foreach($attackOrgs as $attackOrg){
			if($attackOrg != null || $attackGroups[$attackerIndex] != null){
				$attackers->push([
					'attack_org'=>$attackOrg,
					'attack_group'=>$attackGroups[$attackerIndex]
				]);
			}
			$attackerIndex ++;
		}


		/** អ្នកដែលត្រូវបានបង្ក្រាប */
		$suppresseds = collect([]);
		$suppressedOrgs   = $request->suppressed_orgs;
		$suppressedGroups   = $request->suppressed_groups;
		$suppressedIndex = 0;
		foreach($suppressedOrgs as $suppressedOrg){
			if($suppressedOrg != null || $suppressedGroups[$suppressedIndex] != null){
				$suppresseds->push([
					'suppressed_org'=>$suppressedOrg,
					'suppressed_group'=>$suppressedGroups[$suppressedIndex],
				]);
				$suppressedIndex ++;
			}
		}


		/** អ្នករងគ្រោះ */
		$victims = collect([]);
		$victimOrgs   = $request->victim_orgs;
		$victimGroups   = $request->victim_groups;
		$victimIndex = 0;
		foreach($victimOrgs as $victimOrg){
			if($victimOrg != null || $victimGroups[$victimIndex] != null){
				$victims->push([
					'victim_org'=>$victimOrg,
					'victim_group'=>$victimGroups[$victimIndex],
				]);
			}
			$victimIndex ++;
		}

		/** ទីតាំងបង្ក្រាប */
		$crackdowns = collect([]);
		$crackdownCountries   = $request->crackdown_countries;
		$crackdownProvinces   = $request->crackdown_provinces;
		$crackdownAreas   = $request->crackdown_areas;
		$crackdownIndex = 0;
		foreach($crackdownCountries as $crackdownCountry){
			if($crackdownCountry != null || $crackdownProvinces[$crackdownIndex] != null || $crackdownAreas[$crackdownIndex] != null){
				$crackdowns->push([
					'crackdown_country'=>$crackdownCountry,
					'crackdown_province'=>$crackdownProvinces[$crackdownIndex],
					'crackdown_area'=>$crackdownAreas[$crackdownIndex]
				]);
			}
			$crackdownIndex ++;
		}

		/** ទីតាំងវាយប្រហារ */
		$attacks = collect([]);
		$attackedCountries   = $request->attacked_countries;
		$attackedProvinces   = $request->attacked_provinces;
		$attackedAreas   = $request->attacked_areas;
		$attackIndex = 0;
		foreach($attackedCountries as $attackedCountry){
			if($attackedCountry != null || $attackedProvinces[$attackIndex] != null || $attackedAreas[$attackIndex] != null){
				$attacks->push([
					'attacked_country'=>$attackedCountry,
					'attacked_province'=>$attackedProvinces[$attackIndex],
					'attacked_area'=>$attackedAreas[$attackIndex]
				]);
			}
			$attackIndex ++;
		}

		CaseInfoKh::where('id',$request->kh_case_id)->update([
			'title' => $request->title,
			'description'=>$request->description,
			'released_date'=>$request->released_date,
			'actual_date'=>$request->actual_date,
			'death'=>$request->death,
			'injure'=>$request->injure,
			'activities'=>$request->activities,
			'causing_case'=>$request->causing_case,
			'country'=>$request->country,
			'province_city'=>$request->province_city,
			'area'=>$request->area,
			'provocative_group'=>$request->provocative_group,
			'victim'=>$request->victim,
			'perpetrator_name'=>$request->perpetrator_name,
			'victim_name'=>$request->victim_name,

			'detention'=>$request->detention,//ចំនួនឃុំខ្លួន
			'relocate'=>$request->relocate,//ផ្លាស់ទីលំនៅ
			'migration'=>$request->migration,//ចំណាកស្រុក
			'provocative_case'=>$request->provocative_case,//ករណីបង្កហេតុ
			'suppressors'=>$suppressors,//ករណីបង្កហេតុ
			'attackers'=>$attackers,//្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
			'suppressed'=>$suppresseds,// អ្នកដែលត្រូវបានបង្ក្រាប 
			'victims'=>$victims,// អ្នករងគ្រោះ 
			'crackdowns'=>$crackdowns,//ទីតាំងបង្ក្រាប 
			'attackeds'=>$attacks,//ទីតាំងវាយប្រហារ 
			'other_material'=>$request->other_material,
			'other_losses'=>$request->other_losses,

			'status'=>'Active'
		]);

		//find case for update
		CaseInformation::where('id',$request->case_id)->update([
			'released_date'=>$request->released_date,
			'actual_date'=>$request->actual_date,
			'death'=>$request->death,
			'injure'=>$request->injure,
			'activities'=>$request->activities,
			'causing_case'=>$request->causing_case,
			'country'=>$request->country,
			'province_city'=>$request->province_city,
			'area'=>$request->area,
			'provocative_group'=>$request->provocative_group,
			'victim'=>$request->victim,
			'perpetrator_name'=>$request->perpetrator_name,
			'victim_name'=>$request->victim_name,

			'detention'=>$request->detention,//ចំនួនឃុំខ្លួន
			'relocate'=>$request->relocate,//ផ្លាស់ទីលំនៅ
			'migration'=>$request->migration,//ចំណាកស្រុក
			'provocative_case'=>$request->provocative_case,//ករណីបង្កហេតុ
			'suppressors'=>$suppressors,//ករណីបង្កហេតុ
			'attackers'=>$attackers,//្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
			'suppressed'=>$suppresseds,// អ្នកដែលត្រូវបានបង្ក្រាប 
			'victims'=>$victims,// អ្នករងគ្រោះ 
			'crackdowns'=>$crackdowns,//ទីតាំងបង្ក្រាប 
			'attackeds'=>$attacks,//ទីតាំងវាយប្រហារ 
			'other_material'=>$request->other_material,
			'other_losses'=>$request->other_losses,
			
			'status'=>'Active'
		]);

		return redirect()->route('CaseList')->with('success', "case information data created successfully");
		}catch (Exception $e) {
			abort(404);
		}
    }

	public function deletCaseUpload(Request $request){
		$caseUploadId = Crypt::decrypt($request->case_upload_id);
		/** remove file from directory */
		$caseUpload = CaseUpload::find($caseUploadId);
		if($caseUpload){
			\Storage::disk('local')->delete($caseUpload->file_path);
		}

		/** remove file from db */
		
		CaseUpload::where('id',$caseUploadId)->delete();

		

		return redirect("case-information/{{$request->id}}/edit");
	}

	public function search(){

		$search = '';
		$cases = CaseInformation::select(
			'case_information.*',
			'case_information.created_by as user_id_created_case',
			'case_info_khs.created_by as user_id_created_caseKh', 
			'case_info_khs.id as case_id_kh',
			'case_info_khs.title as title_kh',
			'case_info_khs.case_number as case_number_kh',
			'case_info_khs.description as description_kh'
			)
		->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
		->where('case_information.status','=','Active')
		->orderBy('created_at', 'DESC')
		->paginate(10);

		return view('form/case/search',compact('cases','search'));
		
	}

	public function userSearchCase(Request $request){
		if($request->search){
			$search = $request->search;
			$cases = $this->searchCases($request->search);

			return view('form/case/user-search',compact('cases','search'));
		}else{
			$search = '';
			$cases = $this->searchCases($request->search);

			return view('form/case/user-search',compact('cases','search'));
		}
	}

	public function searchResult(Request $request){
		if($request->search){
			$search = $request->search;
			$cases = $this->searchCases($search);
			return view('form/case/search',compact('cases','search'));
		}else{
			$search = '';
			$cases = $this->searchCases($search);
			
			return view('form/case/search',compact('cases','search'));
		}
	}
	private function searchCases($searchString){
		if($searchString){
			$string ='%'.$searchString.'%' ;
			$cases = CaseInformation::select(
				'case_information.*',
				'case_information.created_by as user_id_created_case',
				'case_info_khs.created_by as user_id_created_caseKh', 
				'case_info_khs.id as case_id_kh',
				'case_info_khs.title as title_kh',
				'case_info_khs.case_number as case_number_kh',
				'case_info_khs.description as description_kh'
				)
			->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
			->where('case_information.status','=','Active')

			->where('case_information.title', 'like', $string)
			->orWhere('case_information.description', 'like', $string)
			->orWhere('case_information.case_number','like',$string)

			->orWhere('case_info_khs.title', 'like', $string)
			->orWhere('case_info_khs.description', 'like', $string)
			->orWhere('case_info_khs.case_number','like',$string)

			->orderBy('case_information.created_at', 'DESC')
			->paginate(10);
			return $cases;
		}else{
			$cases = CaseInformation::select(
				'case_information.*',
				'case_information.created_by as user_id_created_case',
				'case_info_khs.created_by as user_id_created_caseKh', 
				'case_info_khs.id as case_id_kh'
				)
			->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
			->orderBy('case_information.created_at', 'DESC')
			->paginate(10);
		return $cases;
		}
	}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CaseInformation $caseInformation)
    {
        //
    }
}