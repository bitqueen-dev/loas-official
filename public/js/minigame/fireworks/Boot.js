BasicGame = {};

BasicGame.Boot = function(game) {};

BasicGame.Boot.prototype = {

  init: function() {

    this.input.maxPointers = 1;
    this.stage.disableVisibilityChange = true;
    this.stage.backgroundColor = '#330066';

    this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
    this.scale.fullScreenScaleMode = Phaser.ScaleManager.SHOW_ALL;

    this.scale.parentIsWindow = true ;

    this.scale.refresh();

  },

  preload: function() {

    this.load.atlasJSONHash('loading', 'images/minigame/loading.png', 'images/minigame/loading.json');

  },

  create: function() {

    this.state.start('Preloader');

  }

};
