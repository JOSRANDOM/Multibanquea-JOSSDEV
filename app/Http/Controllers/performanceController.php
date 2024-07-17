<?php

namespace App\Http\Controllers;

use App\Models\Question;
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
    
        // Retornar la vista con los datos y la respuesta del servicio
        return view('training.IA', [
            'formattedResults' => $formattedResults,
            'response' => $response
        ]);
    }
    
    public function training($id)
    {
        // Obtener la categoría por ID
        $category = QuestionCategory::findOrFail($id);
        
        // Obtener el título del entrenamiento
        $trainingTitle = $category->name;
        
        // Obtener las subcategorías relacionadas con sus preguntas al azar (15 preguntas por subcategoría)
        $subcategories = $category->question_subcategories()->with(['questions' => function ($query) {
            $query->inRandomOrder()->limit(15);
        }])->get();
        
        // Calcular el número total de preguntas
        $totalQuestions = 0;
        foreach ($subcategories as $subcategory) {
            $totalQuestions += $subcategory->questions->count();
        }
        
        // Inicialmente, no hay preguntas respondidas
        $answeredCount = 0;
        
        // Obtener la fecha actual
        $fecha = \Carbon\Carbon::now()->format('d-m-Y');
        
        return view('training.training', compact('trainingTitle', 'subcategories', 'totalQuestions', 'answeredCount', 'fecha'));
    }
    public function trainingstep1()
    {
        // Obtener todas las preguntas
        $questions = Question::inRandomOrder()->limit(180)->get();
        
        // Calcular el número total de preguntas
        $totalQuestions = $questions->count();
        
        // Inicialmente, no hay preguntas respondidas
        $answeredCount = 0;
        
        // Obtener la fecha actual
        $fecha = \Carbon\Carbon::now()->format('d-m-Y');
        
        return view('training.training1', compact('questions', 'totalQuestions', 'answeredCount', 'fecha'));
    }    

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'user_id' => 'required|integer',
            'date_training' => 'required|date',
            'event_ids' => 'required|array',
            'event_ids.*' => 'integer',
        ]);

        $userId = Auth::id(); // Obtén el ID del usuario autenticado

        // Crear el evento en la base de datos
        foreach ($request->event_ids as $eventId) {
            Training::create([
                'user_id' => $request->user_id,
                'date_training' => $request->date_training,
                'created_at' => now(),
                'created_by' => $userId,
                'updated_at' => now(),
                'updated_by' => $userId,
                'id_category' => $eventId,
            ]);
        }

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Eventos almacenados correctamente'], 200);
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

    public function showQuestion($id)
    {
        // Obtener la pregunta por ID
        $question = Question::with('answers')->findOrFail($id);
    
        // Obtener el total de preguntas del examen
        $totalQuestions = Question::count(); // Ajusta esto según tu lógica
    
        // Obtener el índice de la pregunta actual (1-based index)
        $questions = Question::pluck('id')->toArray();
        $currentQuestionIndex = array_search($id, $questions) + 1;
    
        // Obtener el título del entrenamiento
        // Aquí se asume que todas las preguntas pertenecen a una categoría común
        $trainingTitle = "Título del Entrenamiento"; // Ajusta esto según tu lógica
    
        return view('training.show', compact('question', 'totalQuestions', 'currentQuestionIndex', 'trainingTitle'));
    }

    public function showCalendar(){

        $userId = Auth::id(); // Obtén el ID del usuario autenticado
        $trainings = Training::where('user_id', $userId)->get(); // Filtra por user_id

        return view('training.show_calendar', compact('trainings'));

    }
    
    public function deleteAll()
    {
        $userId = Auth::id(); // Obtén el ID del usuario autenticado
        Training::where('user_id', $userId)->delete(); // Elimina todos los eventos del usuario

        return response()->json(['message' => 'Eventos eliminados correctamente'], 200);
    }

    
    
}
