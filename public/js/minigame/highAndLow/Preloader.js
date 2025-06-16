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

	    var root = '//ap-statics.loas.jp/mm2/official/images/minigame/';
	    //var root = 'images/minigame/';

	    // Load game assets here...
	    this.load.image('bg', root + 'highAndLow/bg.png');
	    this.load.atlasJSONHash('cards', root + 'highAndLow/cards.png', 'images/minigame/highAndLow/cards.json');
	    this.load.image('characterCry', root + 'highAndLow/character_cry.png');
	    this.load.image('characterNormal', root + 'highAndLow/character_normal.png');
	    this.load.image('characterSmile', root + 'highAndLow/character_smile.png');
	    this.load.image('closeBtn', root + 'closeBtn.png');
	    this.load.image('cursor', root + 'highAndLow/cursor.png');

	    this.load.image('highBtnOff', root + 'highAndLow/highBtnOff.png');
	    this.load.image('highBtnOn', root + 'highAndLow/highBtnOn.png');

	    this.load.image('howToBtnOff', root + 'highAndLow/howToBtnOff.png');
	    this.load.image('howToBtnOn', root + 'highAndLow/howToBtnOn.png');
	    this.load.image('howToPanel', root + 'highAndLow/howToPanel.png');

	    this.load.image('lowBtnOff', root + 'highAndLow/lowBtnOff.png');
	    this.load.image('lowBtnOn', root + 'highAndLow/lowBtnOn.png');

	    this.load.image('restartBtnOff', root + 'restartBtnOff.png');
	    this.load.image('restartBtnOn', root + 'restartBtnOn.png');
	    this.load.image('toTopBtnOff', root + 'highAndLow/toTopBtnOff.png');
	    this.load.image('toTopBtnOn', root + 'highAndLow/toTopBtnOn.png');

	    this.load.image('resultLose', root + 'highAndLow/resultLose.png');
	    this.load.image('resultWin', root + 'highAndLow/resultWin.png');

	    this.load.image('startBtnOff', root + 'highAndLow/startBtnOff.png');
	    this.load.image('startBtnOn', root + 'highAndLow/startBtnOn.png');

	    this.load.image('wordError', root + 'highAndLow/wordError.png');
	    this.load.image('wordLose', root + 'highAndLow/wordLose.png');
	    this.load.image('wordNoPoint', root + 'highAndLow/wordNoPoint.png');
	    this.load.image('wordReady', root + 'highAndLow/wordReady.png');
	    this.load.image('wordWin', root + 'highAndLow/wordWin.png');

	    // global variable
		this.game.gameId = gameId;
		this.game.userPoint = 0;
		this.game.pointId = 5;

		$('[name=selectPoint]').val(5);

	},

	create: function () {
		var self = this;

		this.fetchUserPoint().then(function (response) {
			if (response.up >= 0) {
				self.game.userPoint = response.up;

				self.state.start('Play');
			} else {
				self.errView();
			}
		}, function (err) {
			self.errView();
		});

		$('[name=selectPoint]').change(function() {
		    var val = $('[name=selectPoint]').val();
		    self.game.pointId = val;
		});
	},

	fetchUserPoint: function () {
		var gId = this.game.gameId;

		return $.ajax({
			method: "POST",
			url: "/minigame/fetchUP",
			data: {
				gId: gId,
			},
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (response) {

			if((response.status === true) && (response.code == 0)) {

				return $.Deferred().resolve(response).promise();

			}

			return $.Deferred().reject().promise();

		});
	},

	errView: function () {
		this.loading.visible = false;

		var style = { font: "bold 48px メイリオ", fill: "#ffffff"};
		var errorText = this.add.text(this.game.width/2, this.game.height/2, 'サーバーエラーです。\n時間をおいてから再度お試しください。', style);
		errorText.anchor.setTo(.5);

		// reload this page
		this.input.onDown.add(function () {
			return window.location.href = '/';
		}, this);
	}
};
