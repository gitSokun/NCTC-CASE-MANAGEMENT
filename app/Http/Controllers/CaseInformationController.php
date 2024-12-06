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
		DB::transaction(function () use ($request) {
			/** get case_number */
			$caseInfo = new CaseInformation();
			$caseNumber = $caseInfo->getCaseNumber();

			/** create case information */
			$case = CaseInformation::create([
				'case_number'=>$caseNumber,
				'related_case_number'=>$request->related_case_number,
				'title' => $request->title,
				'description'=>$request->original_source,//$request->description,
				'original_source'=>$request->original_source,
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

		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();

		$activities = Activity::get();
		$causingCases = CausingCase::get();
		$countries = Country::get();
		$actions = Action::get();


        return view('form/case/edit',compact('case','actions','activities','causingCases','countries','caseUploads'));
    }

	/** edit khmer case information */
	public function editKhmerCase(Request $request){
		$caseKHId = Crypt::decrypt($request->id);
		$caseKH = CaseInfoKh::find($caseKHId);
		$countries = Country::get();
		$case = CaseInformation::find($caseKH->case_id);
		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();
		$actions = Action::get();

		return view('form/case/edit-khmer-case',compact('case','actions','countries','caseKH','caseUploads'));
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
			CaseInformation::where('id',$request->id)->update([
				'related_case_number'=>$request->related_case_number,
				'title' => $request->title,
				'description'=>$request->original_source,//$request->description,
				'original_source'=>$request->original_source,
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