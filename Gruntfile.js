module.exports = function (grunt)
{
    'use strict';

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        less: {
            main: {
                files: {
                    'tmp/assets/css/main.css': 'assets/css/main.less',
                    'tmp/assets/css/ie8.css': 'assets/css/ie8.less'
                }
            }
        },

        cssmin: {
            main: {
                files: {
                    'output_dev/assets/css/main.css': ['tmp/assets/css/main.css'],
                    'output_dev/assets/css/ie8.css': ['tmp/assets/css/ie8.css']
                }
            }
        },

        copy: {
            img: {
                files: [
                    {expand: true, cwd: 'assets/img/', src: ['**'], dest: 'output_dev/assets/img/'}
                ]
            }
        },

        watch: {
            sass: {
                files: ['assets/css/**.less'],
                tasks: ['less', 'cssmin']
            },

            js: {
                files: 'assets/js/**.js',
                tasks: ['jshint', 'uglify']
            },

            img: {
                files: 'assets/img/**',
                tasks: ['copy:img']
            }
        },

        jshint: {
            files: ['Gruntfile.js', 'assets/js/*.js'],
            options: {
                bitwise: true,
                camelcase: true,
                curly: true,
                eqeqeq: true,
                es3: true,
                forin: true,
                immed: true,
                indent: 4,
                latedef: true,
                noarg: true,
                noempty: true,
                nonew: true,
                quotmark: 'single',
                undef: true,
                unused: true,
                strict: true,
                trailing: true,
                browser: true,
                globals: {
                    jQuery: true,
                    Zepto: true,
                    define: true,
                    module: true,
                    require: true,
                    requirejs: true,
                    responsiveNav: true,
                    prettyPrint: true,
                    WebFont: true
                }
            }
        },

        uglify: {
            dist: {
                options: {
                    mangle: false,
                    preserveComments: 'some'
                },

                files: [
                    {
                        'output_dev/assets/js/main.js': ['assets/js/main.js'],
                        'output_dev/assets/js/prettify.js': ['bower_components/google-code-prettify/src/prettify.js'],
                        'output_dev/assets/js/require.js': ['bower_components/requirejs/require.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/google-code-prettify/src/',
                        src: 'lang-*.js',
                        dest: 'output_dev/assets/js/'
                    }
                ]
            }
        }
    });

    grunt.registerTask('test', ['jshint']);
    grunt.registerTask('default', ['watch']);
    grunt.registerTask('build', ['jshint', 'uglify', 'less', 'cssmin', 'copy:img']);
    grunt.registerTask('travis', ['jshint']);
};
