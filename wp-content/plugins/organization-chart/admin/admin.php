<?php

class wpda_org_chart_admin_main{
	
	function __construct(){
		if(is_admin()){
			$this->admin_files();
			$this->admin_filters();
		}
		$this->gutenberg();
	}
	
	private function admin_files(){
		require_once(wpda_org_chart_plugin_path.'admin/org_chart_tree.php');
		require_once(wpda_org_chart_plugin_path.'admin/tree_theme.php');
	}
	
	private function admin_filters(){
		add_action( 'admin_menu', array($this,'create_admin_menu') );
		//classic editor button
		add_filter( 'mce_external_plugins', array( $this ,'mce_external_plugins' ) );
		add_filter( 'mce_buttons', array($this, 'mce_buttons' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'mce_buttons_style' ));
		add_action('wp_ajax_wpda_org_chart_post_page_content', array($this,"post_page_content"));
	}
	
	public function create_admin_menu(){
		global $submenu;
		$main_page = add_menu_page( "Wpdevart Chart", "Wpdevart Chart", 'manage_options', "wpda_chart_tree_page", array($this, 'manage_tree'),'dashicons-networking');
		add_submenu_page( "wpda_chart_tree_page", "Charts", "Charts", 'manage_options',"wpda_chart_tree_page",array($this, 'manage_tree'));
		$theme = add_submenu_page( "wpda_chart_tree_page", "Themes", "Themes", 'manage_options',"wpda_chart_tree_themes",array($this, 'manage_tree_themes'));
		$featured_page = add_submenu_page( "wpda_chart_tree_page", "Featured Plugins", "Featured Plugins", 'manage_options',"wpda_chart_featured_plugins",array($this, 'featured_plugins'));
		add_action('admin_print_styles-' .$main_page, array($this,'tree_page_js_css'));
		add_action('admin_print_styles-' .$theme, array($this,'tree_theme_js_css'));
		add_action('admin_print_styles-' .$featured_page, array($this,'tree_featured_plugins_js_css'));
		
		if(isset($submenu['wpda_chart_tree_page']))
			add_submenu_page( 'wpda_chart_tree_page', "Support or Any Ideas?", "<span style='color:#00ff66' >Support or Any Ideas?</span>", 'manage_options',"wpdevar_youtube_any_ideas",array($this, 'any_ideas'),156);
		if(isset($submenu['wpda_chart_tree_page']))
			$submenu['wpda_chart_tree_page'][3][2]=wpda_org_chart_support_url;
	}
	
	public function tree_page_js_css(){
		wp_enqueue_script('angularejs',wpda_org_chart_plugin_url.'admin/js/angular.min.js');
		wp_enqueue_script("wpda_chart_tree_page_js",wpda_org_chart_plugin_url.'admin/js/tree_page.js');
		wp_localize_script("wpda_chart_tree_page_js", 'req_urls', array( 'plug_url' => wpda_org_chart_plugin_url ));
		// css 
		wp_enqueue_style('wpda_chart_tree_page_css',wpda_org_chart_plugin_url.'admin/css/tree_page.css');
		wp_enqueue_media();
	}
	
	public function tree_theme_js_css(){
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script('angularejs',wpda_org_chart_plugin_url.'admin/js/angular.min.js');
		wp_enqueue_script("wpda_chart_tree_page_js",wpda_org_chart_plugin_url.'admin/js/theme_page.js');
		wp_enqueue_script('wpda_library_admin_js',wpda_org_chart_plugin_url.'library/js/admin.js');
		wp_localize_script( 'alpha-color-picker', 'wpColorPickerL10n', array(
			'clear'            =>'Clear',
			'clearAriaLabel'   =>'Clear color',
			'defaultString'    =>'Default',
			'defaultAriaLabel' =>'Select default color',
			'pick'             =>'Select Color',
			'defaultLabel'     =>'Color value',
		) ); // error withouth this
		wp_enqueue_script( 'alpha-color-picker' );
		// css 
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style('wpda_chart_tree_theme_page_css',wpda_org_chart_plugin_url.'admin/css/theme_page.css');
		wp_enqueue_style('wpda_library_admin_css',wpda_org_chart_plugin_url.'library/css/admin.css');		
	}
	
	public function tree_featured_plugins_js_css(){
		wp_enqueue_style('wpda_chart_featured_page_css',wpda_org_chart_plugin_url.'admin/css/featured_plugins_css.css');
	}
	
	public function manage_tree(){
		$this->org_chart_tree = new wpda_org_chart_admin_tree();
	}
	
	public function manage_tree_themes(){		
		$this->org_chart_tree_themes = new wpda_org_chart_tree_theme_page();
		$this->org_chart_tree_themes->controller_page();
	}
	
	/*concect with gutenberg editor*/
	public function gutenberg(){	
		require_once(wpda_org_chart_plugin_path.'admin/gutenberg/gutenberg.php');
		$gutenberg=new wpda_chart_gutenberg();		
		
	}
	/*post page button*/
	public function mce_external_plugins( $plugin_array ) {
		$plugin_array["wpda_org_chart"] = wpda_org_chart_plugin_url.'admin/js/post_page_insert_button.js';
		return $plugin_array;
	}
	/*post page button add_class*/
	public function mce_buttons( $buttons ) {
		array_push( $buttons, "wpda_org_chart" );
		return $buttons;
	} 
	/*button styling*/
	public function mce_buttons_style(){
		wp_register_style( 'wpda_org_chart_inline_css', false );
		wp_enqueue_style( 'wpda_org_chart_inline_css' );
		wp_add_inline_style( 'wpda_org_chart_inline_css', '.mce-i-wpdevart_org_chart.dashicons.dashicons-networking::before{font-family: \'dashicons\';font-size: 20px;color:}' );
	}
	/*button html*/
	public function post_page_content(){
		global $wpdb;
		$trees = $wpdb->get_results('SELECT `id`,`name` FROM '.wpda_org_chart_databese::$table_names['tree']);
		$themes = $wpdb->get_results('SELECT `id`,`name` FROM '.wpda_org_chart_databese::$table_names['theme']);
		$cur_chart=intval($_GET["chart_id"])."";
		$cur_theme=intval($_GET["theme_id"])."";
		$html='<!DOCTYPE html>';
		$html.='<html xmlns="http://www.w3.org/1999/xhtml">';
		$html.='<head>';
		$html.='<title>WpDevArt Organization Chart</title>';
		$html.='<script language="javascript" type="text/javascript" src="'.site_url().'/wp-includes/js/tinymce/tiny_mce_popup.js"></script>';
		$html.='<script language="javascript" type="text/javascript" src="'.site_url().'/wp-includes/js/tinymce/utils/mctabs.js"></script>';
		$html.='<script language="javascript" type="text/javascript" src="'.site_url().'/wp-includes/js/tinymce/utils/form_utils.js"></script>';		
		$html.='<script type="text/javascript">';
		$html.='function insert_chart() {'	;				  
		$html.='let tagtext;';
		$html.='tagtext = \'<p>[wpda_org_chart tree_id="\' + document.getElementById("select_chart").value + \'"  theme_id="\' + document.getElementById("select_theme").value + \'"]</p>\';';
		$html.='window.parent.tinyMCE.execCommand("mceInsertContent", false, tagtext);';
		$html.='tinyMCEPopup.close();}';
		$html.='</script>';
		$html.='</head><body>';
		$html.='<table width="100%" style="margin-bottom: 100px;" class="paramlist admintable" cellspacing="1"><tbody><tr>';
		$html.='<td style="width: 150px;vertical-align: top;" class="paramlist_key"><span class="editlinktip"><label style="font-size:12px;" class="hasTip">Select a Tree: </label></span></td>';
		$html.='<td class="paramlist_value" ><select style="min-width:200px;font-size:12px" id="select_chart">';
		foreach($trees as $key => $value){
			$html.='<option '.selected($value->id,$cur_chart,false).' value="'.$value->id.'">'.$value->name.'</option>';
		}
		$html.='</td></tr><tr><td style="width: 150px;" class="paramlist_key"><span class="editlinktip"><label style="font-size:12px" class="hasTip">Select a Theme: </label></span></td><td class="paramlist_value" ><select style="min-width:200px;font-size:12px" id="select_theme">';
		foreach($themes as $key => $value){
			$html.='<option '.selected($value->id,$cur_theme,false).' value="'.$value->id.'">'.$value->name.'</option>';
		}
		$html.='</select></td></tr></tbody></table>';
		$html.='<div class="mceActionPanel"><div style="float: left"><input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();"/></div><div style="float: right"><input type="submit" id="insert" name="insert" value="Insert" onClick="insert_chart();"/><input type="hidden" name="iden" value="1"/></div></div>';
		$html.='</body></html>';
		echo $html;
		exit;
	}
	public function hire_expert(){
		$plugins_array=array(
			'custom_site_dev'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/1.png',
				'title'			=>	'Custom WordPress Development',
				'description'	=>	'Hire a WordPress expert and make any custom development for your WordPress website.'
			),
			'custom_plug_dev'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/2.png',
				'title'			=>	'WordPress Plugin Development',
				'description'	=>	'Our developers can create any WordPress plugin from zero. Also, they can customize any plugin and add any functionality.'
			),
			'custom_theme_dev'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/3.png',
				'title'			=>	'WordPress Theme Development',
				'description'	=>	'If you need an unique theme or any customizations for a ready theme, then our developers are ready.'
			),
			'custom_theme_inst'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/4.png',
				'title'			=>	'WordPress Theme Installation and Customization',
				'description'	=>	'If you need a theme installation and configuration, then just let us know, our experts configure it.'
			),
			'gen_wp_speed'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/5.png',
				'title'			=>	'General WordPress Support',
				'description'	=>	'Our developers can provide general support. If you have any problem with your website, then our experts are ready to help.'
			),
			'speed_op'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/6.png',
				'title'			=>	'WordPress Speed Optimization',
				'description'	=>	'Hire an expert from WpDevArt and let him take care of your website speed optimization.'
			),
			'mig_serv'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/7.png',
				'title'			=>	'WordPress Migration Services',
				'description'	=>	'Our developers can migrate websites from any platform to WordPress.'
			),
			'page_seo'=>array(
				'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/hire_expert/8.png',
				'title'			=>	'WordPress On-Page SEO',
				'description'	=>	'On-page SEO is an important part of any website. Hire an expert and they will organize the on-page SEO for your website.'
			)
		);
		$content='';
		
		$content.='<h1 class="wpdev_hire_exp_h1"> Hire an Expert from WpDevArt </h1>';
		$content.='<div class="hire_expert_main">';		
		foreach($plugins_array as $key => $plugin) {
			$content.='<div class="wpdevart_hire_main"><a target="_blank" class="wpdev_hire_buklet" href="https://wpdevart.com/hire-a-wordpress-developer-online-submit-form/">';
			$content.='<div class="wpdevart_hire_image"><img src="'.$plugin["image_url"].'"></div>';
			$content.='<div class="wpdevart_hire_information">';
			$content.='<div class="wpdevart_hire_title">'.$plugin["title"].'</div>';			
			$content.='<p class="wpdevart_hire_description">'.$plugin["description"].'</p>';
			$content.='</div></a></div>';		
		} 
		$content.='<div><a target="_blank" class="wpdev_hire_button" href="https://wpdevart.com/hire-a-wordpress-developer-online-submit-form/">Start a project</a></div>';
		$content.='</div>';
		
		echo $content;
	
	}
	
	public function featured_plugins(){
		$plugins_array=array(
			'gallery_album'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/gallery-album-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-gallery-plugin',
						'title'			=>	'WordPress Gallery plugin',
						'description'	=>	'Gallery plugin is an useful tool that will help you to create Galleries and Albums. Try our nice Gallery views and awesome animations.'
						),		
			'coming_soon'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/coming_soon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-coming-soon-plugin/',
						'title'			=>	'Coming soon and Maintenance mode',
						'description'	=>	'Coming soon and Maintenance mode plugin is an awesome tool to show your visitors that you are working on your website to make it better.'
						),
			'Contact forms'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/contact_forms.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-contact-form-plugin/',
						'title'			=>	'Contact Form Builder',
						'description'	=>	'Contact Form Builder plugin is an handy tool for creating different types of contact forms on your WordPress websites.'
						),						
			'countdown-extended'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/countdown-extended-featured.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-countdown-extended-version',
						'title'			=>	'WordPress Countdown Extended',
						'description'	=>	'Countdown extended is a fresh and extended version of the countdown timer. You can easily create and add countdown timers to your website.'
						),	
			'Booking Calendar'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/Booking_calendar_featured.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-booking-calendar-plugin/',
						'title'			=>	'WordPress Booking Calendar',
						'description'	=>	'WordPress Booking Calendar plugin is an awesome tool to create a booking system for your website. Create booking calendars in a few minutes.'
						),
			'Pricing Table'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/Pricing-table.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-pricing-table-plugin/',
						'title'			=>	'WordPress Pricing Table',
						'description'	=>	'WordPress Pricing Table plugin is a nice tool for creating beautiful pricing tables. Use WpDevArt pricing table themes and create tables just in a few minutes.'
						),							
			'youtube'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/youtube.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-youtube-embed-plugin',
						'title'			=>	'WordPress YouTube Embed',
						'description'	=>	'YouTube Embed plugin is an convenient tool for adding videos to your website. Use YouTube Embed plugin for adding YouTube videos in posts/pages, widgets.'
						),
            'facebook-comments'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/facebook-comments-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-comments-plugin/',
						'title'			=>	'Wpdevart Social comments',
						'description'	=>	'WordPress Facebook comments plugin will help you to display Facebook Comments on your website. You can use Facebook Comments on your pages/posts.'
						),						
			'countdown'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/countdown.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-countdown-plugin/',
						'title'			=>	'WordPress Countdown plugin',
						'description'	=>	'WordPress Countdown plugin is an nice tool for creating countdown timers for your website posts/pages and widgets.'
						),
			'lightbox'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/lightbox.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-lightbox-plugin',
						'title'			=>	'WordPress Lightbox plugin',
						'description'	=>	'WordPress Lightbox Popup is an high customizable and responsive plugin for displaying images and videos in popup.'
						),
			'facebook'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/facebook.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-like-box-plugin',
						'title'			=>	'Social Like Box',
						'description'	=>	'Facebook like box plugin will help you to display Facebook like box on your wesite, just add Facebook Like box widget to sidebar or insert it into posts/pages and use it.'
						),
			'poll'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/poll.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-polls-plugin',
						'title'			=>	'WordPress Polls system',
						'description'	=>	'WordPress Polls system is an handy tool for creating polls and survey forms for your visitors. You can use our polls on widgets, posts and pages.'
						),
			'vertical menu'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/vertical-menu.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-polls-plugin',
						'title'			=>	'WordPress Vertical Menu',
						'description'	=>	'WordPress Vertical Menu is a handy tool for adding nice vertical menus. You can add icons for your website vertical menus using our plugin.'
						),
			'duplicate_page'=>array(
						'image_url'		=>	wpda_org_chart_plugin_url.'admin/images/featured_plugins/featured-duplicate.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-duplicate-page-plugin-easily-clone-posts-and-pages/',
						'title'			=>	'WordPress Duplicate page',
						'description'	=>	'Duplicate Page or Post is a great tool that allows duplicating pages and posts. Now you can do it with one click.'
						),						
						
			
		);
		?>      
		<h1>Featured Plugins</h1>
		<?php foreach($plugins_array as $key=>$plugin) { ?>
		<div class="featured_plugin_main">
			<div class="featured_plugin_image"><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><img src="<?php echo $plugin['image_url'] ?>"></a></div>
			<div class="featured_plugin_information">
				<div class="featured_plugin_title"><h4><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><?php echo $plugin['title'] ?></a></h4></div>
				<p class="featured_plugin_description"><?php echo $plugin['description'] ?></p>
				<a target="_blank" href="<?php echo $plugin['site_url'] ?>" class="blue_button">Check The Plugin</a>
			</div>
			<div style="clear:both"></div>                
		</div>
		<?php } 
	
	}
}