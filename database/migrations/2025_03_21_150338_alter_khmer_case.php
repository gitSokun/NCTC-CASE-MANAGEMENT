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
		Schema::table('case_info_khs', function (Blueprint $table) {
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
        //
    }
};
