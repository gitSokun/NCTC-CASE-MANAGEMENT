<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CaseInformation extends Model
{
    use HasFactory, CreatedUpdatedBy;

	//ចំនួនឃុំខ្លួន : detention
	//ផ្លាស់ទីលំនៅ:relocate
	//ចំណាកស្រុក:migration
	//ករណីបង្កហេតុ:provocative_case
	//សម្ភារះផ្សេងទៀត:other_material
	//កាខាតបង់ផ្សេងទៀត:other_losses

	//អ្នកបង្រ្កាប:suppressors[suppressor_groups,suppressors_orgs] json
	//អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ : attacker[attack_orgs,attack_groups] json
	//អ្នកដែលត្រូវបានបង្ក្រាប: [suppressed_orgs,suppressed_groups] json
	//អ្នករងគ្រោះ :[victim_orgs,victim_groups] json
	//ទីតាំងបង្ក្រាប: [crackdown_countries,crackdown_provinces,crackdown_areas] json
	//ទីតាំងវាយប្រហារ: [attacked_countries,attacked_provinces,attacked_areas] json

	protected $fillable = [
		'case_number', //លេខសំគាល់ ព្រឹត្តិការណ៍
		'related_case_number',//លេខសំគាល់ ព្រឹត្តិការណ៍​ពាក់ព័ន្ធ
        'title',//ចំណងជើង
		'description',
		'original_source',//ខ្លឹមសារដើម
		'released_date',//កាលបរិច្ឆេទចុះផ្សាយ
		'actual_date',//កាលបរិច្ឆេទជាក់ស្តែង
		'death',//ចំនួនស្លាប់
		'injure',//ចំនួនរបួស
		'causing_case',
		'country',
		'province_city',//ខេត្ត
		'area',//តំបន់
		'provocative_group',//ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ
		'victim',//ក្រុមរងគ្រោះ
		'perpetrator_name',//ឈ្មោះជនបង្ក
		'victim_name',//ឈ្មោះជនរងគ្រោះ
		'status',
		'detention',//ចំនួនឃុំខ្លួន
		'relocate',//ផ្លាស់ទីលំនៅ
		'migration',//ចំណាកស្រុក
		'activities',//សកម្មភាព
		'other_activities',//សកម្មភាព ផ្សេងៗ

        // -----------------ករណីបង្ក្រាប--------------
		'suppressors',//អ្នកបង្រ្កាប
		'suppressed',// អ្នកដែលត្រូវបានបង្ក្រាប 
		'crackdowns',//ទីតាំងបង្ក្រាប 

		// -----------------ករណីបង្ក--------------
		'attackers',// អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ 
		'victims',// អ្នករងគ្រោះ 
		'attackeds',//ទីតាំងវាយប្រហារ 

		'other_activities',//សកម្មភាព ផ្សេងៗ 
		'other_material',//សម្ភារៈផ្សេងទៀត
		'other_losses',//ការខាតបង់ផ្សេងទៀត

		'provocative_case',
		'crackdowns',
		'created_at'
		
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
		$caseNumber = 'CASE_'.$mytime;
		return $caseNumber;
	}

	
}