<?php

namespace App\Http\Controllers\Api\Rajaongkir;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;

class ProvinceController extends Controller
{
	protected $provinceRepository;

	public function __construct(ProvinceRepository $provinceRepository)
	{
		$this->provinceRepository = $provinceRepository;
	}

	public function search(Request $request)
	{
		$provinceId = $request->input('id');

		$province = $this->provinceRepository->getByProvinceId($provinceId);

		return new JsonResponse(['data'=>$province]);
	}

}
