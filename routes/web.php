<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientCompteController;
use App\Http\Controllers\LoginController;


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/aboutus', [HomeController::class, 'aboutus'])->name('aboutus'); 
Route::get('/contactus', [HomeController::class, 'contactus'])->name('contactus');

// Route::get('/creercompte', [AccountController::class, 'home'])->name('creercompte'); 


Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'logged'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name("logout");

// utilisateur simple compte routes
Route::get('creercompte', [ClientCompteController::class, 'creationCompte'])->name('creercompte');
Route::post('creercompte', [ClientCompteController::class, 'CreerCompte'])->name('creercompte');
Route::get('clientportal', [ClientCompteController::class, 'index'])->name("clientportal");
Route::get('mescommandes', [ClientCompteController::class, 'mesCommandes'])->name("mescommandes");
Route::get('mesfavoris', [ClientCompteController::class, 'mesFavoris'])->name("mesfavoris");
Route::get('monpanier', [ClientCompteController::class, 'monPanier'])->name("monpanier");
Route::get('activerusercompte/{token}', [ClientCompteController::class, 'ActiverCompte'])->name('activerusercompte');
Route::get('delmonfav/{id}', [ClientCompteController::class, 'delMonFav'])->whereNumber("id")->name("delmonfav");
Route::get('voiremacommande/{id}', [ClientCompteController::class, 'voireMaCommande'])->whereNumber("id")->name("voiremacommande");
Route::get('mesdonnees', [ClientCompteController::class, 'mesDonnees'])->name("mesdonnees");
Route::post('mesdonnees', [ClientCompteController::class, 'updateMesDonnees'])->name("mesdonnees");
Route::post('codeoublier', [ClientCompteController::class, 'resetCode'])->name("codeoublier");
Route::get('codeoublier', [ClientCompteController::class, 'codeOublier'])->name("codeoublier");
Route::get('moncode', [ClientCompteController::class, 'monCode'])->name("moncode");
Route::post('moncode', [ClientCompteController::class, 'resetMonCode'])->name("moncode");
// Route::get('/', [LoginController::class, 'index'])->name('portal'); 
