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
        Schema::create('case_information', function (Blueprint $table) {
            $table->id();
			$table->string('case_number');
			$table->string('related_case_number')->nullable();
			$table->string('title');
			$table->string('description',5000);
			$table->string('original_source',5000)->nullable();
			$table->date('released_date')->nullable();
			$table->date('actual_date')->nullable();
			$table->integer('death')->nullable();
			$table->integer('injure')->nullable();
			$table->string('activities')->nullable();
			$table->string('causing_case')->nullable();
			$table->string('country')->nullable();
			$table->string('province_city')->nullable();
			$table->string('area')->nullable();
			$table->string('provocative_group')->nullable();
			$table->string('victim')->nullable();
			$table->string('perpetrator_name')->nullable();
			$table->string('victim_name')->nullable();
			$table->unsignedBigInteger('created_by');
			$table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_information');
    }
};
