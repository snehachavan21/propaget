<?php

use App\Device;
use App\Http\Controllers\Auth\DoLoginPdo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

Route::get('/', 'WelcomeController@index');

Route::get('home', ['uses' => 'HomeController@index', 'as' => 'userHome']);

Route::group(['middleware' => 'auth', 'prefix' => 'requirementsold'], function() {
    Route::get('view', ['uses' => 'Requirementctrl\RequirementoldController@getListRequirementPage', 'as' => 'viewRequirement']);
    Route::get('add', ['uses' => 'Requirementctrl\RequirementoldController@getAddRequirementPage', 'as' => 'addRequirement']);
    Route::post('save', ['uses' => 'Requirementctrl\RequirementoldController@postSaveRequirement', 'as' => 'saveRequirement']);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('/fb/login', 'SocialLogin\SocialLoginController@fb_login');
//Route::get('/fb/login/done', 'SocialLoginController@fbloginUser');


Route::get('get-token', function() {
    return csrf_token();
});

Route::get('see-tokens', function() {
    echo Session::getId();
    echo '<br />';
    echo Session::token();
    echo '<br />';
    echo csrf_token();
});

Route::get('mobile-logout', function() {
    Session::flush();
});

//Route::post('mobile/login', 'SocialLoginController@mobile_login', ['middleware' => 'auth.token']);
Route::post('mobile/login', 'SocialLogin\SocialLoginController@mobile_login');
Route::post('testingAuth', ['middleware' => 'auth.token', function () {
   return 'Successfully Authenticated';
}]);

/* Distribution list */
Route::resource('dist-list', 'DistListController');
Route::controller('dist-list', 'Distribution\DistListController');
Route::get('distribution', 'Distribution\DistributionAppController@index');
Route::get('distribution/list', 'Distribution\DistributionAppController@listing');
Route::get('distribution/view', 'Distribution\DistributionAppController@view');

Route::resource('req-list','Requirementctrl\RequirementController');
Route::controller('req-list','Requirementctrl\RequirementController');

Route::get('requirements', 'Requirementctrl\RequirementAppController@index');
Route::get('requirements/list', 'Requirementctrl\RequirementAppController@listing');
Route::get('requirements/add', 'Requirementctrl\RequirementAppController@add');
Route::get('requirements/view', 'Requirementctrl\RequirementAppController@view');

Route::post('register-device', function(Request $request) {
    $postData = $request->input();

    $device = new Device;
    $device->deviceId = $postData['deviceId'];
    $device->registraionId = $postData['registrationId'];
    $device->save();

    /*$gcm = new GcmHelper;
    $gcm->sendNotification(
        array($device->registraionId),
        array('title' => 'Device registered', 'message' => 'Congratulations, your devie has been registered with us.')
    );*/
});



Route::resource('property', 'Property\PropertyController');
Route::get('properties', 'Property\PropertyAppController@index');
Route::get('properties/list', 'Property\PropertyAppController@listing');
Route::get('properties/add', 'Property\PropertyAppController@add');
Route::get('properties/view', 'Property\PropertyAppController@view');

Route::post('oauth/token', 'Auth\OAuthController@getOAuthToken');
//Route::get('oauth/get-access', 'Auth\OAuthController@validateAccessToken');

App::singleton('oauth2', function() {
    $storage = new DoLoginPdo(array(
        'dsn' => 'mysql:dbname=' . env('DB_DATABASE') . ';host=' . env('DB_HOST'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD')
    ));

    $server = new OAuth2\Server($storage);

    $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
    $server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
    $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
    $server->addGrantType(new OAuth2\GrantType\RefreshToken($storage));

    return $server;
});

Route::post('get-new-token', 'Auth\OAuthController@newAccessToken');


Route::group(['middleware' => 'oauth', 'prefix' => 'oauth'], function() {
    Route::get('get-access', 'Auth\OAuthController@validateAccessToken');
});

