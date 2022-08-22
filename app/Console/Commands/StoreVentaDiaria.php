<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\ventaDiariaController;
use Illuminate\Console\Command;

class StoreVentaDiaria extends Command
{
    protected $signature = 'sincroniza:ventadiaria';
    protected $description = 'Ejecuta a diario la suma de venta diarias para calcular la capacidad de la FTK';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $start = microtime(true);
                
        $ventaDiaria = new ventaDiariaController();
        $ventaDiaria->init();

        $end = microtime(true);
        
        $duration = $end-$start;
        $hours = (int)($duration/60/60);
        $minutes = (int)($duration/60)-$hours*60;
        $seconds = (int)$duration-$hours*60*60-$minutes*60;
        echo "Tiempo ejecucion {$hours} : {$minutes} : {$seconds}";
    }
}
