<?php
return [
	'maintenance' => false,

	'loginBonus' => [
		'point' => [
			'startTime' => '2017-10-13 12:00:00',
			'endTime' => '2017-10-26 23:59:59',
			'pointNum' => 10,
			'name' => '毎日ログインボーナス'
		],
	],

	'typeIds' => [
		'newest' => ['id' => 0, 'name' => 'Newest', 'navName' => '最新情報'],
		'event' => ['id' => 1, 'name' => 'Event', 'navName' => 'イベント'],
		'notice' => ['id' => 2, 'name' => 'Notice', 'navName' => 'お知らせ'],
		'maintenance' => ['id' => 3, 'name' => 'Maintenance', 'navName' => 'メンテナンス'],
		'update' => ['id' => 4, 'name' => 'Update', 'navName' => 'アップデート']
	],

	'coinExpirationAlertDays' => 20,

	'releaseTime' => '2017-01-12 15:00:00',
	'ipWhriteList' => ['211.5.132.113'],

	'userFingerprintKey' => '8kCpXe%HkyxODKTE',

	'epsilonCallUri' => ($_ENV['APP_ENV'] == 'prod') ? 'https://secure.epsilon.jp/cgi-bin/order/receive_order3.cgi' : 'https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi',
	'epsilonID' => '68964060',

	'netcafeGameId' => 'LOA',
	'netcafeKey' => 'K9UXHE',
	'netcafeTimetoolUri' => ($_ENV['APP_ENV'] == 'prod') ? 'https://www.paynetcafe.com/contents/timetool/' : 'http://test.paynetcafe.com/contents/timetool/',

	/*
	|--------------------------------------------------------------------------
	| Application Name
	|--------------------------------------------------------------------------
	|
	| This value is the name of your application. This value is used when the
	| framework needs to place the application's name in a notification or
	| any other location as required by the application or its packages.
	*/

	'name' => 'Laravel',

	'httpBaseUrl' => ($_ENV['APP_ENV'] == 'prod') ? 'http://www.loas.jp' : (($_ENV['APP_ENV'] == 'test') ? 'http://official.test.loas.jp' : 'http://official.dev.loas.jp'),
	'httpsBaseUrl' => ($_ENV['APP_ENV'] == 'prod') ? '//www.loas.jp' : (($_ENV['APP_ENV'] == 'test') ? '//official.test.loas.jp' : '//official.dev.loas.jp'),
	
	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => env('APP_DEBUG', false),

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => env('APP_URL', 'http://localhost'),

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => 'Asia/Tokyo',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => env('APP_KEY'),

	'cipher' => 'AES-256-CBC',

	/*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog", "errorlog"
	|
	*/

	'log' => env('APP_LOG', 'daily'),

	'log_level' => env('APP_LOG_LEVEL', 'debug'),

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => [

		/*
		 * Laravel Framework Service Providers...
		 */
		Illuminate\Auth\AuthServiceProvider::class,
		Illuminate\Broadcasting\BroadcastServiceProvider::class,
		Illuminate\Bus\BusServiceProvider::class,
		Illuminate\Cache\CacheServiceProvider::class,
		Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
		Illuminate\Cookie\CookieServiceProvider::class,
		Illuminate\Database\DatabaseServiceProvider::class,
		Illuminate\Encryption\EncryptionServiceProvider::class,
		Illuminate\Filesystem\FilesystemServiceProvider::class,
		Illuminate\Foundation\Providers\FoundationServiceProvider::class,
		Illuminate\Hashing\HashServiceProvider::class,
		Illuminate\Mail\MailServiceProvider::class,
		Illuminate\Notifications\NotificationServiceProvider::class,
		Illuminate\Pagination\PaginationServiceProvider::class,
		Illuminate\Pipeline\PipelineServiceProvider::class,
		Illuminate\Queue\QueueServiceProvider::class,
		Illuminate\Redis\RedisServiceProvider::class,
		Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
		Illuminate\Session\SessionServiceProvider::class,
		Illuminate\Translation\TranslationServiceProvider::class,
		Illuminate\Validation\ValidationServiceProvider::class,
		Illuminate\View\ViewServiceProvider::class,

		/*
		 * Package Service Providers...
		 */

		//

		/*
		 * Application Service Providers...
		 */
		App\Providers\AppServiceProvider::class,
		App\Providers\AuthServiceProvider::class,
		// App\Providers\BroadcastServiceProvider::class,
		App\Providers\EventServiceProvider::class,
		App\Providers\RouteServiceProvider::class,
		
		Laravel\Socialite\SocialiteServiceProvider::class,
				
	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [

		'App' => Illuminate\Support\Facades\App::class,
		'Artisan' => Illuminate\Support\Facades\Artisan::class,
		'Auth' => Illuminate\Support\Facades\Auth::class,
		'Blade' => Illuminate\Support\Facades\Blade::class,
		'Bus' => Illuminate\Support\Facades\Bus::class,
		'Cache' => Illuminate\Support\Facades\Cache::class,
		'Config' => Illuminate\Support\Facades\Config::class,
		'Cookie' => Illuminate\Support\Facades\Cookie::class,
		'Crypt' => Illuminate\Support\Facades\Crypt::class,
		'DB' => Illuminate\Support\Facades\DB::class,
		'Eloquent' => Illuminate\Database\Eloquent\Model::class,
		'Event' => Illuminate\Support\Facades\Event::class,
		'File' => Illuminate\Support\Facades\File::class,
		'Gate' => Illuminate\Support\Facades\Gate::class,
		'Hash' => Illuminate\Support\Facades\Hash::class,
		'Lang' => Illuminate\Support\Facades\Lang::class,
		'Log' => Illuminate\Support\Facades\Log::class,
		'Mail' => Illuminate\Support\Facades\Mail::class,
		'Notification' => Illuminate\Support\Facades\Notification::class,
		'Password' => Illuminate\Support\Facades\Password::class,
		'Queue' => Illuminate\Support\Facades\Queue::class,
		'Redirect' => Illuminate\Support\Facades\Redirect::class,
		'Redis' => Illuminate\Support\Facades\Redis::class,
		'Request' => Illuminate\Support\Facades\Request::class,
		'Response' => Illuminate\Support\Facades\Response::class,
		'Route' => Illuminate\Support\Facades\Route::class,
		'Schema' => Illuminate\Support\Facades\Schema::class,
		'Session' => Illuminate\Support\Facades\Session::class,
		'Storage' => Illuminate\Support\Facades\Storage::class,
		'URL' => Illuminate\Support\Facades\URL::class,
		'Validator' => Illuminate\Support\Facades\Validator::class,
		'View' => Illuminate\Support\Facades\View::class,
		'Socialite' => Laravel\Socialite\Facades\Socialite::class,
	],

];
