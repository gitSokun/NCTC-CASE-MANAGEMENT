<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\Activity;
use App\Models\CausingCase;
use App\Models\Country;
use App\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		DB::transaction(function (){

			/** create profile */
            $userprofile = UserProfile::create([
				'gender'  => 'M',
				'first_name' => 'Admin',
				'last_name' => 'Admin'
			]);

			/** create user */
			$user = $userprofile->user()->create([
				'name' => 'admin',
				'role'=>'ADMIN',
				'email' => 'admin@gmail.com',
				'password' => Hash::make('password')
			]);
			
			///** create activity */
			//$activityCodes = ['001','002'];
			//$activityNames =['ការវាយប្រហារ','ការបង្ក្រាប'];
			//for($i=0;$i<2;$i++){
			//	Activity::create([
			//		'code'=>$activityCodes[$i],
			//		'name'=>$activityNames[$i]
			//	]);
			//}

			///** create Causing Case */
			//$causingCaseCodes = ['001','002'];
			//$causingCaseName =['គ្រាប់បែកបង្កប់','បាញ់គ្នាប្រហារ'];
			//for($i=0;$i<2;$i++){
			//	CausingCase::create([
			//		'code'=>$causingCaseCodes[$i],
			//		'name'=>$causingCaseName[$i]
			//	]);
			//}

			///** Create country */
			//$countryCodes = ['AF','ES','PAK'];
			//$countryNameENGS=['Afghanistan','SPAIN','Pakistan'];
			//$countryNamesKH=['អាហ្វហ្គានីស្ថាន','អេស្ប៉ាញ','ប៉ាគីស្ថាន'];
			//for($i=0;$i<3;$i++){
			//	Country::create([
			//		'code'=>$countryCodes[$i],
			//		'name_eng'=>$countryNameENGS[$i],
			//		'name_kh'=>$countryNamesKH[$i]
			//	]);
			//}

			
        });
    }
}
