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