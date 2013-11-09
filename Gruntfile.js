module.exports = function (grunt)
{
    'use strict';

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-shell');

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        less: {
            main: {
                files: {
                    'tmp/assets/css/main.css': 'assets/css/main.less'
                }
            }
        },

        cssmin: {
            main: {
                options: {
                    keepSpecialComments: 0
                },
                files: {
                    'output_dev/assets/css/main.css': ['tmp/assets/css/main.css']
                }
            }
        },

        copy: {
            img: {
                files: [
                    {expand: true, cwd: 'assets/img/', src: ['**'], dest: 'output_dev/assets/img/'}
                ]
            },

            html: {
                files: [
                    {expand: true, cwd: 'tmp/output_dev/', src: ['**'], dest: 'output_dev/'}
                ]
            }
        },

        watch: {
            sass: {
                files: ['assets/css/**/*.less'],
                tasks: ['less', 'cssmin']
            },

            js: {
                files: 'assets/js/**.js',
                tasks: ['jshint', 'uglify']
            },

            img: {
                files: 'assets/img/**',
                tasks: ['copy:img']
            },

            sculpin: {
                files: ['source/**/*'],
                tasks: ['shell:sculpingenerate', 'htmlmin', 'copy:html']
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
        },

        shell: {
            sculpingenerate: {
                command: [
                    './vendor/bin/sculpin generate'
                ].join('&&'),
                options: {
                    stdout: true
                }
            },
            phpdoc: {
                command: [
                    'mkdir -f tmp',
                    'rm -fR php-textile',
                    'git clone git@github.com:textile/php-textile.php ./tmp/php-textile',
                    './vendor/bin/phpdoc.php --directory="./tmp/php-textile/src/" --target="./tmp/phpdoc/" --template="xml"'
                ].join('&&'),
                options: {
                    stdout: true
                }
            }
        },

        htmlmin: {
            main: {
                options: {
                    removeComments: true,
                    collapseWhitespace: true
                },
                files: [
                    {expand: true, cwd: 'output_dev/', src: ['**/*.html'], dest: 'tmp/output_dev/'}
                ]
            }
        }
    });

    grunt.registerTask('test', ['jshint']);
    grunt.registerTask('default', ['watch']);
    grunt.registerTask('build', ['shell:sculpingenerate', 'htmlmin', 'copy:html', 'jshint', 'uglify', 'less', 'cssmin', 'copy:img']);
    grunt.registerTask('travis', ['jshint']);
};
