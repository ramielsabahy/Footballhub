<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// User authentication
Route::post('/authenticate', [
	'uses' => 'AuthController@authenticate'
]);
// admin registration
Route::post('/register', [
	'uses' => 'AuthController@register'
])->middleware('jwt.auth');
// Create User
Route::post('/users/createUser', 'UsersController@createUser')->name('createUser')->middleware('jwt.auth');
Route::post('/players/registerCMS', 'UsersController@createPlayerCMS')->name('registerUser');
// Create Admin
Route::post('/users/createAdmin', 'UsersController@createAdmin')->middleware('jwt.auth');
Route::post('/admins/registerCMS', 'UsersController@createAdminCMS')->name('registerAdmin');
// Edit User
Route::post('/users/editUser', 'UsersController@editUser')->middleware('jwt.auth');
Route::post('/users/editCMS', 'UsersController@editUserCMS')->name('editUser');
// Edit Admin
Route::post('/users/editAdmin', 'UsersController@editAdmin')->middleware('jwt.auth');
// All Suspended Admins
Route::get('/users/allSuspendedAdmins', 'UsersController@allSuspendedAdmins')->name('allSuspendedAdmins')->middleware('jwt.auth');
// Send Suspended admin data to the view
Route::get('/admins/allDT', 'UsersController@allSuspendedAdminsDT')->name('allSuspendedAdmins');
// Send unSuspended admin data to the view
Route::get('/admins/allUnsuspendedDT', 'UsersController@allUnSuspendedAdminsDT')->name('allUnSuspendedAdmins');

// All UnSuspended Admins
Route::get('/users/allUnSuspendedAdmins', 'UsersController@allUnSuspendedAdmins')->name('allUnsuspendedAdmins')->middleware('jwt.auth');
// Get User By Id
Route::get('/users/getUserById', 'UsersController@getUserById')->middleware('jwt.auth');
// Get Admin By Id
Route::get('/users/getAdminById', 'UsersController@getAdminById')->middleware('jwt.auth');
// Suspend User
Route::post('/users/suspendUser', 'UsersController@suspendUser')->middleware('jwt.auth');
// UnSuspend User
Route::post('/users/UnSuspendUser', 'UsersController@UnSuspendUser')->middleware('jwt.auth');
// Suspend Admin
Route::post('/users/suspendAdmin', 'UsersController@suspendAdmin')->middleware('jwt.auth');
// UnSuspend Admin
Route::post('/users/unSuspendAdmin', 'UsersController@unSuspendAdmin')->middleware('jwt.auth');
// All Suspended Users
Route::get('/users/allSuspendedUsers', 'UsersController@allSuspendedUsers')->name('suspendedUsers')->middleware('jwt.auth');
// All UnSuspended Users
Route::get('/users/allUnSuspendedUsers', 'UsersController@allUnSuspendedUsers')->middleware('jwt.auth');
// Send Suspended Users data to the view
Route::get('/users/allsuspendedDT', 'UsersController@allSuspendedUsersDT')->name('allSuspendedUsers');
// Send unSuspended Users data to the view
Route::get('/users/allUnsuspendedDT', 'UsersController@allUnSuspendedUsersDT')->name('allUnSuspendedUsers');
// Get Users By Full Name
Route::get('/users/getUsersByFullname', 'UsersController@getUsersByFullname')->middleware('jwt.auth');

// Player follow
Route::get('/players/follow', 'FollowsController@follow')->middleware('jwt.auth');
// Player unFollow
Route::get('/players/unfollow', 'FollowsController@unFollow')->middleware('jwt.auth');
// player following
Route::get('/players/following', 'FollowsController@following')->middleware('jwt.auth');
// player followers
Route::get('/players/followers', 'FollowsController@followers')->middleware('jwt.auth');

// Create a general feed
Route::post('/general_feeds/create', 'GeneralFeedsController@createGeneralFeed')->middleware('jwt.auth');
// Edit a general feed
Route::post('/general_feeds/edit', 'GeneralFeedsController@editGeneralFeed')->middleware('jwt.auth');
// Get all active general feeds
Route::get('/general_feeds/allActive', 'GeneralFeedsController@allActiveGeneralFeeds')->middleware('jwt.auth');
// Get all in-active general feeds
Route::get('/general_feeds/allInActive', 'GeneralFeedsController@AllInActiveGeneralFeeds')->middleware('jwt.auth');
// Get a general feed by id
Route::get('/general_feeds/get', 'GeneralFeedsController@getGeneralFeedById')->middleware('jwt.auth');
// Destroy a general feed
Route::get('/general_feeds/destroy', 'GeneralFeedsController@destroyGeneralFeed')->middleware('jwt.auth');
// Hide a general feed
Route::get('/general_feeds/hide', 'GeneralFeedsController@hideGeneralFeed')->middleware('jwt.auth');
// Player/Referee general feeds
Route::get('/general_feeds/user_feeds', 'GeneralFeedsController@userGeneralFeeds')->middleware('jwt.auth');

// Create a football hub feed
Route::post('/football_hub_feeds/create', 'FootballHubFeedsController@createFootballHubFeed')->middleware('jwt.auth');
// Edit a football hub feed
Route::post('/football_hub_feeds/edit', 'FootballHubFeedsController@editFootballHubFeed')->middleware('jwt.auth');
// Destroy a football hub feed
Route::get('/football_hub_feeds/destroy', 'FootballHubFeedsController@destroyFootballHubFeed')->middleware('jwt.auth');
// Get all football hub feeds
Route::get('/football_hub_feeds/all', 'FootballHubFeedsController@allFootballHubFeeds')->middleware('jwt.auth');
Route::get('/suspended_football_hub_feeds_cms/all', 'FootballHubFeedsController@allSuspendedFootballHubFeedsCMS')->name('allFootballHubFeeds');
Route::get('/unsuspended_football_hub_feeds_cms/all', 'FootballHubFeedsController@allUnSuspendedFootballHubFeedsCMS')->name('allUnsuspendedFootballHubFeeds');

Route::get('/suspended_general_feeds_cms/all', 'GeneralFeedsController@allSuspendedGeneralFeedsCMS')->name('allSuspendedGeneralFeeds');
Route::get('/unsuspended_general_feeds_cms/all', 'GeneralFeedsController@allUnSuspendedGeneralFeedsCMS')->name('allUnGeneralFeeds');


// Get a football hub feed by id
Route::get('/football_hub_feeds/get', 'FootballHubFeedsController@getFootballHubFeedById')->middleware('jwt.auth');

// Getting the comments of a feed
Route::get('/comments/feed_comments', 'CommentsController@feedComments')->middleware('jwt.auth');
// Comment on a feed
Route::post('/comments/comment', 'CommentsController@commentOnFeed')->middleware('jwt.auth');
// Editing a comment
Route::post('/comments/edit', 'CommentsController@editComment')->middleware('jwt.auth');
// Destroying a comment
Route::get('/comments/destroy', 'CommentsController@destroyComment')->middleware('jwt.auth');
// Hide a comment
Route::get('/comments/hide', 'CommentsController@hideComment')->middleware('jwt.auth');
// UnHide a comment
Route::get('/comments/unHide', 'CommentsController@unHideComment')->middleware('jwt.auth');
// Liking a feed
Route::get('/likes/like', 'LikesController@like')->middleware('jwt.auth');
// Unliking a feed
Route::get('/likes/unlike', 'LikesController@unlike')->middleware('jwt.auth');
// user likes
Route::get('/likes/userLikes', 'LikesController@userLikes')->middleware('jwt.auth');
// Liked by
Route::get('/likes/likedBy', 'LikesController@likedBy')->middleware('jwt.auth');
// Show terms and conditions
Route::get('/termsandconditions', 'TermsAndConditionsController@returnTermsAndConditions');
// Set terms and conditions
Route::post('/termsandconditions/setTermsAndConditions', 'TermsAndConditionsController@setTermsAndConditions')->name('setTermsAndConditions');
// Reports
Route::post('/reports/reportFeed', 'ReportsController@reportFeed')->middleware('jwt.auth');
Route::get('/reports/getReports', 'ReportsController@getReports')->middleware('jwt.auth');
Route::get('/reports/getReportsDataTable', 'ReportsController@getReportsDataTable')->name('getReportsDataTable');
Route::post('/reports/createReport', 'ReportsController@createReport')->name('createReport');
Route::post('/reports/editReport', 'ReportsController@editReport')->name('editReport');
Route::get('/reports/destroyReport', 'ReportsController@destroyReport')->name('destroyReport');
Route::get('/reports/destroyFeedReport', 'ReportsController@destroyFeedReport')->name('destroyFeedReport');
Route::get('/reports/getReportFeeds', 'ReportsController@getReportFeeds')->name('getReportFeeds');
Route::get('/reports/getFeedReports', 'ReportsController@getFeedReports')->name('getFeedReports');

// Teams
Route::post('/teams/create', 'TeamsController@createTeam')->middleware('jwt.auth');
Route::post('/teams/edit', 'TeamsController@editTeam')->middleware('jwt.auth');
Route::get('/teams/all', 'TeamsController@allTeams')->middleware('jwt.auth');
Route::any('/teams/allActiveDT', 'TeamsController@allActiveTeamsDT')->name('fetchTeams');
Route::any('/teams/teamPlayersDT', 'TeamsController@teamPlayersDT')->name('fetchPlayers');
Route::any('/teams/allPlayersDT', 'TeamsController@allTeamPlayersDT')->name('fetchTeamPlayers');
Route::any('/teams/deactivate', 'TeamsController@deactivateTeamCMS')->name('deactivateTeamCMS');
Route::get('/teams/regenerateTeamCode', 'TeamsController@regenerateTeamCode')->middleware('jwt.auth');
Route::post('/teams/setTeamCode', 'TeamsController@setTeamCode')->middleware('jwt.auth');
Route::get('/teams/getTeamById', 'TeamsController@getTeamById');
Route::get('/teams/getTeamsByName', 'TeamsController@getTeamsByName');
Route::get('/teams/getTeamByCode', 'TeamsController@getTeamByCode');
Route::get('/teams/activateTeam', 'TeamsController@activateTeam')->middleware('jwt.auth');
Route::get('/teams/deactivateTeam', 'TeamsController@deactivateTeam')->middleware('jwt.auth');
Route::get('/teams/activeTeams', 'TeamsController@allActiveTeams')->middleware('jwt.auth');
Route::get('/teams/inActiveTeams', 'TeamsController@allInActiveTeams')->middleware('jwt.auth');

// Invitations
Route::post('/invitations/inviteByPhone', 'InvitationsController@inviteByPhone')->middleware('jwt.auth');
Route::post('/invitations/inviteById', 'InvitationsController@inviteById')->middleware('jwt.auth');
Route::get('/invitations/checkPhoneInvitations', 'InvitationsController@checkPhoneInvitations')->middleware('jwt.auth');
Route::get('/invitations/allTeamInvitations', 'InvitationsController@allTeamInvitations')->middleware('jwt.auth');
Route::get('/invitations/allPlayerInvitations', 'InvitationsController@allPlayerInvitations')->middleware('jwt.auth');
Route::get('/invitations/acceptInvitation', 'InvitationsController@acceptInvitation')->middleware('jwt.auth');
Route::get('/invitations/rejectInvitation', 'InvitationsController@rejectInvitation')->middleware('jwt.auth');
Route::post('/invitations/cancelInvitation', 'InvitationsController@cancelInvitation')->middleware('jwt.auth');
Route::get('/invitations/clearPhoneInvitations', 'InvitationsController@clearPhoneInvitations')->middleware('jwt.auth');
Route::get('/invitations/clearTeamInvitations', 'InvitationsController@clearTeamInvitations')->middleware('jwt.auth');
Route::get('/invitations/leaveTeam', 'InvitationsController@leaveTeam')->middleware('jwt.auth');
Route::post('/invitations/playerKickOff', 'InvitationsController@playerKickOff')->middleware('jwt.auth');
// Friendly Routes
Route::post('/friendly/createFriendlyMatch', 'FriendlyController@createFriendlyMatch')->middleware('jwt.auth');
Route::get('/friendly/getPlayerFriendlyInvitations', 'FriendlyController@getPlayerFriendlyInvitations')->middleware('jwt.auth');
Route::get('/friendly/getPlayerFriendlyMatches', 'FriendlyController@getPlayerFriendlyMatches')->middleware('jwt.auth');
Route::get('/friendly/getPlayerJoinedFriendlyMatches', 'FriendlyController@getPlayerJoinedFriendlyMatches')->middleware('jwt.auth');
Route::get('/friendly/getAllPlayerFriendlyMatches', 'FriendlyController@getAllPlayerFriendlyMatches')->middleware('jwt.auth');
Route::get('/friendly/getFriendlyMatchById', 'FriendlyController@getFriendlyMatchById')->middleware('jwt.auth');
Route::get('/friendly/friendlyMembersCount', 'FriendlyController@friendlyMembersCount')->middleware('jwt.auth');
Route::get('/friendly/deleteFriendlyMatch', 'FriendlyController@deleteFriendlyMatch')->middleware('jwt.auth');
Route::get('/friendly/acceptFriendlyMatchInvitation', 'FriendlyController@acceptFriendlyMatchInvitation')->middleware('jwt.auth');
Route::get('/friendly/rejectFriendlyMatchInvitation', 'FriendlyController@rejectFriendlyMatchInvitation')->middleware('jwt.auth');
Route::post('/friendly/cancelFriendlyMatchInvitation', 'FriendlyController@cancelFriendlyMatchInvitation')->middleware('jwt.auth');
Route::post('/friendly/kickOffFriendlyMatchMember', 'FriendlyController@kickOffFriendlyMatchMember')->middleware('jwt.auth');
Route::get('/friendly/leaveFriendlyMatch', 'FriendlyController@leaveFriendlyMatch')->middleware('jwt.auth');
Route::post('/friendly/invitePlayerToFriendlyMatch', 'FriendlyController@invitePlayerToFriendlyMatch')->middleware('jwt.auth');
Route::get('/friendly/CheckFriendlyMatchCanStart', 'FriendlyController@CheckFriendlyMatchCanStart')->middleware('jwt.auth');
Route::get('/friendly/startFriendlyMatch', 'FriendlyController@startFriendlyMatch')->middleware('jwt.auth');
Route::get('/friendly/endFriendlyMatch', 'FriendlyController@endFriendlyMatch')->middleware('jwt.auth');
Route::get('/friendly/getPlayerFriendlyScore', 'FriendlyController@getPlayerFriendlyScore')->middleware('jwt.auth');
Route::post('/friendly/flushFriendlyMatchResults', 'FriendlyController@flushFriendlyMatchResults')->middleware('jwt.auth');
Route::post('/pushToken', 'PushNotificationController@pushToken')->name('pushToken');
Route::post('/sendPushNotification', 'PushNotificationController@sendPushNotification')->name('sendPushNotification');

Route::any('/friendly/allDT', 'FriendlyController@allMatchesDT')->name('allMatches');
Route::get('/league/search', 'LeagueAndTournamentController@search')->name('searchLeague');
Route::get('/league/create', 'LeagueAndTournamentController@create')->name('createLeague');

//League & Tournaments
Route::get('/allCompetitions', 'CompetitionsController@allCompetitions')->middleware('jwt.auth');
Route::get('/allRounds', 'RoundsController@allRounds')->middleware('jwt.auth');
Route::get('/seasonsByCompetition/{id}', 'CompetitionSeasonsController@seasonsByCompetition')->middleware('jwt.auth');
Route::get('/groupsBySeason/{id}', 'CompetitionSeasonGroupsController@groupsBySeason')->middleware('jwt.auth');
Route::get('/teamsByGroup/{id}', 'CompetitionSeasonTeamsController@teamsByGroup')->middleware('jwt.auth');
Route::get('/teamsBySeason/{id}', 'CompetitionSeasonTeamsController@teamsBySeason')->middleware('jwt.auth');
Route::get('/roundsByCompetition/{id}', 'CompetitionRoundsController@roundsByCompetition')->middleware('jwt.auth');
Route::get('/matchesByRound/{id}', 'CompetitionSeasonMatchesController@matchesBySeason')->middleware('jwt.auth');
Route::get('/matchesBySeason/{id}', 'CompetitionSeasonMatchesController@matchesBySeason')->middleware('jwt.auth');
Route::get('/matchesBySeasonAndGroup/{id}/{id2}', 'CompetitionSeasonMatchesController@matchesBySeasonAndGroup')->middleware('jwt.auth');
Route::get('/basicSetupList', 'BasicSetupController@basicSetupList')->middleware('jwt.auth');

Route::get('/cardsByMatch/{id}', 'CompetitionSeasonMatcheCardsController@cardsByMatch')->middleware('jwt.auth');
Route::post('/raiseCard', 'CompetitionSeasonMatcheCardsController@raiseCard')->middleware('jwt.auth');

Route::get('/activitesByMatch/{id}', 'CompetitionSeasonMatchActsController@activitesByMatch')->middleware('jwt.auth');
Route::post('/sendActivity', 'CompetitionSeasonMatchActsController@sendActivity')->middleware('jwt.auth');

Route::get('/goalsByMatch/{id}', 'CompetitionSeasonMatcheGoalsController@goalsByMatch')->middleware('jwt.auth');
Route::post('/scoreGoal', 'CompetitionSeasonMatcheGoalsController@scoreGoal')->middleware('jwt.auth');

Route::get('/subsByMatch/{id}', 'CompetitionSeasonMatcheSubsController@subsByMatch')->middleware('jwt.auth');
Route::post('/swicthPlayer', 'CompetitionSeasonMatcheSubsController@swicthPlayer')->middleware('jwt.auth');

// Notifications Controller
Route::get('/notifications/allPlayerNotifications', 'NotificationsController@allPlayerNotifications')->middleware('jwt.auth');

//competiton
Route::get('/allCompetitionsDT', 'CompetitionsController@allCompetitionsDT')->name('allCompetitions');
Route::post('/getTeams', 'CompetitionsController@GetTeams')->name('getTeams');
Route::post('/CreateCompetitionSeason', 'CompetitionsController@CreateCompetitionSeason')->name('CreateCompetitionSeason');
Route::post('/AddSeasons', 'CompetitionsController@AddSeasons');
Route::get('/allCompetitionSeasons/{id}', 'CompetitionsController@allCompetitionSeasons');
Route::post('/CreateGroupsGroupsTeams', 'CompetitionsController@CreateGroupsGroupsTeams')->name('CreateGroupsGroupsTeams');
Route::post('/EditCompetitonSeason', 'CompetitionsController@EditCompetitonSeason')->name('EditCompetitonSeason');

Route::post('/matchMapTeams', 'CompetitionsController@matchMapTeams')->name('matchMapTeams');

Route::post('/createGroups', 'TeamsController@Groups')->name('groups');
Route::get('/allCompetitionSeasonGroupsDT', 'CompetitionsController@allCompetitionSeasonGroupsDT')->name('allCompetitionsGroups');
Route::post('/AddGroups', 'CompetitionsController@AddGroups');

Route::any('/getRound', 'CompetitionRoundsController@getRound')->name('getRound');
