<?php

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

Route::get('/', function() {
	return view('layouts.main');
})->name('main');

Route::get('/dashboard', function() {
	return view('dashboard.view');
})->name('dashboard');


Route::group(['prefix' => 'cpanel'], function () {
    // Route::get('/admins/register', 'Auth\RegisterController@showRegistrationForm');
	// Route::post('/admins/register', 'Auth\RegisterController@register')->name('register');
	Route::get('/admins/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('/admins/login', 'Auth\LoginController@login');
	Route::post('/admins/logout', 'Auth\LoginController@logout')->name('logout');

	// Facebook Login
	// Route::get('login/facebook', 'Auth\LoginController@facebookRedirectToProvider');
	// Route::get('login/facebook/callback', 'Auth\LoginController@facebookHandleProviderCallback');

	// Google Login
	// Route::get('login/google', 'Auth\LoginController@googleRedirectToProvider');
	// Route::get('login/google/callback', 'Auth\LoginController@googleHandleProviderCallback');

	// admins
	Route::get('suspendedAdmins', 'UsersController@allSuspendedAdminsView')->name('suspendedAdmins');
	Route::get('unsuspendedAdmins', 'UsersController@allUnSuspendedAdminsView')->name('unsuspendedAdmins');


	Route::get('/admins/create', 'UsersController@createAdminView')->name('createAdminView');
	Route::get('/admins/editView/{id}', 'UsersController@editAdminView')->name('editAdminView');
	Route::get('/admins/allAdmins', 'UsersController@allAdminsView')->name('allAdminsView');
	// players
	Route::get('admins/players/create', 'UsersController@createPlayerView')->name('createPlayerView');
	Route::get('/players/editView/{id}', 'UsersController@editUserView')->name('editUserView');
	Route::get('/players/allAdmins', 'UsersController@allPlayersView')->name('allPlayersView');
	// referees

	// Users
	Route::get('suspendedUsers', 'UsersController@allSuspendedUsersView')->name('suspendedUsers');
	Route::get('unsuspendedUsers', 'UsersController@allUnSuspendedUsersView')->name('unsuspendedUsers');

	Route::get('/user/create', 'UsersController@createUserView')->name('createUser');
	Route::get('/referees/editView/{id}', 'UsersController@editRefereeView')->name('editRefereeView');
	Route::get('/referees/allAdmins', 'UsersController@allRefereesView')->name('allRefereesView');
	// Info
	Route::get('/info/create', 'UsersController@createInfoView')->name('createInfoView');
	Route::get('/info/editView/{id}', 'UsersController@editInfoView')->name('editInfoView');
	Route::get('/info/allInfo', 'UsersController@allInfoView')->name('allInfoView');
	//Teams
	Route::get('/teams/allActiveTeams', 'TeamsController@indexActiveView')->name('allActiveTeamsView');
	Route::get('/teams/allInActiveTeams', 'TeamsController@indexInActiveView')->name('allInActiveTeamsView');
	Route::get('teams/players',['uses' => 'TeamsController@playersView'])->name('playersView');
	Route::get('/teams/index', 'TeamsController@indexActiveView');

	// Terms and Conditions
	Route::get('/termsandconditions/show', 'TermsAndConditionsController@show')->name('showTermsAndConditions');
	Route::get('/termsandconditions/create', 'TermsAndConditionsController@create')->name('createTermsAndConditions');
	Route::get('/termsandconditions/update', 'TermsAndConditionsController@update')->name('updateTermsAndConditions');

	// FootballHub Feeds
	Route::get('/suspended_footballHubFeeds/indexView', 'FootballHubFeedsController@indexView')->name('indexFootballHubFeeds');
	Route::get('/unsuspended_footballHubFeeds/indexView', 'FootballHubFeedsController@indexUnsuspendedView')->name('indexUnFootballHubFeeds');
	Route::get('/footballHubFeeds/editView/{id}', 'FootballHubFeedsController@editView')->name('editFootballHubFeed');
	Route::get('/footballHubFeeds/createView', 'FootballHubFeedsController@createView')->name('createFootballHubFeed');
	Route::get('/footballHubFeeds/showView/{id}', 'FootballHubFeedsController@showView');

	// General Feeds
	Route::get('/generalFeeds/indexView', 'GeneralFeedsController@indexActiveGeneralFeedsView')->name('indexGeneralFeeds');

	Route::get('/suspended_generalFeeds/indexView', 'GeneralFeedsController@indexInActiveGeneralFeedsView')->name('indexUnGeneralFeeds');

	Route::get('/generalFeeds/showView/{id}', 'GeneralFeedsController@showView');

	// Reports
	Route::get('/reports/indexReports', 'ReportsController@indexReportsView')->name('indexReportsView');
	Route::get('/reports/createReport', 'ReportsController@createReportView')->name('createReportView');
	Route::get('/reports/editReport/{report_id}', 'ReportsController@editReportView')->name('editReportView');
	Route::get('/reports/indexFeedReports/{feed_id}', 'ReportsController@indexFeedReportsView')->name('indexFeedReportsView');
	Route::get('/reports/indexReportFeeds/{report_id}', 'ReportsController@indexReportFeedsView')->name('indexReportFeedsView');

	// Friendly
	Route::get('/friendly/allMatches', 'FriendlyController@matchesView')->name('allMatchesView');
	Route::any('/feeds/feedReport', 'ReportsController@IndexReportFeedsView2')->name('viewReportFeeds');
	Route::any('/invitations', 'FriendlyController@invitationsView')->name('invitations');

	//League and Tournament
	Route::get('/league', 'LeagueAndTournamentController@index')->name('league')->middleware('auth');
	Route::get('/tournament', 'LeagueAndTournamentController@load')->name('tournaments');
	Route::get('/competition' , 'CompetitionsController@index');
	Route::get('/competition/{id}' , 'CompetitionsController@show');
	Route::post('/getGroupById', 'CompetitionsController@getGroupById')->name('getGroupById');
	Route::get('/league', 'LeagueAndTournamentController@index')->name('league');
});

