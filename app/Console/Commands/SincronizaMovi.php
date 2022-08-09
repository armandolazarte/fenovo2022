<?php

namespace App\Console\Commands;
use App\Exports\MovementsViewExport;
use Illuminate\Console\Command;

class SincronizaMovi extends Command
{
    protected $signature   = 'sincroniza:movi';
    protected $description = 'Sincroniza los movimientos de Fenovo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Exportar movimientos
        (new MovementsViewExport() )->store('movi.csv');
    }
}
