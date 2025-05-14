<?php

use App\Http\Controllers\Api\CallCenterTicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CdrController;
use App\Http\Controllers\Api\InboundCallController;


Route::group(['prefix' => '/callcenter'], function () {
    Route::get('/cdr/store', [CdrController::class, 'index'])->name('callcenter.cdr.index');
    Route::post('/cdr/store', [CdrController::class, 'cdrStore'])->name('callcenter.cdr.store');
    Route::post('/inbound-call/store', [InboundCallController::class, 'inboundCallStore'])->name('callcenter.inboundCall.store');
    Route::post('/ticket/store', [CallCenterTicketController::class, 'ticketStore'])->name('callcenter.ticket.store');
    Route::post('/ticket/etr/store', [CallCenterTicketController::class, 'etrStore'])->name('callcenter.etr.store');
});
