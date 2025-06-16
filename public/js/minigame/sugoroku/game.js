BasicGame={};
BasicGame.Boot=function(){};
BasicGame.Boot.prototype={
	init:function(){
		this.input.maxPointers = 1;
		this.stage.disableVisibilityChange = true;
		this.stage.backgroundColor = '#424242';
		this.load.crossOrigin = "Anonymous";
		this.stage.backgroundColor='#fff';
	},
	preload: function() {this.load.atlasJSONHash('loading', '//ap-statics.loas.jp/mm2/official/images/minigame/loading.png', null, this.loadingJson());},
	create: function() {this.state.start('Preloader');},
	loadingJson: function () {return {"frames":{"loading0.png":{"frame":{"x":0,"y":0,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading1.png":{"frame":{"x":512,"y":0,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading2.png":{"frame":{"x":1024,"y":0,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading3.png":{"frame":{"x":0,"y":512,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading4.png":{"frame":{"x":512,"y":512,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading5.png":{"frame":{"x":1024,"y":512,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading6.png":{"frame":{"x":0,"y":1024,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}},"loading7.png":{"frame":{"x":512,"y":1024,"w":512,"h":512},"rotated":false,"trimmed":false,"spriteSourceSize":{"x":0,"y":0,"w":512,"h":512},"sourceSize":{"w":512,"h":512}}},"meta":{"app":"https://github.com/piskelapp/piskel/","version":"1.0","image":"loading.png","format":"RGBA8888","size":{"w":1536,"h":1536}}};},
};
BasicGame.Preloader=function(){};
BasicGame.Preloader.prototype={
	preload: function () {
		this.loading = this.add.sprite(this.world.centerX,this.world.centerY,'loading');
		this.loading.scale.setTo(.8);
		this.loading.anchor.setTo(.5);
		this.loading.animations.add('loading').play(8, true);
		this.loadAssets();
	},
	loadAssets:function(){
		this.imgPath = '//ap-statics.loas.jp/mm2/official/images/minigame/sugoroku/';
        this.load.spritesheet('dice', this.imgPath + 'dice.png', 200, 200);
        this.load.atlasJSONHash('CecilyRun', this.imgPath + 'CecilyRun/CecilyRun.png', '/images/minigame/sugoroku/CecilyRun/CecilyRun.json');
        this.load.image('arrowBtn','//ap-statics.loas.jp/mm2/official/images/minigame/arrow.png');
		var images={
			'baseBg':'19/baseBg.png',
            'panelFrame':'panelFrame.png',
            'playBtn1':'19/playBtn1.png',
            'playBtn2':'19/playBtn2.png',
            'playBtn3':'19/playBtn3.png',
            'historyBtn':'19/historyBtn.png',
            'howToBtn':'19/howToBtn.png',
            'diceBg':'diceBg.png',
            'diceFrame':'diceFrame.png',
            'yesBtn':'yesBtn.png',
            'noBtn':'noBtn.png',
            'whiteBoard':'whiteBoard.png',
            'closeBtn':'closeBtn.png',
            'gaugeBar':'19/gaugeBar.png',
            'gaugeBase':'19/gaugeBase.png',
            'gaugeText':'19/gaugeText.png',
            'resetFreeCountText':'19/resetFreeCountText.png',
		};
        for(var k in images)this.load.image(k,this.imgPath+images[k]);
        this.loadItems();
        this.loadBox();
	},
	loadItems:function(){
		for (var i = 1; i <= 37; i++) {
			if (i==5)continue;
			this.load.image('itemImg'+i, this.imgPath + 'items/itemImg'+i+'.png');
		}
	},
	loadBox:function(){
		for (var i = 1; i <= 5; i++) {
			this.load.image('bx_'+i+'_off', this.imgPath + '19/bx_'+i+'_off.png');
			this.load.image('bx_'+i+'_on', this.imgPath + '19/bx_'+i+'_on.png');
		}
	},
	create: function () {this.state.start('Play')},
};
BasicGame.Play=function(){};
BasicGame.Play.prototype={
	init: function () {
		this.btnInfo = {
			blueDiamond:{name:'ダイヤ',price:300,img:'playBtn1',x:this.world.width*.26},
			freePlay:{name:'無料回数',price:__userData.freePlayCredit+'/1',img:'playBtn2',x:this.world.width*.43},
			goldDiamond:{name:'ロイヤルダイヤ',price:300,img:'playBtn3',x:this.world.width*.6},
		};
		this.panelsPos = {};
		this.inputEnabled = true;
		this.boxCount=__boxInfo.length;
		this.panelCount = __panelInfo.length;
		this.curCornerNum = 0;
		this.curDoubleCornerNum = 0;
		this.moveVel = 500;
		this.historyInfo = null;
		this.againFlag = false;
		this.rewardItemName = null;
		this.rewardItemId = null;
		this.cornerInfo = {1:0,2:8,3:12,4:20};
		this.panelMarginX = (this.world.width-50)/(this.cornerInfo[2]+1);
		this.panelMarginY = this.world.height/(this.cornerInfo[3]-this.cornerInfo[2]+1);

		this.CaptionG=this.BackG=this.ConfirmG=this.BoxBtnG=this.RewardG=
		this.BtnG=this.HowToG=this.HistoryG=
		this.DiceS=this.PlayerS=this.SubValT=this.SelectedB=this.ConfirmT=
		this.GaugeBarS=this.GaugeMaskS=this.RoundCountT=
		null;
	},
	create: function () {
		this.add.sprite(this.world.centerX,this.world.centerY,'baseBg').anchor.setTo(.5);
		this.BackG = this.add.group();
		this.genBtns();
		this.genPanels();
		this.genDice();
		this.genRoundCountText();
		this.genGauge();
		this.genPlayer();
		this.genCaptionGroup();
		this.genConfirmGroup();
		this.genHistory();
		this.genHowTo();
		this.genRewardGroup();
		this.chGauge(__userData.totalMovement);
	},
	textStyle:function(fontSize, fill, align){return {font: 'bold '+(fontSize||12)+'px メイリオ', fill: fill||'#151515', align: align||'center'};},
	genBtns:function(){
		this.BtnG = this.add.group();
		var b,t,k,info,
		textStyle=this.textStyle(12,'#fff'),
		by=this.world.height*.67,ty=15;

		for(k in this.btnInfo){
			info = this.btnInfo[k];
			b=this.add.button(info.x,by,info.img,this.showStartSelect,this);
			b.anchor.setTo(.5);
			b.eventName=k;
			b.nameText=info.name;
			t=this.add.text(0,ty,info.price,textStyle);
			t.anchor.setTo(.5);
			b.addChild(t);
			this.BtnG.add(b);
			if(k=='freePlay'&&__userData.freePlayCredit==0){
				b.alpha=.7;
				b.inputEnabled=false;
			}
		}

		t=this.add.text(b.centerX,b.top-10,'ロイヤルダイヤで回して\n報酬2倍になる',this.textStyle(12,'#000'));
		t.anchor.setTo(.5);
		this.add.button(this.world.width*.15,100,'historyBtn',this.showHistory,this);
		this.add.button(this.world.width*.15,150,'howToBtn',this.showHowTo,this);
	},
	showStartSelect: function (b) {
		this.SelectedB=b;
		this.ConfirmT.setText(b.nameText+'で１回プレイしますか？');
		this.openConfirm();
	},
	genConfirmGroup: function () {
		var s,b;
		this.ConfirmG=this.add.group();
		s=this.add.sprite(this.world.centerX,this.world.centerY,'whiteBoard');
		s.anchor.setTo(.5);
		this.ConfirmG.add(s);
		b=this.add.button(s.right-50,s.top+30,'closeBtn',this.closeConfirm,this);
		b.anchor.setTo(.5);
		this.ConfirmG.add(b);
		this.ConfirmT=this.add.text(this.world.centerX,this.world.height*.45,'本当にプレイしますか？',this.textStyle(20));
		this.ConfirmT.anchor.setTo(.5);
		this.ConfirmG.add(this.ConfirmT);
		b=this.add.button(this.world.width*.4,this.world.height*.55,'yesBtn',this.startGame,this);
		b.anchor.setTo(.5);
		this.ConfirmG.add(b);
		b=this.add.button(this.world.width*.6,this.world.height*.55,'noBtn',this.closeConfirm,this);
		b.anchor.setTo(.5);
		this.ConfirmG.add(b);

		this.ConfirmG.visible=false;
	},
	openConfirm:function(){
		if(this.inputEnabled){
			this.inputEnabled = false;
			this.ConfirmG.visible = true;
			this.CaptionG.visible = false;
		}
	},
	closeConfirm:function(){
		if(!this.inputEnabled){
			this.inputEnabled = true;	
			this.ConfirmG.visible = false;
		}
	},
	startGame: function() {
		this.closeConfirm();
		this.initialize();
		this.DiceS.animations.play('shake', 12, false);

		var self = this;
		this.play().then(function (res) {
			self.cmplPlay(res);
		}, function (errNum) {
			showErr(self,errNum);
		});
	},
	initialize:function(){
		this.againFlag = false;
		this.DiceS.movement = null;
		this.DiceS.gotoPanelNum = -1;
		this.DiceS.loopCount = 0;
		this.inputEnabled = false;
	},
	play:function(){
		return $.ajax({
			method: 'POST',
			url: '/minigame/sugoroku/play',
			data: {
				uId: __uId,
				sId: __sId,
				playerPos: __userData.positionNum,
				eventName: this.SelectedB.eventName,
			},
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (res) {
			if (res.status === true && res.code == 0) return $.Deferred().resolve(res).promise();
			return $.Deferred().reject(res.code).promise();
		});
	},
	cmplPlay: function (res) {
		this.DiceS.movement = res.movement;
		this.DiceS.gotoPanelNum = res.gotoPanelNum;
		this.historyInfo = null;
		__userData.totalMovement = res.totalMovement;
		this.rewardItemId = res.itemId;
		this.rewardItemName = res.itemName;
		this.againFlag = res.againFlag;

		if(res.eventName=='freePlay')__userData.freePlayCredit--;
		if(res.againFlag)__userData.freePlayCredit++;
		var b=this.BtnG.children[1];
		if(__userData.freePlayCredit>0){
			b.alpha=1;
			b.inputEnabled=true;
		}else{
			b.alpha=.7;
			b.inputEnabled=false;
		}
		b.children[0].setText(__userData.freePlayCredit+'/1');
	},
	genPanels:function () {
		var increaseX = 0;
		var increaseY = 0;
		var startX = -this.panelMarginX/2+25;
		var startY = this.panelMarginY/2;

		for (var i = 0; i < this.panelCount; i++) {
			if (i <= this.cornerInfo[2]) {
				increaseX += this.panelMarginX;
			} else if (i <= this.cornerInfo[3]) {
				increaseY += this.panelMarginY;
			} else if (i <= this.cornerInfo[4]) {
				increaseX -= this.panelMarginX;
			} else {
				increaseY -= this.panelMarginY;
			}

			var x = startX + increaseX;
			var y = startY + increaseY;

			var panelInfo=__panelInfo[i];
			this.genPanelBtn(x,y,panelInfo);
			this.panelsPos[i] = {x:x,y:y};
		}
	},
	genPanelBtn:function(x,y,panelInfo){
		var b=this.add.button(x,y);
		b.anchor.setTo(.5);
		b.width=this.panelMarginX;
		b.height=this.panelMarginY;

		var captionText = '次のうちどれかが当たります。\n';
		var panelInfoItems = panelInfo.items;
		for (var key in panelInfoItems) {
			if (key != (panelInfoItems.length-1)) {
				captionText += panelInfoItems[key] + '\n';
			} else {
				if (panelInfoItems.length-1 == 0) {
					captionText = panelInfoItems[key];
				} else {
					captionText += panelInfoItems[key];
				}
			}
		}
		b.captionText = panelInfo.rare == 'D' ? 'このマスに止まると\n無料回数が1回増えます。' : captionText;

		if (panelInfo.rare != 'E')b.onInputOver.add(this.showCaption,this);
		b.onInputOut.add(this.hideCaption, this);
	},
	showCaption:function(b){
		if (this.inputEnabled) {
			this.CaptionG.children[1].setText(b.captionText);
			this.CaptionG.visible=true;
		}
	},
	hideCaption:function(){
		this.CaptionG.visible=false;
	},
	genCaptionGroup:function () {
		this.CaptionG = this.add.group();
		var s = this.add.sprite(this.world.width*.7,this.world.height*.4,'whiteBoard');
		s.anchor.setTo(.5);
		s.scale.setTo(.5,1);
		this.CaptionG.add(s);
		var t = this.add.text(s.centerX,s.centerY,'',this.textStyle(12));
		t.anchor.setTo(.5);
		this.CaptionG.add(t);
		this.CaptionG.visible=false;
	},
	genDice: function () {
		var s,x=this.world.width*.43,y=this.world.height*.47;
		s=this.add.sprite(x,y,'diceBg');
		s.anchor.setTo(.5);
		s.scale.setTo(.7);
		this.BackG.add(s);
		s=this.add.sprite(x,y,'diceFrame');
		s.anchor.setTo(.5);
		s.scale.setTo(.7);
		this.BackG.add(s);
		this.DiceS = s = this.add.sprite(x+2,y,'dice');
		s.anchor.setTo(.5);
		s.scale.setTo(.3);
		s.angle = 90;
		s.movement = null;
		s.gotoPanelNum = -1;
		s.loopCount = 0;
		s.animations.add('shake').onComplete.add(this.dicing,this);
		this.BackG.add(s);

		this.add.sprite(x,this.world.height*.78,'resetFreeCountText').anchor.setTo(.5);
	},
	dicing:function(s){
		if (s.loopCount < 5) {
			if (!s.movement || s.gotoPanelNum < 0) {
				s.animations.play('shake', 12, false);
				return;
			}

			s.animations.stop();
			s.loopCount = 0;
			s.frame = (s.movement-1);
			var tw = this.add.tween(s.scale);
			tw.to({x:.6,y:.6}, 500, Phaser.Easing.Bounce.Out, true).yoyo(true, 0);
			tw.onComplete.addOnce(function () {
				this.movePlayer();
				this.DiceS.frame = this.DiceS.movement - 1;
			},this);
		} else {
			this.time.events.add(100,function(){
				s.animations.play('shake', 12, false);
				s.loopCount += 1;
			});
		}
	},
	movePlayer: function () {
		this.PlayerS.changeAnim();
		var gotoPanelNum = this.DiceS.gotoPanelNum;
		var toPos = null;
		var duration = 0;
		var playerPosNum = __userData.positionNum;
		this.moveCmplBase=this.moveCmplNormal;

		if (playerPosNum >= this.cornerInfo[1] && playerPosNum < this.cornerInfo[2] && gotoPanelNum > this.cornerInfo[2]) {
			this.curCornerNum = this.cornerInfo[2];
			var middlePath = this.panelsPos[this.curCornerNum];
			toPos = {x:middlePath.x,y:middlePath.y};
			duration = this.moveVel * (this.curCornerNum - playerPosNum);
			this.moveCmplBase = this.moveCmplMiddlePath;
			if (gotoPanelNum > this.cornerInfo[3]) {
				this.curDoubleCornerNum = this.cornerInfo[3];
				this.moveCmplBase = this.moveCmplDoubleCorner;
			}
		} else if (playerPosNum >= this.cornerInfo[2] && playerPosNum < this.cornerInfo[3] && gotoPanelNum > this.cornerInfo[3]) {
			this.curCornerNum = this.cornerInfo[3];
			var middlePath = this.panelsPos[this.curCornerNum];
			toPos = {x:middlePath.x,y:middlePath.y};
			duration = this.moveVel * (this.curCornerNum - playerPosNum);
			this.moveCmplBase = this.moveCmplMiddlePath;
			if (gotoPanelNum > this.cornerInfo[4]) {
				this.curDoubleCornerNum = this.cornerInfo[4];
				this.moveCmplBase = this.moveCmplDoubleCorner;
			}
		} else if (playerPosNum >= this.cornerInfo[3] && playerPosNum < this.cornerInfo[4] && (gotoPanelNum > this.cornerInfo[4] || gotoPanelNum < this.cornerInfo[2])) {
			this.curCornerNum = this.cornerInfo[4];
			var middlePath = this.panelsPos[this.curCornerNum];
			toPos = {x:middlePath.x,y:middlePath.y};
			duration = this.moveVel * (this.curCornerNum - playerPosNum);
			this.moveCmplBase = this.moveCmplMiddlePath;
			if (gotoPanelNum > this.cornerInfo[1] && gotoPanelNum < this.cornerInfo[2]) {
				this.curDoubleCornerNum = this.cornerInfo[1];
				this.moveCmplBase = this.moveCmplDoubleCorner;
			}
		} else if (playerPosNum >= this.cornerInfo[4] && playerPosNum < this.panelCount && gotoPanelNum < this.cornerInfo[2] && gotoPanelNum != this.cornerInfo[1]) {
			this.curCornerNum = this.cornerInfo[1];
			var middlePath = this.panelsPos[this.curCornerNum];
			toPos = {x:middlePath.x,y:middlePath.y};
			duration = this.moveVel * (this.panelCount - playerPosNum);
			this.moveCmplBase = this.moveCmplMiddlePath;
		} else {
			var pos = this.panelsPos[gotoPanelNum];
			toPos = {x:pos.x,y:pos.y};
			if (gotoPanelNum == this.cornerInfo[1]) {
				duration = this.moveVel * (this.panelCount - playerPosNum);
			} else {
				duration = this.moveVel * (gotoPanelNum - playerPosNum);
			}
		}

		this.add.tween(this.PlayerS).to(toPos,duration,null,true).onComplete.addOnce(this.moveCmplBase,this);
	},
	moveCmplBase:function(){},
	moveCmplNormal:function(){
		if (this.DiceS.gotoPanelNum == this.cornerInfo[2] || this.DiceS.gotoPanelNum == this.cornerInfo[4])
			this.PlayerS.scale.x *= -1;
		this.moveEnd();
	},
	moveCmplMiddlePath:function(){
		var gotoPanelNum = this.DiceS.gotoPanelNum;
		var pos = this.panelsPos[gotoPanelNum];
		if ((gotoPanelNum >= this.cornerInfo[2] && gotoPanelNum <= this.cornerInfo[3]) || (gotoPanelNum >= this.cornerInfo[4] && gotoPanelNum < this.panelCount) || gotoPanelNum == this.cornerInfo[1])
			this.PlayerS.scale.x *= -1;
		this.add.tween(this.PlayerS)
			.to({x:pos.x,y:pos.y},
				this.moveVel * (gotoPanelNum == this.cornerInfo[1] ? 4 : gotoPanelNum - this.curCornerNum),null,true)
			.onComplete.addOnce(this.moveEnd,this);
	},
	moveCmplDoubleCorner:function(){
		var dpos = this.panelsPos[this.curDoubleCornerNum];
		this.add.tween(this.PlayerS)
			.to({x:dpos.x,y:dpos.y},this.moveVel * 4,null, true)
			.onComplete.addOnce(function () {
				var pos = this.panelsPos[this.DiceS.gotoPanelNum];
				this.add.tween(this.PlayerS)
					.to({x:pos.x,y:pos.y},this.moveVel,null,true)
					.onComplete.addOnce(this.moveEnd,this);
			},this);
		this.PlayerS.scale.x *= -1;
	},
	moveEnd: function () {
		this.PlayerS.changeAnim();
		var gotoPanelNum = this.DiceS.gotoPanelNum;
		__userData.positionNum = gotoPanelNum;
		var text = '';
		if (this.rewardItemId == 2239) {
			text = 'GOGO!';
		} else if (this.againFlag) {
			text = 'もう1回！！無料回数が１増えました。';
		} else {
			text = this.rewardItemName + '\nを獲得しました。';
		}
		this.openReward(text);
		this.chGauge(__userData.totalMovement);
	},
	genRoundCountText:function(){
		var t,count = Math.floor(__userData.totalMovement/this.panelCount);
		this.RoundCountT = t=this.add.text(this.world.centerX-230,this.world.centerY,'現在'+count+'周',this.textStyle(20));
		t.anchor.setTo(.5);
		t.panelCount=this.panelCount;
		t.changeText = function (totalMovement) {
			var count = Math.floor(totalMovement/this.panelCount);
			this.setText('現在'+count+'周');
		};
	},
	genGauge: function () {
		var x=this.world.width*.3;
		var y=this.world.height*.26;

		this.add.sprite(x,y,'gaugeBase').anchor.setTo(0,.5);

		this.GaugeBarS = s = this.add.sprite(x,y,'gaugeBar');
		s.anchor.setTo(0,.5);

		this.GaugeMaskS = mask = this.add.graphics(x,y);
		mask.beginFill(0xFF3300);
		mask.drawRect(0, -50, s.width, 80);
		s.mask = mask;

		this.genBox(x,y);
	},
	chGauge:function(totalMovement){
		var gaugeMax = this.boxCount * this.panelCount * 10;
		var maskRange = totalMovement < gaugeMax ? this.GaugeBarS.width * (totalMovement / gaugeMax) : this.GaugeBarS.width;
		this.GaugeMaskS.clear();
		this.GaugeMaskS.beginFill(0xFF3300);
		this.GaugeMaskS.drawRect(0, -50, maskRange, 80);

		var boxRounds=[10*this.panelCount,20*this.panelCount,30*this.panelCount,40*this.panelCount,50*this.panelCount];
		var boxBtn = null;
		if (totalMovement >= boxRounds[0] && totalMovement < boxRounds[1]) {
			boxBtn = this.BoxBtnG.children[0];
		} else if (totalMovement >= boxRounds[1] && totalMovement < boxRounds[2]) {
			boxBtn = this.BoxBtnG.children[1];
		} else if (totalMovement >= boxRounds[2] && totalMovement < boxRounds[3]) {
			boxBtn = this.BoxBtnG.children[2];
		} else if (totalMovement >= boxRounds[3] && totalMovement < boxRounds[4]) {
			boxBtn = this.BoxBtnG.children[3];
		} else if (totalMovement >= boxRounds[4]) {
			boxBtn = this.BoxBtnG.children[4];
		}

		if (boxBtn && boxBtn.giveItem == 0) {
			boxBtn.tween.start();
			boxBtn.onInputUp.add(this.openBox,this);
			boxBtn.captionText = __boxInfo[boxBtn.boxNum].itemName+'\nが獲得できます。';
		}
		this.RoundCountT.changeText(totalMovement);
	},
	genBox:function(x,y){
		this.BoxBtnG = this.add.group();
		y += 25;

		var checkPointWidth = this.GaugeBarS.width / 5;
		for (var i = 0; i < this.boxCount; i++) {
			x += checkPointWidth;
			var boxBtn=this.add.button(x,y,'bx_'+(i+1)+'_off');
			boxBtn.anchor.setTo(1,.5);
			boxBtn.giveItem = __userData.boxConditions['box_' + i];
			boxBtn.boxNum = i;
			boxBtn.boxImgNum = i + 1;
			boxBtn.changeImg = function (target) {
				target.loadTexture('bx_'+target.boxImgNum+'_on');
			};
			boxBtn.tween = this.add.tween(boxBtn.scale).to({x: .8, y: .8}, 500,null, false, 0, -1).yoyo(true, 0);

			if (i < parseInt(__userData.totalMovement / (10 * this.panelCount)) && boxBtn.giveItem == 0) {
				boxBtn.tween.start();
				boxBtn.onInputUp.add(this.openBox,this);
				boxBtn.captionText = __boxInfo[boxBtn.boxNum].itemName+"\nが獲得できます。";
			} else {
				if (boxBtn.giveItem == 0) {
					boxBtn.captionText = "ここに到達で\n"+__boxInfo[boxBtn.boxNum].itemName+"\nが獲得できます。";
				} else {
								boxBtn.changeImg(boxBtn);
					boxBtn.captionText = "すでに\n"+__boxInfo[boxBtn.boxNum].itemName+"\nを獲得しました。";
				}
			}

			boxBtn.onInputOver.add(this.showCaption,this);
			boxBtn.onInputOut.add(this.hideCaption,this);

			this.BoxBtnG.add(boxBtn);
		}

		y -= 40;
		this.add.sprite(x,y,'gaugeText').anchor.setTo(1,.5);
	},
	openBox:function(b){
		if (this.inputEnabled && b.giveItem == 0) {
			this.inputEnabled = false;
			b.giveItem = 1;
			b.tween.stop();
			b.scale.setTo(1);
			this.hideCaption();
			b.changeImg(b);
			b.captionText = 'すでに\n'+__boxInfo[b.boxNum].itemName+'\nを獲得しました。';

			var self=this;
			this.giveBoxItem(b.boxNum).then(function (res) {
				self.openReward('宝箱を発見！！\n'+__boxInfo[b.boxNum].itemName+'を獲得しました。');
				self.historyInfo = null;
			},function(errNum){
				showErr(self,errNum);
			});
		}
	},
	giveBoxItem: function (boxNum) {
		return $.ajax({
			method: 'POST',
			url: '/minigame/sugoroku/giveBoxItem',
			data: {uId:__uId,sId:__sId,boxNum:boxNum},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (res) {
			if (res.status === true && res.code == 0) return $.Deferred().resolve(res).promise();
			return $.Deferred().reject(res.code).promise();
		});
	},
	genPlayer: function () {
		var playerPosNum = __userData.positionNum;
		var pos = this.panelsPos[playerPosNum];
		this.PlayerS = s = this.add.sprite(pos.x,pos.y,'CecilyRun');
		s.anchor.setTo(.5);
		s.scale.setTo(.6);
		if (playerPosNum >= this.cornerInfo[2] && playerPosNum < this.cornerInfo[4]) {
			s.scale.x *= -1;
		}
		s.animations.add('idle');
		s.animations.add('walk');
		s.animStop = function () {
			this.animations.play('idle', 0, false);
			this.frame = 1;
		};
		s.animStart = function () {
			this.play('walk', 18, true);
		};
		s.changeAnim = function () {
			this.animations.name == 'idle' ? this.animStart() : this.animStop();
		};
		s.animStop();
	},
	genHistory:function(){
		this.HistoryG = this.add.group();
		var s,b;
		s=this.add.sprite(this.world.centerX,this.world.centerY,'whiteBoard');
		s.anchor.setTo(.5);
		s.scale.setTo(1.5);
		this.HistoryG.add(s);
		b=this.add.button(s.right-50,s.top,'closeBtn',this.closeHistory,this);
		b.anchor.setTo(1,0);
		b.scale.setTo(1.5);
		this.HistoryG.add(b);
		this.HistoryG.visible = false;

		if ($('.history_wrapper').length == 0) {
			$('.wrapper').append(
				'<div class="history_wrapper" style="'
					+'display:none;'
					+'width:570px;'
					+'height:270px;'
					+'position: absolute;'
					+'top: 80px;'
					+'left: 120px;'
					+'overflow-x: scroll;'
					+'padding: 5px 15px 5px 10px;'
					+'word-break : break-all;'
				+'"></div>'
			);
		}
	},
	showHistory: function () {
		if (this.inputEnabled) {
			this.inputEnabled = false;
			this.HistoryG.visible = true;

			var self = this;
			this.fetchHistory().then(function (res) {
				var elem = '<table border=1><tr><th width=265>賞品</th><th>消費</th><th>日時</th></tr>', resArr;
				if(res){
					if (!self.historyInfo) {
						self.historyInfo = resArr = JSON.parse(res);
					} else {
						resArr = res;
					}
					for(var k in resArr){
						var val = resArr[k];
						elem+='<tr><td>'+val.name+'</td><td>'+(self.btnInfo[val.type]?self.btnInfo[val.type].name:' - ')+'</td><td>'+val.date+'</td></tr>';
					}
				}
				elem+='</table>';
				$('.history_wrapper').html(elem);
				$('.history_wrapper').show();
			},function(){
				$('.history_wrapper').html('Error');
			});
		}
	},
	closeHistory:function(){
		if (!this.inputEnabled) {
			this.inputEnabled = true;
			$('.history_wrapper').hide();
			this.HistoryG.visible = false;
		}
	},
	fetchHistory: function () {
		if(this.historyInfo)return $.Deferred().resolve(this.historyInfo).promise();
		return $.ajax({
			method: 'POST',
			url: '/minigame/sugoroku/history',
			data: {uId:__uId,sId:__sId},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).then(function (res) {
			if(res.status === true && res.code == 0)return $.Deferred().resolve(res.history).promise();
			return $.Deferred().resolve(null).promise();
		});
	},
	genRewardGroup:function(){
		var s,b,t;
		this.RewardG=this.add.group();
		s=this.add.sprite(this.world.centerX,this.world.centerY,'whiteBoard');
		s.anchor.setTo(.5);
		this.RewardG.add(s);
		b=this.add.button(s.right-50,s.top+30,'closeBtn',this.closeReward,this);
		b.anchor.setTo(.5);
		this.RewardG.add(b);
		t=this.add.text(this.world.centerX,this.world.centerY,'',this.textStyle(14));
		t.anchor.setTo(.5);
		this.RewardG.add(t);

		this.RewardG.visible=false;
	},
	openReward:function(text){
		this.RewardG.children[2].setText(text);
		this.RewardG.visible = true;
	},
	closeReward:function(){
		this.RewardG.visible = false;
		this.inputEnabled = true;
	},
	genHowTo:function(){
		this.HowToG = this.add.group();
		var s,b;
		s=this.add.sprite(this.world.centerX,this.world.centerY,'whiteBoard');
		s.anchor.setTo(.5);
		s.scale.setTo(1.5);
		this.HowToG.add(s);
		b=this.add.button(s.right-50,s.top,'closeBtn',this.closeHowTo,this);
		b.anchor.setTo(1,0);
		b.scale.setTo(1.5);
		this.HowToG.add(b);
		this.HowToG.visible = false;
	},
	showHowTo: function () {
		if (this.inputEnabled) {
			this.inputEnabled = false;
			$('.howto_wrapper').show();
			this.HowToG.visible = true;
		}
	},
	closeHowTo: function () {
		if (!this.inputEnabled) {
			this.inputEnabled = true;
			$('.howto_wrapper').hide();
			this.HowToG.visible = false;
		}
	},
	reset: function(){
		location.reload();
	},
};

var __error={
	'-999':'システムエラー\n時間をおいてから再度お試しください。',
	'-10':'すでに終了したゲームです。\nプレイすることはできません。',
	'-8':'リクエストエラー\n時間をおいてから再度お試しください。',
	'-7':'データベースエラー\n時間をおいてから再度お試しください。',
	'-5':'残高が足りません。',
};
function showErr (self,errNum) {
	alert(__error[errNum]);
	self.reset();
}
