<?php

namespace App\Repositories;

class BaseRepository
{

	public function query(){
		return call_user_func(static::MODEL.'::query');
	}

	public function isDirectRequest(){
		if(env('RAJAONGKIR_DIRECT')=='true'){
			return true;
		}
		return false;
	}

}