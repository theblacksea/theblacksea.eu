module.exports = function(grunt){

    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            build: {
                files: {
                    "public/css/site.css" : ["public/less/*.less"]
                }
            }
        },
        cssmin: {
            compress: {
                files: {
                    'public/css/site.min.css' : ['public/css/site.css']
                }
            }
        },
        watch: {
            css: {
                files: ['public/less/*.less'],
                tasks: ['less:build']
            },
            min: {
                files: ['public/css/site.css'],
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