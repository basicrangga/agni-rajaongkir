<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class rajaongkirFetchProvince extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rajaongkir:fetch-province';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data province from rajaongkir';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $client;
    protected $provinceModel = \App\Models\Province::class;
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
            config('custom.api.rajaongkir.url').'/province',[
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

        echo $this->truncateProvince();
        echo $this->storeProvince($dataReturn);
        return true;
    }

    public function storeProvince($data)
    {

        $totalData = count($data)-1;
        $totalStore = 0;

        for ($i=$totalData; $i >0 ; $i--) { 
            $row = $data[$i];

            $newProvince = $this->stup( (array) $row );
            if( $newProvince->save() ){
                $totalStore++;
            }

        }

        return "TOTAL Province Fetch / Stored : $totalData / $totalStore".PHP_EOL;
    }

    public function stup($input){
        $province = new $this->provinceModel;
        $province->province_id = $input['province_id'];
        $province->province = $input['province'];

        return $province;
    }

    public function truncateProvince()
    {   
        $province = new $this->provinceModel;
        $province->truncate();

        return "TABLE CITY TRUNCATED".PHP_EOL;
    }
}
