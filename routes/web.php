<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\KudosEmailController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SlackController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TangoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInvitationController;
use App\Http\Controllers\ZoomController;
use App\Models\Company;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Route;

//use Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (config('app.env') === 'production') {
    \URL::forceScheme('https');
}

Route::middleware(['auth:sanctum', 'verified', 'payingCustomer'])->get('/kudos-feed', function () {
    //return Auth::user()->grab_associated_points();

    if (request()->filled('verified')) {
        session()->flash('flash.banner', 'Email verified!');

        return redirect()->route('kudos.feed');
    }

    if (request()->filled('team-removed')) {
        session()->flash('flash.banner', 'Team Removed!');

        return redirect()->route('kudos.feed');
    }

    return view('dashboard');
})->name('kudos.feed');

Route::middleware(['auth:sanctum', 'verified', 'payingCustomer'])->get('/kudos-feed/{user}', function (User $user) {
    if (auth()->user()->role !== 1) {
        abort(403);
    }

    return view('user.kudos', ['user' => $user]);
})->name('user.kudos');

// this is the exact same but for google analytics purposes - this counts as a conversion
Route::middleware(['auth:sanctum', 'verified', 'payingCustomer'])->get('/welcome', function () {
    if (request()->filled('verified')) {
        session()->flash('flash.banner', 'Email verified!');

        return redirect()->route('dashboard');
    }

    if (request()->filled('team-removed')) {
        session()->flash('flash.banner', 'Team Removed!');

        return redirect()->route('dashboard');
    }

    return view('dashboard');
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->get('/profile', function () {
    $user = Auth::user();

    return view('user.profile', ['user' => $user]);
})->name('profile');

Route::middleware(['auth:sanctum', 'verified', 'can:view,user'])->get('/profile/{user}', function (User $user) {
    if ($user->active !== 1) {
        abort(403, 'This profile no longer exists');
    }

    return view('user.profile', ['user' => $user]);
})->name('profile.user');

Route::middleware(['auth:sanctum', 'verified'])->get('/team', function () {
    $team = Auth::user()->currentTeam;

    return view('teams.all', ['team' => $team]);
})->name('teams_all');

Route::middleware(['auth:sanctum', 'verified'])->get('/team/{team}', function (Team $team) {
    return view('teams.all', ['team' => $team]);
})->name('view.team');

Route::middleware(['guest'])->post('/contact-us', [ContactUsController::class, 'store'])->name('connect-us.store');

//Kudos
Route::middleware(['auth:sanctum', 'verified'])->get('/kudos/{user}', [PointController::class, 'show'])->name('kudos-show');
Route::middleware(['auth:sanctum', 'verified'])->post('/kudos/store', [PointController::class, 'store'])->name('kudos.store');
Route::middleware(['auth:sanctum', 'verified'])->get('/kudos/sent/{point}', [PointController::class, 'store2'])->name('kudos.store2');
Route::middleware(['auth:sanctum', 'verified'])->get('/received/{point}', [PointController::class, 'received'])->name('kudos.received');
Route::middleware(['auth:sanctum', 'can:access_admin_controls', 'verified'])->get('/kudos-gifting', [PointController::class, 'kudosGifting'])->name('admin.kudos-gifting');

//rewards
Route::middleware(['auth:sanctum', 'verified'])->get('/redeem/{redemption}', [RedemptionController::class, 'purchased'])->name('redeemed.reward');
Route::middleware(['auth:sanctum', 'verified'])->post('/redeem/{reward}', [RedemptionController::class, 'redeem'])->name('redeem.reward');

Route::middleware(['auth:sanctum', 'verified'])->get('/notifications', [NotificationsController::class, 'show'])->name('notifications');

Route::middleware(['auth:sanctum', 'verified'])->get('/rewards', [RewardController::class, 'view'])->name('rewards.view');
Route::middleware(['auth:sanctum', 'verified'])->get('/rewards/{reward}', [RewardController::class, 'redeem'])->name('rewards.redeem');

Route::middleware(['auth:sanctum', 'verified'])->get('/wallet', [RedemptionController::class, 'wallet'])->name('wallet');
Route::middleware(['auth:sanctum', 'verified'])->get('/redemption/{redemption}', [RedemptionController::class, 'purchased'])->name('purchased');

Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/rewards/create/new', [RewardController::class, 'create'])->name('rewards.create');

Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/rewards/company/view', [RewardController::class, 'company'])->name('rewards.company');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/rewards/company/stats', [RewardController::class, 'companyStats'])->name('rewards.company-stats');

Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/rewards/company/reward/{reward}', [RewardController::class, 'company_reward'])->name('rewards.company.reward');

//Company manage settings
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/company/manage', [CompanyController::class, 'show'])->name('manage.company');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/company/manage/kudos', [CompanyController::class, 'kudos'])->name('manage.company.kudos');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/company/manage/refillKudos', [CompanyController::class, 'refillKudos'])->name('manage.company.refillKudos');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/company/user-stats', [CompanyController::class, 'userStats'])->name('company.user-stats');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/company/manage-invites', [CompanyController::class, 'manageInvites'])->name('company.manage-invites');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/company/invites/{invitation}/edit', [CompanyController::class, 'editInvitation'])->name('company.invitation.edit');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->post('/kudos-gifting', [PointController::class, 'storeForAdmin'])->name('admin.kudos-gifting');

Route::get('register/company', [CompanyController::class, 'create_form'])->name('manage.company.create_form');
Route::get('company/join/{alise}', [CompanyController::class, 'create_user'])->name('manage.company.create_user');
Route::get('company/login/{userId}', [CompanyController::class, 'login'])->name('manage.company.login');

Route::get('/company-invitations/{invitation}', [CompanyController::class, 'accept'])
    //->middleware(['signed'])
    ->name('company-invitations.accept');

Route::middleware(['auth:sanctum'])->get('company/manage/users', [CompanyController::class, 'manage_users'])->name('company.manage.users');
Route::middleware(['auth:sanctum'])->get('company/invite/bulk-users', [CompanyController::class, 'bulk_invite'])->name('company.users.bulk-invite');
Route::get('register/{company}/{hash}', [UserInvitationController::class, 'register'])->name('user.register');
Route::post('register/save/{ui}', [UserInvitationController::class, 'store'])->name('user.store');

/// card routes ////
Route::get('/card/pdf/{card}', [CardController::class, 'createPDF']);
Route::middleware(['auth:sanctum', 'verified'])->get('/card/create', [CardController::class, 'create'])->name('card.create');
Route::middleware(['auth:sanctum', 'verified'])->get('/card/edit/{card}', [CardController::class, 'edit'])->name('card.edit');
Route::middleware(['auth:sanctum', 'verified'])->get('/card/build/{card}', [CardController::class, 'build'])->name('card.build');
Route::middleware(['auth:sanctum', 'verified'])->get('/cards', [CardController::class, 'cards'])->name('card.cards');
Route::middleware(['auth:sanctum', 'verified'])->get('/card/people/{card}', [CardController::class, 'people'])->name('card.people');
Route::middleware(['auth:sanctum', 'verified'])->get('/card/notify/{card}', [CardController::class, 'notify'])->name('card.notify');
Route::middleware(['auth:sanctum', 'verified'])->get('/card/preview/{card}', [CardController::class, 'preview'])->name('card.preview');
Route::middleware(['auth:sanctum', 'verified'])->delete('/card/{card}', [CardController::class, 'delete'])->name('card.delete');
Route::middleware(['auth:sanctum', 'verified'])->delete('/card/element/{cardElement}/transcoding-status', [\App\Http\Controllers\CardElementController::class, 'getTranscodingStatus'])->name('card.video.transcoding-status');
Route::get('/card/view/{card:token}', [CardController::class, 'view'])->name('card.view');

Route::post('/chunk/file-upload/{cardElement?}', [CardController::class, 'chunkFileUpload'])->name('chunk.upload');
//Route::get('/card/download/{card:token}', [CardController::class, 'download'])->name('card.download');

//meeting routes////
Route::middleware(['auth:sanctum', 'verified'])->get('/connect/register', [MeetingController::class, 'register'])->name('connect.register');
Route::middleware(['auth:sanctum', 'verified'])->post('/connect/create', [MeetingController::class, 'create'])->name('connect.create');
Route::middleware(['auth:sanctum', 'verified'])->get('/connect/match', [MeetingController::class, 'match'])->name('connect.match');
Route::middleware(['auth:sanctum', 'verified'])->get('/connect', [MeetingController::class, 'connect'])->name('connect');
Route::middleware(['auth:sanctum', 'verified'])->get('/connect/{meeting}', [MeetingController::class, 'view'])->name('connect.view');

/// Tango redemption routes ///
Route::middleware(['auth:sanctum', 'verified'])->get('/tango', [RedemptionController::class, 'tango'])->name('tango');
Route::middleware(['auth:sanctum', 'verified'])->get('/catalog', [RedemptionController::class, 'catalog'])->name('catalog');
Route::middleware(['auth:sanctum', 'verified'])->get('/tango/test', [RedemptionController::class, 'refresh_tango']);

//transaction routes/////
Route::middleware(['auth:sanctum', 'verified'])->get('/transactions', [UserController::class, 'transactions'])->name('transactions');
Route::middleware(['auth:sanctum', 'verified'])->get('/reward-redemption', [UserController::class, 'rewardRedemption'])->name('reward-redemption');
/////////////////// Zoom routes /////////////

Route::middleware(['auth:sanctum', 'verified'])->get('/special-days', [UserController::class, 'specialDays'])->name('user-special-days');

// Get list of meetings.
Route::middleware(['auth:sanctum', 'verified'])->get('/meetings', [ZoomController::class, 'list'])->name('zoom.list');

// Create meeting room using topic, agenda, start_time.
// Route::post('/meetings', 'Zoom/MeetingController@create');
Route::middleware(['auth:sanctum', 'verified'])->post('/meetings', [ZoomController::class, 'create'])->name('zoom.create');

// // Get information of the meeting room by ID.
// Route::get('/meetings/{id}', 'Zoom/MeetingController@get')->where('id', '[0-9]+');
Route::middleware(['auth:sanctum', 'verified'])->get('/meetings/{id}', [ZoomController::class, 'get'])->where('id', '[0-9]+')->name('zoom.get');
Route::middleware(['auth:sanctum', 'verified'])->patch('/meetings/{id}', [ZoomController::class, 'update'])->where('id', '[0-9]+')->name('zoom.update');
Route::middleware(['auth:sanctum', 'verified'])->delete('/meetings/{id}', [ZoomController::class, 'delete'])->where('id', '[0-9]+')->name('zoom.delete');
// Route::patch('/meetings/{id}', 'Zoom/MeetingController@update')->where('id', '[0-9]+');
// Route::delete('/meetings/{id}', 'Zoom/MeetingController@delete')->where('id', '[0-9]+');
////////////////////////////////////
// admin analytics routes
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls', 'payingCustomer'])->get('/billing', [DashboardController::class, 'billing'])->name('billing');

Route::middleware(['auth:sanctum', 'verified', 'can:is_developer_user'])->prefix('developer')->group(function () {
    Route::get('/', [DeveloperController::class, 'show'])->name('developer.show');
    Route::get('/transactions', [DeveloperController::class, 'transactions'])->name('developer.transactions');
    Route::get('/redemptions', [DeveloperController::class, 'redemptions'])->name('developer.redemptions');
    Route::get('/transactions-kudos-to-give', [DeveloperController::class, 'transactions_kudos_to_give'])->name('developer.transactions-kudos-to-give');
    Route::get('/company/{company}', [DeveloperController::class, 'company'])->name('developer.company');
    Route::get('/companies', [DeveloperController::class, 'companies'])->name('developer.companies');
    Route::get('/active-companies', [DeveloperController::class, 'activeCompanies'])->name('developer.active-companies');
    Route::get('/rewards', [DeveloperController::class, 'rewards'])->name('developer.rewards');
    Route::get('/rewards/update', [TangoController::class, 'update'])->name('tango.update');
    Route::get('/billing/{company}', [DeveloperController::class, 'billing'])->name('developer.billing');
    Route::get('/activity/{company}', [DeveloperController::class, 'activity'])->name('developer.activity');
    Route::get('/kudos', [DeveloperController::class, 'kudos'])->name('developer.kudos');
    Route::post('/kudos/store', [PointController::class, 'storeForDeveloper'])->name('developer.kudos');
    Route::get('/customize-teams', [DeveloperController::class, 'customizeTeams'])->name('developer.customize-teams');
    Route::get('/send-invites', [DeveloperController::class, 'invites'])->name('developer.invites');
    Route::get('/send-kudos-to-give-away', [DeveloperController::class, 'sendKudosToGiveAway'])->name('developer.send-kudos-to-give-away');
    Route::get('/{company}/toggle-verified', [DeveloperController::class, 'toggleVerifiedCompany'])->name('developer.toggle-verified-company');
    Route::get('/conversion-rate', [DeveloperController::class, 'conversionRates'])->name('developer.conversion-rates');
    Route::get('/manage-company-settings', [DeveloperController::class, 'manageCompanySettings'])->name('developer.manage-company-settings');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/company-setting', [DeveloperController::class, 'companySetting'])->name('developer.company-setting');
    Route::get('/edit-company/{company}', function (Company $company) {
        return view('developer.edit-company', ['company' => $company]);
    })->name('edit.company');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/meetings', [ZoomController::class, 'list'])->name('zoom.list');

/////////////////// Billing and subscription related routes! ////////////////////
//Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/cashier/testing', [CashierController::class, 'testing'])->name('cashier.test');

Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/billing-portal', [CashierController::class, 'billing_portal'])->name('cashier.billing.portal');

Route::middleware(['auth:sanctum', 'verified', 'can:access_admin_controls'])->get('/checkout', [CashierController::class, 'checkout'])->name('cashier.checkout');

Route::middleware(['auth:sanctum'])->get('/stripe/checkout/{user_id}', [CashierController::class, 'create_stripe_checkout'])->name('cashier.checkout.button');

Route::middleware(['auth:sanctum'])->get('/payments/refill/{hash}', [CashierController::class, 'verify_refill'])->name('cashier.verify');

//////////////////////// People Pages ////////////////////
Route::middleware(['auth:sanctum'])->get('/people', [UserController::class, 'people'])->name('people');

//// Help & Support Pages ///////////

Route::get('/faq', function () {
    return view('support.faq');
});

Route::middleware(['auth:sanctum'])->get('/help', [SupportController::class, 'help'])->name('help');

Route::middleware(['auth:sanctum'])->get('/dailyemail', [KudosEmailController::class, 'test_report'])->name('daily.email');

//////////// home routes ///////////////////
Route::get('/', function () {
    return view('home.home');
})->name('home');

Route::get('/rewards-process', function () {
    return view('home.rewards-process');
});
// Route::get('/analytics', function () {
//     return view('home.analytics');
// });
Route::get('/appreciation', function () {
    return view('home.appreciation');
});
Route::get('/contact', function () {
    return view('home.contact');
})->name('home.contact');
Route::get('/group-cards', function () {
    return view('home.group-cards');
});
Route::get('/inclusion', function () {
    return view('home.inclusion');
});
Route::get('/perksweet-connect', function () {
    return view('home.connect');
})->name('perksweet-connect');

Route::get('/pricing', function () {
    return view('home.pricing');
});
// Route::get('/stay-connected', function () {
//     return view('home.stay-connected');
// });
Route::get('/about', function () {
    return view('home.about');
});

Route::get('/slack', function () {
    return view('home.slack');
});

Route::get('/group-card-example', function () {
    return view('home.group-card-example');
});

Route::get('/reduce-turnover', function () {
    return view('home.reduce-turnover');
});

Route::get('/demo-booked', function () {
    return view('home.demo-booked');
});

//Route::get('blog', function () { return "blog here"});

Route::post('/tryit-for-free', []);

//testing routes
///////////////////////////////////////
///// Test Routes /////////////////////
Route::get('testmail', function () {
    //Mail::to('nick@perksweet.com')->send(new TestAmazonSes('This is a test email'));
});

Route::middleware(['auth:sanctum', 'verified'])->get('/redemption/check/fraud', [RedemptionController::class, 'check_for_fraud'])->name('check.for.fraud');

Route::get('test', function () {
    echo 'here';
    $key = 'kifeS8I35n58H6dChWjooa2MzIxtWpywdgHKMGyo';
    $response = Http::withToken($key)->post('http://127.0.0.1:8001/api/test');

    return $response;
});

Route::get('test/mail', function () {
    // Artisan::call('send:test-mail');
});

Route::get('/slack/integration', [SlackController::class, 'integrate'])->name('slack.integrate');

//Route::middleware(['auth:sanctum', 'verified'])->get('/vimeo', [VimeoController::class, 'test'])->name('vimeo.test');

Route::get('/demo-booked', function () {
    return view('home.demo-booked');
});

Route::get('/enable-full-access', function () {
    Auth::user()->company->verified = 1;
    // Auth::user()->company->in_trial_mode = 0;
    if (config('app.env') !== 'production') {
        Auth::user()->company->save();
    }
});

//Route::get('/giphy', [GifController::class, "pull"]);
//Route::get('blank', function () { return view('designs.blank');});
//Route::get('gradient', function () { return view('designs.gradient');});

//Route::middleware(['auth:sanctum', 'verified'])->get('/slack', [SlackController::class, 'test'])->name('slack');
Route::get('export', [DashboardController::class, 'export']);
Route::get('export-funding', [DashboardController::class, 'export_funding']);
Route::get('export-wallet', [DashboardController::class, 'export_wallet']);
Route::get('export-reward', [DashboardController::class, 'export_reward']);
Route::get('export-reward-stats', [DashboardController::class, 'export_reward_stats']);
Route::get('export-user-stats', [DashboardController::class, 'export_user_stats']);
Route::get('exportData', [DashboardController::class, 'exportData']);

Route::get('updateFirstNameAndLastName', [\App\Http\Controllers\TestController::class, 'updateFirstNameAndLastName']);

require_once __DIR__.'/fortify.php';

require_once __DIR__.'/jetstream.php';
