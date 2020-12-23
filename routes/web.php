<?php
/**
 * This file is part of the wangningkai/olaindex.
 * (c) wangningkai <i@ningkai.wang>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
// 消息通知
Route::view('message', config('olaindex.theme') . 'message')->name('message');
// 授权回调
Route::get('callback', 'AuthController@callback')->name('callback');
// 登录登出
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// 后台管理
Route::prefix('admin')->middleware('auth')->group(static function () {
    // 安装绑定
    Route::prefix('install')->group(static function () {
        Route::any('/', 'InstallController@install')->name('install');
        Route::any('apply', 'InstallController@apply')->name('apply');
        Route::any('reset', 'InstallController@reset')->name('reset');
        Route::any('bind', 'InstallController@bind')->name('bind');
    });
    // 基础设置
    Route::any('/', 'AdminController@config');
    Route::any('config', 'AdminController@config')->name('admin.config');
    Route::any('profile', 'AdminController@profile')->name('admin.profile');
    Route::get('clear', 'AdminController@clear')->name('cache.clear');
    // 账号详情
    Route::get('account/list', 'AccountController@list')->name('admin.account.list');
    Route::get('account/{id}', 'AccountController@quota')->name('admin.account.info');
    Route::get('account/drive/{id}', 'AccountController@drive')->name('admin.account.drive');
    Route::any('account/config/{id}', 'AccountController@config')->name('admin.account.config');
    Route::post('account/remark/{id}', 'AccountController@remark')->name('admin.account.remark');
    Route::post('account/set-main', 'AccountController@setMain')->name('admin.account.setMain');
    Route::post('account/delete', 'AccountController@delete')->name('admin.account.delete');
    // 日志
    Route::any('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.logs');

});
Route::get('/', 'DriveController@query')->name('home');
Route::get('drive/{hash?}', 'DriveController@query')->name('drive');
Route::get('drive/{hash?}/{query?}', 'DriveController@query')->name('drive.query')->where('query', '.*');
Route::post('decrypt', 'DriveController@decrypt')->name('drive.decrypt');
Route::get('image', 'ImageController@index')->name('image')->middleware('custom');
Route::post('image-upload', 'ImageController@upload')->name('image.upload')->middleware('custom');
Route::get('t/{code}', 'IndexController')->name('short');
