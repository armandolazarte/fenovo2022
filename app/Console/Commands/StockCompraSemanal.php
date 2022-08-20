<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\StockCompraSemanalController;
use Illuminate\Console\Command;

class StockCompraSemanal extends Command
{

    protected $signature = 'sincroniza:comprasemanal';
    protected $description = 'Obtiene el resumen de stock de los productos comprados por Fenovo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $stockSemanal = new StockCompraSemanalController();
        $stockSemanal->init();
    }
}
