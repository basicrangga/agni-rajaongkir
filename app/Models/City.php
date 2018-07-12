<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	protected $table = 'cities';

	protected $primaryKey = 'id';
	
	protected $fillable = [
		'city_id','city_name','province_id',
		'type','postal_code'
	];

	protected $hidden = [
		'created_at','updated_at'
	];
}
