<?php

namespace App\Http\Controllers;

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
        return view('SendAI', [
            'formattedResults' => $formattedResults,
            'response' => $response
        ]);
    }

    public function IA () 
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
        return view('SendAI', [
            'formattedResults' => $formattedResults,
            'response' => $response
        ]);
    }
}
