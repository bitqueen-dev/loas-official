var __baseWords = {
	defaultError:'サーバーエラーです。\n時間をおいてから再度お試しください。',
	notEnoughError:'が足りません',
	dbError:'データベースエラーです。\n時間をおいてから再度お試しください。',
	requestError:'リクエストエラーです。\n時間をおいてから再度お試しください。',
	closeGame:'このゲームはすでに終了しています。',
	confirmFront:'を消費してガチャを',
	confirmBack:'回引きます。\nよろしいですか？',
	ticketName:'ガチャ券',
};

function genTextStyle () {
	return {
		fontSize: 15,
		fill: '#fff',
		stroke: '#000',
		strokeThickness: 5,
		align: 'center',
	};
}
function genConfirmText(){
	var price=__data.curGachaInfo.type=='ticket'?__data.curGachaInfo.ticket:__data.curGachaInfo.payDiamond;
	return __data.curGachaInfo.name+price+__data.curGachaInfo.numeral+__baseWords.confirmFront+__data.curGachaInfo.playGachaCount+__baseWords.confirmBack;
}

//-------- Boot --------------------------------------------------------------------------------
BasicGame = {};
BasicGame.Boot = function() {};
BasicGame.Boot.prototype = {
	init: function () {
		this.input.maxPointers = 1;
		this.stage.disableVisibilityChange = true;
		this.stage.backgroundColor = '#424242';
		this.load.crossOrigin = "Anonymous";
	},
	preload: function () {this.load.atlasJSONHash('loading', '//ap-statics.loas.jp/mm2/official/images/minigame/loading.png', null, this.loadingJson());},
	create: function () {this.state.start('Preloader');},
	loadingJson: function () {return {"frames":{"loading0.png":{"frame":{"x":0,"y":0,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading1.png":{"frame":{"x":512,"y":0,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading2.png":{"frame":{"x":1024,"y":0,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading3.png":{"frame":{"x":0,"y":512,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading4.png":{"frame":{"x":512,"y":512,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading5.png":{"frame":{"x":1024,"y":512,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading6.png":{"frame":{"x":0,"y":1024,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading7.png":{"frame":{"x":512,"y":1024,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}}},"meta":{"app":"https://github.com/piskelapp/piskel/","version":"1.0","image":"loading.png","format":"RGBA8888","size":{"w":1536,"h":1536}}};},
};

//-------- Preloader --------------------------------------------------------------------------------
BasicGame.Preloader = function () {};
BasicGame.Preloader.prototype = {
	create: function () {
		this.loadingAnim();
		this.loadAssets();
		this.loadProgress();
		this.load.onLoadComplete.add(this.loadedAssets, this);
		this.load.start();
	},
	loadProgress: function(){
		var textStyle = genTextStyle();
		textStyle.fontSize = 24;
		var textSprite = this.add.text(this.world.centerX, this.world.height*.8, '0%', textStyle);
		textSprite.anchor.setTo(.5);
		this.load.onFileComplete.add(function (progress) {
			this.setText(progress+'%');
		}, textSprite);
	},
	loadingAnim: function () {
		var loadingSprite = this.add.sprite(this.world.width/2, this.world.height/2, 'loading');
		loadingSprite.anchor.setTo(0.5, 0.5);
		loadingSprite.scale.setTo(.5);
		loadingSprite.animations.add('loading').play(8, true);
	},
	loadAssets:function () {
		var imagePath = '//ap-statics.loas.jp/mm2/official/images/minigame/gacha/';
		var images = {
			'caution1': 'caution1.png',
			'caption1': 'caption1.png',
			'caption2': 'caption2.png',
			'caption3': 'caption3.png',
			'ok_btn': 'ok_btn.png',
			'cancel_btn': 'cancel_btn.png',
			'detail_btn': 'detail_btn.png',
			'play1_btn_on': 'play1_btn_on.png',
			'play1_btn_off': 'play1_btn_off.png',
			'free_btn_on': 'free_btn_on.png',
			'free_btn_off': 'free_btn_off.png',
			'gacha_btn_1_off': 'gacha_btn_1_off.png',
			'gacha_btn_1_on': 'gacha_btn_1_on.png',
			'gacha_btn_2_off': 'gacha_btn_2_off.png',
			'gacha_btn_2_on': 'gacha_btn_2_on.png',
			'play10_btn_on': 'play10_btn_on.png',
			'play10_btn_off': 'play10_btn_off.png',
			'play_blue_dia_10_btn_on': 'play_blue_dia_10_btn_on.png',
			'play_blue_dia_10_btn_off': 'play_blue_dia_10_btn_off.png',
			'back_btn_on': 'back_btn_on.png',
			'back_btn_off': 'back_btn_off.png',
			'again_btn_on': 'again_btn_on.png',
			'again_btn_off': 'again_btn_off.png',
			'sword1': 'sword1.png',
			'sword2': 'sword2.png',
			'sword3': 'sword3.png',
			'gr_char_1': 'gr_char_1.jpg',
			'gr_char_2': 'gr_char_2.jpg',
			'gr_char_3': 'gr_char_3.jpg',
			'gr_char_4': 'gr_char_4.jpg',
			'gr_char_5': 'gr_char_5.jpg',
			'gr_char_6': 'gr_char_6.jpg',
			'gr_char_7': 'gr_char_7.jpg',
			'gr_char_7_2': 'gr_char_7_2.png',
			'gr_char_8': 'gr_char_8.jpg',
			'char_anim1': 'char_anim1.png',
			'char_anim2': 'char_anim2.png',
			'char_anim3': 'char_anim3.png',
			'card_gold': 'card_gold.png',
			'card_red': 'card_red.png',
			'card_orange': 'card_orange.png',
			'title_bg': 'title_bg2.jpg',
			'anim_bg': 'anim_bg.jpg',
			'white_block': 'white_block.png',
			'white_bg': 'white_bg.jpg',
			'result_frame': 'result_frame.png',
			'confirm_dialog': 'confirm_dialog.png',
		};
		for (var k in images) this.load.image(k, imagePath + images[k]);
		for (var k in __itemList) this.load.image('item_'+__itemList[k], imagePath + 'items/' + __itemList[k] + '.png');

		images = {
			'closeBtn': 'closeBtn.png'
		};
		for (var k in images) this.load.image(k, 'https://ap-statics.loas.jp/mm2/official/images/minigame/' + images[k]);
	},
	loadedAssets:function () {
		document.body.style.cursor = 'pointer';
		this.state.start('Title');
	},
};

function error (_this, errorNum) {
	var txt = __baseWords.defaultError;
	errorNum = errorNum.toString();
	switch (errorNum) {
		case '-5': txt = __data.curGachaInfo.name+__baseWords.notEnoughError; break;
		case '-7': txt = __baseWords.dbError; break;
		case '-8': txt = __baseWords.requestError; break;
		case '-10':
		default: txt = __baseWords.closeGame;
	}
	var textStyle = genTextStyle();
	textStyle.fontSize = 24;
	var errorText = _this.add.text(_this.world.centerX, _this.world.centerY, txt, textStyle);
	errorText.anchor.setTo(.5);

	var backBtn = _this.add.button(_this.world.centerX,_this.world.height*.8,'back_btn_off',_this.back,_this);
	backBtn.imgOn = 'back_btn_on';
	backBtn.imgOff = 'back_btn_off';
	backBtn.anchor.setTo(.5);
	_this.setOnOffImg(backBtn);
}

//-------- Title --------------------------------------------------------------------------------
BasicGame.Title = function () {};
BasicGame.Title.prototype = {
	init: function () {
		this.curHistoryPage = 0;
		this.maxHistoryPage = 0;
		this.isOpenModal = false;
	},
	create: function () {
		this.add.sprite(0,0,'title_bg');
		this.genBtns();
		this.genConfirmModal();
		// this.genHistoryModal();
		this.genDetail();
		this.genDetailModal();
	},
	genBtns:function(){
		this.add.sprite(this.world.width*.2,this.world.height*.7,'caption1').anchor.setTo(.5);
		this.add.sprite(this.world.width*.8,this.world.height*.7,'caption2').anchor.setTo(.5);
		this.add.sprite(this.world.width*.42,this.world.height*.52,'caption3').anchor.setTo(.5);

		var y = this.world.height*.8;
		var btnInfo = [
			{x:this.world.width*.25,y:y,imgOff:'free_btn_off',imgOn:'free_btn_on'},
			{x:this.world.width*.5,y:y,imgOff:'play1_btn_off',imgOn:'play1_btn_on'},
			{x:this.world.width*.75,y:y,imgOff:'play10_btn_off',imgOn:'play10_btn_on'},
			{x:this.world.centerX,y:this.world.height*.6,imgOff:'play_blue_dia_10_btn_off',imgOn:'play_blue_dia_10_btn_on'},
			{x:this.world.width*.5,y:y+50,imgOff:'gacha_btn_1_off',imgOn:'gacha_btn_1_on'},
			{x:this.world.width*.75,y:y+50,imgOff:'gacha_btn_2_off',imgOn:'gacha_btn_2_on'},
		];
		var i=0;
		for(var gachaId in __gachaInfo){
			var gInfo = __gachaInfo[gachaId];
			var bInfo = btnInfo[i];
			this.genPlayBtn(gachaId,gInfo,bInfo);
			i++;
		}

		var detailBtn = this.add.button(this.world.width*.92,this.world.height*.85,'detail_btn',this.openDetail,this);
		detailBtn.anchor.setTo(.5);

		this.add.text(this.world.width*.55,y+50,__data.haveTicket,genTextStyle()).anchor.setTo(0,.5);
		this.add.text(this.world.width*.8,y+50,__data.haveTicket,genTextStyle()).anchor.setTo(0,.5);

		// this.add.button(0,0,'',this.openHistory,this);
	},
	genPlayBtn:function(gachaId,gInfo,bInfo){
		var b=this.add.button(bInfo.x,bInfo.y,bInfo.imgOff,this.openConfirm,this);
		b.anchor.setTo(.5);

		if (
			(gInfo.specialPlayA == true && __data.specialPlayCreditA == 0)
			|| (gInfo.specialPlayB == true && __data.specialPlayCreditB == 0)
		) {
			b.inputEnabled = false;
			b.alpha = .5;
		} else {
			b.imgOn=bInfo.imgOn;
			b.imgOff=bInfo.imgOff;
			b.onInputDown.add(this.btnImgOn,this);
			b.onInputOver.add(this.btnImgOn,this);
			b.onInputOut.add(this.btnImgOff,this);
			b.onInputUp.add(this.btnImgOff,this);
			b.gachaId = gachaId;
		}
	},
	btnImgOn:function(b){
		if(!this.isOpenModal){
			b.loadTexture(b.imgOn);
		}
	},
	btnImgOff:function(b){
		if(!this.isOpenModal){
			b.loadTexture(b.imgOff);
		}
	},
	genConfirmModal: function () {
		this.ConfirmModal = this.add.group();
		this.ConfirmModal.visible = false;

		var modal = this.add.sprite(this.world.centerX,this.world.centerY,'confirm_dialog');
		modal.anchor.setTo(.5);
		modal.width*=1.2;

		this.ConfirmText = this.add.text(this.world.centerX,this.world.centerY,'',genTextStyle());
		this.ConfirmText.anchor.setTo(.5);

		var y=this.world.height*.65;
		var yesBtn = this.add.button(this.world.width*.6,y,'ok_btn',this.playGacha,this);
		yesBtn.anchor.setTo(.5);

		var noBtn = this.add.button(this.world.width*.4,y,'cancel_btn',this.closeConfirm,this);
		noBtn.anchor.setTo(.5);

		this.ConfirmModal.add(modal);
		this.ConfirmModal.add(yesBtn);
		this.ConfirmModal.add(noBtn);
		this.ConfirmModal.add(this.ConfirmText);
	},
	openConfirm: function (btn) {
		if (!this.isOpenModal) {
			this.isOpenModal = true;
			this.ConfirmModal.visible = true;

			__data.curGachaId = btn.gachaId;
			__data.curGachaInfo = __gachaInfo[btn.gachaId];

			this.ConfirmText.setText(genConfirmText());
		}
	},
	closeConfirm: function () {
		if (this.isOpenModal) {
			this.isOpenModal = false;
			this.ConfirmModal.visible = false;
		}
	},
	genHistoryModal: function () {
		this.HistoryModal = this.add.group();
		this.HistoryModal.visible = false;

		var modal = this.add.sprite(this.world.centerX,this.world.centerY,'confirm_dialog');
		modal.anchor.setTo(.5);

		var closeBtn = this.add.button(modal.right,modal.top,'closeBtn',this.closeHistory,this);
		this.PrevBtn = this.add.button(modal.left,modal.bottom,'closeBtn',this.prevHistory,this);
		this.PrevBtn.visible = false;
		this.NextBtn = this.add.button(modal.right,modal.bottom,'closeBtn',this.nextHistory,this);
		this.NextBtn.visible = false;

		this.HistoryText=this.add.text(this.world.centerX,this.world.centerY,'',{tabs:[this.world.width*.4,this.world.width*.4]});
		this.HistoryText.anchor.setTo(.5);

		this.HistoryModal.add(modal);
		this.HistoryModal.add(closeBtn);
		this.HistoryModal.add(this.PrevBtn);
		this.HistoryModal.add(this.NextBtn);
		this.HistoryModal.add(this.HistoryText);
	},
	/*
	openHistory: function () {
		this.HistoryModal.visible = true;
		this.curHistoryPage = 0;

		if (!__data.historyContents) {
			var self = this;
			$.ajax({
				method: 'POST',
				url: '/minigame/history',
				data: {
					game: 'gacha',
					uId: __data.uId,
					// limit: 10,
					// offset: 0,
				},
				type: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				timeout: 5000,
			}).done(function(res){

				if (res.status && res.code == 0) {
					var contents = [];
					var header = ['【獲得アイテム】', '【日付】'];

					var historyPage = 0;
					contents[historyPage] = [];
					contents[historyPage].push(header);

					if (res.history) {
						var counter = 0;
						for(var k in res.history){
							var data = res.history[k];
							if (counter == 5) {
								counter = 0;
								historyPage++;
								contents[historyPage] = [];
								contents[historyPage].push(header);
							}
							contents[historyPage].push([data.itemName, data.createdAt]);
							counter++;
						}

						self.maxHistoryPage = historyPage;
						self.HistoryText.parseList(contents[0]);
						self.NextBtn.visible = true;

						__data.historyContents = contents;
					}
					return;
				}

				error(self);
			});
		} else {
			this.HistoryText.parseList(__data.historyContents[0]);
			this.NextBtn.visible = true;
		}
	},
	closeHistory:function () {
		this.HistoryModal.visible = false;
		this.NextBtn.visible = false;
		this.PrevBtn.visible = false;
	},
	prevHistory:function(){
		if (!this.NextBtn.visible) {
			this.NextBtn.visible = true;
		}

		this.curHistoryPage--;
		this.HistoryText.parseList(__data.historyContents[this.curHistoryPage]);

		if (this.curHistoryPage == 0) {
			this.PrevBtn.visible = false;
		}
	},
	nextHistory:function(){
		if (!this.PrevBtn.visible) {
			this.PrevBtn.visible = true;
		}

		this.curHistoryPage++;
		this.HistoryText.parseList(__data.historyContents[this.curHistoryPage]);

		if (this.curHistoryPage == this.maxHistoryPage) {
			this.NextBtn.visible = false;
		}
	},
	*/
	genDetailModal: function () {
		this.DetailModal = this.add.group();
		this.DetailModal.visible = false;

		var modal = this.add.sprite(this.world.centerX,this.world.centerY,'confirm_dialog');
		modal.anchor.setTo(.5);
		modal.scale.setTo(1.6);

		var closeBtn = this.add.button(modal.right,modal.top,'closeBtn',this.closeDetail,this);
		closeBtn.anchor.setTo(.5);
		closeBtn.scale.setTo(.6);

		this.DetailModal.add(modal);
		this.DetailModal.add(closeBtn);

		var self=this;
	},
	openDetail: function () {
		if (!this.isOpenModal) {
			this.isOpenModal = true;
			this.DetailModal.visible = true;
			$('.minigame_detail_area').show();
		}
	},
	closeDetail: function () {
		if (this.isOpenModal) {
			this.isOpenModal = false;
			this.DetailModal.visible = false;
			$('.minigame_detail_area').hide();
		}
	},
	genDetail:function(){
		var html='';
		for(var k in __itemInfo1){
			var info=__itemInfo1[k];
			if(info.u==true){
				html+='<tr><td>'+info.r+'</td><td>'+info.n+'<span class="right_float"> 出現率UP！</span></td><td><span>'+(info.p).toFixed(4)+'%</span></td></tr>'
			}else{
				html+='<tr><td>'+info.r+'</td><td>'+info.n+'</td><td>'+(info.p).toFixed(4)+'%</td></tr>'
			}
		}
		$('.detail_table_body_1').append(html);
		html='';
		for(var k in __itemInfo2){
			var info=__itemInfo2[k];
			if(info.u==true){
				html+='<tr><td>'+info.r+'</td><td>'+info.n+'<span class="right_float">出現率UP！</span></td><td><span>'+(info.p).toFixed(4)+'%</span></td></tr>'
			}else{
				html+='<tr><td>'+info.r+'</td><td>'+info.n+'</td><td>'+(info.p).toFixed(4)+'%</td></tr>'
			}
		}
		$('.detail_table_body_2').append(html);

		var _minigame_detail_contents = $('.minigame_detail_contents');
		$('.detail_item_btn').click(function(){
			var btnNum = $(this).data('btn-num');
			_minigame_detail_contents.children().hide();
			$('.detail_content_'+btnNum).show();
		});
	},
	playGacha: function () {
		this.state.start('Play');
	},
};

//-------- Play --------------------------------------------------------------------------------
BasicGame.Play = function () {};
BasicGame.Play.prototype = {
	init: function () {
		this.movingCards = false;
		this.skipInput = null;
		this.isOpenModal = false;

		this.cardsArr = [];
		this.cardTweenArr = [];
		this.cardPosArr = [];

		this.flipingCardNum = 0;
	},
	create: function () {
		this.genFirstView();
		this.genResultPanel();
		this.genResultHUD();
		this.genConfirmModal();
	},
	genFirstView: function () {
		this.time.events.add(300,function(){
			this.input.onDown.addOnce(this.play,this);
		},this);

		this.add.sprite(0,0,'anim_bg')
		this.genEmitter();
		this.CharAnim=this.add.sprite(0,0,'char_anim1');

		this.Sword = this.add.sprite(this.world.centerX,this.world.centerY,'sword1');
		this.Sword.anchor.setTo(.5);
	},
	genEmitter:function(){
		var e=this.add.emitter(this.world.centerX,this.world.centerY,200);
		e.makeParticles('white_block');
		e.minParticleScale=.3;
		e.maxParticleScale=.6;
		e.gravity.x=0;
		e.gravity.y=0;
		e.setAlpha(1,0,12000);
		e.setXSpeed(-300,300);
		e.setYSpeed(-80,80);
		e.start(false,12000,100,0);
		this.time.events.add(1000,function(){
			this.setXSpeed(-100,100);
		},e);
	},
	genResultPanel: function () {
		this.ResultPanel = this.add.group();
		this.ResultPanel.visible = false;

		var panel = this.add.sprite(this.world.centerX,this.world.centerY,'result_frame');
		panel.anchor.setTo(.5);

		this.ResultPanel.add(panel);
	},
	genResultHUD: function () {
		this.ResultHUD = this.add.group();
		this.ResultHUD.visible = false;

		var caution = this.add.sprite(this.world.centerX,this.world.height*.95,'caution1');
		caution.anchor.setTo(.5,1);

		var backBtn = this.add.button(this.world.width*.3,this.world.height*.8,'back_btn_off',this.back,this);
		backBtn.imgOn = 'back_btn_on';
		backBtn.imgOff = 'back_btn_off';
		backBtn.anchor.setTo(.5);
		this.setOnOffImg(backBtn);

		this.AgainBtn = this.add.button(this.world.width*.7,this.world.height*.8,'again_btn_off',this.openConfirm,this);
		this.AgainBtn.imgOn = 'again_btn_on';
		this.AgainBtn.imgOff = 'again_btn_off';
		this.AgainBtn.anchor.setTo(.5);
		this.setOnOffImg(this.AgainBtn);

		this.ResultHUD.add(caution);
		this.ResultHUD.add(backBtn);
		this.ResultHUD.add(this.AgainBtn);
	},
	setOnOffImg:function(btn){
		btn.onInputDown.add(this.btnImgOn,this);
		btn.onInputOver.add(this.btnImgOn,this);
		btn.onInputOut.add(this.btnImgOff,this);
		btn.onInputUp.add(this.btnImgOff,this);
	},
	btnImgOn:function(b){
		if(!this.isOpenModal){
			b.loadTexture(b.imgOn);
		}
	},
	btnImgOff:function(b){
		if(!this.isOpenModal){
			b.loadTexture(b.imgOff);
		}
	},
	genConfirmModal: function () {
		this.ConfirmModal = this.add.group();
		this.ConfirmModal.visible = false;

		var modal = this.add.sprite(this.world.centerX,this.world.centerY,'confirm_dialog');
		modal.anchor.setTo(.5);
		modal.width*=1.2;

		this.ConfirmText = this.add.text(this.world.centerX,this.world.centerY,'',genTextStyle());
		this.ConfirmText.anchor.setTo(.5);

		var y=this.world.height*.65;
		var yesBtn = this.add.button(this.world.width*.6,y,'ok_btn',this.again,this);
		yesBtn.anchor.setTo(.5);

		var noBtn = this.add.button(this.world.width*.4,y,'cancel_btn',this.closeConfirm,this);
		noBtn.anchor.setTo(.5);

		this.ConfirmModal.add(modal);
		this.ConfirmModal.add(yesBtn);
		this.ConfirmModal.add(noBtn);
		this.ConfirmModal.add(this.ConfirmText);
	},
	play: function () {
		var self = this;

		$.ajax({
			method: 'POST',
			url: '/minigame/gacha/play',
			data: {
				uId: __data.uId,
				sId: __data.sId,
				gachaId: __data.curGachaId,
			},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).done(function(res){
			if (res.status && res.code == 0) {
				__data.getCardList = res.getCardList;
				__data.haveTicket = res.haveTicket;
				self.anim();
			} else {
				error(self,res.code);
			}
		});
	},
	anim:function(){
		this.time.events.add(400,function(){
			this.CharAnim.loadTexture('char_anim2');
			this.time.events.add(400,function(){
				this.CharAnim.loadTexture('char_anim3');
				this.time.events.add(800,function(){
					this.CharAnim.loadTexture('char_anim2');
					this.time.events.add(400,function(){
						this.CharAnim.loadTexture('char_anim1');
						this.time.events.add(500,function(){
							this.moveCards();
						},this);
					},this);
				},this);
			},this);
		},this);

		var tween1 = this.add.tween(this.Sword).to({y:-this.world.centerY},800,null,true);
		tween1.onComplete.add(function(s){
			s.scale.y *= -1;
			var loadTexture = 'sword1';
			for(var k in __data.getCardList){
				var info = __data.getCardList[k];
				if (info.rare == 'GR') {
					loadTexture = 'sword2';
					break;
				} else if (info.rare == 'UR') {
					loadTexture = 'sword3';
				}
			}
			s.loadTexture(loadTexture);
		},this);

		var tween2 = this.add.tween(this.Sword).to({y:this.world.height*1.5},800,null,false,800);
		tween1.chain(tween2);
	},
	back: function () {
		if (!this.isOpenModal) {
			this.state.start('Title');
		}
	},
	openConfirm: function () {
		if (!this.isOpenModal) {
			this.isOpenModal = true;
			this.ConfirmModal.visible = true;

			this.ConfirmText.setText(genConfirmText());
		}
	},
	closeConfirm: function () {
		if (this.isOpenModal) {
			this.isOpenModal = false;
			this.ConfirmModal.visible = false;
		}
	},
	again: function () {
		this.state.start('Play');
	},
	moveCards:function () {
		this.movingCards = true;
		this.ResultPanel.visible = true;

		var resultFrame = this.ResultPanel.children[0];

		var row = 0;
		var i=0;
		for(var k in __data.getCardList){
			var cardData = __data.getCardList[k];
			var col = i % 5;

			var x = resultFrame.left + 50 + 80 * col;
			var y = resultFrame.top + 50 + 70 * row;

			var card = this.add.sprite(x, this.world.height * 1.5, 
				cardData.rare == 'GR' ? 'card_gold' : cardData.rare == 'UR' ? 'card_red' : 'card_orange');
			card.anchor.setTo(.5);
			card.num = i;
			card.rare = cardData.rare;
			card.itemImg = 'item_' + cardData.itemId
			card.animImg = cardData.animImg;

			var tween = this.add.tween(card);
			tween.to({y: y}, 1000, Phaser.Easing.Back.Out, true, i * 200);

			this.ResultPanel.add(card);

			this.cardsArr.push(card);
			this.cardTweenArr.push(tween);
			this.cardPosArr.push({x:x,y:y});
			
			if (col == 4) row++;
			i++;
		}

		tween.onComplete.add(this.moveCardsComplete, this);

		this.skipInput = this.input.onDown.addOnce(this.skipMoveCards, this);
	},
	skipMoveCards: function () {
		for (var k in this.cardsArr) {
			if (this.cardTweenArr[k].isRunning) {
				this.cardTweenArr[k].stop();

				var card = this.cardsArr[k];
				var pos = this.cardPosArr[k];
				card.x = pos.x;
				card.y = pos.y;
			}
		}

		this.moveCardsComplete();
	},
	moveCardsComplete: function () {
		if (this.movingCards) {
			this.movingCards = false;
			this.skipInput.active = false;

			this.flipCard();
		}
	},
	flipCard: function () {
		if (this.flipingCardNum == __data.curGachaInfo.playGachaCount) {
			return this.flipComplete();
		}

		var card = this.cardsArr[this.flipingCardNum];

		var tweenA = this.add.tween(card.scale);
		tweenA.to({x:0}, 100, null, true, 0);
		tweenA.onComplete.add(function () {
			this.loadTexture(this.itemImg);
		}, card);

		var tweenB = this.add.tween(card.scale);
		tweenB.to({x:1}, 100, null, false, 0);
		tweenA.chain(tweenB);

		this.flipingCardNum++;

		if (card.rare == 'GR' && card.animImg) {
			this.curGRAnim = card.animImg;
			if (this.curGRAnim == 'gr_char_7') {
				tweenB.onComplete.add(this.rareOpenAnimation2, this);
			} else {
				tweenB.onComplete.add(this.rareOpenAnimation, this);
			}
		} else {
			tweenB.onComplete.add(this.flipCard, this);
		}
	},
	rareOpenAnimation: function () {
		this.RareSceneSprite = this.add.sprite(this.world.centerX,this.world.centerY,this.curGRAnim);
		this.RareSceneSprite.anchor.setTo(.5);
		this.RareSceneSprite.scale.setTo(1.5);

		var tween1 = this.add.tween(this.RareSceneSprite.scale).to({x:1,y:1},1000,Phaser.Easing.Circular.Out,true,300);
		tween1.onComplete.add(function(){
			this.time.events.add(1500,function(){
				this.RareSceneSprite.destroy();
				this.flipCard();
			},this);
		},this);

		var white = this.add.sprite(0,0,'white_bg');
		white.width = this.world.width;
		white.height = this.world.height;
		var tween2 = this.add.tween(white).to({alpha: 0}, 1000, null, true, 100);
		tween2.onComplete.add(function(sprite){
			sprite.destroy();
		});
	},
	rareOpenAnimation2:function(){
		this.WhiteBgS = this.add.sprite(0,0,'white_bg');
		this.WhiteBgS.width = this.world.width;
		this.WhiteBgS.height = this.world.height;

		this.RareScreneTS=this.add.sprite(this.world.centerX,this.world.centerY,this.curGRAnim+'_2');
		this.RareScreneTS.anchor.setTo(.5);
		this.RareScreneTS.alpha=.5;
		var tw=this.add.tween(this.RareScreneTS).to({alpha:1},500,null,true,100);
		tw.onComplete.add(function(s){
			this.RareSceneSprite = this.add.sprite(this.world.centerX,this.world.centerY,this.curGRAnim);
			this.RareSceneSprite.anchor.setTo(.5);
			this.RareSceneSprite.scale.setTo(1.5);
			this.RareSceneSprite.visible = false;

			var tween1 = this.add.tween(this.RareSceneSprite.scale).to({x:1,y:1},1000,Phaser.Easing.Circular.Out,true,600);
			tween1.onComplete.add(function(){
				this.time.events.add(1500,function(){
					this.RareSceneSprite.destroy();
					this.RareScreneTS.destroy();
					this.flipCard();
				},this);
			},this);

			var tween2 = this.add.tween(this.WhiteBgS).to({alpha: 0},1000,null,true,300);
			tween2.onStart.add(function(){
				this.RareSceneSprite.visible = true;
			},this);
			tween2.onComplete.add(function(sprite){
				sprite.destroy();
			});
			this.world.bringToTop(this.RareScreneTS);
		},this);
	},
	flipComplete: function () {
		this.ResultHUD.visible = true;

		if(__data.curGachaId==1001){
			__data.specialPlayCreditA = 0;
			this.AgainBtn.visible = false;
		}
		if(__data.curGachaId==1004){
			__data.specialPlayCreditB = 0;
			this.AgainBtn.visible = false;
		}
	},
};
