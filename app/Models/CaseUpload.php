<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CaseUpload extends Model
{
    use HasFactory,CreatedUpdatedBy;
	protected $fillable = [
		'case_number',
		'file_name',
		'original_name',
		'file_path',
		'created_by'
	];
}
