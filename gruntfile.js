var envify = require('envify/custom');
module.exports = function (grunt) {
    grunt.initConfig({
        browserify: {
            dist: {
                files: [
                    {
                        expand: true,       // Enable dynamic expansion.
                        cwd: 'assets/js/',  // Source Path
                        src: ['*.js'],      // Actual pattern(s) to match.
                        dest: 'assets/pjs/',  // Destination folder
                        ext: '.min.js',     // Dest filepaths will have this extension.
                    },
                ],
                options: {
                    configure: b => b
                    .transform('vueify')
                    .transform(
                      // Obrigatório para processar arquivos em node_modules
                      { global: true },
                      envify({ NODE_ENV: 'production' })
                    )
                    .bundle(),
                    transform: [
                        [
                            'babelify',
                            { presets: ["es2015"] }
                        ],
                    ],

                }
            },
            
            dev: {
                files: [
                    {
                        expand: true,       // Enable dynamic expansion.
                        cwd: 'assets/js/',  // Source Path
                        src: ['*.js'],      // Actual pattern(s) to match.
                        dest: 'assets/pjs/',  // Destination folder
                        ext: '.min.js',     // Dest filepaths will have this extension.
                    },
                ],
                options: {
                    transform: [
                        [
                            'babelify',
                            { presets: ["es2015"] }
                        ],
                        [
                            'vueify'
                        ]
                    ],
                    browserifyOptions: {
                        debug: true
                    }
                }
            }
        },
        
        uglify: {
            options: {
                banner: '/*! Grunt Uglify <%= grunt.template.today("yyyy-mm-dd") %> */ ',
                sourceMap: false,
            },
            build: {
                files: [{
                    expand: true,
                    src: ['*.js'],
                    cwd: 'assets/pjs',
                    dest: 'assets/pjs',
                    ext: '.min.js'
                }]
            }
        },
        sass: {
            dist: {
                options: {
                    outputStyle: 'compressed',
                    sourceMap: false,
                    noCache: true
                },
                files: [{
                    expand: true,
                    cwd: 'assets/sass',
                    src: ['*.scss'],
                    dest: 'assets/css',
                    ext: '.min.css'
                }]
            },
            dev: {
                options: {
                    outputStyle: 'expanded',
                    sourceMap: false,
                    update: true
                },
                files: [
                    {
                        expand: true,
                        cwd: 'assets/sass',
                        src: ['*.scss'],
                        dest: 'assets/css',
                        ext: '.min.css'
                    },
                    {
                        expand: true,
                        cwd: 'blog/wp-content/themes/myMiniFramework',
                        src: ['*.scss'],
                        dest: 'blog/wp-content/themes/myMiniFramework/css',
                        ext: '.min.css'
                    }
                ]
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'assets/img/',
                src: ['**/*.{png,jpg,svg,gif}'],
                dest: 'public/img/'
            },
            fonts: {
                expand: true,
                flatten: true,
                src: [
                    'node_modules/font-awesome/fonts/*',
                    'assets/fonts/*'
                ],
                dest: 'assets/fonts/',
                filter: 'isFile'
            },
        },
        // configure the "grunt watch" task
        watch: {
            sass: {
                files: 'assets/sass/*',
                tasks: ['newer:sass:dev']
            },
            sass_blog: {
                files: 'blog/wp-content/themes/myMiniFramework/*',
                tasks: ['newer:sass:dev']
            },
            browserify: {
                files: [
                    'assets/js/*',
                    'blog/wp-content/themes/myMiniFramework/js/*'
                ],
                tasks: ['newer:browserify:dev']
            },
            copy: {
                files: 'assets/img/**',
                tasks: ['newer:copy:images', 'newer:copy:fonts']
            }
        },
        php: {
            dev: {
                options: {
                    bin: 'php',
                    hostname: 'localhost',
                    port: 2999,
                    base: './',
                    keepAlive: false,
                    open: false
                }
            },
            test: {
                options: {
                    bin: 'php',
                    hostname: 'localhost',
                    port: 4000,
                    base: './',
                    keepAlive: true,
                    open: true
                }
            }
        },
        browserSync: {
            bsFiles: {
                src: [
                    'assets/css/*',
                    'assets/fonts/*',
                    'assets/img/**',
                    'assets/js/*',
                    'app/**/*.php'
                ]
            },
            options: {
                proxy: '<%= php.dev.options.hostname %>:<%= php.dev.options.port %>',
                https: false,
                watchTask: true,
                notify: true,
                open: true,
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-php');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-newer');
    grunt.registerTask('dev', ['browserify:dev', 'sass:dev', 'php:dev',  'browserSync', 'watch']);
    grunt.registerTask('build', ['browserify:dist', 'uglify', 'sass:dist']);
    grunt.registerTask('test', ['build', 'php:test', 'watch']);
};