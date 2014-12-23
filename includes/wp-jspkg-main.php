<?php

/**
 *  @package wp-jspkg-plugin
 *  @author  Michael Alaimo
 **/


class WPJSPKG {
	private $config = array();
	private static $instance = null;
	
	
	public static function obj() {
		if (!(self::$instance instanceof WPJSPKG)) {
			self::$instance = new WPJSPKG();
		}
		
		return self::$instance;
	}
	
	public static function addScript($ext, $name, $script, $version) {
		self::obj()->config = array_merge(self::obj()->config, array('wp_jspkg_'.$ext => array($name, $script, $version)));
	}
	
	
    public function init($config) {
    	$this->config = array_merge($this->config, $config);
    	
    	
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
    	);;
    	foreach ($this->config as $optName => $setting) {;
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
		    	'Enable/Disable '.$setting[0], 
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
    	foreach ($this->config as $option => $config) {
	    	if (get_option($option) == 1) {
	    		wp_enqueue_script($option, $config[1], null, $config[2], FALSE);
	    	}
    	}
        
    	return  TRUE;
    }
}
