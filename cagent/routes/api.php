<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyzerController;

Route::post('/prescription/analyze', [AnalyzerController::class, 'analyze']);
