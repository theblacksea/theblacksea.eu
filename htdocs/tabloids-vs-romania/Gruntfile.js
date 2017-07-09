module.exports = function(grunt){

    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            build: {
                files: {
                    "css/site.css" : ["less/*.less"]
                }
            }
        },
        cssmin: {
            compress: {
                files: {
                    'css/site.min.css' : ['css/site.css']
                }
            }
        },
        watch: {
            css: {
                files: ['less/*.less'],
                tasks: ['less:build']
            },
            min: {
                files: ['css/site.css'],
                tasks: ['cssmin:compress']
            }
        }
    });

    grunt.registerTask('default', [
        'watch',
        'less',
        'cssmin'
    ]);

};