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
use Carbon\Carbon;

class CaseInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$user = Auth::user();
		$isRoleAdmin = false;

		if($user->role == 'ADMIN'){
			$cases = CaseInformation::select(
				'case_information.*',
				'case_information.created_by as user_id_created_case',
				'case_info_khs.created_by as user_id_created_caseKh', 
				'case_info_khs.id as case_id_kh'
				)
			->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
			->orderBy('case_information.created_at', 'DESC')
			->paginate(10);
			$isRoleAdmin = true;
			return view('form/case/index',compact('cases','user','isRoleAdmin'));
		}

		$cases = CaseInformation::select(
			'case_information.*',
			'case_information.created_by as user_id_created_case',
			'case_info_khs.created_by as user_id_created_caseKh', 
			'case_info_khs.id as case_id_kh'
			)
		->leftJoin('case_info_khs', 'case_information.id', '=', 'case_info_khs.case_id')
		->where('case_information.created_by',$user->id)
		->orWhere('case_info_khs.created_by',$user->id)
		->orderBy('case_information.created_at', 'DESC')
		->paginate(10);


		return view('form/case/index',compact('cases','user','isRoleAdmin'));


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
		$activities = Activity::get();
		$causingCases = CausingCase::get();
		$countries = Country::get();

		$caseInfo = new CaseInformation();
		$caseNumber = $caseInfo->getCaseNumber();

		return view('form/case/create',compact('activities','causingCases','countries','caseNumber'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createKhmerCase(Request $request)
    {
		$caseId = Crypt::decrypt($request->id);
		$case = CaseInformation::find($caseId);

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
			return view('form/case/create-khmer-case',compact('case','caseUploads','relatedCases','latestCases','caseNumber'));
		
    }
	public function storeKhmerCase(Request $request){
		$request->validate([
            'title' => 'required',
            'description' => 'required|max:5000',
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
					'victim_name'=>$request->victim_name
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
					'victim_name'=>$request->victim_name
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
            'description' => 'required|max:5000',
			'original_source' => 'required|max:5000',
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
				'description'=>$request->description,
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
				'is_publish'=>true
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

		/** find related news */
		$relatedCases = CaseInformation::where('related_case_number',$case->case_number)->whereNotNull('related_case_number')->get();

		$latestCases = CaseInformation::orderBy('created_at', 'DESC')->paginate(5);
		return view('form/case/user-show',compact('case','caseUploads','relatedCases','latestCases'));
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


        return view('form/case/edit',compact('case','activities','causingCases','countries','caseUploads'));
    }

	/** edit khmer case information */
	public function editKhmerCase(Request $request){
		$caseKHId = Crypt::decrypt($request->id);
		$caseKH = CaseInfoKh::find($caseKHId);
		
		$case = CaseInformation::find($caseKH->case_id);
		$caseUploads = CaseUpload::where('case_number',$case->case_number)->get();


		return view('form/case/edit-khmer-case',compact('case','caseKH','caseUploads'));
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
		$request->validate([
            'title' => 'required',
            'description' => 'required|max:5000',
        ]);

		CaseInformation::where('id',$request->id)->update([
			'related_case_number'=>$request->related_case_number,
			'title' => $request->title,
			'description'=>$request->description,
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
			'victim_name'=>$request->victim_name
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
    }


	    /**
     * Update the specified resource in storage.
     */
    public function updateKhmerCase(Request $request)
    {
		$request->validate([
            'title' => 'required',
            'description' => 'required|max:5000',
        ]);

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
			'victim_name'=>$request->victim_name
		]);
		return redirect()->route('CaseList')->with('success', "case information data created successfully");
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
		$cases = CaseInformation::orderBy('created_at', 'DESC')->paginate(10);
		return view('form/case/search',compact('cases','search'));
		
	}

	public function userSearchCase(Request $request){
		if($request->search){
			$search = $request->search;
			$cases = $this->searchCases($request->search);
			return view('form/case/user-search',compact('cases','search'));
		}else{
			$cases = $this->searchCases($request->search);
			$search = '';
			return view('form/case/user-search',compact('cases','search'));
		}
	}

	public function searchResult(Request $request){
		if($request->search){
			$search = $request->search;
			$cases = $this->searchCases($request->search);
			return view('form/case/search',compact('cases','search'));
		}else{
			$cases = $this->searchCases($request->search);
			$search = '';
			return view('form/case/search',compact('cases','search'));
		}
	}
	private function searchCases($searchString){
		if($searchString){
			$string ='%'.$searchString.'%' ;
			$cases = CaseInformation::where('title', 'like', $string)
			->orWhere('description', 'like', $string)
			->orWhere('case_number','like',$string)
			->orderBy('created_at', 'DESC')
			->paginate(10);
			return $cases;
		}else{
			$cases = CaseInformation::orderBy('created_at', 'DESC')
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