<?php
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\DepositosController;
use Illuminate\Support\Facades\Route;

Route::get('menu/print', [PrintController::class, 'menuPrint'])->name('menu.print');
Route::get('movement-print/printPDF', [PrintController::class, 'printMovimientosPDF'])->name('movement.printPDF');
Route::get('movement-export/exportCSV', [PrintController::class, 'exportMovimientosCsv'])->name('movement.exportCSV');
Route::get('ordenes-export/exportCSV', [PrintController::class, 'exportOrdenesCsv'])->name('movement.exportOrdenesCSV');
Route::get('store-export/stocks/exportCSV/{id}', [PrintController::class, 'exportStoreStocks'])->name('store.exportStockCSV');

Route::get('balance/exportar/{store_id}/{week}/{year}', [DepositosController::class, 'exportBalance'])->name('deposito.balance.exportCSV');



