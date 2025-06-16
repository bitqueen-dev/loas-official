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