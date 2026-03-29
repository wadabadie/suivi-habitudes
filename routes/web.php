<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatistiqueController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();
//routes pour mon authentification google2fa
Route::middleware(['2fa'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('\2fa',function(){
        return redirect(route('home'));
    })->name('2fa');
});
Route::get('/register/verify-2fa', [RegisterController::class, 'showVerify2FA'])->name('verify.2fa');
Route::post('/complete-registration', [RegisterController::class, 'completeRegistration'])->name('complete.registration');

// Route de test TEMPORAIRE  Generer un code OTP valide
Route::get('/test/otp', function() {
    $secret = session('registration_data')['google2fa_secret'] ?? null;
    if (!$secret) {
        return 'Pas de secret en session. Complétez d\'abord le formulaire de registration.';
    }
    $google2fa = app('pragmarx.google2fa');
    $otp = $google2fa->getCurrentOtp($secret);
    return "Code OTP valide : <strong>$otp</strong><br>Ce code change toutes les 30 secondes.";
});


//route pour la gestions relles de mes ressources les habitudes  les amis les notifications etc.....
Route::middleware(['auth'])->group(function () {

    Route::resource('habitudes', HabitController::class)->parameters(['habitudes' => 'habit']);
    Route::post('habitudes/{habit}/faite', [HabitController::class, 'marquerFaite'])->name('habitudes.faite');
    Route::get('amis', [FriendController::class, 'index'])->name('amis.index');
    Route::get('amis/rechercher', [FriendController::class, 'rechercher'])->name('amis.rechercher');
    Route::post('amis/rechercher', [FriendController::class, 'rechercher'])->name('amis.rechercher.post');
    Route::post('amis/envoyer', [FriendController::class, 'envoyerDemande'])->name('amis.envoyer');
    Route::post('amis/{friend}/accepter', [FriendController::class, 'accepterDemande'])->name('amis.accepter');
    Route::delete('amis/{friend}/supprimer', [FriendController::class, 'supprimerAmi'])->name('amis.supprimer');
    Route::get('amis/{user}/habitudes', [FriendController::class, 'voirHabitudes'])->name('amis.habitudes');
    Route::get('notifications/{id}/lire', [NotificationController::class, 'lire'])->name('notifications.lire');
    Route::get('notifications/tout-lire', [NotificationController::class, 'toutLire'])->name('notifications.toutLire');
    Route::get('statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
});


