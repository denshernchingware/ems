<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', \App\Livewire\Dashboard\AdminDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('employees', \App\Livewire\Dashboard\EmployeeDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('employees.index');

       Route::view('users', 'admin.users')
    ->middleware(['auth', 'verified'])
    ->name('admin.users');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';