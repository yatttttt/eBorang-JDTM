<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\LogAktivitiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PermohonanPDFController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengarahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PentadbirSistemController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\NotificationController;

// Direct to welcome animation page
Route::get('/', function () {
    return view('welcome');
});

// Welcome route (optional, for direct access)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Login & Logout routes (public)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password reset routes
Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

// Email Verification Routes
// Show verification notice page
Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationNotice'])->name('verification.notice');

// Verify email with token
Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verifyEmail'])->name('verification.verify');

// Resend verification email
Route::post('/email/resend', [EmailVerificationController::class, 'resendVerificationEmail'])->name('verification.resend');

// Protected routes (only accessible after login)
Route::middleware('auth')->group(function () {

    // Resource routes for your models
    Route::resource('permohonans', PermohonanController::class);
    Route::resource('ulasans', UlasanController::class);
    Route::resource('log-aktivitis', LogAktivitiController::class);

    // PDF Download Route
    Route::get('/admin/permohonan/{id}/pdf', [PermohonanPDFController::class, 'downloadPDF'])->name('admin.permohonan.pdf');

    // Profile Routes - CHANGED TO POST FOR FILE UPLOAD
    Route::get('/profile', [ProfilController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfilController::class, 'update'])->name('profile.update'); 
    Route::delete('/profile/photo', [ProfilController::class, 'deletePhoto'])->name('profile.photo.delete'); 
    Route::post('/profile/signature/upload', [ProfilController::class, 'uploadSignature'])->name('profile.signature.upload');
    Route::post('/profile/signature/draw', [ProfilController::class, 'drawSignature'])->name('profile.signature.draw');
    Route::delete('/profile/signature/delete', [ProfilController::class, 'deleteSignature'])->name('profile.signature.delete');

    // Admin Routes
    // Admin Dashboard
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');

    // Muat Naik Permohonan route
    Route::get('/permohonan', function () {return view('admin.muat_naik_permohonan');})->name('permohonans.create');

    Route::post('/admin/permohonan/store', [PermohonanController::class, 'store'])->name('admin.permohonan.store');

    // Admin - View Application Details
    Route::get('/admin/permohonan/{id}', [AdminController::class, 'show'])->name('admin.permohonan.show');

    // Senarai Permohonan route
    Route::get('/admin/senarai-permohonan', [AdminController::class, 'senaraiPermohonan'])->name('admin.senarai_permohonan');

    //Senarai Permohonan route (detail view)
    Route::get('/permohonans/{id}', [PermohonanController::class, 'show'])->name('permohonans.show');

    //Senarai Permohonan route (edit view)
    Route::get('/permohonans/{id}/edit', [PermohonanController::class, 'edit'])->name('permohonans.edit');

    //Senarai Permohonan route (update action)
    Route::put('/permohonans/{id}', [PermohonanController::class, 'update'])->name('permohonans.update');
    
    //Senarai Permohonan Lama route
    Route::get('/admin/senarai_permohonan_lama', [AdminController::class, 'senaraiPermohonanLama'])->name('admin.senarai_permohonan_lama');

    //Senarai Permohonan Lama route (detail view)
    Route::get('/admin/senarai-permohonan-lama/{id}', [AdminController::class, 'viewPermohonanLama'])->name('admin.senarai_permohonan_lama_view');

    // Delete Permohonan Lama
    Route::delete('/admin/permohonan-lama/{id}', [AdminController::class, 'destroyPermohonanLama'])->name('admin.permohonan_lama.destroy');

    // Log Aktiviti route
    Route::get('/admin/log-aktiviti', [AdminController::class, 'logAktiviti'])->name('admin.log-aktiviti');

    // Log Aktiviti API (for AJAX filtering)
    Route::get('/admin/api/log-aktiviti', [AdminController::class, 'getLogAktiviti'])->name('admin.api.log-aktiviti');

    // Download Permohonan File
    Route::get('/permohonans/{permohonan}/download', [PermohonanController::class, 'download'])->name('permohonans.download');

    // 🔹 User Management Routes (Admin Only - access control in UserController)
    // Display list of users
    Route::get('/pengurusan-pengguna', [UserController::class, 'index'])->name('pengurusan.pengguna');
    
    // Show form to create new user
    Route::get('/pengurusan-pengguna/tambah', [UserController::class, 'create'])->name('pengguna.tambah');
    
    // Store new user
    Route::post('/pengurusan-pengguna', [UserController::class, 'store'])->name('pengguna.store');
    
    // Show form to edit user
    Route::get('/pengurusan-pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
    
    // Update user
    Route::put('/pengurusan-pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
    
    // Delete user
    Route::delete('/pengurusan-pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');
    

    // Pengarah Routes
    // Pengarah Dashboard
    Route::get('/dashboard/pengarah', [PengarahController::class, 'dashboard'])->name('dashboard.pengarah');

    // Pengarah - Senarai Permohonan
   Route::get('/pengarah/senarai-permohonan', [PengarahController::class, 'senaraiPermohonan'])->name('pengarah.senarai-permohonan');

    // Pengarah - View Application Details
    Route::get('/pengarah/permohonan/{id}', [PengarahController::class, 'show'])->name('pengarah.permohonan.show');

    // Pengarah - Edit Application
    Route::get('/pengarah/permohonan/{id}/edit', [PengarahController::class, 'edit'])->name('pengarah.permohonan.edit');

    // Pengarah - Update Application
    Route::put('/pengarah/permohonan/{id}', [PengarahController::class, 'update'])->name('pengarah.permohonan.update');

    // Pengarah - Review Form
    Route::get('/pengarah/permohonan/{id}/review', [PengarahController::class, 'showReviewForm'])->name('pengarah.permohonan.review');

    // Pengarah - Submit Review
    Route::post('/pengarah/permohonan/{id}/review', [PengarahController::class, 'submitReview'])->name('pengarah.permohonan.submitReview');

    // Pengarah - Update Status
    Route::put('/pengarah/permohonan/{id}/status', [PengarahController::class, 'updateStatus'])->name('pengarah.permohonan.updateStatus');

    // Pengarah - Senarai Permohonan Lama
    Route::get('/pengarah/permohonan-lama', [PengarahController::class, 'senaraiPermohonanLama'])->name('pengarah.permohonan.lama');

    // Pengarah - Download File
    Route::get('/pengarah/permohonan/{id}/download', [PengarahController::class, 'downloadFile'])->name('pengarah.permohonan.download');


    // Pegawai Routes
    // Pegawai Dashboard
    Route::get('/dashboard/pegawai', [PegawaiController::class, 'dashboard'])->name('dashboard.pegawai');

    // Pegawai - Senarai Permohonan
    Route::get('/pegawai/senarai-permohonan', [PegawaiController::class, 'senaraiPermohonan'])->name('pegawai.senarai-permohonan');

    // Pegawai - View Application Details
    Route::get('/pegawai/permohonan/{id}', [PegawaiController::class, 'show'])->name('pegawai.permohonan.show');

    // Pegawai - Edit Application
    Route::get('/pegawai/permohonan/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.permohonan.edit');

    // Pegawai - Update Application
    Route::put('/pegawai/permohonan/{id}', [PegawaiController::class, 'update'])->name('pegawai.permohonan.update');

    // Pegawai - Review Form
    Route::get('/pegawai/permohonan/{id}/review', [PegawaiController::class, 'showReviewForm'])->name('pegawai.permohonan.review');

    // Pegawai - Submit Review
    Route::post('/pegawai/permohonan/{id}/review', [PegawaiController::class, 'submitReview'])->name('pegawai.permohonan.submitReview');

    // Pegawai - Update Status
    Route::put('/pegawai/permohonan/{id}/status', [PegawaiController::class, 'updateStatus'])->name('pegawai.permohonan.updateStatus');

    // Pegawai - Senarai Permohonan Lama
    Route::get('/pegawai/permohonan-lama', [PegawaiController::class, 'senaraiPermohonanLama'])->name('pegawai.permohonan.lama');

    // Pegawai - Download File
    Route::get('/pegawai/permohonan/{id}/download', [PegawaiController::class, 'downloadFile'])->name('pegawai.permohonan.download');


    // Pentadbir sistem routes
    // Pentadbir Sistem Dashboard
    Route::get('/dashboard/pentadbir_sistem', [PentadbirSistemController::class, 'dashboard'])->name('dashboard.pentadbir_sistem');

    // Pentadbir Sistem - Senarai Permohonan
    Route::get('/pentadbir_sistem/senarai-permohonan', [PentadbirSistemController::class, 'senaraiPermohonan'])->name('pentadbir_sistem.senarai-permohonan');

    // Pentadbir Sistem - View Application Details
    Route::get('/pentadbir_sistem/permohonan/{id}', [PentadbirSistemController::class, 'show'])->name('pentadbir_sistem.permohonan.show');

    // Pentadbir Sistem - Edit Application
    Route::get('/pentadbir_sistem/permohonan/{id}/edit', [PentadbirSistemController::class, 'edit'])->name('pentadbir_sistem.permohonan.edit');

    // Pentadbir Sistem - Update Application
    Route::put('/pentadbir_sistem/permohonan/{id}', [PentadbirSistemController::class, 'update'])->name('pentadbir_sistem.permohonan.update');

    // Pentadbir Sistem - Review Form
    Route::get('/pentadbir_sistem/permohonan/{id}/review', [PentadbirSistemController::class, 'showReviewForm'])->name('pentadbir_sistem.permohonan.review');

    // Pentadbir Sistem - Submit Review
    Route::post('/pentadbir_sistem/permohonan/{id}/review', [PentadbirSistemController::class, 'submitReview'])->name('pentadbir_sistem.permohonan.submitReview');

    // Pentadbir Sistem - Update Status
    Route::put('/pentadbir_sistem/permohonan/{id}/status', [PentadbirSistemController::class, 'updateStatus'])->name('pentadbir_sistem.permohonan.updateStatus');

    // Pentadbir Sistem - Senarai Permohonan Lama
    Route::get('/pentadbir_sistem/permohonan-lama', [PentadbirSistemController::class, 'senaraiPermohonanLama'])->name('pentadbir_sistem.permohonan.lama');

    // Pentadbir Sistem - Download File
    Route::get('/pentadbir_sistem/permohonan/{id}/download', [PentadbirSistemController::class, 'downloadFile'])->name('pentadbir_sistem.permohonan.download');

    // Notification Routes
    // Fetch all notifications for current user
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    // Mark a single notification as read
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsReadSingle'])->name('notifications.markAsReadSingle');

    // Mark all notifications as read
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    
    // Get unread notification count (for real-time badge updates)
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');

});