
BasicGame.Play = function (game) {

	this.startBtn;
	this.menuBtns;
	this.playBtns;
	this.howToBtns;

	this.playFlag;

	this.upperCardNum;
	this.orderNumber;
	this.p;

	this.upperCard;
	this.lowerCard;

	this.userPointText;

	this.character;
	this.cursor;
	this.characterMessage;

	this.givePoint;

};

BasicGame.Play.prototype = {

	// Create first view
	create: function () {
		var centerX = this.game.width/2;
		var centerY = this.game.height/2;

		this.playFlag = false;

		// show sprites
		this.add.sprite(0, 0, 'bg');

		this.character = this.add.sprite(0, this.game.height, 'characterNormal');
		this.character.anchor.setTo(0, 1);

		this.characterMessage = this.add.sprite(385, 1230, 'wordReady');
		this.characterMessage.visible = false;

		// hover cursor
		this.cursor = this.add.sprite(centerX - 250, this.game.height/2, 'cursor');
		this.cursor.anchor.setTo(.5);
		this.cursor.visible = false;

		// show text
		var textStyle = { font: "bold 32px メイリオ", fill: "#000"};
		this.userPointText = this.add.text(this.game.width - 30, 30, this.game.userPoint + "ポイント", textStyle);
		this.userPointText.anchor.setTo(1, 0);

		// show buttons
		var toTopBtn = this.add.button(30, 30, 'toTopBtnOff', function () {
			return location.href = '/';
		}, this);

		var howToBtn = this.add.button(this.game.width - 30, this.game.height - 50, 'howToBtnOff', this.showHowToPanel, this);
		howToBtn.anchor.setTo(1);

		var lowBtn = this.add.button(centerX - 300, centerY + 150, 'lowBtnOff', this.gamePlay, this);
		lowBtn.anchor.setTo(.5);

		var highBtn = this.add.button(centerX + 300, centerY + 150, 'highBtnOff', this.gamePlay, this);
		highBtn.anchor.setTo(.5);

		// set button group
		this.menuBtns = this.add.group();
		this.menuBtns.add(toTopBtn);

		this.playBtns = this.add.group();
		this.playBtns.add(lowBtn);
		this.playBtns.add(highBtn);

		this.howToBtns = this.add.group();
		this.howToBtns.add(howToBtn);

		this.playBtns.setAll('inputEnabled', false);

		// start button
		this.startBtn = this.add.button(centerX, centerY, 'startBtnOff', this.gameStart, this);
		this.startBtn.anchor.setTo(.5);

		// set hover action
		this.setHoverBtns();

	},

	gameStart: function () {
		$("select[name='selectPoint']").attr("disabled", true);
		this.menuBtns.setAll('inputEnabled', false);
		this.startBtn.visible = false;
		this.playFlag = true;
		this.cursor.visible = false;

		this.character.loadTexture('characterNormal');
		this.characterMessage.loadTexture('wordReady');
		this.characterMessage.visible = true;

		var self = this;
		this.bet().then(function (response) {
			if (0 <= response.cn && response.cn <= 12) {
				self.game.userPoint = response.up;
				self.userPointText.setText(self.game.userPoint + "ポイント");

				self.upperCardNum = response.cn;
				self.orderNumber = response.o;
				self.p = response.p;

				self.gameScene();
			} else {
				self.errView();
			}
		}, function (err) {
			self.errView(err);
		});

	},

	gamePlay: function (pointer) {
		this.playBtns.setAll('inputEnabled', false);

		for (var key in this.playBtns.children) {
			if (this.playBtns.children[key].key == "lowBtnOn") {
				this.playBtns.children[key].loadTexture('lowBtnOff');
			} else if (this.playBtns.children[key].key == "highBtnOn") {
				this.playBtns.children[key].loadTexture('highBtnOff');
			}
		}

		var r =  rand(1, 100);

		if (r <= this.p) {
			var result = "win";
			if (pointer.key == "highBtnOff") {
				var lowerCardNum = rand(this.upperCardNum + 1, 12);
			} else {
				var lowerCardNum = rand(0, this.upperCardNum - 1);
			}
		} else {
			var result = "lose";
			if (pointer.key == "highBtnOff") {
				var lowerCardNum = rand(0, this.upperCardNum - 1);
			} else {
				var lowerCardNum = rand(this.upperCardNum + 1, 12);
			}
		}

		var flipTweenFront = this.add.tween(this.lowerCard.scale);
		flipTweenFront.to({ x: 1 }, 500, Phaser.Easing.Linear.None, false, 0);

		var flipTweenBack = this.add.tween(this.lowerCard.scale);
		flipTweenBack.to({ x: 0 }, 500, Phaser.Easing.Linear.None, false, 0);

		flipTweenFront.onComplete.addOnce(function () {

			this.playFlag = false;
			this.result(result);

		}, this);

		flipTweenBack.onComplete.addOnce(function () {

			this.lowerCard.frame = lowerCardNum;

		}, this);

		flipTweenBack.chain(flipTweenFront);
		flipTweenBack.start();

		function rand(min, max) {
			return Math.floor(Math.random() * (max + 1 - min)) + min;
		}

	},

	result: function (result) {
		var self = this;
		this.resultPost(result).then(function (response) {
			self.game.userPoint = response.up;
			self.givePoint = response.gp;
			self.userPointText.setText(self.game.userPoint + "ポイント");

			self.resultView(result);
		}, function (err) {
			self.errView();
		});
	},

	resultView: function (result) {
		$("select[name='selectPoint']").removeAttr("disabled");
		this.menuBtns.setAll('inputEnabled', true);

		var centerX = this.game.width/2;
		var centerY = this.game.height/2;

		if (result == "win") {
			var resultSprite = this.add.sprite(centerX, centerY - 400, 'resultWin');

			this.character.loadTexture('characterSmile');
			this.characterMessage.loadTexture('wordWin');

			var textStyle = { font: "bold 32px メイリオ", fill: "#ff0000"};
			var givePoint = this.add.text(this.userPointText.x, this.userPointText.y, "+" + this.givePoint + "ポイント", textStyle);
			givePoint.anchor.setTo(1, 0);

			var pointTween = this.add.tween(givePoint);
			pointTween.to({ y: this.userPointText.y + 50 }, 1000, Phaser.Easing.Linear.None, true, 0);

			pointTween.onComplete.addOnce(function () {

				givePoint.destroy();

			}, this);

		} else {
			var resultSprite = this.add.sprite(centerX, centerY - 400, 'resultLose');

			this.character.loadTexture('characterCry');
			this.characterMessage.loadTexture('wordLose');

		}
		resultSprite.anchor.setTo(.5);

		var restartBtn = this.add.button(centerX, centerY, 'restartBtnOff', restartBtnClick, this);
		restartBtn.anchor.setTo(.5);

		restartBtn.onInputOver.add(function () {
			restartBtn.loadTexture('restartBtnOn');
		}, this);
		restartBtn.onInputOut.add(function () {
			restartBtn.loadTexture('restartBtnOff');
		}, this);

		function restartBtnClick () {
			this.upperCard.destroy();
			this.lowerCard.destroy();
			resultSprite.destroy();
			restartBtn.destroy();

			this.gameStart();
		}
	},

	resultPost: function (res) {
		var gId = this.game.gameId;
		var pId = this.game.pointId;
		var oNum = this.orderNumber;

		return $.ajax({
			method: "POST",
			url: "/minigame/highAndLow/result",
			data: {
				gId: gId,
				pId: pId,
				oNum: oNum,
				res: res
			},
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (response) {

			if((response.status === false) && (response.code == -7)) {

				return $.Deferred().reject('DB_ERROR').promise();

			}

			if((response.status === true) && (response.code == 0)) {

				return $.Deferred().resolve(response).promise();

			}

			return $.Deferred().reject().promise();

		});
	},

	gameScene: function () {
		this.upperCard = this.add.sprite(this.game.width, this.game.height/2-235, 'cards', 13);
		this.upperCard.anchor.setTo(.5);

		this.lowerCard = this.add.sprite(this.game.width, this.game.height/2+175, 'cards', 13);
		this.lowerCard.anchor.setTo(.5);

		var mvTweenUpper = this.add.tween(this.upperCard);
		mvTweenUpper.to({ x: this.game.width/2, angle: 360 }, 1000, Phaser.Easing.Linear.None, true);

		var mvTweenLower = this.add.tween(this.lowerCard);
		mvTweenLower.to({ x: this.game.width/2, angle: 360 }, 1000, Phaser.Easing.Linear.None, true);

		mvTweenUpper.onComplete.addOnce(function () {

			var flipTweenFront = this.add.tween(this.upperCard.scale);
			flipTweenFront.to({ x: 1 }, 500, Phaser.Easing.Linear.None, false, 0);

			var flipTweenBack = this.add.tween(this.upperCard.scale);
			flipTweenBack.to({ x: 0 }, 500, Phaser.Easing.Linear.None, false, 0);

			flipTweenFront.onComplete.addOnce(function () {

				this.playBtns.setAll('inputEnabled', true);

			}, this);

			flipTweenBack.onComplete.addOnce(function () {

				this.upperCard.frame = this.upperCardNum;

			}, this);

			flipTweenBack.chain(flipTweenFront);
			flipTweenBack.start();

		}, this);
	},

	bet: function () {
		var gId = this.game.gameId;
		var pId = this.game.pointId;

		return $.ajax({
			method: "POST",
			url: "/minigame/highAndLow/bet",
			data: {
				gId: gId,
				pId: pId
			},
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (response) {

			if((response.status === false) && (response.code == -7)) {

				return $.Deferred().reject('DB_ERROR').promise();

			}

			if((response.status === false) && (response.code == -9)) {

				return $.Deferred().reject('NOT_ENOUGHT_POINT').promise();

			}

			if((response.status === true) && (response.code == 0)) {

				return $.Deferred().resolve(response).promise();

			}

			return $.Deferred().reject().promise();

		});
	},

	showHowToPanel: function (pointer) {
		this.startBtn.inputEnabled = false;
		this.menuBtns.setAll('inputEnabled', false);
		this.playBtns.setAll('inputEnabled', false);
		this.howToBtns.setAll('inputEnabled', false);

		var howToPanel = this.add.sprite(this.game.width/2, this.game.height/2, 'howToPanel');
		howToPanel.anchor.setTo(.5);

		var textStyle = { font: "bold 32px メイリオ", fill: "#000"};
		var refundText = this.add.text(this.game.width/2-315, this.game.height/2+30, "4", textStyle);
		refundText.anchor.setTo(.5);

		var closeBtn = this.add.button(howToPanel.right, howToPanel.top, 'closeBtn', function () {

			refundText.destroy();
			howToPanel.destroy();
			closeBtn.destroy();

			pointer.loadTexture('howToBtnOff');

			if (this.startBtn.visible) {
				this.startBtn.inputEnabled = true;
				this.menuBtns.setAll('inputEnabled', true);
			} else {
				if (this.playFlag) {
					this.playBtns.setAll('inputEnabled', true);
				} else {
					this.menuBtns.setAll('inputEnabled', true);
				}
			}

			this.howToBtns.setAll('inputEnabled', true);

		}, this);

		closeBtn.anchor.setTo(.5);
	},

	setHoverBtns: function () {

		this.menuBtns.onChildInputOver.add(hoverOver, this);
		this.menuBtns.onChildInputOut.add(hoverOut, this);
		this.playBtns.onChildInputOver.add(hoverOver, this);
		this.playBtns.onChildInputOut.add(hoverOut, this);
		this.howToBtns.onChildInputOver.add(hoverOver, this);
		this.howToBtns.onChildInputOut.add(hoverOut, this);
		this.startBtn.onInputOver.add(hoverOver, this);
		this.startBtn.onInputOut.add(hoverOut, this);

		function hoverOver (pointer) {
			switch (pointer.key) {
				case "toTopBtnOff":
					pointer.loadTexture('toTopBtnOn');
					break;

				case "howToBtnOff":
					pointer.loadTexture('howToBtnOn');
					break;

				case "lowBtnOff":
					pointer.loadTexture('lowBtnOn');
					this.cursor.x = pointer.x + 50;
					this.cursor.visible = true;
					break;

				case "highBtnOff":
					pointer.loadTexture('highBtnOn');
					this.cursor.x = pointer.x + 50;
					this.cursor.visible = true;
					break;

				case "startBtnOff":
					pointer.loadTexture('startBtnOn');
					break;
			}
		}

		function hoverOut (pointer) {
			switch (pointer.key) {
				case "toTopBtnOn":
					pointer.loadTexture('toTopBtnOff');
					break;

				case "howToBtnOn":
					pointer.loadTexture('howToBtnOff');
					break;

				case "lowBtnOn":
					pointer.loadTexture('lowBtnOff');
					this.cursor.visible = false;
					break;

				case "highBtnOn":
					pointer.loadTexture('highBtnOff');
					this.cursor.visible = false;
					break;

				case "startBtnOn":
					pointer.loadTexture('startBtnOff');
					break;
			}
		}
	},

	errView: function (err) {

		$("select[name='selectPoint']").attr("disabled", true);
		this.startBtn.inputEnabled = false;
		this.menuBtns.setAll('inputEnabled', false);
		this.playBtns.setAll('inputEnabled', false);
		this.howToBtns.setAll('inputEnabled', false);

		this.character.loadTexture('characterCry');

		if (err == 'NOT_ENOUGHT_POINT') {
			this.characterMessage.loadTexture('wordNoPoint');
		} else if (err == 'DB_ERROR'){
			console.log('DB_ERROR');
			this.characterMessage.loadTexture('wordError');
		} else {
			console.log('UNKNOWN');
			this.characterMessage.loadTexture('wordError');
		}

		// reload this page
		this.input.onDown.add(function () {
			return window.location.href = '/';
		}, this);

	}

};
