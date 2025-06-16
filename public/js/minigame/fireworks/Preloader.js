BasicGame.Preloader = function (game) {

	this.loading = null;

};

BasicGame.Preloader.prototype = {

  preload: function () {

    // Loading
	this.loading = this.add.sprite(this.game.width/2, this.game.height/2, 'loading');
	this.loading.anchor.setTo(0.5, 0.5);

	var loadingAnim = this.loading.animations.add('loading');
	loadingAnim.play(8, true);

    // Cross-Origin Resource Sharing
    this.load.crossOrigin = "Anonymous";

    // Load game assets here...

    this.load.image('bg_1', 'images/minigame/bg1.png');
    this.load.image('bg_2', 'images/minigame/bg2.png');

    this.load.image('serverListOff', '//ap-statics.loas.jp/mm2/official/images/server_list_normal_off.png');
    this.load.image('serverListOn', '//ap-statics.loas.jp/mm2/official/images/server_list_normal_on.png');

    this.load.image('cursor', 'images/minigame/cursor.png');
    this.load.image('cylinder_10', 'images/minigame/gacha_10point.png');
    this.load.image('cylinder_50', 'images/minigame/gacha_50point.png');
    this.load.image('cylinder_100', 'images/minigame/gacha_100point.png');

    this.load.image('historyBtn', 'images/minigame/historyBtn.png');

    this.load.image('characterCry', 'images/minigame/character_cry.png');
    this.load.image('characterNormal', 'images/minigame/character_normal.png');
    this.load.image('characterSmile', 'images/minigame/character_smile.png');

    this.load.image('wordsAgain', 'images/minigame/words_again.png');
    this.load.image('wordsCongratulations', 'images/minigame/words_congratulations.png');
    this.load.image('wordsNoPoint', 'images/minigame/words_nopoint.png');
    this.load.image('wordsLetsStart', 'images/minigame/words_pressbutton.png');
    this.load.image('wordsUnluck', 'images/minigame/words_unluck.png');
    this.load.image('wordsError', 'images/minigame/words_error.png');

    this.load.image('giftGold', 'images/minigame/gift_gold.png');
    this.load.image('giftSilver', 'images/minigame/gift_silver.png');

    this.load.image('ball', 'images/minigame/ball.png');
    this.load.atlasJSONHash('firework', 'images/minigame/firework.png', 'images/minigame/firework.json');

    this.load.image('congratulationsText', 'images/minigame/result_congratulations.png');
    this.load.image('unfortunateText', 'images/minigame/result_unluck.png');
    this.load.image('againText', 'images/minigame/result_again.png');

    this.load.image('selectPanel', 'images/minigame/selectPanel.png');
    this.load.image('yesBtn', 'images/minigame/yesBtn.png');
    this.load.image('noBtn', 'images/minigame/noBtn.png');

    this.load.image('whitePanel', 'images/minigame/whitePanel.png');
    this.load.image('arrow', 'images/minigame/arrow.png');
    this.load.image('closeBtn', 'images/minigame/closeBtn.png');

    this.load.image('restartBtnOff', 'images/minigame/restartBtnOff.png');
    this.load.image('restartBtnOn', 'images/minigame/restartBtnOn.png');
    this.load.image('toTopBtnOff', 'images/minigame/toTopBtnOff.png');
    this.load.image('toTopBtnOn', 'images/minigame/toTopBtnOn.png');

    for (var i = 1; i <= 25; i++) {
    	var num = ("00" + i).slice(-2);
    	this.load.image('itemImg1' + num, 'images/minigame/items/itemImg1' + num + '.png');
    }

    // global variable

    this.game.itemName;
	this.game.itemImg;
	this.game.againFlag;
	this.game.worth;
	this.game.pointId;
	this.game.serverId;
	this.game.serverInfo;
	this.game.gameId = gameId;

  },

  create: function () {

	  var self = this;

	  this.fetchSeverInfos().then(function (response) {

		  if (response && response.data.serverInfo) {
			  self.game.serverInfo = response.data.serverInfo;

			  self.state.start('MainMenu');
		  } else {
			  self.loading.visible = false;

			  var style = { font: "bold 48px メイリオ", fill: "#ffffff"};
			  var errorText = self.add.text(self.game.width/2, self.game.height/2, 'キャラクターを作成してください。', style);
			  errorText.anchor.setTo(0.5, 0.5);

				// reload this page
				self.input.onDown.add(function () {
					return window.location.href = 'http://www.loas.jp/';
				}, self);
		  }

	  });

  },

  fetchSeverInfos: function () {
	  var gId = this.game.gameId;
	  //return $.Deferred().resolve(false).promise();

	  return $.ajax({
		  method: "POST",
		  url: "/minigame_fireworks/fetchSList",
		  data: {
			  gId: gId,
		  },
		  type: "json",
		  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		  timeout: 12000,
	  }).then(function (response) {

		  if((response.status === false) && (response.code == -8)) {

			  return $.Deferred().resolve(false).promise();

		  }

		  if((response.status === true) && (response.code == 0) && response.data) {

			  return $.Deferred().resolve(response).promise();

		  }

		  return $.Deferred().reject('wordsError').promise();

	  }).fail(function (jqXHR, textStatus, errorThrown) {

		  return false;
	  });

  }

};
