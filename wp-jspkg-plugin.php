<?php
/**
 * Plugin Name: WP-JSPKG
 * Plugin URI: http://www.github.com/malaimo2900/wp-jspkg-plugin
 * Description: An JavaScript loader plugin
 * Version: 0.1
 * Author URI: http://blog.quantum-foam.org
 */


defined('ABSPATH') or die("Please do not run script directly.");

define('WP_JSPKG_PLUGIN_DEBG', TRUE);

define('WP_JSPKG_PATH', realpath(__DIR__));
define('WP_JSPKG_PLUGIN_URL', plugins_url( '' , WP_JSPKG_PATH ) );
define('WP_JSPKG_EMBER_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/ember.min.js' );
define('WP_JSPKG_HANDLEBARS_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/handlebars-v2.0.0.js' );
define('WP_JSPKG_ANGULAR_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/angular.min.js' );
define('WP_JSPKG_SYNAPSE_JS_URL',  WP_JSPKG_PLUGIN_URL . '/js/synapse-min.js' );


require_once(WP_JSPKG_PATH. "/includes/wp-jspkg-main.php");


$config = array(
		'wp_jspkg_emberjs' => array('Ember JS', WP_JSPKG_EMBER_JS_URL, '1.9.0'),
		'wp_jspkg_handlebars' => array('Handlebars', WP_JSPKG_HANDLEBARS_JS_URL, '2.0.0'),
		'wp_jspkg_angular' => array('Angular JS', WP_JSPKG_ANGULAR_JS_URL, '1.3.8'),
		'wp_jspkg_synapse' => array('Synapse JS', WP_JSPKG_SYNAPSE_JS_URL, '0.5.1')
);


WPJSPKG::obj()->init($config);


?>