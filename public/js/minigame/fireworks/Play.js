
BasicGame.Play = function (game) {
    this.frontLayer;
    this.backLayer;
};

BasicGame.Play.prototype = {

    create: function () {

    	// show background
    	this.add.sprite(0, 0, 'bg_1');

    	// animation ball
    	this.ballTween();

    },

    ballTween: function () {

    	var ball = this.add.sprite(this.game.width/2, this.game.height-100, 'ball');
		ball.scale.setTo(0.2, 0.2);
		ball.anchor.setTo(0.5, 0.5);
		ball.alpha = 0.1;

		var ballTween = this.add.tween(ball);
		ballTween.to({ y: this.game.height/2, alpha: 1 }, 2000, Phaser.Easing.Circular.Out);
		ballTween.onComplete.add(this.bloom, this);
		ballTween.start();

    },

    bloom: function (sprite) {
    	sprite.destroy();

		// set z-index layer
        this.backLayer = this.add.group();
        this.frontLayer = this.add.group();

		// again
    	if (this.game.againFlag) {

    		this.againGame();

    	} else {

    		// unlucky
    		if (this.game.worth == 0) {

    			var resultText = this.add.sprite(this.game.width/2, this.game.height/4, 'unfortunateText');

				var giftBack = this.add.sprite(this.game.width/2, this.game.height/2, 'giftSilver');
				giftBack.anchor.setTo(0.5, 0.5);

				this.backLayer.add(giftBack);

        		// show character
    			var character = this.add.sprite(0, this.game.height/2, 'characterCry');
    			var words = this.add.sprite(this.game.width/2 -100 , this.game.height/2 + 150, 'wordsUnluck');

    		// congratulations
    		} else {

    			// change background
        		var bg_2 = this.add.sprite(0, 0, 'bg_2');
        		this.backLayer.add(bg_2);

    			// animation firework
    	        var firework = this.add.sprite(this.game.width/2, this.game.height/2, 'firework');
    	        firework.anchor.setTo(0.5, 0.5);

    	        var animFirework = firework.animations.add('firework');
    			animFirework.play(9, true);

    			if (this.game.worth == "gold") {

    				var giftBack = this.add.sprite(this.game.width/2, this.game.height/2, 'giftGold');

    			} else {

    				var giftBack = this.add.sprite(this.game.width/2, this.game.height/2, 'giftSilver');

    			}

        		giftBack.anchor.setTo(0.5, 0.5);

        		this.backLayer.add(giftBack);
        		this.backLayer.add(firework);

        		var resultText = this.add.sprite(this.game.width/2, this.game.height/4, 'congratulationsText');

        		// show character
        		var character = this.add.sprite(0, this.game.height/2, 'characterSmile');
        		var words = this.add.sprite(this.game.width/2 -100 , this.game.height/2 + 150, 'wordsCongratulations');

        		var prize = this.add.sprite(this.game.width/2, this.game.height/2, this.game.itemImg);
        		prize.anchor.setTo(0.5, 0.5);
        		prize.scale.setTo(3);

        		this.frontLayer.add(prize);

    		}

    		resultText.anchor.setTo(0.5, 0.5);

    		// show restart button
    		var restartBtn = this.add.button(this.game.width/4, this.game.height*7/8, 'restartBtnOff', this.restart, this);

    		restartBtn.anchor.setTo(0.5, 0.5);

    		restartBtn.onInputOver.add(function (pointer) {
    			restartBtn.loadTexture('restartBtnOn');
    		}, this);

    		restartBtn.onInputOut.add(function (pointer) {
    			restartBtn.loadTexture('restartBtnOff');
    		}, this);

    		// show toTop button
    		var toTopBtn = this.add.button(this.game.width*3/4, this.game.height*7/8, 'toTopBtnOff', function () {
    			toTopBtn.inputEnabled = false;
    			restartBtn.inputEnabled = false;
    			location.reload();
    		}, this);

    		toTopBtn.anchor.setTo(0.5, 0.5);

    		toTopBtn.onInputOver.add(function (pointer) {
    			toTopBtn.loadTexture('toTopBtnOn');
    		}, this);

    		toTopBtn.onInputOut.add(function (pointer) {
    			toTopBtn.loadTexture('toTopBtnOff');
    		}, this);

    		var textStyle = { font: "bold 24px メイリオ", fill: "#000"};
    		var itemName = this.add.text(this.game.width/2, this.game.height/2 -110, this.game.itemName, textStyle);
    		itemName.anchor.setTo(0.5);

            this.frontLayer.add(resultText);
            this.frontLayer.add(itemName);
            this.frontLayer.add(character);
            this.frontLayer.add(words);
            this.frontLayer.add(restartBtn);
            this.frontLayer.add(toTopBtn);

    	}

    },

    againGame: function () {

    	this.game.againFlag = false;

        // animation firework
        var firework = this.add.sprite(this.game.width/2, this.game.height/2, 'firework');
        firework.anchor.setTo(0.5, 0.5);

		var resultText = this.add.sprite(this.game.width/2, this.game.height/4, 'againText');
		resultText.anchor.setTo(0.5, 0.5);

		// show character
		var character = this.add.sprite(0, this.game.height/2, 'characterNormal');
		var words = this.add.sprite(this.game.width/2 -100 , this.game.height/2 + 150, 'wordsAgain');

		// show cylinder
		if (this.game.pointId == 100) {

			var cylinder = this.add.button(this.game.width / 2, this.game.height - 150, 'cylinder_100', this.againAnim, this);

		} else if (this.game.pointId == 50) {

			var cylinder = this.add.button(this.game.width / 2, this.game.height - 150, 'cylinder_50', this.againAnim, this);

		} else {

			var cylinder = this.add.button(this.game.width / 2, this.game.height - 150, 'cylinder_10', this.againAnim, this);

		}

		cylinder.anchor.setTo(0.5, 0.5);

        this.frontLayer.add(resultText);
        this.frontLayer.add(character);
        this.frontLayer.add(words);
        this.frontLayer.add(cylinder);

        this.backLayer.add(firework);

    },

    againAnim: function (pointer) {

		this.frontLayer.destroy();
		this.backLayer.destroy();

		// animation ball
		this.ballTween();

    },

	restart: function (pointer) {
		pointer.inputEnabled = false;

		this.game.itemName = null;
		this.game.itemImg = null;
		this.game.againFlag = null;
		this.game.worth = null;

		// ajax: subtract point & play game
		var self = this;
		this.subPoint(this.game.pointId, this.game.gameId, this.game.serverId).then(function (response) {

			self.game.itemName = response.itemName;
			self.game.itemImg = response.itemImg;
			self.game.againFlag = response.againFlag;
			self.game.worth = response.worth;

			// show play scene
			return self.state.start('Play');

		// ajax Error
		}, function (errWords) {

			self.frontLayer.destroy();

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

	closeErrorView: function () {

		return location.reload();

	}
};

