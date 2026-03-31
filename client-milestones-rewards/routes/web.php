<?php

use Illuminate\Support\Facades\Route;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use App\Models\RewardAccess;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MilestoneController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\TriggerController;
use App\Http\Controllers\Admin\SupportMessageController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Your public homepage (optional)
    // You can keep this as rewards page if you want, but it won’t be personalized
    // unless you pass a token.
    return view('reward.expired');
});

Route::get('/reward', function () {
    // IMPORTANT: no token = no access
    // prevents the "Undefined variable $access" crash
    return view('reward.expired');
});

/*
|--------------------------------------------------------------------------
| Contact (GET + POST)
|--------------------------------------------------------------------------
*/

Route::get('/contact', function (Request $request) {
    // Optional: allow prefill from query params
    return view('contact', [
        'prefillEmail' => $request->query('email'),
        'prefillSubject' => $request->query('subject'),
        'prefillToken' => $request->query('token'),
    ]);
})->name('contact.show');

Route::post('/contact', function (Request $request) {

    $data = $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255'],
        'subject' => ['required', 'string', 'max:150'],
        'message' => ['required', 'string', 'max:2000'],

        // optional hidden fields
        'reward_access_id' => ['nullable', 'integer'],
        'reward_token' => ['nullable', 'string', 'max:80'],
    ]);

    SupportMessage::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'subject' => $data['subject'],
        'message' => $data['message'],
        'reward_access_id' => $data['reward_access_id'] ?? null,
        'reward_token' => $data['reward_token'] ?? null,
    ]);

    return redirect()->route('contact.show')->with('success', '✅ Thanks! Your message was received.');
})->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Reward Link Flow (Token-based)
|--------------------------------------------------------------------------
*/

/**
 * 1) Landing page (GET) - shows reward details (NOT claimed yet)
 */
Route::get('/reward/{token}', function ($token) {

    $access = RewardAccess::where('token', $token)
        ->with(['reward', 'milestone'])
        ->first();

    // Token not found
    if (!$access) {
        return view('reward.invalid');
    }

    // Expired link
    if ($access->expires_at && now()->greaterThan($access->expires_at)) {
        return view('reward.expired', [
            'access' => $access,
            'reward' => $access->reward,
            'milestone' => $access->milestone,
        ]);
    }

    // Already claimed/used
    if ($access->used) {
        return view('reward.used', [
            'access' => $access,
            'reward' => $access->reward,
            'milestone' => $access->milestone,
        ]);
    }

    // Log opening
    if (!$access->opened_at) {
        $access->opened_at = now();
        $access->save();
    }

    // Show landing page with personalized data
    return view('reward', [
        'access' => $access,
        'reward' => $access->reward,
        'milestone' => $access->milestone,
    ]);
})->name('reward.landing');


/**
 * 2) Redeem (POST) - claims the reward (one-time use happens here)
 */
Route::post('/reward/{token}/redeem', function ($token) {

    $access = RewardAccess::where('token', $token)
        ->with(['reward', 'milestone'])
        ->first();

    // Token not found
    if ($access->expires_at && now()->greaterThan($access->expires_at)) {
        return view('reward.invalid', [
            'access' => $access,
            'reward' => $access->reward,
            'milestone' => $access->milestone,
        ]);
    }

    // Expired link
    if ($access->expires_at && now()->greaterThan($access->expires_at)) {
        return view('reward.expired', [
            'access' => $access,
            'reward' => $access->reward,
            'milestone' => $access->milestone,
        ]);
    }

    // Already used
    if ($access->used) {
        return view('reward.used', [
            'access' => $access,
            'reward' => $access->reward,
            'milestone' => $access->milestone,
        ]);
    }

    // Claim it now (one-time use)
    $access->used = true;
    $access->claimed_at = now();
    $access->save();

    // Show success/valid page (and pass data if you want to display it)
    return view('reward.valid', [
        'access' => $access,
        'reward' => $access->reward,
        'milestone' => $access->milestone,
    ]);
})->name('reward.redeem');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Auth pages (Admin)
Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('admin.register');
Route::post('/register', [AuthController::class, 'register'])->name('admin.register.submit');

Route::get('/profile', [ProfileController::class, 'show']);
Route::post('/profile', [ProfileController::class, 'update']);

Route::get('/inbox', [InboxController::class, 'index']);
Route::get('/settings', [SettingsController::class, 'index']);

// Use POST logout (recommended). If you still want GET, keep both.
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/logout', [AuthController::class, 'logout']); // optional fallback

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    
    // Milestones
    Route::get('/milestones', [MilestoneController::class, 'index']);
    Route::get('/milestones/create', [MilestoneController::class, 'create']);
    Route::post('/milestones', [MilestoneController::class, 'store']);
    Route::get('/milestones/{milestone}/edit', [MilestoneController::class, 'edit']);
    Route::put('/milestones/{milestone}', [MilestoneController::class, 'update']);
    Route::delete('/milestones/{milestone}', [MilestoneController::class, 'destroy']);

    // Rewards
    Route::get('/rewards', [RewardController::class, 'index']);
    Route::get('/rewards/create', [RewardController::class, 'create']);
    Route::post('/rewards', [RewardController::class, 'store']);
    Route::get('/rewards/{id}/edit', [RewardController::class, 'edit']);
    Route::put('/rewards/{id}', [RewardController::class, 'update']);
    Route::delete('/rewards/{id}', [RewardController::class, 'destroy']);
    
    Route::get('/logs', [LogController::class, 'index']);

    Route::get('/manual-trigger', [TriggerController::class, 'create']);
    Route::post('/manual-trigger', [TriggerController::class, 'store']);

    Route::view('/profile', 'admin.pages.dashboard');
    Route::view('/inbox', 'admin.pages.dashboard');
    Route::view('/settings', 'admin.pages.dashboard');

    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings', [SettingsController::class, 'update']);

    Route::get('/general-settings', [GeneralSettingsController::class, 'index']);
    Route::post('/general-settings', [GeneralSettingsController::class, 'update']);
    Route::post('/general-settings/test-email',[GeneralSettingsController::class, 'testEmail']);

    Route::get('/support-messages', [SupportMessageController::class, 'index']);
    Route::get('/support-messages/{supportMessage}', [SupportMessageController::class, 'show']);
    Route::post('/support-messages/{supportMessage}', [SupportMessageController::class, 'update']);
});
