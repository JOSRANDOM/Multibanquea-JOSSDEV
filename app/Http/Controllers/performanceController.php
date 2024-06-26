<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use App\Models\Training;
use App\Models\Training_questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    public function SendAI () 
    {
        // Obtener el nombre de la variante
        $variantName = env('VARIANT_NAME');
    
        // Construir el nombre de la base de datos en producción
        $dbName = env('VARIANT_NAME') . '_pe';
    
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
    
        // Realizar la consulta SQL
        $resultados = DB::select("
            SELECT
                examenes.user_id AS id_users,
                preguntas_examen.exam_id,
                preguntas_examen.question_id,
                preguntas.question_subcategory_id AS subcategory_id,
                subcategorias.question_category_id AS category_id,
                preguntas_examen.correct
            FROM
                " . $dbName . ".exam_question AS preguntas_examen
                INNER JOIN " . $dbName . ".exams AS examenes ON preguntas_examen.exam_id = examenes.id
                INNER JOIN " . $dbName . ".users AS usuarios ON examenes.user_id = usuarios.id
                INNER JOIN " . $dbName . ".questions AS preguntas ON preguntas_examen.question_id = preguntas.id
                INNER JOIN " . $dbName . ".question_subcategories AS subcategorias ON preguntas.question_subcategory_id = subcategorias.id
            WHERE
                examenes.user_id = :user_id
        ", ['user_id' => '3758']);
    
        // Formatear los resultados en el formato JSON requerido
        $formattedResults = [];
        foreach ($resultados as $resultado) {
            $formattedResults[] = [
                "id_users" => $resultado->id_users,
                "exam_id" => $resultado->exam_id,
                "question_id" => $resultado->question_id,
                "subcategory_id" => $resultado->subcategory_id,
                "category_id" => $resultado->category_id,
                "correct" => $resultado->correct
            ];
        }
    
        // Construir la URL base para la solicitud a la API
        $url = "http://143.198.70.70:5000/rasch_analysis/?services=$variantName";
    
        // Realizar la solicitud a la API
        $response = Http::post($url, $formattedResults);
    
        // Retornar la vista con los datos y la respuesta del servicio
        return view('training.IA', [
            'formattedResults' => $formattedResults,
            'response' => $response
        ]);
    }

    public function IA() 
    {
        // Obtener el nombre de la variante
        $variantName = env('VARIANT_NAME');
    
        // Construir el nombre de la base de datos en producción
        $dbName = env('VARIANT_NAME') . '_pe';
    
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
    
        // Realizar la consulta SQL
        $resultados = DB::select("
            SELECT
                examenes.user_id AS id_users,
                preguntas_examen.exam_id,
                preguntas_examen.question_id,
                preguntas.question_subcategory_id AS subcategory_id,
                subcategorias.question_category_id AS category_id,
                preguntas_examen.correct
            FROM
                " . $dbName . ".exam_question AS preguntas_examen
                INNER JOIN " . $dbName . ".exams AS examenes ON preguntas_examen.exam_id = examenes.id
                INNER JOIN " . $dbName . ".users AS usuarios ON examenes.user_id = usuarios.id
                INNER JOIN " . $dbName . ".questions AS preguntas ON preguntas_examen.question_id = preguntas.id
                INNER JOIN " . $dbName . ".question_subcategories AS subcategorias ON preguntas.question_subcategory_id = subcategorias.id
            WHERE
                examenes.user_id = :user_id
            ", ['user_id' => $userId]);
    
        // Formatear los resultados en el formato JSON requerido
        $formattedResults = [];
        foreach ($resultados as $resultado) {
            $formattedResults[] = [
                "id_users" => $resultado->id_users,
                "exam_id" => $resultado->exam_id,
                "question_id" => $resultado->question_id,
                "subcategory_id" => $resultado->subcategory_id,
                "category_id" => $resultado->category_id,
                "correct" => $resultado->correct
            ];
        }
    
        // Construir la URL base para la solicitud a la API
        $url = "http://143.198.70.70:5000/rasch_analysis/?services=$variantName";
    
        // Realizar la solicitud a la API
        $response = Http::post($url, $formattedResults);
    
        // Verificar si la respuesta tiene datos
        $responseData = $response->json();
        $hasData = !empty($responseData);
    
        // Retornar la vista con los datos y la respuesta del servicio
        return view('training.IA', [
            'formattedResults' => $formattedResults,
            'responseData' => $responseData,
            'hasData' => $hasData
        ]);
    }
    
    public function training($id, $fecha)
    {
        // Aquí puedes realizar cualquier lógica adicional con $id y $fecha
        $category = QuestionCategory::findOrFail($id);
        $subcategories = $category->question_subcategories()->with(['questions' => function ($query) {
            $query->inRandomOrder()->limit(15);
        }])->get();
    
        // Calcular el número total de preguntas
        $totalQuestions = $subcategories->flatMap(function ($subcategory) {
            return $subcategory->questions;
        })->count();
    
        $trainingId = uniqid(); // Generar un ID único para el entrenamiento
    
        // Puedes pasar $fecha a la vista como una variable junto con $totalQuestions
        return view('training.training', compact('id', 'subcategories', 'trainingId', 'fecha', 'totalQuestions'));
    }
    
    

    public function statistics()
    {
        // Obtener el ID del usuario autenticado
        $userId = auth()->id();
    
        // Obtener la fecha del entrenamiento (suponiendo que está en la última pregunta respondida)
        $latestTrainingQuestion = Training_questions::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
    
        $date = $latestTrainingQuestion ? $latestTrainingQuestion->date : now()->toDateString();
    
        // Contar preguntas correctas e incorrectas del usuario
        $correctCount = Training_questions::where('user_id', $userId)
            ->where('is_correct', 1)
            ->count();
    
        $incorrectCount = Training_questions::where('user_id', $userId)
            ->where('is_correct', 0)
            ->count();
    
        return view('training.statistics', [
            'date' => $date,
            'correctCount' => $correctCount,
            'incorrectCount' => $incorrectCount
        ]);
    }
    

     public function store(Request $request)
    {
        // Valida los datos entrantes
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'date_training' => 'required|date',
            'event_ids' => 'required|array',
            'event_ids' => 'required|array',
        ]);

        foreach ($validatedData['event_ids'] as $eventId) {
            Training::create([
                'user_id' => $validatedData['user_id'],
                'date_training' => $validatedData['date_training'],
                'created_at' => now(),
                'created_by' => $validatedData['user_id'],
                'updated_at' => now(),
                'updated_by' => $validatedData['user_id'], // Asigna un valor aquí
                'id_category' => $eventId,
            ]);
        }
        

        return response()->json(['message' => 'Training events stored successfully'], 200);
    }

    public function storeAnswer(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'user_id' => 'required|integer',
            'question_id' => 'required|integer',
            'answer_id' => 'required|integer',
            'is_correct' => 'required|boolean',
            'date' => 'required|date',
        ]);
    
        try {
            // Crear una nueva instancia de TrainingQuestion y guardarla en la base de datos
            $trainingQuestion = new Training_questions();
            $trainingQuestion->user_id = $request->user_id;
            $trainingQuestion->questions_id = $request->question_id;
            $trainingQuestion->answers_id = $request->answer_id;
            $trainingQuestion->is_correct = $request->is_correct;
            $trainingQuestion->date = $request->date;
            $trainingQuestion->created_at = now(); // Opcional, dependiendo de tu lógica de negocio
            $trainingQuestion->created_by = $request->user_id; // Opcional, dependiendo de tu lógica de negocio
            $trainingQuestion->updated_at = now(); // Opcional, dependiendo de tu lógica de negocio
            $trainingQuestion->updated_by = $request->user_id; // Opcional, dependiendo de tu lógica de negocio
            $trainingQuestion->save();
    
            return response()->json(['message' => 'Respuesta almacenada correctamente.']);
        } catch (\Exception $e) {
            // Manejo de excepciones
            return response()->json(['error' => 'Error al almacenar la respuesta.', 'message' => $e->getMessage()], 500);
        }
    }
      
    
}
