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