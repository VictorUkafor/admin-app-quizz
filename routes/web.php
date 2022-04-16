<?php
use Illuminate\Http\Request;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth'])->group(function (){

	Route::get('/', 'AdminController@index')->name('admin.dashboard');

	Route::get('/admin/users', 'AdminController@users')->name('admin.users');
	Route::get('/admin/users/subscriptions/{userId}', 'AdminController@subscriptions')->name('admin.users.subscriptions');
	Route::post('/admin/users/subscription/add', 'AdminController@addSubscriptions')->name('admin.users.subscriptions.add');
	Route::get('/admin/users/subscriptions/delete/{userId}/{queryId}', 'AdminController@deleteSubscription')->name('admin.users.subscriptions.delete');

	Route::post('/admin/users/add', 'AdminController@addUser')->name('admin.users.add');
	Route::post('/admin/users/edit', 'AdminController@editUser')->name('admin.users.edit');
	Route::get('/admin/users/delete/{userId}', 'AdminController@deleteUser')->name('admin.users.delete');
	Route::post('/admin/users/edit/password', 'AdminController@editPassword')->name('admin.users.edit.password');

	Route::get('/admin/webhooks', 'AdminController@webhooks')->name('admin.webhooks');
	Route::post('/admin/webhooks/add', 'AdminController@addWebhook')->name('admin.webhooks.add');
	Route::post('/admin/webhooks/update', 'AdminController@updateWebhook')->name('admin.webhooks.update');
	Route::get('/admin/webhooks/delete/{webhookId}', 'AdminController@deleteWebhook')->name('admin.webhooks.delete');
	Route::get('/transactions', 'AdminController@transactions')->name('admin.transactions');

	Route::get('/subscriptions', 'SubscriptionManagerController@index')->name('admin.subscription.index');
	Route::post('/subscriptions/add', 'SubscriptionManagerController@addPackage')->name('admin.subscription.add');
	Route::post('/subscriptions/edit', 'SubscriptionManagerController@editPackage')->name('admin.subscription.edit');
	Route::get('/subscriptions/delete/{packageId}', 'SubscriptionManagerController@deletePackage')->name('admin.subscription.delete');

	Route::get('/admin/settings', 'AdminController@settings')->name('admin.settings');
	Route::post('/admin/settings', 'AdminController@updateSettings')->name('admin.settings.edit');

	Route::get('/user/subscriptions', 'UserController@subscriptions')->name('user.subscriptions');
	Route::get('/user/settings', 'UserController@settings')->name('user.settings');
	Route::post('/user/settings', 'UserController@updateSettings')->name('user.settings.edit');
	Route::post('/user/settings/password', 'UserController@editPassword')->name('user.settings.password.edit');

});



Route::get('/login', 'Auth\LoginController@loginView')->name('login');
Route::get("/logout", "Auth\LoginController@logout")->name('auth.logout');
//Route::get('/register', 'Auth\RegisterController@registerPage')->name('register');
//Route::post('/register', 'Auth\RegisterController@register')->name('auth.register');
Route::post('/login', 'Auth\LoginController@login')->name('auth.login');

Route::get('/password-reset', 'Auth\ResetPasswordController@passwordReset')->name('auth.password.reset');
Route::get('/password-reset/verification/{token}',
    'Auth\ResetPasswordController@emailVerification')->name('auth.password.verification');
Route::post('/password-reset/recovery', 'Auth\ResetPasswordController@recoverPassword')->name('auth.password.recover');
Route::post('/password-reset/reset', 'Auth\ResetPasswordController@resetPassword')->name('auth.password.update');





// Route::get('/setter', 'TestController@index')->name('admin.setter');
// Route::get('/getter', 'TestController@getCache')->name('admin.getter');



