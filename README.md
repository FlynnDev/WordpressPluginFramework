WordPress Plugin Framework
===

By: Mike Flynn

Install
---
1. Clone this project into a folder in your project named framework
1. In the framework folder, run composer install
1. Include framework/load.php into your main plugin file
1. Create a class that extends `PluginFramework\V_1_1\Core` that has `$this->start('Plugin Name', 'version', __FILE__)` in the constructor
1. See the examples for more details
1. Profit!

Features
--------
+ Shortcodes
+ Admin Pages
+ Mustache Template Engine
+ Scripts
+ Styles
+ Admin Scripts
+ Admin Styles
+ Basic Security Settings

Todo
----
- Custom Post Types
- Meta Boxes
- Shortcode atts
- More Verbose Data Controls