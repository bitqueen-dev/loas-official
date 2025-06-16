
BasicGame.MainMenu = function (game) {

	this.cylinderBasePosX;
	this.cylinderBasePosY;
	this.cursor;
	this.historyBtn;
	this.historyPanel;
	this.closeBtn;
	this.headText;
	this.bodyText;
	this.panelPos;
	this.history;
	this.viewHistoryCount = 0;
	this.mainBtns;
	this.allowRightBtn;
	this.allowLeftBtn;
	this.selectViewGroup;
	this.character;
	this.words;
	this.selectSId;

};

BasicGame.MainMenu.prototype = {

	create: function () {

		// Create first view

		// show background
		this.add.sprite(0, 0, 'bg_1');

		// set invisible cursor
		this.cursor = this.add.sprite(0, 0, 'cursor');
		this.cursor.visible = false;

		// show character
		this.character = this.add.sprite(0, this.game.height/2, 'characterNormal');
		this.words = this.add.sprite(this.game.width/2 -100 , this.game.height/2 + 150, 'wordsLetsStart');

		// show buttons
		this.cylinderBasePosX = this.game.width / 4;
		this.cylinderBasePosY = this.game.height - 250;

		var cylinder_10 = this.add.button(this.cylinderBasePosX, this.cylinderBasePosY, 'cylinder_10', this.selectView, this);
		cylinder_10.onInputOver.add(this.hover, this);
		cylinder_10.onInputOut.add(this.hoverOut, this);

		var cylinder_50 = this.add.button(this.cylinderBasePosX * 2, this.cylinderBasePosY, 'cylinder_50', this.selectView, this);
		cylinder_50.onInputOver.add(this.hover, this);
		cylinder_50.onInputOut.add(this.hoverOut, this);

		var cylinder_100 = this.add.button(this.cylinderBasePosX * 3, this.cylinderBasePosY, 'cylinder_100', this.selectView, this);
		cylinder_100.onInputOver.add(this.hover, this);
		cylinder_100.onInputOut.add(this.hoverOut, this);

		this.historyBtn = this.add.button(30, this.cylinderBasePosY, 'historyBtn', this.historyView, this);
		this.historyBtn.frame = 1;
		this.historyBtn.onInputOver.add(this.hover, this);
		this.historyBtn.onInputOut.add(this.hoverOut, this);

		this.mainBtns = this.add.group();
		this.mainBtns.add(cylinder_10);
		this.mainBtns.add(cylinder_50);
		this.mainBtns.add(cylinder_100);
		this.mainBtns.add(this.historyBtn);
		this.mainBtns.add(this.cursor);

		// serverSelect
		this.serverSelectView();

	},

	serverSelectView: function () {
		this.mainBtns.setAll('inputEnabled', false);

		var panelPos = 100;

		var textStyle = { font: "bold 32px メイリオ", fill: "#000"};

		var sBtn = {};
		var serverContents = this.add.group();

		var serverSelectPanel = this.add.sprite(panelPos, panelPos, 'whitePanel');
		serverSelectPanel.scale.setTo(1, 1.2);
		serverContents.add(serverSelectPanel);

		var btnPosX = panelPos + serverSelectPanel.width / 2;
		var btnPosY = panelPos + 70;

		var titleText = this.add.text(btnPosX, btnPosY, "アイテムを付与するキャラクターがいる\nサーバーを選んでください。", textStyle);
		titleText.anchor.setTo(0.5);
		serverContents.add(titleText);

		btnPosY = btnPosY + 100;

		for (var serverId in this.game.serverInfo) {
			var serverInfo = this.game.serverInfo[serverId];

			sBtn[serverId] = null;

			sBtn[serverId] = this.add.button(btnPosX, btnPosY, 'serverListOff', function (pointer) {

				this.selectSId = pointer.serverId;
				this.game.serverId = pointer.serverId;
				serverContents.destroy();
				this.mainBtns.setAll('inputEnabled', true);

			}, this);

			sBtn[serverId].onInputOver.add(function (pointer) {
				sBtn[pointer.serverId].loadTexture('serverListOn');
			}, this);

			sBtn[serverId].onInputOut.add(function (pointer) {
				sBtn[pointer.serverId].loadTexture('serverListOff');
			}, this);

			sBtn[serverId].scale.setTo(1.5);
			sBtn[serverId].anchor.setTo(0.5);

			sBtn[serverId].serverId = serverId;

			var worldNameText = this.add.text(btnPosX, btnPosY, serverInfo.serverName, textStyle);
			var characterNameText = this.add.text(btnPosX, btnPosY + 60, "キャラクター名： " + serverInfo.userName, textStyle);

			worldNameText.anchor.setTo(0.5);
			characterNameText.anchor.setTo(0.5);

			serverContents.add(sBtn[serverId]);
			serverContents.add(worldNameText);
			serverContents.add(characterNameText);

			btnPosY = btnPosY + 120;
		}

	},

	hover: function(pointer) {

		switch (pointer.key){
			case 'cylinder_10':
				this.cursor.x = this.cylinderBasePosX + 60;
				this.cursor.y = this.cylinderBasePosY - 110;
				this.cursor.visible = true;

				break;

			case 'cylinder_50':
				this.cursor.x = this.cylinderBasePosX * 2 + 60;
				this.cursor.y = this.cylinderBasePosY - 110;
				this.cursor.visible = true;

				break;

			case 'cylinder_100':
				this.cursor.x = this.cylinderBasePosX * 3 + 60;
				this.cursor.y = this.cylinderBasePosY - 110;
				this.cursor.visible = true;

				break;

			default:
				pointer.alpha = 0.5;
		}

	},

	hoverOut: function (pointer) {

		this.cursor.visible = false;
		pointer.alpha = 1;

	},

	selectView: function (pointer) {

		this.mainBtns.setAll('inputEnabled', false);

		this.selectViewGroup = this.add.group();

		switch (pointer.key){
			case 'cylinder_10':
				this.game.pointId = 10;

				break;

			case 'cylinder_50':
				this.game.pointId = 50;

				break;

			case 'cylinder_100':
				this.game.pointId = 100;

				break;

			default:
				this.game.pointId = 0;
		}

		var panelXPos = this.game.width/2;
		var panelYPos = this.game.height/2 - 100;

		var selectPanel = this.add.sprite(panelXPos, panelYPos, 'selectPanel');

		selectPanel.anchor.setTo(0.5);
		selectPanel.scale.setTo(1, 1.2);

	    var style = { font: "bold 48px メイリオ", fill: "#000"};
	    var selectText = this.add.text(panelXPos, panelYPos - 45, '本当にプレイしますか？', style);

	    selectText.anchor.setTo(0.5);

	    var yesBtn = this.add.button(panelXPos - 150, panelYPos + 35, 'yesBtn', this.start, this);
		var noBtn = this.add.button(panelXPos + 150, panelYPos + 35, 'noBtn', this.closeSelect, this);

		yesBtn.anchor.setTo(0.5);
		noBtn.anchor.setTo(0.5);

		yesBtn.onInputOver.add(this.hover, this);
		yesBtn.onInputOut.add(this.hoverOut, this);

		noBtn.onInputOver.add(this.hover, this);
		noBtn.onInputOut.add(this.hoverOut, this);

		this.selectViewGroup.add(selectPanel);
		this.selectViewGroup.add(selectText);
		this.selectViewGroup.add(yesBtn);
		this.selectViewGroup.add(noBtn);

	},

	closeSelect: function () {

		this.selectViewGroup.destroy();

		this.cursor.visible = false;

		this.mainBtns.setAll('inputEnabled', true);

	},

	start: function (pointer) {
		pointer.inputEnabled = false;

		// ajax: subtract point & play game
		var self = this;
		this.subPoint(this.game.pointId, this.game.gameId, this.selectSId).then(function (response) {

			self.game.itemName = response.itemName;
			self.game.itemImg = response.itemImg;
			self.game.againFlag = response.againFlag;
			self.game.worth = response.worth;

			// show play scene
			return self.state.start('Play');

		// ajax Error
		}, function (errWords) {
			self.mainBtns.setAll('inputEnabled', false);

			self.character.destroy();
			self.words.destroy();
			self.selectViewGroup.destroy();

			if (errWords != 'wordsNoPoint') {
				errWords = 'wordsError';
			}

			// show character
			self.add.sprite(0, self.game.height/2, 'characterCry');
			self.add.sprite(self.game.width/2 -100 , self.game.height/2 + 150, errWords);

			// reload this page
			self.input.onDown.add(self.closeErrorView, self);

		});
	},

	subPoint: function (pointId, gId, sId) {

		return $.ajax({

			method: "POST",
			url: "/minigame_fireworks/play",
			data: {
				pointId: pointId,
				sId: sId,
				gId: gId
			},
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,

		}).then(function (response) {
			// console.log(response);
			if((response.status === false) && (response.code == -9)) {

				return $.Deferred().reject('wordsNoPoint').promise();

			}

			if((response.status === true) && (response.code == 0)) {

				return $.Deferred().resolve(response).promise();

			}

			return $.Deferred().reject('wordsError').promise();

		}).fail(function (jqXHR, textStatus, errorThrown) {
			// console.log(jqXHR, textStatus, errorThrown);
			if (textStatus == null) {
				return jqXHR;

			} else {
				return 'wordsError';

			}

		});
	},

	historyView: function (pointer) {

		this.mainBtns.setAll('inputEnabled', false);

		// If it already gets history, it does not ajax
		if (this.history) {

			return this.genHistoryText(this.history).then(function(){ /* succ */ });

		} else {

			// ajax: fetch history data
			var self = this;
			this.fetchHistory().then(function (history) {

				return self.genHistoryText(history);

			}).then(function () {

				/* succ */

			// ajax Error
			}, function (errWords) {

				self.mainBtns.setAll('inputEnabled', false);

				self.character.destroy();
				self.words.destroy();

				// show character
				self.add.sprite(0, self.game.height/2, 'characterCry');
				console.log(errWords);
				self.add.sprite(self.game.width/2 -100 , self.game.height/2 + 150, 'wordsError');

				// reload this page
				self.input.onDown.add(self.closeErrorView, self);

			});

		}
	},

	closeHistoryView: function () {

		this.closeBtn.destroy();
		this.historyPanel.destroy();
		this.headText.destroy();
		this.bodyText.destroy();

		this.historyBtn.alpha = 1;
		this.cursor.visible = false;

		if (this.allowRightBtn) {
			this.allowRightBtn.destroy();
		}

		if (this.allowLeftBtn) {
			this.allowLeftBtn.destroy();
		}

		this.viewHistoryCount = 0;

		this.mainBtns.setAll('inputEnabled', true);

	},

	genHistoryText: function (history) {
		this.history = history;
		this.panelPos = 100;

		this.historyPanel = this.add.sprite(this.panelPos, this.panelPos, 'whitePanel');
		this.historyPanel.alpha = 0;

		var panelTween = this.add.tween(this.historyPanel);
		panelTween.to( { alpha: 1 }, 1000, Phaser.Easing.Circular.Out, true);
		panelTween.onComplete.add(function () {

			var closeBtnXPos = this.panelPos + this.historyPanel.width - 100;
		    var closeBtnYPos = this.panelPos + 30;

		    this.closeBtn = this.add.button(closeBtnXPos, closeBtnYPos, 'closeBtn', this.closeHistoryView, this);

		    this.genHistoryContents();

		}, this);

		return $.Deferred().resolve().promise();
	},

	genHistoryContents: function (pointer) {

	    var allowRightBtnXPos = this.panelPos + this.historyPanel.width - 100;
	    var allowLeftBtnXPos = this.panelPos + 100;
	    var allowRightBtnYPos = this.panelPos + this.historyPanel.height - 100;
	    var allowLeftBtnYPos = this.panelPos + this.historyPanel.height - 40;

	    var viewPerPage = 20;

		if (pointer && pointer.position) {

			this.bodyText.destroy();
			this.headText.destroy();

			if (this.allowRightBtn) {
				this.allowRightBtn.destroy();
			}

			if (this.allowLeftBtn) {
				this.allowLeftBtn.destroy();
			}

			if (pointer.position.x > this.game.width/2) {
				// right click
				this.viewHistoryCount = this.viewHistoryCount + viewPerPage;
				var viewHistory = this.history.slice(this.viewHistoryCount, this.viewHistoryCount + (viewPerPage - 1));

				if ((this.history.length - viewPerPage) > this.viewHistoryCount) {
					this.allowRightBtn = this.add.button(allowRightBtnXPos, allowRightBtnYPos, 'arrow', this.genHistoryContents, this);
				}

				this.allowLeftBtn = this.add.button(allowLeftBtnXPos, allowLeftBtnYPos, 'arrow', this.genHistoryContents, this);
				this.allowLeftBtn.angle = 180;

			}

			if (pointer.position.x < this.game.width/2) {
				// left click
				this.viewHistoryCount = this.viewHistoryCount - viewPerPage;
				var viewHistory = this.history.slice(this.viewHistoryCount, this.viewHistoryCount + (viewPerPage - 1));

				this.allowRightBtn = this.add.button(allowRightBtnXPos, allowRightBtnYPos, 'arrow', this.genHistoryContents, this);

				if (0 < this.viewHistoryCount) {
					this.allowLeftBtn = this.add.button(allowLeftBtnXPos, allowLeftBtnYPos, 'arrow', this.genHistoryContents, this);
					this.allowLeftBtn.angle = 180;
				}

			}

		} else {

			var viewHistory = this.history.slice(this.viewHistoryCount, this.viewHistoryCount + (viewPerPage - 1));

			if (this.history.length > viewPerPage) {

				this.allowRightBtn = this.add.button(allowRightBtnXPos, allowRightBtnYPos, 'arrow', this.genHistoryContents, this);

			}

		}

	    var style = { font: "bold 24px メイリオ", fill: "#000", tabs: [100, 280]};
	    var headings = ['【ﾎﾟｲﾝﾄ】', '【賞品】', '【日付】'];

	    var textXPos = this.panelPos + 30;
	    var headerTextYPos = this.panelPos + 150;
	    var bodyTextYPos = headerTextYPos + 60;

	    this.headText = this.add.text(textXPos, headerTextYPos, '', style);
	    this.headText.parseList(headings);

	    var swords = [];
	    for (var key in viewHistory) {
	    	var pushData = [];
	    	pushData.push(viewHistory[key].point);
	    	pushData.push(viewHistory[key].itemName);
	    	pushData.push(viewHistory[key].createdAt);
	    	swords.push(pushData);
	    }

	    this.bodyText = this.add.text(textXPos, bodyTextYPos, '', style);
	    this.bodyText.parseList(swords);
	},

	fetchHistory: function () {

		return $.ajax({

			method: "POST",
			url: "/minigame_fireworks/history",
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,

		}).then(function (response) {

			if((response.status === true) && (response.code == 0) && response.history) {
				return $.Deferred().resolve(response.history).promise();
			}

			return $.Deferred().reject('wordsError').promise();

		}).fail(function (jqXHR, textStatus, errorThrown) {

			if (textStatus == null) {
				return jqXHR;
			} else {
				return 'wordsError';
			}

		});
	},

	closeErrorView: function () {

		return location.reload();

	}

};
