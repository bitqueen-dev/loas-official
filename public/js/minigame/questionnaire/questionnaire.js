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
BasicGame.Play = function () {};
BasicGame.Play.prototype = {
	init: function () {
		this.CanvasContainer = null;
		this.selectedBtnKey = null;
		this.dataURL = null;
		this.bgSprite = null;
		this.btnGroup = null;
		this.panelGroup = null;
	},

	create: function () {
		this.bgSprite = this.genBackground();
		this.genBtnContainer();
		this.CanvasContainer = this.genCanvasContainer();
		this.genPointTextSprite();
		this.genTextArea();
	},

	genBackground: function () {
		var sprite = this.add.sprite(this.world.centerX, this.world.centerY, 'PlayBG');
		sprite.anchor.setTo(.5);
		return sprite;
	},

	genBtnContainer: function () {
		this.btnGroup = this.add.group();
		this.genCoinBtn();
		this.genPointBtn();
		this.genBackBtn();
		this.genResetBtn();
	},

	genCoinBtn: function () {
		var btnSprite = this.add.button(this.world.centerX/2, this.world.height-350, 'CoinBtn', function () {
			this.genPanelContainer(btnSprite.key, function () {
				this.btnGroup.setAll('inputEnabled', false);
				this.panelGroup.setAll('inputEnabled', false);
				this.selectedBtnKey = btnSprite.key;
				this.play();
			});
		}, this);
		btnSprite.anchor.setTo(.5);
		this.btnGroup.add(btnSprite);
	},

	genPointBtn: function () {
		var btnSprite = this.add.button(this.world.centerX/2*3, this.world.height-350, 'PointBtn', function () {
			this.genPanelContainer(btnSprite.key, function () {
				this.btnGroup.setAll('inputEnabled', false);
				this.panelGroup.setAll('inputEnabled', false);
				this.selectedBtnKey = btnSprite.key;
				this.play();
			});
		}, this);
		btnSprite.anchor.setTo(.5);
		this.btnGroup.add(btnSprite);
	},

	genBackBtn: function () {
		var btnSprite = this.add.button(this.world.centerX/2, this.world.height-100, 'BackBtn', function () {
			this.genPanelContainer(btnSprite.key, function () {
				this.state.start('Title');
			});
		}, this);
		btnSprite.anchor.setTo(.5);
		this.btnGroup.add(btnSprite);
	},

	genResetBtn: function () {
		var btnSprite = this.add.button(this.world.centerX/2*3, this.world.height-100, 'ResetBtn', function () {
			this.genPanelContainer(btnSprite.key, function () {
				this.CanvasContainer.clear();
				this.btnGroup.setAll('inputEnabled', true);
				this.panelGroup.destroy();
			});
		}, this);
		btnSprite.anchor.setTo(.5);
		this.btnGroup.add(btnSprite);
	},

	genPanelContainer: function (key, func) {
		this.panelGroup = this.add.group();
		this.btnGroup.setAll('inputEnabled', false);
		var img = 'Panel_CP';
		if (key == 'BackBtn') {
			img = 'Panel_MB';
		} else if (key == 'ResetBtn') {
			img = 'Panel_R';
		}
		var panelSprite = this.add.sprite(this.world.centerX, this.world.centerY+200,img);
		panelSprite.anchor.setTo(.5);
		var y = this.world.centerY+350;
		var yesBtn = this.add.button(this.world.centerX-200,y,'YesBtn',func,this);
		yesBtn.anchor.setTo(.5);
		var noBtn = this.add.button(this.world.centerX+200,y,'NoBtn',function () {
			this.btnGroup.setAll('inputEnabled', true);
			this.panelGroup.destroy();
		}, this);
		noBtn.anchor.setTo(.5);
		this.panelGroup.add(panelSprite);
		this.panelGroup.add(yesBtn);
		this.panelGroup.add(noBtn);
	},

	genCanvasContainer: function () {
		var CanvasContainer = {};
		var canvasX = 71;
		var canvasY = 760;
		var canvasWidth = 830 - canvasX;
		var canvasHeight = 1086 - canvasY;
		var paper = this.make.bitmapData(canvasWidth, canvasHeight);
		paper.addToWorld(canvasX, canvasY);
		paper.x = canvasX;
		paper.y = canvasY;
		var color = 'rgba(121,121,255,1)';
		var fontSize = 5;
		var pen = this.make.bitmapData(canvasWidth, canvasHeight);
		pen.circle(32, 32, fontSize, color);
		this.input.addMoveCallback(function (pointer, pointerX, pointerY) {
			if (pointer.isDown) {
				var penX = pointerX - canvasX - 32;
				var penY = pointerY - canvasY - 32;
				paper.draw(pen, penX, penY);
			}
		}, this);
		CanvasContainer.clear = function () {
			paper.clear();
		};
		CanvasContainer.getPaper = function () {
			return paper;
		};
		return CanvasContainer;
	},

	genPointTextSprite: function () {
		var x = this.world.centerX + 230;
		var y = 135;
		var textStyle = {font:'35px',fill:'#ffffff',stroke:'#6c3a64',strokeThickness:15};
		var text = this.game.global.userPoint;
		var textSprite = this.add.text(x,y,text,textStyle);
		textSprite.anchor.setTo(1);
	},

	genTextArea: function () {
		var gameElem = $('#game');
		var canvasElem = $('canvas');
		var top = canvasElem.height()/4;
		var left = gameElem.width()/2-canvasElem.width()/4;
		var textAreaElem = $('.textArea');
		textAreaElem.css({top:top,left:left});
		textAreaElem.show();
	},

	play: function () {
		var paper = this.CanvasContainer.getPaper();
		var bmd = this.add.bitmapData(paper.width, paper.height);
		this.world.updateTransform();
		bmd.copy(this.bgSprite, paper.x, paper.y);
		bmd.copy(this.CanvasContainer.getPaper());
		var tx = this.make.renderTexture(bmd.width,bmd.height);
		tx.render(bmd.addToWorld(this.world.width,this.world.height));
		this.dataURL = tx.getBase64();
		var self = this;
		this.fetchResult().then(function (res) {
			self.game.global.itemId = res.itemId;
			self.state.start('Result');
		}, function (err) {
			self.errView(err);
		});
	},

	fetchResult: function () {
		var c = this.game.const;
		return $.ajax({
			method: 'POST',
			url: '/minigame/questionnaire/play',
			data: {
				gId: __gId,
				sId: this.game.global.serverId,
				sendText: $('textArea').val(),
				dataURL: this.dataURL,
				payId: this.game.conf.payIds[this.selectedBtnKey],
			},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 10000,
		}).then(function (res) {
			if ((res.status === false) && (res.code == c.REQUEST_ERROR)) { return $.Deferred().reject(c.REQUEST_ERROR).promise(); }
			if ((res.status === false) && (res.code == c.DB_ERROR)) { return $.Deferred().reject(c.DB_ERROR).promise(); }
			if ((res.status === false) && (res.code == c.CLOSED_GAME)) { return $.Deferred().reject(c.CLOSED_GAME).promise(); }
			if ((res.status === false) && (res.code == c.NOT_ENOUGHT_BALANCE)) { return $.Deferred().reject(c.NOT_ENOUGHT_BALANCE).promise(); }
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

BasicGame.Result = function () {};
BasicGame.Result.prototype = {
	init: function () {
		this.btnGroup = null;
		this.panelGroup = null;
	},
	create: function () {
		this.genBackground();
		this.genBtnContainer();
		this.genGiveItemSprite();
		$('.textArea').hide();
	},

	genBackground: function () {
		this.add.sprite(this.world.centerX, this.world.centerY, 'ResultBG').anchor.setTo(.5);
	},

	genBtnContainer: function () {
		this.btnGroup = this.add.group();
		this.genBackBtn();
		this.genTweetBtn();
	},

	genBackBtn: function () {
		var btnSprite = this.add.button(this.world.centerX, this.world.height-350, 'MainBackBtn', function () {
			this.genPanelContainer(btnSprite.key, function () {
				this.state.start('Title');
			});
		}, this);
		btnSprite.anchor.setTo(.5);
		this.btnGroup.add(btnSprite);
	},

	genTweetBtn: function () {
		var btnSprite = this.add.button(this.world.width/4*3, this.world.height-100, 'TweetBtn', function () {
			var item = this.game.conf.items[this.game.global.itemId];
			var text = '#リーグ・オブ・エンジェルズ 公式限定ミニゲーム【神社祈願】で'+item.name+' '+item.count+'個を手に入れました！';
			var tweetText = encodeURIComponent(text);
			var tweetUrl = location.href;
			var tweetHashtags = 'LOA_JP'; // 'A,B,C'
			window.open(
				'https://twitter.com/intent/tweet?text='+tweetText+'&url='+tweetUrl+'&hashtags='+tweetHashtags, 
				'share window', 
				'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600'
			);
			return false;
		}, this);
		btnSprite.anchor.setTo(.5);
		this.btnGroup.add(btnSprite);
	},

	genGiveItemSprite: function () {
		var itemId = this.game.global.itemId;
		var i = this.game.conf.items;
		var itemCount = i[itemId].count;
		var itemName = i[itemId].name;
		var sprite = this.add.sprite(this.world.centerX, this.world.height/4+100, itemId);
		sprite.anchor.setTo(.5);
		sprite.scale.setTo(5);
		var textStyle = {font:'35px',fill:'#ffffff',stroke:'#6c3a64',strokeThickness:15};
		var countTextSprite = this.add.text(sprite.right-20, sprite.bottom, itemCount, textStyle);
		countTextSprite.anchor.setTo(1);
		var nameTextSprite = this.add.text(this.world.centerX, sprite.bottom+50, itemName, textStyle);
		nameTextSprite.anchor.setTo(.5);
	},

	genPanelContainer: function (key, func) {
		this.panelGroup = this.add.group();
		this.btnGroup.setAll('inputEnabled', false);
		var panelSprite = this.add.sprite(this.world.centerX, this.world.centerY+200,'Panel_MB');
		panelSprite.anchor.setTo(.5);
		var y = this.world.centerY+350;
		var yesBtn = this.add.button(this.world.centerX-200,y,'YesBtn',func,this);
		yesBtn.anchor.setTo(.5);
		var noBtn = this.add.button(this.world.centerX+200,y,'NoBtn',function () {
			this.btnGroup.setAll('inputEnabled', true);
			this.panelGroup.destroy();
		}, this);
		noBtn.anchor.setTo(.5);
		this.panelGroup.add(panelSprite);
		this.panelGroup.add(yesBtn);
		this.panelGroup.add(noBtn);
	},
};
BasicGame.Title = function () {};
BasicGame.Title.prototype = {

	init: function () {
		this.PanelContainer = null;
	},

	create: function () {
		this.genBackground();
		this.genServerList();
		this.genBtnContainer();
		this.PanelContainer = this.genPanelContainer();
		$('.textArea').hide();
	},

	genBackground: function () {
		this.add.sprite(this.world.centerX, this.world.centerY, 'TitleBG').anchor.setTo(.5);
	},

	genServerList: function () {
		var self = this;
		__selectServer = function (sid) {
			layer.closeAll();
			self.game.global.serverId = sid;
		};

		var content = '<div class="server_area"><div class="server_list_title"></div><div class="server_area_items">';
		var s = this.game.global.serverInfo;
		for (var sid in s) {
			content += '<div class="server_item" onclick="__selectServer('+sid+')">'+s[sid].serverName+'<br>'+s[sid].userName+'</div>';
		}
		content += '</div></div>';
    	layer.open({
    	    type: 1,
    	    closeBtn: false,
    	    title: false,
    	    shadeClose: false,
    	    skin: 'layui-layer-nobg',
    	    shade: 0.8,
    	    area: ['910px', '610px'],
    	    content: content,
    	});
	},

	genBtnContainer: function () {
		this.genStartBtn();
		this.genItemListBtn();
		this.genHowToBtn();
	},

	genStartBtn: function () {
		var btnSprite = this.add.button(this.world.centerX, this.world.height-350, 'StartBtn', function () {
			this.state.start('Play');
		}, this);
		btnSprite.anchor.setTo(.5);
	},

	genItemListBtn: function () {
		var btnSprite = this.add.button(this.world.width/4, this.world.height-100, 'ItemListBtn', function () {
			this.PanelContainer.show('ItemListPanel');
		}, this);
		btnSprite.anchor.setTo(.5);
	},

	genHowToBtn: function () {
		var btnSprite = this.add.button(this.world.width/4*3, this.world.height-100, 'HowToBtn', function () {
			this.PanelContainer.show('HowToPanel');
		}, this);
		btnSprite.anchor.setTo(.5);
	},

	genPanelContainer: function () {
		var PanelContainer = {};
		var ItemListPanel = this.genItemListPanel();
		var HowToPanel = this.genHowToPanel();
		var CloseBtn = this.genCloseBtn();
		PanelContainer.show = function (key) {
			this.hide();
			var sprite = null;
			if (key == 'ItemListPanel') {
				sprite = ItemListPanel;
			} else if (key == 'HowToPanel') {
				sprite = HowToPanel;
			}
			if (sprite) {
				sprite.visible = true;
				CloseBtn.visible = true;
				CloseBtn.pos(sprite);
			}
		};
		PanelContainer.hide = function () {
			ItemListPanel.visible = false;
			HowToPanel.visible = false;
			CloseBtn.visible = false;
		};
		PanelContainer.hide();
		return PanelContainer;
	},

	genItemListPanel: function () {
		var sprite = this.add.sprite(this.world.centerX, this.world.centerY, 'ItemListPanel');
		sprite.anchor.setTo(.5);
		return sprite;
	},

	genHowToPanel: function () {
		var sprite = this.add.sprite(this.world.centerX, this.world.centerY, 'HowToPanel');
		sprite.anchor.setTo(.5);
		return sprite;
	},

	genCloseBtn: function () {
		var btnSprite = this.add.button(0, 0, 'CloseBtn', function () {
			this.PanelContainer.hide();
		}, this);
		btnSprite.anchor.setTo(.5);
		btnSprite.pos = function (parentSprite) {
			btnSprite.x = parentSprite.right - 60;
			btnSprite.y = parentSprite.top + 60;
		};
		return btnSprite;
	},
};