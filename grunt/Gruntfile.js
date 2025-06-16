// grunt minigame-dev --game=sugoroku
module.exports = function(grunt){
	var gameName = grunt.option('game');

	var filePath = '../public/js/minigame/' + gameName + '/';

	var concatFileName = gameName + '.js';
	var minifyFileName = gameName + '.min.js';

	var concatFileUrl = filePath + concatFileName;
	var minifyFileUrl = filePath + minifyFileName;

	grunt.initConfig({
	    concat: {
	        files: {
	        	// before
	            src : [
	            	filePath+'*.js', // include
	            	'!'+filePath+concatFileName, // exclude
	            	'!'+filePath+minifyFileName, // exclude
	            ],

	            // after
	            dest: concatFileUrl
	        }
	    },

	    // minify
	    uglify: {
	    	files: {
	    		src: concatFileUrl, // before
	    		dest: minifyFileUrl // after
	    	}
	    }
	});
	
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.registerTask('minigame-dev', ['concat', 'uglify']);
};