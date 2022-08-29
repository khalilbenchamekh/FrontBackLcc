<?php

use App\Http\Controllers\Crud\AffaireSituationController;
use App\Http\Controllers\Crud\EmployeeController;
use App\Http\Requests\Enums\EmailMessageChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crud\LoadController;
use App\Http\Controllers\Crud\LoadTypesController;
use App\Http\Controllers\Crud\ClientController;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/send',function (){
    $emailMessageChoise=new EmailMessageChoice();
    $table=$emailMessageChoise->getConstants();
    dd($table);
});

Route::post("/employees/store",[EmployeeController::class,'store']);
//Route::post("/affairesituations",[AffaireSituationController::class,'index']);
//GOOD Route::post("/affairesituations/many",[AffaireSituationController::class,'storeMany']);
//GOOD Route::get("/affairesituations/delete/{id}",[AffaireSituationController::class,'destroy']);
//Good Route::post("/affairesituations/edit/{id}",[AffaireSituationController::class,'update']);

// Good Route::get("/affairesituations/{id}",[AffaireSituationController::class,'show']);

// GOOD Route::post("/affairesituations/store",[AffaireSituationController::class,'store']);
//?? Route::get("/loads/destroy/{id}",[LoadController::class,'destroy']);
// LE PROBLEME DANS MODIFICATION DE FILE  Route::post("/loads/{id}",[LoadController::class,'update']);
//GOOD Route::post("/loads/store",[LoadController::class,'store']);

//GOOD  Route::post("/loads/index",[LoadController::class,'index']);


    //-------------- loadtypes ------------->

// GOOD Route::post('/loadtypes',[LoadTypesController::class,"index"]);

//Good Route::get('/loadtypes/{id}',[LoadTypesController::class,"show"]);

//GOOD Route::post('/loadtypes/edit/{id}',[LoadTypesController::class,"update"]);


// GOOD Route::get('/loadtypes/delete/{id}',[LoadTypesController::class,"destroy"]);


// GOOD Route::post('/loadtypes/saveMany',[LoadTypesController::class,"storeMany"]);

//-------------- End loadtypes ------------->

//----------clients ------------------>
Route::post('/clients',[ClientController::class,"index"]);
Route::post('/client/store',[ClientController::class,"store"]);
Route::get('/client/{id}',[ClientController::class,"show"]);





Route::post('/user/image/save/{id}',[\App\Http\Controllers\Web\AdminController::class,'saveImage']);

Route::get('loadtypes/all', [LoadTypesController::class,'index']);
Route::post('/connexion',[\App\Http\Controllers\Web\AuthController::class,'login']);

Route::prefix('super')->middleware(['jwt.verify','isSuper'])->group(function (){
    Route::post('/organisations',[\App\Http\Controllers\Web\OrganisationController::class,'getAllOrganisation']);
    Route::get('/organisation/image/get/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'getImOrganisation']);
    Route::get('/organisation/image/delete/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'deleteImageOrganisation']);
    Route::post('/organisation/image/update/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'saveImageOrganisation']);
    Route::get('/organisation/get/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'getOrganisation']);
    Route::post('/organisation/edit/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'editOrganisation']);
    Route::get('/organisation/delete/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'deleteOrganisation']);
    Route::get('/organisation/enable/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'enableOrganisation']);
    Route::get('/organisation/disable/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'disableOrganisation']);
    Route::get('/organisation/block/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'blockedOrganisation']);
    Route::post('/organisation/save',[\App\Http\Controllers\Web\OrganisationController::class,'storeOrganisation']);
    Route::post('/organisation/users/get/{id}',[\App\Http\Controllers\Web\OrganisationController::class,'getAllUserOrganisation']);

    Route::post('/users',[\App\Http\Controllers\Web\AdminController::class,'getAllUser']);
    Route::get('/users/count',[\App\Http\Controllers\Web\AdminController::class,'getUserCount']);
    Route::get('/user/get/{id}',[\App\Http\Controllers\Web\AdminController::class,'getUser']);
    Route::post('/user/edit/{id}',[\App\Http\Controllers\Web\AdminController::class,'editUser']);
    Route::get('/user/delete/{id}',[\App\Http\Controllers\Web\AdminController::class,'deleteUser']);
    Route::get('/user/enable/{id}',[\App\Http\Controllers\Web\AdminController::class,'enableUser']);
    Route::get('/user/disable/{id}',[\App\Http\Controllers\Web\AdminController::class,'disableUser']);
    Route::get('/user/block/{id}',[\App\Http\Controllers\Web\AdminController::class,'blockUser']);
    Route::post('/user/generatePass/{id}',[\App\Http\Controllers\Web\AdminController::class,'generatePasswordUser']);
    Route::post('/user/save',[\App\Http\Controllers\Web\AdminController::class,'createUser']);
    Route::get('/user/image/get/{id}',[\App\Http\Controllers\Web\AdminController::class,'getImage']);
    // Route::post('/user/image/save/{id}',[\App\Http\Controllers\Web\AdminController::class,'saveImage']);

});








Route::group(['namespace' => 'Auth'], function () {

    Route::post('auth/login', ['as' => 'login', 'uses' => 'AuthController@login']);

    Route::post('auth/register', ['as' => 'register', 'uses' => 'RegisterController@register']);
    // Send reset password mail
    Route::post('auth/recovery', 'ForgotPasswordController@sendPasswordResetLink');
    // handle reset password form process
    Route::post('auth/reset', 'ResetPasswordController@callResetPassword');

});
Route::post('fileExplorer/download', 'FileManagerController@downloadFunc');
Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::any('fileExplorer', 'FileManagerController@actions');

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('auth/refresh', 'AuthController@refresh');
    });
    Route::group(['namespace' => 'Statistiques'], function () {
        Route::post('/accounting', 'StatistiquesController@index');
    });

    Route::group(['namespace' => 'Messagerie'], function () {

        Route::get('/conversations', 'ConversationsController@index');
        Route::get('/conversations/{user}', 'ConversationsController@show')->middleware('can:talkTo,user');
        Route::post('/conversations/{user}', 'ConversationsController@store')->middleware('can:talkTo,user');
        Route::post('/messages/{message}', 'MessagesController@read')->middleware('can:read,message');

    });

    Route::group(['namespace' => 'Profile'], function () {

        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@me']);

        Route::post('profile', ['as' => 'profile', 'uses' => 'ProfileController@update']);

        Route::put('profile/password', ['as' => 'profile', 'uses' => 'ProfileController@updatePassword']);

    });

    Route::group(['namespace' => 'Auth'], function () {

        Route::post('auth/logout', ['as' => 'logout', 'uses' => 'LogoutController@logout']);

    });
    Route::group(['namespace' => 'Admin'], function () {
        Route::post('auth/Admin/res/users', 'AdminResourceController@getUsers');
        Route::post('auth/Admin/res/setUser', 'AdminResourceController@setUsers');
        Route::post('auth/Admin/res/analytics', 'AdminResourceController@getDefaultElementOfDashBoard');
        Route::get('auth/Admin/res/roles', 'AdminResourceController@getRoles');
        Route::get('auth/Admin/res/permission', 'AdminResourceController@getPermissions');
        Route::get('auth/Admin/res/logs', 'AdminResourceController@logActivity');
        Route::get('auth/Admin/res/routes', 'AdminResourceController@getRoutes');
        Route::apiResource('missions', 'MissionController');
    });


    Route::group(['namespace' => 'Crud'], function () {
        //Route::apiResource('affairenatures', 'AffaireNatureController');
        //TAPE1
        Route::post('affairenatures/store', [\App\Http\Controllers\Crud\AffaireNatureController::class,'store']);
        Route::post('affairenatures/all', [\App\Http\Controllers\Crud\AffaireNatureController::class,'index']);
        Route::post('affairenatures/get/{id}', [\App\Http\Controllers\Crud\AffaireNatureController::class,'getAffaireNature']);
        Route::post('affairenatures/edit/{id}', [\App\Http\Controllers\Crud\AffaireNatureController::class,'edait']);
        Route::get('affairenatures/delete/{id}', [\App\Http\Controllers\Crud\AffaireNatureController::class,'destroy']);
        //end apiResource('affairenatures', 'AffaireNatureController')
        Route::apiResource('foldertechnatures', 'FolderTechNatureController');
        // Route::post('affairenatures/multi', 'AffaireNatureController@storeMany');
        Route::post('foldertechnatures/multi', 'FolderTechNatureController@storeMany');
        //end Route::post('foldertechnatures/multi', 'FolderTechNatureController@storeMany');
        //Route::apiResource('loadtypes', 'LoadTypesController');

        Route::post('loadtypes/multi', 'LoadTypesController@storeMany');

        //Route::apiResource('loads', 'LoadController');
        Route::post('loads/statistics', 'LoadController@dashboard');

        //Route::apiResource('clients', 'ClientController');
        Route::post('clients/business', 'ClientController@storeBusiness');
        Route::post('clients/particular', 'ClientController@storeParticular');

        //Route::apiResource('employees', 'EmployeeController');
        Route::post('employees/employee', 'EmployeeController@storeEmployee');
        Route::post('employees/docs', 'EmployeeController@download');

        //Route::apiResource('affairesituations', 'AffaireSituationController');
        Route::post('affairesituations/multi', 'AffaireSituationController@storeMany');

        Route::apiResource('foldertechsituations', 'FolderTechSituationController');
        Route::post('foldertechsituations/multi', 'FolderTechSituationController@storeMany');


        Route::apiResource('affaires', 'AffaireController');


        Route::apiResource('folderteches', 'FolderTechController');

        Route::apiResource('intermediates', 'IntermediateController');

        Route::get('getFolderTech', 'FeesController@getFolderTech');
        Route::get('getBusiness', 'FeesController@getBusiness');
        Route::get('getFolderTechFees', 'FeesController@getFolderTechFees');
        Route::get('getBusinessFees', 'FeesController@getBusinessFees');
        Route::post('saveBusinessFees', 'FeesController@saveBusinessFees');
        Route::post('saveFolderTechFees', 'FeesController@saveFolderTechFees');
        Route::put('updateBusinessFees/{index}', 'FeesController@updateBusinessFees');
        Route::put('updateFolderTechFees/{index}', 'FeesController@updateFolderTechFees');

        Route::apiResource('greatconstructionsites', 'GreatConstructionSitesController');
        Route::post('g_c_s/dashboard', 'GreatConstructionSitesController@dashboard');
        Route::apiResource('cadastralconsultations', 'CadastralconsultationController');

        Route::apiResource('invoicestatuses', 'InvoiceStatusController');
        Route::apiResource('charges', 'ChargesController');
        Route::apiResource('typescharges', 'TypesChargeController');

    });

    Route::group(['namespace' => 'Resource'], function () {

        Route::get('getClient', 'ResourceController@getClient');
        Route::post('getCountDown', 'ResourceController@getCountDown');
        Route::get('getIntermediate', 'ResourceController@getIntermediate');
        Route::get('getLoadType', 'ResourceController@getLoadType');
        Route::get('getUser', 'ResourceController@getUser');
        Route::get('getLocationsAutoComplete', 'ResourceController@getLocationsAutoComplete');
        Route::get('getAllocatedBrigades', 'ResourceController@getAllocatedBrigades');
        Route::get('getLocations', 'ResourceController@getLocations');
        Route::post('getSearch', 'ResourceController@getSearch');
        Route::post('getSearchWithDetails', 'ResourceController@getSearchWithDetails');
//        Route::post('getClientAutocomplete','ResourceController@getClientAutocomplete');
//        Route::post('geResp','ResourceController@geResp');
        Route::get('getFolderTechName', 'ResourceController@getFolderTechName');
        Route::get('getNatureBusinessName', 'ResourceController@getNatureBusinessName');
        Route::get('geFolderTechSituation', 'ResourceController@geFolderTechSituation');
        Route::get('getBusinessSituation', 'ResourceController@getBusinessSituation');
        Route::get('getNotifications{page?}', 'ResourceController@getNotifications');
    });

});
Route::middleware('cors')->group(function () {
    Route::group(['namespace' => 'Genrator'], function () {
        Route::post('generatePDF', 'PDFController@generatePDF');
    });
});

Route::post('FileManager', 'FileController@FileManager');
Route::apiResource('files', 'FileController');
