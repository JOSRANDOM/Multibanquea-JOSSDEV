<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionCategory;
use App\Models\Question;
use App\Models\Exam;
use App\Models\UserActivityLog;
use App\Models\ActivityType;
use App\Models\QuestionSubcategory;
use App\Models\UserStep;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $user = Auth::user();
        
        // Obtener el estado de user_steps para el usuario actual
        $userSteps = UserStep::where('user_id', $user->id)->first();
    
        // Determinar si step_1 está completado
        $step1Completed = $userSteps && $userSteps->step_1 == 1;
        $step2Completed = $userSteps && $userSteps->step_2 == 1;
    
        // Pasar las variables a la vista
        return view('training.display', compact('step1Completed','step2Completed'));
    }

    public function startIA()
{
    // Implementa cualquier lógica adicional aquí si es necesario
    
    return redirect()->route('training.IA');
}


        // Función para crear un examen balanceado
        public function createBalanced(QuestionCategory $category, $questions_total): array
        {
            $questions = [];
            $subcategories = QuestionSubcategory::where('question_category_id', $category->id)
                ->with(['questions' => function ($query) {
                    $query->where('active', true)
                        ->where('bank_questions', true);
                }])
                ->get();
    
            if ($subcategories->isNotEmpty()) {
                $total_questions_subcategory = ceil($questions_total / $subcategories->count());
                foreach ($subcategories as $subcategory) {
                    $question_subcategory = $subcategory->questions->take($total_questions_subcategory);
                    foreach ($question_subcategory as $question) {
                        $questions[] = $question->id;
                    }
                }
            } else {
                $question_subcategory = Question::where('question_category_id', $category->id)
                    ->where('active', true)
                    ->where('bank_questions', true)
                    ->take($questions_total)
                    ->get();
                foreach ($question_subcategory as $question) {
                    $questions[] = $question->id;
                }
            }
    
            return $questions;
        }
    
        public function startBalancedExam(Request $request)
        {
            $request->validate([
                'exam_id' => 'required|integer',
            ]);
        
            $user = Auth::user();
            $questionCategory = QuestionCategory::findOrFail($request->input('exam_id'));
        
            // Verificar si ya tiene completado step_1
            $userSteps = UserStep::where('user_id', $user->id)->first();
            $step1Completed = $userSteps && $userSteps->step_1 == 1;
        
            // Si ya completó step_1, crear el segundo examen balanceado
            if ($step1Completed) {
                $questions_count = $questionCategory->questions->where('active', true)->where('bank_questions', 1)->count();
                $numberOfQuestions = 180; // Número fijo de preguntas
        
                // Asegúrate de que haya suficientes preguntas activas en la categoría
                if ($questions_count < $numberOfQuestions) {
                    return redirect()->route('exams.index')->with('error', 'No hay suficientes preguntas activas en esta categoría.');
                }
        
                $questions = $questionCategory->questions
                    ->where('active', true)
                    ->where('bank_questions', 1)
                    ->random($numberOfQuestions)
                    ->shuffle();
        
                $exam = Exam::create([
                    'public_id' => Str::uuid(),
                    'question_category_id' => $questionCategory->id,
                    'type' => 'balanced',
                    'user_id' => $user->id,
                    'sharing_token' => Str::random(12),
                ]);
        
                $exam->questions()->saveMany($questions);
        
                // Actualizar user_steps
                if ($userSteps) {
                    $userSteps->update([
                        'step_2' => 1,
                    ]);
                } else {
                    UserStep::create([
                        'user_id' => $user->id,
                        'step_1' => 1,
                        'step_2' => 1,
                        // Ajusta 'created_by' y 'updated_by' según tu lógica
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                    ]);
                }
        
                // Redirigir a la página del examen con el ID del examen recién creado
                return redirect()->route('exams.show', ['exam' => $exam])->with('success', 'Segundo examen balanceado de 180 preguntas iniciado correctamente');
            }
        
            // Si no ha completado step_1, redirigir con un mensaje de error
            return redirect()->route('training.index')->with('error', 'Debe completar el paso 1 para continuar.');
        }
}
