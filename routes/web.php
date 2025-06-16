<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::any('/', ['uses' => 'IndexController@index', 'http' => true]);
Route::any('/notice/{noticeType?}', 'NoticeController@noticeList');
Route::any('/notice/{noticeType?}/page/{pageNumber?}', 'NoticeController@noticeList');
Route::any('/notice/topic/{topicId?}', 'NoticeController@topic');

Route::get('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/auth/{provider}', 'UserController@auth');
Route::get('/auth/{provider}/callback', 'UserController@authCallback');
Route::match(['get', 'post'], '/user/register/{step}', 'UserController@register');
Route::get('/gamePrivacyDialog', function (){
    return view('support.gamePrivacyDialog');
});
Route::get('/agreeGamePrivacy', 'UserController@agreeGamePrivacy');

Route::get('/serverSelect', 'GameController@serverSelect');

Route::get('/game/play/{serverId}', 'GameController@play');
Route::get('/game/startClient/{serverId}', 'GameController@startClient');
Route::post('/game/diamondPurchase', 'GameController@diamondPurchase');

Route::group(['prefix' => 'support'], function () {
	Route::get('terms.html', function () {
		return view('support.terms');
	});

	Route::get('tokusyo.html', function () {
		return view('support.tokusyo');
	});

	Route::get('service.html', function () {
		return view('support.service');
	});

	Route::get('privacy.html', function () {
		return view('support.privacy');
	});

	Route::get('kessai.html', function () {
		return view('support.kessai');
	});

	Route::get('/', function () {
		return view('support.terms');
	});

	Route::get('/qa', function () {
		return view('support.qa');
	});

    Route::get('/download_guide', function () {
        return view('support.download_guide');
    });
    Route::get('/download_guide_pf', function () {
        return view('support.download_guide_pf');
    });
});

Route::group(['prefix' => 'gallery'], function () {
	Route::get('movies.html', function () {
		genSession();
		return view('gallery.movies');
	});

	Route::get('/', function () {
		genSession();
		return view('gallery.movies');
	});
});

Route::group(['prefix' => 'pointMall'], function () {
	Route::get('intro.html', function () {
		genSession();
		return view('pointMall.intro');
	});

	Route::get('itemlist', 'PointMallController@itemList');
	Route::get('history', 'PointMallController@history');
	Route::get('itemInfo/{itemId?}/{serverId?}/{itemCount?}', 'PointMallController@itemInfo');
	Route::post('purchase/{itemId?}/{serverId?}/{itemCount?}', 'PointMallController@purchase');
});

Route::get('/playguild', function () {
	return view('playguild.playguild');
});

Route::get('/charge_cp.html', function () {
	return view('purchase.charge_cp');
});

Route::post('/func/poster', 'FuncController@poster');

Route::group(['prefix' => 'purchase'], function () {
	Route::get('intro', 'PurchaseController@intro');
	Route::get('process', 'PurchaseController@process');
	Route::get('paymentInfo.js', 'PurchaseController@makePaymentInfoJS');
	Route::post('posterPurchase', 'PurchaseController@posterPurchase');
	Route::get('complete', 'PurchaseController@complete');
	Route::get('history', 'PurchaseController@history');
	Route::post('completeCallback', 'PurchaseController@completeCallback');
	Route::get('chargePage', 'PurchaseController@chargePage');
});

Route::group(['prefix' => 'diamondCharge'], function () {
    Route::get('chargePage', 'DiamondChargeController@chargePage');
});

Route::group(['prefix' => 'intro'], function () {
	Route::get('gameintro.html', function() {
		return view('intro.introGame');
	});

	Route::get('outlook.html', function() {
		return view('intro.outlook');
	});

	Route::get('race.html', function() {
		return view('intro.race');
	});

	Route::get('/outlook/story.html', function() {
		return view('intro.story');
	});

	Route::get('/character.html', function() {
		return view('intro.character');
	});

	Route::get('/playenv.html', function() {
		return view('intro.playenv');
	});
    Route::get('/download.html', function() {
        return view('intro.download');
    });
	Route::get('/', function () {
		return view('intro.introGame');
	});
});

Route::get('/terms_clear', function () {
	return view('user.terms_clear');
});
Route::get('/privacy_clear', function () {
    return view('support.privacy_clear');
});
Route::get('/casting.html', function () {
	return view('cv.casting');
});

Route::get('/cv/pakuromi.html', function () {
	return view('cv.pakuromi');
});

Route::get('/cv/shunsuketakeuchi.html', function () {
	return view('cv.shunsuketakeuchi');
});

Route::get('/cv/douzaka_kouzou.html', function () {
	return view('cv.douzaka_kouzou');
});

Route::get('/cv/tamurayukari.html', function () {
	return view('cv.tamurayukari');
});

Route::get('/cv/sakura_ayane.html', function () {
	return view('cv.sakura_ayane');
});

Route::get('/cv/kuwahara-yuuki.html', function () {
	return view('cv.kuwahara-yuuki');
});

Route::get('/cv/isobe-keiko.html', function () {
	return view('cv.isobe-keiko');
});

Route::get('/cv/fujitasaki.html', function () {
	return view('cv.fujitasaki');
});

Route::get('/cv/aranamikazusa.html', function () {
	return view('cv.aranamikazusa');
});

Route::get('/WebMoneycp', function () {
	return view('others.webmoneycp');
});

Route::get('/audition', function () {
	return redirect('http://audition.loas.jp/');
});

Route::get('/auditionpf', function () {
	return redirect('http://audition2.loas.jp/');
});

Route::get('/WebMoneycp_ministop', function () {
	return view('others.webmoneycp_ministop');
});

Route::get('/100k_festa', 'CampaignController@showHTfesta');

Route::get('/Mumucp', 'Minigame\MumucpController@showMumucp');
Route::post('/Mumucp_play', 'Minigame\MumucpController@playMumucp');

Route::get('/venuscp', 'Minigame\VenuscpController@show');
Route::post('/venuscp_post', 'Minigame\VenuscpController@post');
Route::get('/venuscp_exchangePage', 'Minigame\VenuscpController@showExchangePage');
Route::post('/venuscp_exchange', 'Minigame\VenuscpController@exchange');

Route::get('/campaign_{pageName?}', 'CampaignController@pageView');

Route::get('/minigame_{gameName?}', 'Minigame\CommonController@gameView');

Route::group(['prefix' => 'minigame'], function () {
	Route::group(['prefix' => 'highAndLow'], function () {
		Route::post('/bet', 'Minigame\HighAndLowController@highAndLowBet');
		Route::post('/result', 'Minigame\HighAndLowController@highAndLowResult');
	});

	Route::group(['prefix' => 'sugoroku'], function () {
		Route::get('/top', 'Minigame\SugorokuController@showTop');
		Route::post('/play', 'Minigame\SugorokuController@play');
		Route::post('/giveBoxItem', 'Minigame\SugorokuController@giveBoxItem');
		Route::post('/history', 'Minigame\SugorokuController@history');
	});

	Route::group(['prefix' => 'questionnaire'], function () {
		Route::post('/play', 'Minigame\QuestionnaireController@playQuestionnaire');
	});

	Route::group(['prefix' => 'gacha'], function () {
		Route::any('/top', 'Minigame\GachaController@mumuRoom');
		Route::any('/showGame', 'Minigame\GachaController@showGacha');
		Route::post('/play', 'Minigame\GachaController@playGacha');
	});

	Route::group(['prefix' => 'mumuletter'], function () {
		Route::get('/top', 'Minigame\MumuLetterController@showTop');
		Route::post('/answer', 'Minigame\MumuLetterController@answer');
	});

	Route::post('/fetchUP', 'Minigame\CommonController@fetchUserPoint');
	Route::post('/fetchSList', 'Minigame\CommonController@fetchServerList');
	Route::post('/history', 'Minigame\CommonController@getHistory');
});

if (env('APP_ENV') != 'prod') {
	Route::get('/minigame/sugoroku/test', 'Minigame\SugorokuController@test');
	Route::get('/minigame/gacha/test', function () {return view('minigame.gacha_tester');});
	Route::get('/gachaTest.html', function () {return view('minigame.gachaTest');});
}
