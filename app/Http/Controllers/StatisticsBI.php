<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StatisticsBI extends Controller
{
    public function RPT_CIENTIFICA01()
    {
        $sql = "SELECT * FROM exam_question eq
		inner join questions q on q.id = eq.question_id
		inner join exams e on e.id = eq.exam_id
		INNER join question_subcategories qs on qs.id = q.question_subcategory_id
		INNER JOIN users u on u.id = e.user_id
		where  
	   
       e.created_at BETWEEN '2024-04-01 00:00:00' AND '2024-04-05 23:59:59'  and u.program_t  in ('CASOS_CLINICOS_I_2024')  and e.type='SIMULACRUM'  AND u.study_center='CIENTIFICA' and e.simulacrum not in ('UCP2024MAREACASO1');";

        $data = DB::connection()->select($sql);
       return response()->json([
        'status' => true,
        'data' => $data,
       ], 200);

    }

    public function RPT_CIENTIFICA02(Request $request)
    {
        // Obtener los parámetros de la URL
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Definir las fechas predeterminadas si no se proporcionan en la URL
        if (!$startDate) {
            $startDate = '2024-04-01 00:00:00';
        }
        if (!$endDate) {
            $endDate = '2024-04-05 23:59:59';
        }
    
        // Construir la consulta SQL utilizando los parámetros de la URL
        $sql = "SELECT * FROM exam_question eq
            INNER JOIN questions q ON q.id = eq.question_id
            INNER JOIN exams e ON e.id = eq.exam_id
            INNER JOIN question_subcategories qs ON qs.id = q.question_subcategory_id
            INNER JOIN users u ON u.id = e.user_id
            WHERE
            e.created_at BETWEEN '$startDate' AND '$endDate'
            AND u.program_t IN ('CASOS_CLINICOS_I_2024')
            AND e.type = 'SIMULACRUM'
            AND u.study_center = 'CIENTIFICA'
            AND e.simulacrum NOT IN ('UCP2024MAREACASO1')";
    
        // Ejecutar la consulta SQL
        $data = DB::connection()->select($sql);
    
        // Verificar si se encontraron datos
        if (empty($data)) {
            // Devolver un mensaje de error si no se encontraron datos
            return response()->json([
                'status' => false,
                'message' => 'Información no encontrada para las fechas proporcionadas.',
            ], 404);
        }
    
        // Devolver los resultados como una respuesta JSON
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
    
    

    public function RPT_CIENTIFICA03($fc_init, $fc_end)
    {

        $dbName = env('VARIANT_NAME') . '_pe';

        $cientifica02 = DB::connection($dbName)->select("SELECT * FROM exam_question eq
		inner join questions q on q.id = eq.question_id
		inner join exams e on e.id = eq.exam_id
		INNER join question_subcategories qs on qs.id = q.question_subcategory_id
		INNER JOIN users u on u.id = e.user_id
		where  
	   
       e.created_at BETWEEN '2024-04-01 00:00:00' AND '2024-04-05 23:59:59'  and u.program_t  in ('CASOS_CLINICOS_I_2024')  and e.type='SIMULACRUM'  AND u.study_center='CIENTIFICA' and e.simulacrum not in ('UCP2024MAREACASO1');");

       return response()->json([
        'status' => true,
        'data' => $cientifica02,
       ]);

    }
}
