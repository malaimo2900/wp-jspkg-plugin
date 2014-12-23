<?php

/**
 *  @package wp-jspkg-plugin
 *  @author  Michael Alaimo
 **/


class WPJSPKG {
    public function init() {
        add_action('wp_enqueue_scripts', array($this, "wp_jspkg_plugin_init"));
        
        if (is_admin()) {
        	add_action('admin_menu', array( $this, 'wp_jspkg_admin_menu'));
			add_action('admin_init', array( $this, 'wp_jspkg_admin_init'));
        }
    }
    
    
    public function wp_jspkg_admin_menu() {
		add_options_page(
			'JavaScript Package Admin', 
			'JSPKG Admin', 
			'manage_options', 
			'wp_jskpg_admin', 
			array($this, 'wp_jspkg_admin_page')
		);
    }
    
    
    public function wp_jspkg_admin_init() {
    	add_settings_section(
	    	'wp_jspkg_settings_opt_group', 
	    	'Toggle JavaScript Package Settings', 
	    	null,
	    	'wp_jskpg_admin'
    	);
    	$settingsConfig = array(
    			array('emberjs', 'Ember JS'), 
    			array('angular', 'Angular JS'),
    			array('backbone', 'Backbone JS')
    	);
    	foreach ($settingsConfig as $setting) {
    		$optName = 'wp_jspkg_'.$setting[0];
    		register_setting(
	    		'wp_jspkg_settings_opt_group',
	    		$optName
			);

    		$option = get_option($optName);
	    	if (isset($_POST['submit']) && @$_POST[$optName] !== $option) {
	    		$option = intval(@$_POST[$optName]);
	    		update_option($optName, $option);
	    	}
	    	
	    	add_settings_field(
		    	$optName, 
		    	'Enable/Disable '.$setting[1], 
		    	function() use($option, $optName) {
		    		printf('<input type="checkbox" id="'.$optName.'" name="'.$optName.'" value="1" %s />',
		    				($option == 1 ? 'checked="checked"' : ''));
		    	},
		    	'wp_jskpg_admin', 
		    	'wp_jspkg_settings_opt_group' 
	    	);
    	}
    	unset($settingsConfig, $setting, $option, $optName);
    }
    
    
    public function wp_jspkg_field_ember() {
    	echo $this->wp_jspkg_field('emberjs');
    }
    
    
    public function wp_jspkg_field_angular() {
    	echo $this->wp_jspkg_field('angular');
    }
    
    
    public function wp_jspkg_field_backbone() {
    	echo $this->wp_jspkg_field('backbone');
    }
    
    
    public function wp_jspkg_admin_page() {
?>
	<div class="wrap">
		<h2>Enable/Disable JavaScript Files</h2> 
		<form method="post" action="<?php echo get_page_uri('wp_jspkg_admin_page'); ?>">
<?php
		settings_fields('wp_jspkg_settings_opt_group');   
		do_settings_sections('wp_jskpg_admin');
		submit_button(); 
?>
		</form>
	</div>
<?php
    }
    
    
    public function wp_jspkg_plugin_init($attr) {
    	if (get_option('wp_jspkg_emberjs') == 1) {
    		wp_enqueue_script('ember', WP_JSPKG_EMBER_JS_URL, null, '1.9.0', FALSE);
    	}
    	if (get_option('wp_jspkg_angular') == 1) {
    		wp_enqueue_script('angular', WP_JSPKG_ANGULAR_JS_URL, null, '1.3.8', FALSE);
    	}
    	if (get_option('wp_jspkg_backbone') == 1) {
    		wp_enqueue_script('backbone', WP_JSPKG_BACKBONE_JS_URL, null, '1.1.2', FALSE);
    	}
        
    	return  TRUE;
    }
}
