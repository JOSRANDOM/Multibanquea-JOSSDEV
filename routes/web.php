<?php

use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\ReevaluateExamController;
use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Admin\PromoCodeController as AdminPromoCodeController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ImportStudentsController as ImportUserController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CheckoutReferenceController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\OAuthUserController;
// use App\Http\Controllers\PlanController;
use App\Http\Controllers\PromoPageController;
use App\Http\Controllers\Admin\QuestionCategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Admin\QuestionSubcategoryController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\FlashCardsController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SettingsNotificationsController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Pages\SerumController;
use App\Http\Controllers\performanceController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/**
 * -----------------------------------------------------------------------------
 * Welcome
 * -----------------------------------------------------------------------------
 */
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/email-prueba', [App\Http\Controllers\HomeController::class, 'email'])->name('email.prueba');


Route::name('serum.')->group(function () {
    Route::get('/serum2', [SerumController::class, 'index'])->name('index');
});

/**
 * -----------------------------------------------------------------------------
 * Promo pages
 * -----------------------------------------------------------------------------
 */
Route::name('promo.')
    ->middleware(['store_affiliate_clicks_analytics'])
    ->group(function () {
        Route::get('/promo/{promo_code}', [PromoPageController::class, 'show'])->name('show');
    });

/**
 * -----------------------------------------------------------------------------
 * Authentication
 * -----------------------------------------------------------------------------
 */
Route::post('/custom-login', [LoginController::class, 'login'])->name('login.custom');

Route::get('/SendAI ', [performanceController::class, 'SendAI']);

Route::get('/ingresar', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/ingreso-estudiante', [LoginController::class, 'show'])->name('login-students');
Route::post('/salir', [LoginController::class, 'logout'])->name('logout');

Route::get('/recuperar-contraseña', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::prefix('password')->group(function () {
    Route::get('/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    // Agrega la ruta para la vista de restablecimiento de contraseña
    Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    // Agrega la ruta para procesar el restablecimiento de contraseña
    Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::get('/nueva-cuenta/vincular-correo-electronico/{o_auth_user}/{email_requested_request_token}', [OAuthUserController::class, 'showLinkEmailForm'])->name('register.showLinkEmailForm');
Route::post('/nueva-cuenta/vincular-correo-electronico/{o_auth_user}/{email_requested_request_token}', [OAuthUserController::class, 'requestLinkingEmail'])->name('register.requestLinkingEmail');
Route::get('/nueva-cuenta/verificar-vinculacion-de-correo-electronico/{o_auth_user}/{email_requested_reponse_token}', [OAuthUserController::class, 'linkEmail'])->name('register.linkEmail');

Route::get('/oauth/{provider}', [OAuthUserController::class, 'redirectToProvider'])->name('oauth');
Route::get('/oauth/{provider}/callback', [OAuthUserController::class, 'handleProviderCallback'])->name('oauth.callback');

/**
 * Auth debugging
 */
Route::get('/login-debug', function () {
    return view('auth.login-debug');
})->name('login-debug');

/**
 * Legal
 */
Route::get('/legal/aviso-legal-y-condiciones-de-uso', function () {
    return view('legal.terms');
})->name('legal.terms');

/**
 * -----------------------------------------------------------------------------
 * Affiliates
 * -----------------------------------------------------------------------------
 */

Route::name('affiliates.')->group(function () {
    Route::get('/afiliados', [AffiliateController::class, 'index'])->name('index');

    Route::middleware([
        'verify_affiliate_link',
        'store_affiliate_clicks_analytics',
    ])->group(function () {
        Route::get('/unete/{slug}', [AffiliateController::class, 'show'])->name('show');
    });
});

/**
 * -----------------------------------------------------------------------------
 * Exams
 * -----------------------------------------------------------------------------
 */

Route::name('exams.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/examenes', [ExamController::class, 'index'])->name('index');
        Route::get('/examenes/calcule_questions', [ExamController::class, 'calcule_questions']);
        Route::get('/examenes/nuevo', [ExamController::class, 'create'])->name('create');
        Route::get('/examenes/countdown/{exam}', [ExamController::class, 'countdown'])->name('countdown');
        Route::get('/examenes/nuevo/estandar', [ExamController::class, 'createStandard'])->name('create.standard');
        Route::post('/examenes/nuevo/estandar/{size}', [ExamController::class, 'storeStandard'])->name('store.standard');
        Route::get('/examenes/nuevo/simulacrum', [ExamController::class, 'createSimulacrum'])->name('create.simulacrum');
        Route::post('/examenes/nuevo/simulacrum/{size}', [ExamController::class, 'storeSimulacrum'])->name('store.simulacrum');
        Route::get('/examenes/nuevo/extraordinario', [ExamController::class, 'createExtraordinary'])->name('create.extraordinary');
        Route::post('/examenes/nuevo/extraordinario/{size}', [ExamController::class, 'storeExtraordinary'])->name('store.extraordinary');
        Route::middleware('subscribed')->group(function () {
            Route::get('/examenes/nuevo/realista', [ExamController::class, 'createBalanced'])->name('create.balanced');
            Route::get('/examenes/nuevo/categoria', [ExamController::class, 'createCategory'])->name('create.category');
            Route::get('/examenes/nuevo/especial', [ExamController::class, 'createSpecial'])->name('create.especial');
            Route::post('/examenes/store/especial', [ExamController::class, 'storeSpecial'])->name('store.especial');
            Route::post('/examenes/nuevo/realista/{size}', [ExamController::class, 'storeBalanced'])->name('store.balanced');
            Route::post('/examenes/nuevo/categoria/{question_category}', [ExamController::class, 'storeCategory'])->name('store.category');
        });
        Route::get('/examenes/{exam}', [ExamController::class, 'show'])->name('show');
        Route::get('/examenes/exam/{exam}/finish', [ExamController::class, 'finishExam'])->name('finish.exam');
        Route::delete('/examenes/{exam}', [ExamController::class, 'destroy'])->name('destroy');
        Route::post('/examenes/{exam}/completar', [ExamController::class, 'finish'])->name('finish');
        Route::get('/examenes/{exam}/{question}', [ExamController::class, 'showQuestion'])->name('show.question');
        Route::post('/examenes/{exam}/{question}/nota', [ExamController::class, 'saveNote'])->name('save.note');
    });
/**
 * ACADEMIA
 * KRIZTOF182
 */

Route::name('academy.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('academia/', [AcademyController::class, 'index'])->name('index');
        Route::get('academia/examen/clasificatorio', [AcademyController::class, 'createExamQualifying'])->name('create.qualifying');
    });
/**
 * -----------------------------------------------------------------------------
 * Courses
 * -----------------------------------------------------------------------------
 */

Route::name('courses.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/cursos', [CourseController::class, 'index'])->name('index');
        Route::get('/cursos/{courseId}', [CourseController::class, 'showCourse'])->name('show');
    });

/**
 * -----------------------------------------------------------------------------
 * Questions
 * -----------------------------------------------------------------------------
 */

Route::name('questions.')
    ->middleware(['auth'])
    ->group(function () {
        Route::post('/preguntas/{question}/report', [QuestionController::class, 'report'])->name('report');
    });
/**
 * -----------------------------------------------------------------------------
 * My account
 * -----------------------------------------------------------------------------
 */

Route::name('flash-cards.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/flash-cards', [FlashCardsController::class, 'index'])->name('index');
        Route::get('/flash-cards/{slug}', [FlashCardsController::class, 'category'])->name('category');
    });

/**
 * -----------------------------------------------------------------------------
 * My account
 * -----------------------------------------------------------------------------
 */

Route::name('my-account.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/mi-cuenta', [MyAccountController::class, 'index'])->name('index');
        Route::post('/mi-cuenta/cambiar-nombre', [UserController::class, 'updateName'])->name('update-name');
        Route::post('/mi-cuenta/cambiar-telefono', [UserController::class, 'updatePhone'])->name('update-phone');
        Route::post('/mi-cuenta/actualizar-contraseña', [UserController::class, 'updatePassword'])->name('update-password');
    });
/**
 * -----------------------------------------------------------------------------
 * Training - personalized
 * -----------------------------------------------------------------------------
 */

Route::name('training.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/IA', [performanceController::class, 'SendAI'])->name('IA');
        Route::get('/training',[TrainingController::class,'index'])->name('index');
        Route::get('/training/display',[TrainingController::class,'display'])->name('display');
        Route::get('/training/entrenamiento', [performanceController::class, 'training'])->name('training');
    });

/**
 * -----------------------------------------------------------------------------
 * Statistics
 * -----------------------------------------------------------------------------
 */

Route::name('statistics.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/progreso', [StatisticsController::class, 'index'])->name('index');
        Route::get('/progreso/categoria/{question_category}', [StatisticsController::class, 'showQuestionCategory'])->name('showQuestionCategory');
        Route::get('/estadisticas', [StatisticsController::class, 'index_new'])->name('index.new');
        Route::post('/estadisticas/load', [StatisticsController::class, 'exams_load'])->name('exams.load');
        Route::post('/estadisticas/chart', [StatisticsController::class, 'exams_load_chart'])->name('exams.load.chart');
        Route::post('/estadisticas/detail/load', [StatisticsController::class, 'detail_load'])->name('exams.detail.load');
        Route::get('/estadisticas/{exam}', [StatisticsController::class, 'show'])->name('show');
        // Route::get('/estadisticas/{exam}/detail', [StatisticsController::class, 'detail'])->name('detail');
    });

/**
 * -----------------------------------------------------------------------------
 * Subscriptions
 * -----------------------------------------------------------------------------
 */

Route::name('subscriptions.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/suscripcion', [SubscriptionController::class, 'index'])->name('index');
        Route::get('/suscripcion/comprar/{plan}', [SubscriptionController::class, 'checkout'])->name('checkout');
        Route::get('/suscripcion/comprar/new-user', [SubscriptionController::class, 'NewUserPromo'])->name('NewUserPromo');
    });

/**
 * -----------------------------------------------------------------------------
 * Support
 * -----------------------------------------------------------------------------
 */

Route::name('support.')
    ->group(function () {
        Route::post('/soporte', [SupportController::class, 'submit'])->name('submit');
    });

/**
 * -----------------------------------------------------------------------------
 * Administration panel
 * -----------------------------------------------------------------------------
 */
Route::name('admin.')
    // ->middleware(['auth', 'role:super-admin|admin|moderator'])
    ->prefix('9PbqBgmI2f')
    ->group(function () {
        Route::get('/', [AdminPanelController::class, 'index'])->name('index');

        /**
         * Checkout references
         */
        Route::name('checkout_references.')->group(function () {
            Route::get('/referencias-de-compra', [CheckoutReferenceController::class, 'index'])->name('index');
        });
        /**
         * Question categories
         */
        Route::name('question_categories.')->group(function () {
            Route::get('/categorias', [QuestionCategoryController::class, 'index'])->name('index');
        });

        /**
         * Question subcategories
         */
        Route::name('question_subcategories.')->group(function () {
            Route::get('/subcategorias', [QuestionSubcategoryController::class, 'index'])->name('index');
        });


        /**
         * Settings Notifications
         */
        Route::name('notifications_settings.')->group(function () {
            Route::get('/configuracion-notificaciones', [SettingsNotificationsController::class, 'index'])->name('index');
            Route::post('/configuracion-notificaciones', [SettingsNotificationsController::class, 'save'])->name('save');
        });

        /**
         *  Notifications
         */
        Route::name('notifications.')->group(function () {
            Route::get('/notificaciones', [NotificationsController::class, 'index'])->name('index');
        });
        /**
         * Plans
         */
        Route::name('plans.')->group(function () {
            Route::get('/planes', [PlanController::class, 'index'])->name('index');
            Route::get('/planes/nuevo', [PlanController::class, 'create'])->name('create');
            Route::post('/planes/nuevo', [PlanController::class, 'store'])->name('store');
            Route::get('/planes/{plan}', [PlanController::class, 'show'])->name('show');
            Route::post('/planes/{plan}/cambiar-estado-activo', [PlanController::class, 'toggleActive'])->name('toggleActive');
        });

        Route::name('affiliates.')
            ->middleware(['can:list affiliates'])
            ->prefix('afiliados')
            ->group(function () {
                Route::get('/', [AdminAffiliateController::class, 'index'])->name('index');
                Route::put('/', [AdminAffiliateController::class, 'update'])->name('update')->middleware(['can:edit affiliates']);
                Route::post('nuevo', [AdminAffiliateController::class, 'store'])->name('store')->middleware(['can:edit affiliates']);
                Route::put('/identificador-publico', [UserController::class, 'updateSlug'])->name('update-slug')->middleware(['can:edit affiliates']);
            });

        Route::name('promo-codes.')
            ->middleware(['can:list promo codes'])
            ->prefix('codigos-promocionales')
            ->group(function () {
                Route::get('/', [AdminPromoCodeController::class, 'index'])->name('index');
                Route::put('/', [AdminPromoCodeController::class, 'update'])->name('update')->middleware(['can:edit promo codes']);
                Route::post('nuevo', [AdminPromoCodeController::class, 'store'])->name('store')->middleware(['can:edit promo codes']);
            });

        Route::name('roles.')
            ->middleware(['can:list permissions'])
            ->prefix('roles')
            ->group(function () {
                Route::get('/', [AdminRoleController::class, 'index'])->name('index');
                Route::put('/', [AdminRoleController::class, 'update'])->name('update')->middleware(['can:edit permissions']);
                Route::post('nuevo', [AdminRoleController::class, 'store'])->name('store')->middleware(['can:edit permissions']);
            });

        Route::name('users.')
            ->middleware(['can:list users'])
            ->prefix('usuarios')
            ->group(function () {
                Route::get('/', [AdminUserController::class, 'index'])->name('index');
                Route::get('{user}', [AdminUserController::class, 'show'])->name('show');
                Route::post('{user}/suscripcion/nueva', [AdminSubscriptionController::class, 'store'])->name('subscriptions.store')->middleware(['can:edit subscriptions']);
                Route::post('{user}/password/update', [AdminUserController::class, 'updatePassword'])->name('password.update');
            });

        Route::name('import-students.')
            ->middleware(['can:import students'])
            ->prefix('importar-estudiantes')
            ->group(function () {
                Route::get('/', [ImportUserController::class, 'index'])->name('index');
                Route::post('/import', [ImportUserController::class, 'import'])->name('import');
            });

        Route::name('reevaluate-exam.')
            // ->middleware(['can:import students'])
            ->prefix('reevaluar-exam')
            ->group(function () {
                Route::get('/{slug}', [ReevaluateExamController::class, 'upgrade'])->name('index');
            });


        // /**
        //  * Users NO TERMINADO
        //  */
        // Route::name('users.')->group(function () {
        //     Route::get('/usuarios/listas/no-premium', [UserController::class, 'listNonPremium'])->name('listNonPremium');
        //     Route::get('/usuarios/{user}/suscripcion/nueva', [SubscriptionController::class, 'create'])->name('createSubscription');
        //     Route::post('/usuarios/{user}/suscripcion/nueva', [SubscriptionController::class, 'store'])->name('storeSubscription');
        //     Route::get('/usuarios/{user}/suscripcion/{subscription}', [SubscriptionController::class, 'edit'])->name('editSubscription');
        //     Route::post('/usuarios/{user}/suscripcion/{subscription}', [SubscriptionController::class, 'update'])->name('updateSubscription');
        // });
    });

/**
 * Admin
 */
Route::name('admin.')->middleware(['auth', 'admin'])->prefix('administracion')->group(function () {
});

/**
 * Panel Only superADmin
 */
