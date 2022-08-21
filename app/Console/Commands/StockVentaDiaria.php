<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\ventaDiariaController;
use Illuminate\Console\Command;

class StockVentaDiaria extends Command
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
        $time = $end-$start;
        echo "execute time {$time}";
    }
}
