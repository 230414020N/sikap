<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\HrdActivationController;
use App\Http\Controllers\Auth\RoleLoginController;

use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminPortfolioModerationController;
use App\Http\Controllers\Admin\MasterData\EducationLevelController as AdminEducationLevelController;
use App\Http\Controllers\Admin\MasterData\JobCategoryController as AdminJobCategoryController;
use App\Http\Controllers\Admin\MasterData\JobLocationController as AdminJobLocationController;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrdApplicationController;
use App\Http\Controllers\HrdDashboardController;
use App\Http\Controllers\HrdJobController;
use App\Http\Controllers\JobBrowseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PelamarProfileController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPortfolioController;

use App\Http\Controllers\Perusahaan\CompanyRegistrationController;
use App\Http\Controllers\Perusahaan\HrdAccountController;
use App\Http\Controllers\Perusahaan\JobController as PerusahaanJobController;
use App\Http\Controllers\Perusahaan\CompanyController as PerusahaanCompanyController;
use App\Http\Controllers\Perusahaan\PerusahaanDashboardController;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login/pelamar', [RoleLoginController::class, 'show'])->defaults('as', 'pelamar')->name('login.pelamar');
    Route::get('/login/hrd', [RoleLoginController::class, 'show'])->defaults('as', 'hrd')->name('login.hrd');
    Route::get('/login/perusahaan', [RoleLoginController::class, 'show'])->defaults('as', 'perusahaan')->name('login.perusahaan');

    Route::prefix('hrd')->group(function () {
    Route::get('/activate/{token}', [HrdActivationController::class, 'show'])
        ->middleware('signed:relative')
        ->name('hrd.activate');

    Route::post('/activate/{token}', [HrdActivationController::class, 'store'])
        ->middleware(['signed:relative', 'throttle:hrd-activate'])
        ->name('hrd.activate.store');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
    });

    Route::prefix('perusahaan')->as('perusahaan.')->group(function () {
         Route::get('/company', fn () => redirect()->route('perusahaan.company.edit'))->name('company');
         Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
         Route::put('/company', [CompanyController::class, 'update'])->name('company.update');

    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'perusahaan' => redirect()->route('perusahaan.dashboard'),
            'hrd' => redirect()->route('hrd.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('pelamar.dashboard'),
        };
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:pelamar'])->prefix('pelamar')->as('pelamar.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('profile', [\App\Http\Controllers\PelamarProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\PelamarProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile', [PelamarProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [PelamarProfileController::class, 'update'])->name('profile.update');

    Route::resource('portofolio', PortofolioController::class)->except(['show']);

    Route::get('/portofolio-public', [PublicPortfolioController::class, 'index'])->name('portofolio.public');
    Route::post('/portofolio/{portofolio}/like', [PublicPortfolioController::class, 'toggleLike'])->name('portofolio.like');

    Route::get('/jobs', [JobBrowseController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobBrowseController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/apply', [ApplicationController::class, 'applyForm'])->name('jobs.applyForm');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'submit'])->name('jobs.apply');

    Route::get('/applications/tracking', [ApplicationController::class, 'tracking'])->name('applications.tracking');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::middleware(['auth', 'role:hrd'])->prefix('hrd')->as('hrd.')->group(function () {
    Route::get('/dashboard', [HrdDashboardController::class, 'index'])->name('dashboard');

    Route::resource('jobs', HrdJobController::class)->except(['show']);

    Route::get('/applications', [HrdApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [HrdApplicationController::class, 'show'])->name('applications.show');
    Route::post('/applications/{application}/status', [HrdApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    Route::get('/company', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/company', [CompanyController::class, 'update'])->name('company.update');
});

Route::middleware(['auth', 'role:perusahaan'])->prefix('perusahaan')->as('perusahaan.')->group(function () {
    Route::get('/dashboard', [PerusahaanDashboardController::class, 'index'])->name('dashboard');

    Route::resource('jobs', PerusahaanJobController::class)->parameters(['jobs' => 'id']);

    Route::get('/company/edit', [PerusahaanCompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company', [PerusahaanCompanyController::class, 'update'])->name('company.update');

    Route::resource('hrd', HrdAccountController::class)->parameters(['hrd' => 'id']);
    Route::post('/hrd/{id}/activation-link', [HrdAccountController::class, 'regenerateActivationLink'])->name('hrd.activation-link');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('admin.companies.index'))->name('dashboard');

    Route::prefix('master-data')->as('master.')->group(function () {
        Route::resource('job-categories', AdminJobCategoryController::class)->except(['show']);
        Route::put('job-categories/{job_category}/status', [AdminJobCategoryController::class, 'updateStatus'])->name('job-categories.status');

        Route::resource('education-levels', AdminEducationLevelController::class)->except(['show']);
        Route::put('education-levels/{education_level}/status', [AdminEducationLevelController::class, 'updateStatus'])->name('education-levels.status');

        Route::resource('job-locations', AdminJobLocationController::class)->except(['show']);
        Route::put('job-locations/{job_location}/status', [AdminJobLocationController::class, 'updateStatus'])->name('job-locations.status');
    });

    Route::resource('companies', AdminCompanyController::class)->except(['create', 'store', 'show']);
    Route::post('/companies/{company}/verify', [AdminCompanyController::class, 'verify'])->name('companies.verify');
    Route::post('/companies/{company}/unverify', [AdminCompanyController::class, 'unverify'])->name('companies.unverify');
    Route::post('/companies/{company}/toggle-active', [AdminCompanyController::class, 'toggleActive'])->name('companies.toggleActive');

    Route::get('/portofolios', [AdminPortfolioModerationController::class, 'index'])->name('portofolios.index');
    Route::get('/portofolios/{portofolio}', [AdminPortfolioModerationController::class, 'show'])->name('portofolios.show');
    Route::post('/portofolios/{portofolio}/takedown', [AdminPortfolioModerationController::class, 'takedown'])->name('portofolios.takedown');
    Route::post('/portofolios/{portofolio}/restore', [AdminPortfolioModerationController::class, 'restore'])->name('portofolios.restore');
    Route::delete('/portofolios/{portofolio}', [AdminPortfolioModerationController::class, 'destroy'])->name('portofolios.destroy');
});

require __DIR__ . '/auth.php';
