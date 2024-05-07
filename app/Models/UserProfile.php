<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
	protected $fillable = [
        'gender',
        'first_name',
        'last_name',
		'skill',
		'education',
		'remark',
		'file_name',
		'file_path'
    ];
	protected $casts = [
        'gender'        => 'string',
        ];
	
	public function user()
    {
        return $this->morphOne(User::class, 'profileable');
    }
}
