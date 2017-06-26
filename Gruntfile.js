module.exports = function(grunt){

    let package = grunt.file.readJSON('package.json');

    grunt.initConfig({
        pkg: package,

        clean:['build/*', 'load.php'],

        copy:{
            main: {
                expand: true,
                cwd: 'src',
                src: '**',
                dest: 'build/',
                options : {
                    process : function(content){
                        return content.replace(/PluginFramework/g, `PluginFramework\\V_${package.version}`)
                    }
                }
            },

            loader: {
                src: 'build/load.php',
                dest: 'load.php',
                options:{
                    process : function(content, srcpath) {
                        return content.replace(/\.\.\/src/g, '../build').replace(/\.\.\//g, '');
                    }
                }
            }
        },

        usebanner: {
            main: {
                options: {
                    position: 'top',
                    banner:
                    '<?php \n' +
                    '/**\n' +
                    ' * Package:  <%= pkg.title %>\n' +
                    ' * Version:  <%= pkg.version %>\n' +
                    ' * Date:     <%= grunt.template.today("dd-mm-yyyy") %>\n' +
                    ' * Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author.name %> - <%= pkg.author.email %>\n' +
                    ' */ \n ?>',
                    linebreak: true
                },
                files : {
                    src : ['build/*.php', 'load.php']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-banner');

    grunt.registerTask('default', ['copy:main','copy:loader','usebanner']);

};