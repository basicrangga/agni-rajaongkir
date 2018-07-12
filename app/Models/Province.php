<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
	protected $table = 'provinces';
	protected $primaryKey = 'id';
	protected $fillable = [
		'province_id','province'
	];
	protected $hidden = [
		'created_at','updated_at'
	];
    //
}
