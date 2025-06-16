BasicGame = {};
BasicGame.Boot = function() {};
BasicGame.Boot.prototype = {

	init: function() {
		this.input.maxPointers = 1;
		this.stage.disableVisibilityChange = true;
		this.stage.backgroundColor = '#424242';
		
		this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
		this.scale.fullScreenScaleMode = Phaser.ScaleManager.SHOW_ALL;
		
		this.scale.parentIsWindow = true ;
		
		this.scale.refresh();
	},
	
	preload: function() {
		this.load.crossOrigin = "Anonymous";
		this.load.atlasJSONHash('loading', '//ap-statics.loas.jp/mm2/official/images/minigame/loading.png', 'images/minigame/loading.json');
	},
	
	create: function() {
		this.defineGlobal();
		this.defineConst();
		this.defineConf();
		this.state.start('Preloader');
	},

	defineGlobal: function () {
		this.game.global = {
			serverInfo: null,
			serverId: null,
			itemId: null,
			userPoint: 0,
			errNum: 0,
		};
	},

	defineConst: function () {
		this.game.const = {
			SUCCESS: 0,
			NETWORK_ERROR:       -3,
			DB_ERROR:            -7,
			REQUEST_ERROR:       -8,
			CLOSED_GAME:         -10,
			NOT_ENOUGHT_BALANCE: -5,
			SYSTEM_ERROR:        -2,
			UNKNOWN:             -999,
		};
	},

	defineConf: function () {
		this.game.conf = {
			payIds: {
				CoinBtn:  '96a9519b8fddd17e8cc4bba0408ffffd',
				PointBtn: '78ee54aa8f813885fe2fe20d232518b9',
			},
			items: {
				2301: {count:1 ,img:'01.png',name:'女神の赤印'},
				2302: {count:20,img:'02.png',name:'レーヴラムール(欠片)'},
				2303: {count:1 ,img:'03.png',name:'不朽の宝箱(極小)'},
				2304: {count:5 ,img:'04.png',name:'星のインゴット幸運宝箱'},
				2305: {count:5 ,img:'05.png',name:'生命の葉幸運宝箱'},
				2306: {count:5 ,img:'06.png',name:'宝具刻印石幸運宝箱'},
				2307: {count:1 ,img:'07.png',name:'Goldナゲット(大)'},
				2308: {count:5 ,img:'08.png',name:'使い魔EXPポーション幸運宝箱'},
				2309: {count:1 ,img:'09.png',name:'星屑破片'},
				2310: {count:5 ,img:'10.png',name:'結晶石幸運宝箱'},
				2311: {count:20,img:'11.png',name:'チャチャ(欠片)'},
				2312: {count:10,img:'12.png',name:'龍魂の槍(欠片)'},
				2313: {count:1 ,img:'13.png',name:'使い魔の覚醒水晶'},
			},
		};
	},
};

BasicGame.Error = function() {};
BasicGame.Error.prototype = {
	create: function () {
		$('.textArea').hide();
		this.stage.backgroundColor = '#424242';
		var e = this.game.global.errNum;
		var c = this.game.const;
		switch (e) {
			case c.NETWORK_ERROR: this.genText('ネットワークエラーです。\n再度お試しください。'); break;
			case c.DB_ERROR: this.genText('データベースエラーです。\n再度お試しください。'); break;
			case c.REQUEST_ERROR: this.genText('リクエストエラーです。\n再度お試しください。'); break;
			case c.CLOSED_GAME: this.genText('このゲームのキャンペーン期間は\nすでに終了しています。'); break;
			case c.NOT_ENOUGHT_BALANCE: this.genText('残高不足です。\nご確認の上\n再度お試しください。'); break;
			case c.SYSTEM_ERROR: this.genText('システムエラーです。\n再度お試しください。'); break;
			default: this.genText('不明なエラーです。\n再度お試しください。'); break;
		}
		this.input.onDown.add(function (/*pointer, event*/) {
			return window.location.href = '/';
		}, this);
	},
	genText: function (text) {
		var textStyle = {font:'55px',fill:'#ffffff',stroke:'#000000',strokeThickness:20,align:'center'};
		var textSprite = this.add.text(this.world.centerX,this.world.centerY,text,textStyle);
		textSprite.anchor.setTo(.5);
	},
};