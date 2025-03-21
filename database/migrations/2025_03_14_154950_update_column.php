<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
        Schema::table('case_information', function (Blueprint $table) {
            $table->string('detention')->nullable();
            $table->string('relocate')->nullable();
            $table->string('migration')->nullable();
            $table->string('provocative_case')->nullable();
            $table->string('other_material')->nullable();
            $table->string('other_losses')->nullable();

            $table->json('suppressors')->nullable();
            $table->json('attackers')->nullable();
            $table->json('suppressed')->nullable();
            $table->json('victims')->nullable();
            $table->json('crackdowns')->nullable();
            $table->json('attackeds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_information', function (Blueprint $table) {
            //
        });
    }
};
