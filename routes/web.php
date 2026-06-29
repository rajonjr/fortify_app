<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    // Page d'accueil de l'application connectée
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Page des paramètres du profil (Gestion du 2FA)
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});


Route::middleware(['auth', 'password.confirm'])->group(function () {        
        Route::get('/profile/advanced', function () {
            return view('profile.advanced');
        })->name('profile.advanced');
});