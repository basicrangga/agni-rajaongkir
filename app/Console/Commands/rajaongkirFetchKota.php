<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\City;

class rajaongkirFetchKota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rajaongkir:fetch-kota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data kota from rajaongkir';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $client;
    protected $cityModel = \App\Models\City::class;
    protected $storedCity = [];

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $result = $this->client->get(
            config('custom.api.rajaongkir.url').'/city',[
                'query'=>[
                    'key'=>config('custom.api.rajaongkir.key')
                ]
            ]
        );

        if($result->getStatusCode()!=200){
            echo "Request Error $result->getStatusCode()";
            return false;
        }

        $dataReturn = json_decode($result->getBody()->getContents());
        $dataReturn = $dataReturn->rajaongkir->results;

        echo $this->truncateCity();
        echo $this->storeCity($dataReturn);
        return true;
    }

    public function storeCity($data)
    {

        $totalData = count($data)-1;
        $totalStore = 0;

        for ($i=$totalData; $i >0 ; $i--) { 
            $row = $data[$i];

            $newCity = $this->stup( (array) $row );
            if( $newCity->save() ){
                $totalStore++;
            }

        }

        return "TOTAL City Fetch / Stored : $totalData / $totalStore".PHP_EOL;
    }

    public function stup($input){
        $city = new $this->cityModel;
        $city->city_id = $input['city_id'];
        $city->city_name = $input['city_name'];
        $city->type = $input['type'];
        $city->postal_code = $input['postal_code'];
        $city->province_id = $input['province_id'];

        return $city;
    }

    public function truncateCity()
    {   
        $city = new $this->cityModel;
        $city->truncate();

        return "TABLE CITY TRUNCATED".PHP_EOL;
    }

    public function getStoredCity(){

        $allCity = new $this->cityModel;
        $allCity = $allCity->all();
        foreach ($allCity as $key => $v) {
            $this->getStoredCity[ $v->city_id ] = [ 
                "stored" => "$v->city_id $v->city_name $v->province_id $v->type $v->postal_code",
                "id"=>$v->id
            ];
        }

        return $this->getStoredCity;
    }

    public function storedCityOutOfDate($city)
    {
        $cityFormat = "city->city_id city->city_name city->province_id city->type city->postal_code";
        if( isset($this->storedCity[$city->city_id]) 
            && $this->storedCity[ $city->city_id ] == $cityFormat
        ){
            return true;
        }
        return false;
    }
}
