<?php

use App\Http\Middleware\SuperUser;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminPersonalGroupsController;
use App\Http\Controllers\Admin\AdminPersonalJobHierarchyController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminCustomerContactsController;
use App\Http\Controllers\Admin\AdminJobHierarchyController;
use App\Http\Controllers\Admin\AdminEmployeesController;
use App\Http\Controllers\Admin\AdminSectionsController;
use App\Http\Controllers\Admin\AdminEmployeesSectionsController;
use App\Http\Controllers\Admin\AdminToolsController;
use App\Http\Controllers\Admin\AdminToolDatasController;
use App\Http\Controllers\Admin\AdminPersonalToolsController;
use App\Http\Controllers\Admin\AdminTagsController;
use App\Http\Controllers\Admin\AdminToolsTagsController;
use App\Http\Controllers\Admin\AdminLanguagesController;
use App\Http\Controllers\Admin\AdminInspireMeController;
use App\Http\Controllers\Admin\AdminLogsController;
use App\Http\Controllers\Admin\ImpersonatedController;
use App\Http\Controllers\Admin\GetImage;
use App\Http\Middleware\CustomerAdmin;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (Request $request) {
    $languages = Language::orderBy('order')->get(['code', 'name']);
    $currentLanguage = $request->cookie('current-locale') ?: '';

    return view('welcome', [
        'languages' => $languages,
        'currentLanguage' => $currentLanguage,
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('lang/change', 'LanguageController@change')->name('changeLanguage');

Route::middleware('auth')->group(function () {
    // Pagina di amministrazione globale.
    Route::get('/admin', [AdminController::class, 'index']);

    // Ritorna la foto dell'utente o 'images/no-user.png' se nessuna foto è stata caricata nel DB.
    Route::post('/get-photo', [GetImage::class, 'photo']);


    //////////////////////////////////////////////
    // Sub views di amministrazione (via Ajax). //
    //////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // Route di amministrazione per gli impiegati regolari.

    // Profile.
    Route::post('/admin.profile.index', [AdminProfileController::class, 'index'])->can('adm-profile');
    Route::post('/admin.profile.store', [AdminProfileController::class, 'store'])->can('adm-profile');
    Route::post('/admin.profile.upload-photo', [AdminProfileController::class, 'uploadPhoto'])->can('adm-profile');
    Route::post('/admin.profile.delete-photo', [AdminProfileController::class, 'deletePhoto'])->can('adm-profile');

    // Personal Groups.
    Route::post('/admin.personal-groups.index', [AdminPersonalGroupsController::class, 'index'])->can('adm-personal-groups');
    Route::post('/admin.personal-groups.edit', [AdminPersonalGroupsController::class, 'edit'])->can('adm-personal-groups');
    Route::post('/admin.personal-groups.add', [AdminPersonalGroupsController::class, 'add'])->can('adm-personal-groups');
    Route::post('/admin.personal-groups.delete', [AdminPersonalGroupsController::class, 'delete'])->can('adm-personal-groups');

    // Personal Job Hierarchy.
    Route::post('/admin.personal-job-hierarchy.index', [AdminPersonalJobHierarchyController::class, 'index'])->can('adm-personal-job-hierarchy');
    Route::post('/admin.personal-job-hierarchy.edit', [AdminPersonalJobHierarchyController::class, 'edit'])->can('adm-personal-job-hierarchy');
    Route::post('/admin.personal-job-hierarchy.add', [AdminPersonalJobHierarchyController::class, 'add'])->can('adm-personal-job-hierarchy');
    Route::post('/admin.personal-job-hierarchy.delete', [AdminPersonalJobHierarchyController::class, 'delete'])->can('adm-personal-job-hierarchy');


    //////////////////////////////////////////////////////////////////
    // Route di amministrazione per i 'customerAdmin' (e 'siteAdmin').

    // Customer.
    Route::post('/admin.customer.index', [AdminCustomerController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-customer');
    Route::post('/admin.customer.store', [AdminCustomerController::class, 'store'])->middleware(CustomerAdmin::class)
        ->can('adm-customer');
    Route::post('/admin.customer.upload-logo', [AdminCustomerController::class, 'uploadLogo'])->middleware(CustomerAdmin::class)
        ->can('adm-customer');
    Route::post('/admin.customer.delete-logo', [AdminCustomerController::class, 'deleteLogo'])->middleware(CustomerAdmin::class)
        ->can('adm-customer');
    Route::post('/admin.customer.change-country', [AdminCustomerController::class, 'changeCountry'])->middleware(CustomerAdmin::class)
        ->can('adm-customer');

    // Customer Contacts.
    Route::post('/admin.customer-contacts.index', [AdminCustomerContactsController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-customer-contacts');
    Route::post('/admin.customer-contacts.edit', [AdminCustomerContactsController::class, 'edit'])->middleware(CustomerAdmin::class)
        ->can('adm-customer-contacts');
    Route::post('/admin.customer-contacts.add', [AdminCustomerContactsController::class, 'add'])->middleware(CustomerAdmin::class)
        ->can('adm-customer-contacts');
    Route::post('/admin.customer-contacts.delete', [AdminCustomerContactsController::class, 'delete'])->middleware(CustomerAdmin::class)
        ->can('adm-customer-contacts');

    // Customer Job Hierarchy.
    Route::post('/admin.job-hierarchy.index', [AdminJobHierarchyController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-job-hierarchy');
    Route::post('/admin.job-hierarchy.edit', [AdminJobHierarchyController::class, 'edit'])->middleware(CustomerAdmin::class)
        ->can('adm-job-hierarchy');
    Route::post('/admin.job-hierarchy.add', [AdminJobHierarchyController::class, 'add'])->middleware(CustomerAdmin::class)
        ->can('adm-job-hierarchy');
    Route::post('/admin.job-hierarchy.delete', [AdminJobHierarchyController::class, 'delete'])->middleware(CustomerAdmin::class)
        ->can('adm-job-hierarchy');

    // Employees.
    Route::post('/admin.employees.index', [AdminEmployeesController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-employees');
    Route::post('/admin.employees.edit', [AdminEmployeesController::class, 'edit'])->middleware(CustomerAdmin::class)
        ->can('adm-employees');
    Route::post('/admin.employees.add', [AdminEmployeesController::class, 'add'])->middleware(CustomerAdmin::class)
        ->can('adm-employees');
    Route::post('/admin.employees.delete', [AdminEmployeesController::class, 'delete'])->middleware(CustomerAdmin::class)
        ->can('adm-employees');
    Route::post('/admin.employees.upload-photo', [AdminEmployeesController::class, 'uploadPhoto'])->middleware(CustomerAdmin::class)
        ->can('adm-employees');
    Route::post('/admin.employees.delete-photo', [AdminEmployeesController::class, 'deletePhoto'])->middleware(CustomerAdmin::class)
        ->can('adm-employees');

    // Sections.
    Route::post('/admin.sections.index', [AdminSectionsController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-sections');
    Route::post('/admin.sections.store', [AdminSectionsController::class, 'store'])->middleware(CustomerAdmin::class)
        ->can('adm-sections');

    // Employees and Sections.
    Route::post('/admin.employees-sections.index', [AdminEmployeesSectionsController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-employees-sections');
    Route::post('/admin.employees-sections.save-employee', [AdminEmployeesSectionsController::class, 'saveEmployee'])->middleware(CustomerAdmin::class)
        ->can('adm-employees-sections');
    Route::post('/admin.employees-sections.save-section', [AdminEmployeesSectionsController::class, 'saveSection'])->middleware(CustomerAdmin::class)
        ->can('adm-employees-sections');


    //////////////////////////////////////////////
    // Route di amministrazione per i 'siteAdmin'.

    // Tools.
    Route::post('/admin.tools.index', [AdminToolsController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-tools');
    Route::post('/admin.tools.edit', [AdminToolsController::class, 'edit'])->middleware(SuperUser::class)
        ->can('adm-tools');
    Route::post('/admin.tools.add', [AdminToolsController::class, 'add'])->middleware(SuperUser::class)
        ->can('adm-tools');
    Route::post('/admin.tools.delete', [AdminToolsController::class, 'delete'])->middleware(SuperUser::class)
        ->can('adm-tools');


    // Tool Datas.
    Route::post('/admin.tool-datas.index', [AdminToolDatasController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-tool-datas');
    Route::post('/admin.tool-datas.store', [AdminToolDatasController::class, 'store'])->middleware(SuperUser::class)
        ->can('adm-tool-datas');


    // Personal Tools.
    Route::post('/admin.personal-tools.index', [AdminPersonalToolsController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-personal-tools');
    Route::post('/admin.personal-tools.store', [AdminPersonalToolsController::class, 'store'])->middleware(SuperUser::class)
        ->can('adm-personal-tools');

    // Tags.
    Route::post('/admin.tags.index', [AdminTagsController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-tags');
    Route::post('/admin.tags.edit', [AdminTagsController::class, 'edit'])->middleware(SuperUser::class)
        ->can('adm-tags');
    Route::post('/admin.tags.add', [AdminTagsController::class, 'add'])->middleware(SuperUser::class)
        ->can('adm-tags');
    Route::post('/admin.tags.delete', [AdminTagsController::class, 'delete'])->middleware(SuperUser::class)
        ->can('adm-tags');

    // Tools and Tags.
    Route::post('/admin.tools-tags.index', [AdminToolsTagsController::class, 'index'])->middleware(CustomerAdmin::class)
        ->can('adm-tools-tags');
    Route::post('/admin.tools-tags.save-tool', [AdminToolsTagsController::class, 'saveTool'])->middleware(CustomerAdmin::class)
        ->can('adm-tools-tags');
    Route::post('/admin.tools-tags.save-tag', [AdminToolsTagsController::class, 'saveTag'])->middleware(CustomerAdmin::class)
        ->can('adm-tools-tags');

    // Languages.
    Route::post('/admin.languages.index', [AdminLanguagesController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-languages');
    Route::post('/admin.languages.edit', [AdminLanguagesController::class, 'edit'])->middleware(SuperUser::class)
        ->can('adm-languages');
    Route::post('/admin.languages.add', [AdminLanguagesController::class, 'add'])->middleware(SuperUser::class)
        ->can('adm-languages');
    Route::post('/admin.languages.delete', [AdminLanguagesController::class, 'delete'])->middleware(SuperUser::class)
        ->can('adm-languages');

    // Inspire Me.
    Route::post('/admin.inspire-me.index', [AdminInspireMeController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-inspire-me');
    Route::post('/admin.inspire-me.store', [AdminInspireMeController::class, 'store'])->middleware(SuperUser::class)
        ->can('adm-inspire-me');

    // Logs.
    Route::post('/admin.logs.index', [AdminLogsController::class, 'index'])->middleware(SuperUser::class)
        ->can('adm-logs');


    // Route per il cambio di user impersonato (deve essere un Super User).
    Route::post('/impersonated/change', [ImpersonatedController::class, 'change'])->middleware(SuperUser::class);

    // Route per l'aggiornamento del <select#impersonated-employee>.
    Route::post('/impersonated/index', [ImpersonatedController::class, 'index'])->middleware(SuperUser::class);
});

require __DIR__ . '/auth.php';
