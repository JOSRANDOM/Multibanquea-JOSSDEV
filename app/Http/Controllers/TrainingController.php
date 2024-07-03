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

    public function display()
    {
        $paso2Pendiente = true; // Definir la variable según la lógica de tu aplicación
        $paso3Pendiente = false; // Definir la variable según la lógica de tu aplicación

        return view('training.display', compact('paso2Pendiente', 'paso3Pendiente'));
    }
}
