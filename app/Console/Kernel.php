<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'America/Argentina/Buenos_Aires';
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        // Actualizacion de precios
        $schedule->command('update:prices')->dailyAt('03:27')->runInBackground();

        // Copias DB / mantiene últimas 7 copias
        $schedule->command('snapshot:cleanup --keep=29')->dailyAt('03:27')->runInBackground();
        $schedule->command('snapshot:create')->dailyAt('03:27')->runInBackground();

        //Exportacion Fenovo ejecutada cada hora
        $schedule->command('sincroniza:diariamente')->hourly()->runInBackground();

        //Exportacion Movimientos Fenovo ejecutada cada 30 minutos entre las 6 am y las 22 pm
        $schedule->command('sincroniza:movi')->cron('30 6-22 * * *')->runInBackground();

        //Exportacion Fenovo - Compra de productos congelados FENOVO
        $schedule->command('sincroniza:comprasemanal')->cron('45 */3 * * *')->runInBackground();
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
