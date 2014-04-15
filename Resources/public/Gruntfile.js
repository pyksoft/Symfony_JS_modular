module.exports = function(grunt){
	grunt.initConfig({

		concat: {
			options: {
				separator: ';'
			},
			admin: {
				src: ['js/admin/admin.js', 'js/admin/**/*.js', '!js/admin/admin.min.js'],
				dest: 'js/admin/admin.min.js'
			}
		},

		sass: {                             
		    dist: {                          
				options: {                      
					style: 'expanded',
					compass : true
				},
			    files: {                         // Dictionary of files
			        'css/admin.min.css': 'scss/admin/admin.scss',       // 'destination': 'source'
			    }
			} 
		},

		watch: {
			all: {
				files: ['js/**','scss/**'],
				tasks: ['sass','concat'],
				options: {
					spawn: false,
				},
			},
		}

	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');

}