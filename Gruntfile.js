module.exports = function(grunt){

    let package = grunt.file.readJSON('package.json');
    let v = package.version;
    let vs = v.split('.');

    let apply_version = function(content){
        return content
            .replace(/PluginFramework/g, `PluginFramework\\V_${vs[0]}_${vs[1]}`)
            .replace(/plugin_framework_/g, `plugin_framework_v_${vs[0]}_${vs[1]}_`);
    };

    grunt.initConfig({
        pkg: package,

        clean:['build', 'load.php', 'dist'],

        copy: {
            build: {
                expand: true,
                cwd: 'src',
                src: '**',
                dest: 'build/',
                options : {
                    process : apply_version
                }
            },

            dist: {
                expand: true,
                cwd: 'build',
                src: '**',
                dest: 'dist'
            },

            readme: {
                src: 'README.template.md',
                dest: 'README.md',
                options : {
                    process : apply_version
                }
            },

            loader: {
                src: 'build/load.php',
                dest: 'load.php',
                options: {
                    process : function(content) { return content.replace(/\.\//g, 'dist/'); }
                }
            }
        },

        usebanner: {
            main: {
                options: {
                    position: 'replace',
                    replace: "\/\/banner",
                    banner:
                    '/**\n' +
                    ' * Package:  <%= pkg.title %>\n' +
                    ' * Version:  <%= pkg.version %>\n' +
                    ' * Date:     <%= grunt.template.today("dd-mm-yyyy") %>\n' +
                    ' * Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author.name %> - <%= pkg.author.email %>\n' +
                    ' */ \n \n',
                    linebreak: true
                },
                files : {
                    src : ['build/load.php']
                }
            }
        }

    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-banner');

    grunt.registerTask('default', [ 'clean', 'copy:build', 'copy:readme', 'usebanner',  'copy:dist']);
};