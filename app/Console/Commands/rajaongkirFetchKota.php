<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\City;
use App\Repositories\BaseRepository;
use App\Repositories\CityRepository;

class rajaongkirFetchKota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rajaongkir:fetch-kota {--city_id=} {return-data=false}';

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
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        parent::__construct();
        $this->client = new Client();
        $this->cityRepository = $cityRepository;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        if($this->cityRepository->isDirectRequest()==false){
            $this->error('ONLY SUPPORT FOR DIRECT REQUEST');
            return false;
        }

        $return = $this->cityRepository->getByCityId($this->option('city_id'));

        if( $return == false ){
            $this->error('REQUEST FAILED');
            return false;
        }

        if( (int) $this->option('city_id') > 0 ){
            $this->info("Uncovered Single Store Data");
            print_r($return);
            return false;
        }

        if($this->argument('return-data')=='return-data'){
            return $return;         
        }

        $this->confirmTruncate();
        $this->storeCity( (array) $return);
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

        $this->info("TOTAL City Fetch / Stored : $totalData / $totalStore".PHP_EOL);
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

    public function confirmTruncate()
    {   
        if( $this->confirm('Do you wish to truncate CITY table? [yes|no]') ){
            $city = new $this->cityModel;
            $city->truncate();
        }
        $this->info("TABLE PROVINCE TRUNCATED".PHP_EOL);
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
