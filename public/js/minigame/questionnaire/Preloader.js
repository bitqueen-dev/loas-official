BasicGame.Preloader = function () {};
BasicGame.Preloader.prototype = {

	preload: function () {
		this.loadingAnim();
		this.loadAssets();
	},

	create: function () {
		var self = this;
		this.fetchServerInfo().then(function (res) {
			self.game.global.serverInfo = res.serverInfo;
			return self.fetchUP();
		}).then(function (res) {
			self.game.global.userPoint = res.up;
			return self.state.start('Title');
		}, function (err) {
			self.errView(err);
		});
	},

	loadingAnim: function () {
		var loadingSprite = this.add.sprite(this.world.centerX, this.world.centerY, 'loading');
		loadingSprite.anchor.setTo(.5);
		loadingSprite.animations.add('loading').play(8, true);
	},

	loadAssets: function () {
	    var ip = '//ap-statics.loas.jp/mm2/official/images/minigame/questionnaire/';

	    this.load.image('StartBtn',    ip+'StartBtn.png');
	    this.load.image('ItemListBtn', ip+'ItemListBtn.png');
	    this.load.image('HowToBtn',    ip+'HowToBtn.png');
	    this.load.image('CloseBtn',    ip+'CloseBtn.png');
	    this.load.image('YesBtn',      ip+'YesBtn.png');
	    this.load.image('NoBtn',       ip+'NoBtn.png');
	    this.load.image('CoinBtn',     ip+'CoinBtn.png');
	    this.load.image('PointBtn',    ip+'PointBtn.png');
	    this.load.image('BackBtn',     ip+'BackBtn.png');
	    this.load.image('ResetBtn',    ip+'ResetBtn.png');
	    this.load.image('MainBackBtn', ip+'MainBackBtn.png');
	    this.load.image('TweetBtn',    ip+'TweetBtn.png');

	    this.load.image('Panel_CP', ip+'Panel_CP.png');
	    this.load.image('Panel_MB', ip+'Panel_MB.png');
	    this.load.image('Panel_R',  ip+'Panel_R.png');

	    this.load.image('TitleBG',       ip+'title.jpg');
	    this.load.image('HowToPanel',    ip+'howto.jpg');
	    this.load.image('ItemListPanel', ip+'itemlist.jpg');
	    this.load.image('PlayBG',        ip+'write.jpg');
	    this.load.image('ResultBG',      ip+'result.jpg');

	    var items = this.game.conf.items;
	    for (var key in items) {
	    	this.load.image(key, ip+items[key].img);
	    }
	},

	fetchServerInfo: function () {
		var c = this.game.const;
		return $.ajax({
			method: 'POST',
			url: '/minigame/fetchSList',
			data: {gId: __gId,},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 12000,
		}).then(function (res) {
			if ((res.status === false) && (res.code == c.REQUEST_ERROR)) { return $.Deferred().reject(c.REQUEST_ERROR).promise(); }
			if ((res.status === true) && (res.code == c.SUCCESS)) { return $.Deferred().resolve(res.data).promise(); }
			return $.Deferred().reject(c.UNKNOWN).promise();
		}).fail(function () {
			return $.Deferred().reject(c.NETWORK_ERROR).promise();
		});
	},

	fetchUP: function () {
		var c = this.game.const;
		return $.ajax({
			method: 'POST',
			url: '/minigame/fetchUP',
			data: {gId: __gId,},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (res) {
			if ((res.status === true) && (res.code == c.SUCCESS)) { return $.Deferred().resolve(res).promise(); }
			return $.Deferred().reject(c.UNKNOWN).promise();
		}).fail(function () {
			return $.Deferred().reject(c.NETWORK_ERROR).promise();
		});
	},

	errView: function (err) {
		this.game.global.errNum = err;
		this.state.start('Error');
	},
};
