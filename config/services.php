<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
	
	'yahoojp' => [
		'client_id'     => 'dj00aiZpPXkyNWpKY0tNaGxVYyZzPWNvbnN1bWVyc2VjcmV0Jng9ZDk-',
		'client_secret' => '36ff8c8c93e3fd04ebc4af712e29a4c3759e2dfa',
		'redirect'      => (env('APP_ENV') == 'prod') ? 'https://www.loas.jp/auth/yahoojp/callback' : ((env('APP_ENV') == 'test') ? 'https://official.test.loas.jp/auth/yahoojp/callback' : 'http://official.dev.loas.jp/auth/yahoojp/callback'),
	],
	
	'twitter' => [
		'client_id'     => 'GIEsdSJ2ki1jIuZcex7JbDnUO',
		'client_secret' => 'rTDycMVYVqG7hlpzP3RBawOuTywNQimTsdM14kFSM9vyoux6WL',
		//'redirect'      => (env('APP_ENV') == 'dev') ? 'https://official.test.loas.jp/auth/twitter/callback' : 'https://www.loas.jp/auth/twitter/callback',
		'redirect'      => (env('APP_ENV') == 'prod') ? 'https://www.loas.jp/auth/twitter/callback' : ((env('APP_ENV') == 'test') ? 'https://official.test.loas.jp/auth/twitter/callback' : 'http://official.dev.loas.jp/auth/twitter/callback'),
	],
	
	'facebook' => [
		'client_id'     => '671258459715477',
		'client_secret' => 'fa3b8743025215bff52681ccc90f29be',
		//'redirect'      => (env('APP_ENV') == 'dev') ? 'https://official.test.loas.jp/auth/facebook/callback' : 'https://www.loas.jp/auth/facebook/callback',
		'redirect'      => (env('APP_ENV') == 'prod') ? 'https://www.loas.jp/auth/facebook/callback' : ((env('APP_ENV') == 'test') ? 'https://official.test.loas.jp/auth/facebook/callback' : 'http://official.dev.loas.jp/auth/facebook/callback'),
	],
	
	'google' => [
		'client_id'     => '274917332993-onstl1fuc23qmf5pgm982atmd1k4eqrn.apps.googleusercontent.com',
		'client_secret' => 'XAiQY3Ii87-ILzkR0Baujgr9',
		//'redirect'      => (env('APP_ENV') == 'dev') ? 'https://official.test.loas.jp/auth/google/callback' : 'https://www.loas.jp/auth/google/callback',
		'redirect'      => (env('APP_ENV') == 'prod') ? 'https://www.loas.jp/auth/google/callback' : ((env('APP_ENV') == 'test') ? 'https://official.test.loas.jp/auth/google/callback' : 'http://official.dev.loas.jp/auth/google/callback'),
	],

];
