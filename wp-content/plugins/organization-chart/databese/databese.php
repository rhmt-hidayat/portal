<?php

defined( 'ABSPATH' ) || exit;

//instaling databese
class wpda_org_chart_databese{
	
	public static $table_names;
	
	function __construct(){
		global $wpdb;
		self::$table_names=array(
			'tree'=>$wpdb->prefix.'wpda_org_chart_tree',
			'theme'=>$wpdb->prefix.'wpda_org_chart_theme'
		);
	}
	
	public function create_chart_table(){
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		//install tree databese
		$table_name =  self::$table_names['tree'];	
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		`id` int(10) NOT NULL AUTO_INCREMENT,
		  `name` varchar(512) NOT NULL,
		  `tree_nodes` longtext NOT NULL,
			UNIQUE KEY id (id)		
		) $charset_collate;";	
		dbDelta( $sql );
	}
	
	public function create_theme_table(){
		global $wpdb;
		//install org chart theme databese
		$table_name =  self::$table_names['theme'];	
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		`id` int(10) NOT NULL AUTO_INCREMENT,
		  `name` varchar(512) NOT NULL,
		  `option_value` longtext NOT NULL,
		  `default` tinyint(4) NOT NULL,
			UNIQUE KEY id (id)		
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );	
	}
	
	public static function insert_to_chart_default_values(){
		global $wpdb;
		$isset_chart = $wpdb->get_col( 'SELECT `id` FROM '.self::$table_names['tree'].' ORDER BY `id` ASC');
		if($isset_chart == null){
			$chart_value = '{"0":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Ceo","node_description":"IT company","theme":"0"},"chidrens":{"0":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Main","node_description":"Designer","theme":"0"},"chidrens":{"0":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Mid ","node_description":"Designer","theme":"0"},"chidrens":{}},"1":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Mid","node_description":"Designer","theme":"0"},"chidrens":{}},"2":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Mid ","node_description":"Designer","theme":"0"},"chidrens":{}}}},"1":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Main","node_description":"Programmer","theme":"0"},"chidrens":{"0":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Mid","node_description":"Programmer","theme":"0"},"chidrens":{}},"1":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Mid","node_description":"Programmer","theme":"0"},"chidrens":{}},"2":{"node_info":{"image_url":"' . wpda_org_chart_plugin_url . 'admin/images/person_images/default.png","node_title":"Mid","node_description":"Programmer","theme":"0"},"chidrens":{}}}}}}}';
			$chart_name = 'Default';
			$wpdb->insert( self::$table_names['tree'], 
				array( 
					'id' => 5,
					'name' => $chart_name,
					'tree_nodes' => $chart_value,				
				), 
				array( 
					'%d',
					'%s', 
					'%s',
				) 
			);
		}		
	}
	
	public static function insert_to_theme_default_values(){
		global $wpdb;		
		$isset_theme = $wpdb->get_col( 'SELECT `id` FROM '.self::$table_names['theme'].' ORDER BY `id` ASC');		
		$isset_defoult_theme = $wpdb->get_var( "SELECT `id` FROM ".self::$table_names['theme'] ." WHERE `default`=1" );
		$default = 0;
		if(!$isset_defoult_theme){
			$default = 1;
		}
		if($isset_theme == null){
			$theme_value = '{"name":"Default","mobile_frendly":"mobile","background_color":{"color1":"#ffffff","color2":"rgba(255,255,255,0)","gradient":"none"},"border_radius":{"desktop":"0","metric_desktop":"px"},"padding":{"responsive":"desktop","desktop_top":"20","desktop_right":"0","desktop_bottom":"20","desktop_left":"0","metric_desktop":"px","tablet_top":"","tablet_right":"","tablet_bottom":"","tablet_left":"","metric_tablet":"px","mobile_top":"","mobile_right":"","mobile_bottom":"","mobile_left":"","metric_mobile":"px"},"line_color":"#cccccc","line_height":{"desktop":"1","metric_desktop":"px"},"item_bg_color":{"color1":"rgba(255,255,255,0)","color2":"rgba(255,255,255,0)","gradient":"none"},"item_min_width":{"responsive":"desktop","desktop":"120","metric_desktop":"px","tablet":"","metric_tablet":"px","mobile":"","metric_mobile":"px"},"item_min_height":{"responsive":"desktop","desktop":"130","metric_desktop":"px","tablet":"","metric_tablet":"px","mobile":"","metric_mobile":"px"},"item_img_max_width":{"desktop":"100","metric_desktop":"px"},"item_img_max_height":{"desktop":"100","metric_desktop":"px"},"item_img_border_radius":{"desktop":"0","metric_desktop":"%"},"item_img_margin":{"responsive":"desktop","desktop_top":"0","desktop_right":"0","desktop_bottom":"5","desktop_left":"0","metric_desktop":"px","tablet_top":"","tablet_right":"","tablet_bottom":"","tablet_left":"","metric_tablet":"px","mobile_top":"","mobile_right":"","mobile_bottom":"","mobile_left":"","metric_mobile":"px"},"item_title_font_family":"Arial,Helvetica Neue,Helvetica,sans-serif","item_title_color":"","item_title_font_size":{"responsive":"desktop","desktop":"14","metric_desktop":"px","tablet":"","metric_tablet":"px","mobile":"","metric_mobile":"px"},"item_title_line_height":{"desktop":"","metric_desktop":"px"},"item_title_letter_spacing":{"desktop":"","metric_desktop":"px"},"item_title_font_weight":"bold","item_title_font_style":"initial","item_title_margin":{"responsive":"desktop","desktop_top":"0","desktop_right":"0","desktop_bottom":"0","desktop_left":"0","metric_desktop":"px","tablet_top":"","tablet_right":"","tablet_bottom":"","tablet_left":"","metric_tablet":"px","mobile_top":"","mobile_right":"","mobile_bottom":"","mobile_left":"","metric_mobile":"px"},"item_description_font_family":"Arial,Helvetica Neue,Helvetica,sans-serif","item_description_color":"","item_description_font_size":{"responsive":"desktop","desktop":"12","metric_desktop":"px","tablet":"","metric_tablet":"px","mobile":"","metric_mobile":"px"},"item_description_line_height":{"desktop":"","metric_desktop":"px"},"item_description_letter_spacing":{"desktop":"","metric_desktop":"px"},"item_description_font_weight":"initial","item_description_font_style":"initial","item_description_margin":{"responsive":"desktop","desktop_top":"5","desktop_right":"0","desktop_bottom":"5","desktop_left":"0","metric_desktop":"px","tablet_top":"","tablet_right":"","tablet_bottom":"","tablet_left":"","metric_tablet":"px","mobile_top":"","mobile_right":"","mobile_bottom":"","mobile_left":"","metric_mobile":"px"},"item_border_type":"solid","item_border_color":"","item_border_width":{"desktop":"","metric_desktop":"px"},"item_border_radius":{"desktop":"","metric_desktop":"px"}}';			
			$theme_name = 'Default';			
			$wpdb->insert( self::$table_names['theme'], 
				array( 
					'id' => 50,
					'name' => $theme_name,
					'option_value' => $theme_value,
					'default' => $default,				
				), 
				array( 
					'%d',
					'%s', 
					'%s',
					'%d',
				) 
			);			
		}
	}
} 
?>