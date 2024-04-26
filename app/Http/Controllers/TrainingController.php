<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PerformanceController;

class TrainingController extends Controller
{
    public function index()
    {
        // Crear una instancia del controlador de rendimiento
        $performanceController = new PerformanceController();
        
        // Llamar al método SendAI del controlador de rendimiento y obtener la respuesta
        $response = $performanceController->SendAI();

        // Retornar la vista de entrenamiento pasando la respuesta como datos
        return view('training.index', ['response' => $response]);
    }
}
