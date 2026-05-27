<?php

//use App\Livewire\Admin\Agenda;
use App\Livewire\Admin\Agendabeheer;
use App\Livewire\Admin\Bevestigingsmail;
use App\Livewire\Admin\Cocktailbeheer;
use App\Livewire\Admin\CookieOrders;
use App\Livewire\Admin\CookiePictures;
use App\Livewire\Admin\Courses;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Gerechten;
use App\Livewire\Admin\GerechtenPictures;
use App\Livewire\Admin\Ingredienten;
use App\Livewire\Admin\Koekjesbeheer;
use App\Livewire\Admin\Menubeheer;
use App\Livewire\Admin\Personeel;
use App\Livewire\Admin\Reservaties;
use App\Livewire\Admin\Reviews;
use App\Livewire\Admin\Website;
use App\Livewire\Basket;
use App\Livewire\Contact;
use App\Livewire\Cruds;
use App\Livewire\Home;
use App\Livewire\Koekjes;
use App\Livewire\Menu;
use App\Livewire\MenuNextMonth;
use App\Livewire\Reserveren;
use App\Livewire\ReserverenConfirmation;
use App\Livewire\UnderConstruction;
use Illuminate\Support\Facades\Route;
use App\Livewire\User\planning;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::Redirect('/', 'home')->name('home');
Route::get('crud', Cruds::class)->name('crud');
Route::get('home', Home::class)->name('home');
Route::get('menu', Menu::class)->name('menu');
Route::get('menuNextMonth', MenuNextMonth::class)->name('menuNextMonth');
Route::get('contact', Contact::class)->name('contact');
Route::get('koekjes', Koekjes::class)->name('koekjes');
Route::get('reserveren', Reserveren::class)->name('reserveren');
Route::get('/reserveren-confirmation', ReserverenConfirmation::class)->name('reservation.confirmation');
Route::get('mandje', Basket::class)->name('mandje');
Route::get('under-construction', UnderConstruction::class)->name('under-construction');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('logout', function () {
    auth()->logout();
    return redirect()->route('home');
})->name('logout');

Route::view('/playground', 'playground')->name('playground');

Route::middleware(['auth', 'admin', 'active'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
//        Route::redirect('/', '/admin/dashboard')->name('dashboard');
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('agendabeheer', Agendabeheer::class)->name('agendabeheer');
        Route::get('bevestigingsmail', Bevestigingsmail::class)->name('bevestigingsmail');
        Route::get('gerechten/{id?}', Gerechten::class)->name('gerechten');
        Route::get('gerechtenpictures/{id?}', GerechtenPictures::class)->name('gerechtenpictures');
        Route::get('ingredienten', Ingredienten::class)->name('ingredienten');
        Route::get('koekjesbeheer/{id?}', Koekjesbeheer::class)->name('koekjesbeheer');
        Route::get('menubeheer', Menubeheer::class)->name('menubeheer');
        Route::get('cocktailbeheer', Cocktailbeheer::class)->name('cocktailbeheer');
        Route::get('personeel', Personeel::class)->name('personeel');
        Route::get('reservaties', Reservaties::class)->name('reservaties');
        Route::get('reviews', Reviews::class)->name('reviews');
        Route::get('website/{id?}', Website::class)->name('website');
        Route::get('cookiepictures/{id?}', CookiePictures::class)->name('cookiepictures');
        Route::get('koekjesbestellingen', CookieOrders::class)->name('koekjesbestellingen');
        Route::get('courses', Courses::class)->name('courses');
    });

Route::middleware(['auth','active'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', \App\Livewire\User\Dashboard::class)->name('dashboard');
    Route::get('/planning', \App\Livewire\User\Planning::class)->name('planning');
    // koekjesbestellingen
    Route::get('koekjesbestellingen', CookieOrders::class)->name('koekjesbestellingen');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'active',
])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->admin) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    })->name('dashboard');
});

//create symlink for hosting
Route::get('/symlink', function () {
    Artisan::call('storage:link');
});
