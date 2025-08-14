<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactAdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');


Route::controller(ContactController::class)->group(function () {
    Route::get('/', 'index')->name('contacts.index');                      
    Route::post('/contacts/confirm', 'confirm')->name('contacts.confirm');  
    Route::post('/contacts', 'store')->name('contacts.store');             
    Route::get('/thanks', 'thanks')->name('contacts.thanks');               
    Route::patch('/contacts/{contact}', 'update')->name('contacts.update'); 
    Route::delete('/contacts/{contact}', 'destroy')->name('contacts.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [ContactAdminController::class, 'index'])->name('contacts.index');
    Route::get('/export', [ContactAdminController::class, 'export'])->name('contacts.export');
    Route::get('/{contact}', [ContactAdminController::class, 'show'])
        ->whereNumber('contact')->name('contacts.show');
    Route::delete('/{contact}', [ContactAdminController::class, 'destroy'])
        ->whereNumber('contact')->name('contacts.destroy');
});
