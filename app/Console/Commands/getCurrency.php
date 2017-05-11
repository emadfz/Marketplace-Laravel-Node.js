<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;


class getCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currency = new Currency;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://api.fixer.io/latest?base=USD");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //curl_setopt($ch,CURLOPT_HEADER, true); //if you want headers
        $output=curl_exec($ch);
        curl_close($ch);
        $currency->json_data = $output;
        $currency->save();
        print_r( json_decode($output));
    }
}
