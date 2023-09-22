<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
| mysqldump -u root -p sakila > 
*/

Route::get('/bcrypt', function () {
    return Hash::make('password');
});

Route::get('/congress', [MainController::class, 'index']);
Route::get('/', [MainController::class, 'login']);
Route::post('complete-registration',[MainController::class, 'completeRegistration'] );
Route::post('/set-acc-password', [MainController::class, 'setAccountPassword'] );
Route::get('/omsu-dashboard', [MainController::class, 'myOmsuDhasboard'] );
Route::get('/apply-now', [MainController::class, 'apply']);
Route::post('/apply-now', [MainController::class, 'applyForConference']);
Route::get('/submit-abstract', [MainController::class, 'conferenceAbstract']);
Route::get('/submit-new-abstract', [MainController::class, 'conferenceNewAbstract']);
Route::post('/submit-abstract', [MainController::class, 'saveAbstract']);
Route::get('/conference-details', [MainController::class, 'conferenceDetails']);
Route::get('/download-attachment', [MainController::class, 'downloadAbstractTemplate']);
Route::post('/get-reg-amount', [MainController::class, 'getRegAmount']);
Route::get('/reg-success', [MainController::class, 'regSuccess']);
Route::get('/abs-success', [MainController::class, 'absSuccess']);
Route::get('/download-proof', [MainController::class, 'downloadProof']);
Route::get('/download-abs-proof', [MainController::class, 'downloadAbstractProof']);
Route::get('/download-brochure', [MainController::class, 'downloadBrochure']);
Route::get('/no-brochure', [MainController::class, 'noBrochure']);
Route::get('/conference-docs', [MainController::class, 'conferenceDocs']);
Route::get('/about', [MainController::class, 'aboutConference']);

Route::get('/admin-login', [AdminController::class, 'login'])->name('login');
Route::post('/admin-login', [AdminController::class, 'loginAdmin']); 

//nomore in use
Route::get('/verify-reg', [MainController::class, 'verifyReg']);
Route::post('/verify-reg', [MainController::class, 'sendRegEmail']);  
Route::get('/verify-abstract', [MainController::class, 'verifyAbstract']);
Route::post('/verify-abstract', [MainController::class, 'sendAbstractEmail']);

Route::group(['middleware' => 'auth:admin'], function(){
    Route::get('/admin-dashboard', [AdminController::class, 'index']);
    Route::get('/new-conference', [AdminController::class, 'newConference']);
    Route::post('/new-conference', [AdminController::class, 'saveNewConference']);
    Route::get('/conferences', [AdminController::class, 'conferences']);
    Route::get('/view-abstract', [AdminController::class, 'viewAbstract']);
    Route::get('/registrants', [AdminController::class, 'getRegistratnts']);
    Route::get('/edit-conference', [AdminController::class, 'editConference']);
    Route::post('/edit-conference', [AdminController::class, 'saveEditedConference']);
    Route::post('/delete-attachment', [AdminController::class, 'deleteAttachment']);
    Route::post('/delete-conference', [AdminController::class, 'deleteConference']);

    Route::get('/download-all-abstracts', [AdminController::class, 'downloadAllAbstracts']);
    Route::get('/export-registrants', [AdminController::class, 'exportRegistrantsToExcel']);
    Route::get('/export-abstracts', [AdminController::class, 'exportAbstractsToExcel']);
    Route::get('/download-abstract', [AdminController::class, 'downloadAbstract']);
    Route::post('/update-abstract-state', [AdminController::class, 'updateAbstractState']);

    Route::get('/add-documents', [AdminController::class, 'addDocument']);
    Route::post('/add-documents', [AdminController::class, 'saveDocuments']);
    Route::post('/delete-document', [AdminController::class, 'deleteDocument']);




    Route::get('/accounts', [AdminController::class, 'accounts']);
    Route::post('/staff-info', [AdminController::class, 'getStaffInfo']);
    Route::post('/accounts', [AdminController::class, 'saveNewAdmin']);
    Route::post('/deleteuser', [AdminController::class, 'deleteAdmin']);
});

Route::get('/logout', [AdminController::class, 'logout']);





