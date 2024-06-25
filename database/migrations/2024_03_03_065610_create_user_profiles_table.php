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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
			$table->string('gender');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('skill')->nullable();
			$table->string('education',300)->nullable();
			$table->string('remark',1000)->nullable();
			$table->string('file_name')->nullable();
			$table->string('file_path')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
