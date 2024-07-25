<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CaseInfoKh extends Model
{
    use HasFactory, CreatedUpdatedBy;

	protected $fillable = [
		'case_number',
		'case_id',
        'title',
		'description',
		'original_source',
		'released_date',
		'actual_date',
		'death',
		'injure',
		'activities',
		'causing_case',
		'country',
		'province_city',
		'area',
		'provocative_group',
		'victim',
		'perpetrator_name',
		'victim_name',
		'created_at',
		'updated_at'
    ];
	protected $casts = [
        'released_date' => 'date',
        'actual_date' => 'date',
        ];

	public function getCaseNumber(){
		$caseId = 1;
		$maxCaseId = $this::orderBy('id', 'DESC')->first();
		if($maxCaseId){
			$caseId = $maxCaseId->id + 1;
		}
		//$dateStr = Carbon::now()->format('ymd');
		//$caseIdDateStr = $caseId.''.$dateStr;
		$caseIdDateStr = $caseId;
		$mytime = sprintf('%09d', $caseIdDateStr);
		$caseNumber = 'CASE_KH'.$mytime;
		return $caseNumber;
	}
}
