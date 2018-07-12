<?php

namespace App\Http\Controllers\Api\Rajaongkir;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;

class CityController extends Controller
{
	protected $cityRepository;

	public function __construct(CityRepository $cityRepository)
	{
		$this->cityRepository = $cityRepository;
	}

    public function search(Request $request)
    {
		$cityId = $request->input('id');

		$city = $this->cityRepository->getByCityId($cityId);

		return new JsonResponse(['data'=>$city]);
    }
}
