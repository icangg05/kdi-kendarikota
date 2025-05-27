<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;
use App\Models\Download;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap', [SitemapController::class, 'index']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{menu}', [HomeController::class, 'menuEvent']);
Route::get('/arsip', [HomeController::class, 'menuArsip']);
Route::get('/peraturan-daerah', [HomeController::class, 'menuPerda']);
Route::get('/statistik', [HomeController::class, 'menuStatistik']);
Route::get('/direktori/{direktori}', [HomeController::class, 'menuDirektori']);
Route::get('/direktori/{direktori}/{lokasiId}', [HomeController::class, 'viewLokasi']);
Route::get('/kendari-kita/sejarah-kota-kendari', [HomeController::class, 'sejarah']);
Route::get('/kendari-kita/visi-misi', [HomeController::class, 'visiMisi']);
Route::get('/kendari-kita/walikota', [HomeController::class, 'walikota']);
Route::get('/kendari-kita/wakil-walikota', [HomeController::class, 'wakilWalikota']);
Route::get('/kendari-kita/pejabat-pemerintah', [HomeController::class, 'pejabat']);
Route::get('/kendari-kita/perangkat-daerah', [HomeController::class, 'perangkatDaerah']);
Route::get('/all-sub-domain', [HomeController::class, 'allSubDomain']);
Route::get('/all-twibbon', [HomeController::class, 'allTwibbon']);

Route::post('/api/count-download', function () {
  $data = Download::where('link', request('link'))->first();
  abort_if(!$data, 404);

  if (!Cookie::get('downloaded_id_' . $data->id)) {
    $data->increment('download');
    Cookie::queue('downloaded_id_' . $data->id, true, 10);
    $message = 'Success count download';
  }

  return response()->json([
    'message' => $message ?? 'Success. Nothing to update',
  ]);
});


// Dashboard route
// Route::get('/dashboard', function () {
//   return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//   Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Auth route
// require __DIR__ . '/auth.php';
