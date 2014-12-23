<?php
/**
 * Plugin Name: WP-JSPKG
 * Plugin URI: http://www.github.com/malaimo2900
 * Description: An JavaScript Package plugin for wordpress which contains Ember.JS (http://emberjs.com/), Angular JS (https://angularjs.org/), Backbone JS (http://backbonejs.org).
 * Version: 0.1
 * Author: Michael Alaimo
 * Author URI: http://blog.quantum-foam.org
 */




defined('ABSPATH') or die("Please do not run script directly.");

define('WP_JSPKG_PLUGIN_DEBG', TRUE);

define('WP_JSPKG_PATH', realpath(__DIR__));
define('WP_JSPKG_PLUGIN_URL', plugins_url( '' , WP_JSPKG_PATH ) );
define('WP_JSPKG_EMBER_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/ember.min.js' );
define('WP_JSPKG_ANGULAR_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/angular.min.js' );
define('WP_JSPKG_BACKBONE_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/backbone-min.js' );

include(WP_JSPKG_PATH. "/includes/wp-jspkg-main.php");

$jspkg = new WPJSPKG();
$jspkg->init();
?>