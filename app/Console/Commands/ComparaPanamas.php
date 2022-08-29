<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Exports\ComparaPanamasExport;

class ComparaPanamas extends Command
{
    protected $signature = 'compara:panamas';
    protected $description = 'Compara netos desde los panamas y movimientos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        (new ComparaPanamasExport())->store('COMPARA_PANAMAS.csv');
    }
}
