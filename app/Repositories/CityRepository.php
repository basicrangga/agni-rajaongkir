<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\City;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class CityRepository extends BaseRepository
{
	protected $client;
	const MODEL = City::class;

	public function __construct(){
		$this->client = new Client();
	}

	public function getByCityId($id = ""){

		if( $this->isDirectRequest() ){
			return $this->rajaongkirDirectCity($id);
		}
		return City::where('City_id',$id)->first();

	}

	public function rajaongkirDirectCity($id){

        $result = $this->client->get(
            config('custom.api.rajaongkir.url').'/city',[
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