<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MarcheController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CollecteController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HangarController;
use App\Http\Controllers\RegisseurController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\RapportController;

// ==================== ROUTES PUBLIQUES ====================
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== ROUTES ADMIN ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Documentation et rapports
    Route::view('/admin/documentation', 'documentation.index')->name('documentation.index');
    Route::view('/admin/reports', 'reports.index')->name('reports.index');
    
    // Collectes admin
    Route::get('/admin/collectes', [CollecteController::class, 'index'])->name('collectes.index');
    Route::get('/admin/collectes/pdf', [CollecteController::class, 'imprimer'])->name('collectes.pdf');
    
    // Dépôts admin
    Route::get('/admin/depots', [DepotController::class, 'index'])->name('depots.index');
    Route::get('/admin/depots/pdf', [DepotController::class, 'imprimer'])->name('depots.pdf');
    
    // Ressources CRUD (uniquement pour admin)
    Route::resource('marches', MarcheController::class);
    Route::resource('zones', ZoneController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('depots', DepotController::class);
    Route::resource('users', UserController::class);
    Route::resource('hangars', HangarController::class);
    
    // Activation/Désactivation utilisateur
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
});

// ==================== ROUTES RÉGISSEUR ====================
Route::middleware(['auth', 'regisseur'])->prefix('regisseur')->name('regisseur.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [RegisseurController::class, 'dashboard'])->name('dashboard');
    
    // Consultation (lecture seule)
    Route::get('/marches', [RegisseurController::class, 'marches'])->name('marches');
    Route::get('/zones', [RegisseurController::class, 'zones'])->name('zones');
    Route::get('/collectes', [RegisseurController::class, 'collectes'])->name('collectes.index');
    Route::get('/collectes/agent/{agent}', [RegisseurController::class, 'collectesAgent'])->name('collectes.agent');
    
    // Dépôts (création + consultation)
    Route::get('/depots', [RegisseurController::class, 'depots'])->name('depots');
    Route::get('/depots/creer', [RegisseurController::class, 'createDepot'])->name('depots.create');
    Route::post('/depots', [RegisseurController::class, 'storeDepot'])->name('depots.store');
    Route::get('/depots/{depot}/recu', [RegisseurController::class, 'showRecu'])->name('depots.recu');
    
    // ==================== RAPPORTS RÉGISSEUR ====================
    // Vue web des rapports (utilise vos vues existantes)
    Route::get('/rapports/agent', [RapportController::class, 'rapportAgent'])->name('rapports.agent');
    Route::get('/rapports/marche', [RapportController::class, 'rapportMarche'])->name('rapports.marche');
    Route::get('/rapports/synthese', [RapportController::class, 'rapportSynthese'])->name('rapports.synthese');
    
    // Génération PDF des rapports (utilise vos vues PDF existantes)
    Route::post('/rapports/agent/imprimer', [RapportController::class, 'imprimerRapportAgent'])->name('rapports.agent.imprimer');
    Route::post('/rapports/marche/imprimer', [RapportController::class, 'imprimerRapportMarche'])->name('rapports.marche.imprimer');
    Route::post('/rapports/synthese/imprimer', [RapportController::class, 'imprimerRapportSynthese'])->name('rapports.synthese.imprimer');
    
    
});

// ==================== ROUTES AGENT ====================
Route::middleware(['auth'])->prefix('agent')->name('agent.')->group(function () {
    // Collectes
    Route::get('/index', [AgentController::class, 'index'])->name('index');
    Route::post('/store', [AgentController::class, 'store'])->name('store');
    Route::get('/collectes/journalier', [AgentController::class, 'journalier'])->name('collectes.journalier');
    Route::get('/recu/{id}', [AgentController::class, 'recu'])->name('recu');
});