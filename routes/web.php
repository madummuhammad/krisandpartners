<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\member\DashboardController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\member\TransactionController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/register',[WebController::class,'RegisterForm']);
Route::get('/status',[MidtransController::class,'get_status']);
Route::post('/register', [WebController::class, 'register'])->name('register');

Route::get('/login',[WebController::class,'LoginForm']);
Route::get('/term_condition',[WebController::class,'term_condition']);
Route::get('/contact_us',[WebController::class,'contact_us']);
Route::post('/contact_us',[WebController::class,'contact_us_send']);
Route::post('/login', [WebController::class, 'login'])->name('login');
Route::post('/logout', [WebController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [WebController::class, 'forgot_password_form'])->name('forgot-password');
Route::post('/forgot-password', [WebController::class, 'forgot_password'])->name('forgot-password');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verify',[EmailVerificationController::class,'notify']);





// Admin
Route::get('admin/login',[UserController::class,'login'])->name('admin.login');
Route::post('admin/login',[UserController::class,'auth']);
Route::post('admin/logout',[UserController::class,'logout']);

Route::group(['prefix' => 'admin','middleware'=>'auth'], function() {
    Route::get('/',function(){
        return redirect('admin/competition');
    });
    Route::group(['prefix' => 'competition'], function() {
        Route::get('/', [CompetitionController::class, 'index']);
        Route::get('/add', [CompetitionController::class, 'add']);
        Route::post('/add', [CompetitionController::class, 'create'])->name('admin.competition.add');
        Route::get('/edit/{id}', [CompetitionController::class, 'edit']);
        Route::get('/view/{id}', [CompetitionController::class, 'view']);
        Route::post('/update/{id}', [CompetitionController::class, 'update'])->name('admin.competition.update');
        Route::get('/participant/{id}', [CompetitionController::class, 'participant']);
        Route::get('/participant/detail/{id}', [CompetitionController::class, 'participant_detail']);
        Route::post('/participant/detail/{id}', [CompetitionController::class, 'participant_win']);
        Route::get('/participant/certificate/{id}', [CompetitionController::class, 'showCertificate']);
        Route::get('/image', [CompetitionController::class, 'downloadImage'])->name('admin.competition.image');
        Route::delete('/{id}', [CompetitionController::class, 'destroy'])->name('admin.competition.delete');
        Route::post('/certificate/download/{id}',[CertificateController::class,'download']);
        Route::get('/certificate/{id}',[CertificateController::class,'index']);
        Route::post('/certificate/{id}',[CertificateController::class,'update']);
    });

    Route::group(['prefix'=>'settings'],function(){
        Route::get('/',[SettingsController::class,'index']);
        Route::post('/',[SettingsController::class,'update']);
        Route::post('/term_condition',[SettingsController::class,'term_condition']);
    });

    Route::group(['prefix'=>'certificate'],function(){
        Route::get('/',[CertificateController::class,'formGenerate']);
        Route::post('/',[CertificateController::class,'generate']);
    });

    
    Route::group(['prefix' => 'categories'], function() {
        Route::post('/', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('admin.categories');
    });
    Route::delete('/category/delete', [CategoryController::class, 'destroy'])->name('admin.category.delete');
    Route::delete('/category/deleteOne', [CategoryController::class, 'destroyOne'])->name('admin.category.deleteOne');



    Route::group(['prefix'=>'member'],function(){
        Route::get('/',[MemberController::class,'index']);
        Route::get('/edit/{id}',[MemberController::class,'edit']);
        Route::post('/edit/{id}',[MemberController::class,'update']);
        Route::delete('{id}', [MemberController::class,'destroy'])->name('admin.member.destroy');

    });

    Route::group(['prefix'=>'user'],function(){
        Route::get('/',[UserController::class,'index']);
        Route::get('/add',[UserController::class,'add']);
        Route::post('/add', [UserController::class, 'addUser'])->name('admin.user.add');
        Route::get('/edit/{id}',[UserController::class,'edit']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
    });
});

// Member

Route::group(['prefix'=>'/','middleware'=>'member'],function(){
    Route::get('/',[DashboardController::class,'index']);
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/certificate/{id}',[DashboardController::class,'certificate']);
    Route::get('/profile',[DashboardController::class,'profile']);
    Route::post('/profile/{id}',[DashboardController::class,'profile_update']);
    Route::get('/transaction',[TransactionController::class,'index']);

    Route::group(['prefix'=>'/competition'],function(){
        Route::post('/upload',[UploadController::class,'upload'])->name('competition.upload');
        Route::get('/join/{id}',[DashboardController::class,'joinForm']);
        Route::post('/join/{id}',[DashboardController::class,'join'])->name('competition.join');
        Route::get('/detail/{id}',[DashboardController::class,'competition_detail']);
        Route::patch('/detail/{id}',[DashboardController::class,'submision']);

        Route::get('/summary/{id}',[TransactionController::class,'summary']);
        Route::post('/transaction/{id}',[TransactionController::class,'transaction'])->name('competition.transaction');
    });
});