<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Repositories\BaseRepository;
use App\Repositories\ProvinceRepository;

class rajaongkirFetchProvince extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rajaongkir:fetch-province {--province_id=} {return-data=false}';

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
    protected $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        parent::__construct();
        $this->client = new Client();
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->provinceRepository->isDirectRequest()==false){
            $this->error('ONLY SUPPORT FOR DIRECT REQUEST');
            return false;
        }

        $return = $this->provinceRepository->getByProvinceId($this->option('province_id'));

        if( $return == false ){
            $this->error('REQUEST FAILED');
            return false;
        }

        if( (int) $this->option('province_id') > 0 ){
            $this->info("Uncovered Single Store Data");
            print_r($return);
            return false;
        }

        if($this->argument('return-data')=='return-data'){
            return $return;         
        }

        $this->confirmTruncate();
        $this->storeProvince( (array) $return);
        return true;
    }

    public function storeProvince($data = [])
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

        $this->info("TOTAL Province Fetch / Stored : $totalData / $totalStore".PHP_EOL);
    }

    public function stup($input){
        $province = new $this->provinceModel;
        $province->province_id = $input['province_id'];
        $province->province = $input['province'];

        return $province;
    }

    public function confirmTruncate()
    {   
        if( $this->confirm('Do you wish to truncate PROVINCE table? [yes|no]') ){
            $province = new $this->provinceModel;
            $province->truncate();
        }
        $this->info("TABLE PROVINCE TRUNCATED".PHP_EOL);
    }
}
