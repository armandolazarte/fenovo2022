<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\StoreCompraSemanalController;
use Illuminate\Console\Command;

class StoreCompraSemanal extends Command
{

    protected $signature = 'sincroniza:comprasemanal';
    protected $description = 'Obtiene el resumen de stock de los productos comprados por Fenovo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $start = microtime(true);

        $stockSemanal = new StoreCompraSemanalController();
        $stockSemanal->init();

        $end = microtime(true);
        $duration = $end-$start;
        $hours = (int)($duration/60/60);
        $minutes = (int)($duration/60)-$hours*60;
        $seconds = (int)$duration-$hours*60*60-$minutes*60;
        echo "Tiempo ejecucion {$hours} : {$minutes} : {$seconds}";
    }
}
