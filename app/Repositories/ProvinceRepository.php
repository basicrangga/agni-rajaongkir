<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Province;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class ProvinceRepository extends BaseRepository
{
	protected $client;
	const MODEL = Province::class;

	public function __construct(){
		$this->client = new Client();
	}

	public function getByProvinceId($id = ""){

		if( $this->isDirectRequest() ){
			return $this->rajaongkirDirectProvince($id);
		}
		return Province::where('province_id',$id)->first();

	}

	public function rajaongkirDirectProvince($id){

        $result = $this->client->get(
            config('custom.api.rajaongkir.url').'/province',[
                'query'=>[
                    'key'=>$_ENV["RAJAONGKIR_API_KEY"],
                    'id'=>$id
                ]
            ]
        );

        if($result->getStatusCode()!=200){
            echo "Request Error $result->getStatusCode()";
            return false;
        }

        $dataReturn = json_decode($result->getBody()->getContents());

        return $dataReturn->rajaongkir->results;
	}

}