<?php

use App\Http\Controllers\Admin\RentController;
use App\Http\Controllers\Principal;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\CashComponent;
use App\Livewire\Admin\ClientComponent;
use App\Livewire\Admin\ExpenseComponent;
use App\Livewire\Admin\PropertyComponent;
use App\Livewire\Admin\RentalComponent;
use App\Livewire\Admin\RoomComponent;
use App\Livewire\Admin\TypeComponent;
use App\Livewire\Admin\UserComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', [Principal::class, 'index'])->name('index');
Route::get('/dashboard', [Principal::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/properties', PropertyComponent::class)->name('properties.index');
    Route::get('/types', TypeComponent::class)->name('types.index');
    Route::get('/expenses', ExpenseComponent::class)->name('expenses.index');
    Route::get('/cashboxs', CashComponent::class)->name('cashboxs.index');
    Route::get('/rooms', RoomComponent::class)->name('rooms.index');
    Route::get('/clients', ClientComponent::class)->name('clients.index');
    Route::get('/rentals', RentalComponent::class)->name('rentals.index');
    Route::get('/users', UserComponent::class)->name('users.index');

    Route::get('/rent/{id}', [RentController::class, 'index'])->name('rent.index');
    Route::get('/payment/{id}', [RentController::class, 'payment'])->name('rent.payment');

    Route::get('/payment/pdf/{id}', [RentController::class, 'ticketPago'])->name('payment.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
