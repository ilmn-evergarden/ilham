<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogPublicController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectImageController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectPublicController;
use App\Http\Controllers\CertificatePublicController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');

// ── Public Routes ───────────────────────────────────────────────────────────
Route::get('/projects', [ProjectPublicController::class, 'index'])->name('projects.public.index');

Route::get('/certificates', [CertificatePublicController::class, 'index'])->name('certificates.public.index');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ── Public Blog Routes ──────────────────────────────────────────────────────
Route::get('/blog', [BlogPublicController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogPublicController::class, 'show'])->name('blog.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('skills', SkillController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('educations', EducationController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('experiences', ExperienceController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('technologies', TechnologyController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('projects', ProjectController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('projects.images', ProjectImageController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->shallow();
    Route::resource('certificates', CertificateController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('blogs', BlogController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

Route::get('/projects/{slug}', [ProjectPublicController::class, 'show'])->name('projects.public.show');

require __DIR__ . '/auth.php';
