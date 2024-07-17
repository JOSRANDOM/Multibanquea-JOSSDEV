<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionCategory;
use App\Models\Question;
use App\Models\Exam;
use App\Models\UserActivityLog;
use App\Models\ActivityType;
use App\Models\QuestionSubcategory;
use App\Models\Training;
use App\Models\UserStep;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class TrainingController extends Controller
{
    public function index()
    {
        $performanceController = new PerformanceController();
        $response = $performanceController->SendAI();
        return view('training.index', ['response' => $response]);
    }

    public function ShowDisplay()
    {
        $user = Auth::user();
        $userStep = UserStep::where('user_id', $user->id)->first();
    
        // Verificar si el usuario tiene registros en la tabla 'training'
        $trainingExists = Training::where('user_id', $user->id)->exists();
    
        return view('training.show_display', [
            'userStepExists' => $userStep !== null,
            'step1' => $userStep ? $userStep->step_1 : 0,
            'step2' => $userStep ? $userStep->step_2 : 0,
            'step3' => $userStep ? $userStep->step_3 : 0,
            'trainingExists' => $trainingExists, // Pasar la variable a la vista
        ]);
    }
    

    public function display()
    {
        $user = Auth::user();
        $userStepExists = UserStep::where('user_id', $user->id)->exists();
    
        return view('training.display', ['userStepExists' => $userStepExists]);
    }    

    public function startTraining(Request $request)
    {
        $user = Auth::user();

        // Crear o actualizar el registro de UserStep
        UserStep::updateOrCreate(
            ['user_id' => $user->id],
            [
                'step_1' => 0,
                'step_2' => 0,
                'step_3' => 0,
                'exams_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]
        );

        return redirect()->route('training.ShowDisplay')->with('success', 'Pasos actualizados correctamente.');
    }

    public function start(Request $request)
    {
        $user = Auth::user();
    
        // Crear o actualizar el registro de UserStep
        UserStep::updateOrCreate(
            ['user_id' => $user->id],
            [
                'step_1' => 1, // Marcar el paso 1 como completado
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]
        );
    
        // Obtener una categoría de preguntas para el examen (aquí asumo que hay una categoría específica que quieres usar)
        $questionCategory = QuestionCategory::findOrFail($category_id); // Reemplaza $category_id con el ID de la categoría deseada
    
        // Aquí se asume que el número de preguntas y otras configuraciones se manejan según tus requisitos
        $numberOfQuestions = 180; // Número de preguntas para el examen balanceado
    
        // Crear el examen
        $exam = Exam::create([
            'public_id' => Str::uuid(),
            'question_category_id' => $questionCategory->id,
            'type' => 'balanced', // Tipo de examen (puedes ajustar esto según tus necesidades)
            'user_id' => $user->id,
            'sharing_token' => Str::random(12),
        ]);
    
        // Agregar preguntas aleatorias al examen
        $questions = $this->createBalanced($questionCategory, $numberOfQuestions);
        $exam->questions()->attach($questions);
    
        return redirect()->route('exams.show', ['exam' => $exam])->with('success', 'Examen balanceado iniciado correctamente');
    }

    public function trainingIA(Request $request)
    {
        $user = Auth::user();
        $userStep = UserStep::where('user_id', $user->id)->first();
        $userStep->step_3 = 1;
        $userStep->save();
        return view('training.IA');
    }

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
    
        if ($user->hasExamInProgress()) {
            $messageBag = new MessageBag();
            $messageBag->add('error', 'You have an exam in progress.');
            return redirect()->route('exams.index')->with('errors', $messageBag);
        }
    
        // Check if user steps record exists and update step_2
        $userSteps = UserStep::where('user_id', $user->id)->first();
    
        if ($userSteps) {
            $userSteps->update([
                'step_2' => 1,
            ]);
        } else {
            UserStep::create([
                'user_id' => $user->id,
                'step_1' => 1,
                'step_2' => 0,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    
        $questions_count = $questionCategory->questions->where('active', true)->where('bank_questions', 1)->count();
        $numberOfQuestions = 180; 
    
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
    
        // Redirigir a la página del examen con el ID del examen recién creado
        return redirect()->route('exams.show', ['exam' => $exam])->with('success', 'Examen balanceado normal de 180 preguntas iniciado correctamente');
    }
    
}