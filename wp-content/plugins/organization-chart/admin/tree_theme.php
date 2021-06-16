<?php
class wpda_org_chart_tree_theme_page{
	
	private $options;
	
	function __construct(){		
		$this->options=self::return_params_array();					
	}
	
	public static function return_params_array(){	
		return array(
			"org_chart_theme_general"=>array(
				"heading_name"=>"General Settings",
				"params"=>array(
					"mobile_frendly"=>array(
						"title"=>"Responsive",
						"description"=>"How to display the chart, of the organization chart is bigger than the container. Set the  Mobile View & Horizontal option, if you need to display the mobile view only on mobile devices and the horizontal scrolling view on devices with a bigger resolution.",						
						"values"=>array("add_scrolll"=>"Horizontal scroll ","mobile"=>"Mobile view","mob_view_only_on_mob"=>"Mobile View & Horizontal scroll"),
						"default_value"=>"mobile",
						"function_name"=>"radio",
					),
					"scroll_position"=>array(
						"title"=>"Scroll position",
						"description"=>"Type the horizontal scroll position",						
						"default_value"=>"0",
						"show_val"=>true,
						"min_value" => '0',
						"max_value" => '100',
						"small_text" => '%',
						"function_name"=>"range_input",						
					),					
					"background_color"=>array(
						"title"=>"Background Color",
						"description"=>"Set the container background color.",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>"0"),
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
						"function_name"=>"gradient_color_input",
						"transparent"=>true,
					),
					"border_radius"=>array(
						"title"=>"Border Radius",
						"description"=>"Type the container border radius.",
						"default_value"=>array('desktop'=>'0','metric_desktop'=>'px'),
						"function_name"=>"simple_input",
						"metric"=>array("px","%"),
					),
					"padding"=>array(
						"title"=>"Padding",
						"description"=>"Type Padding",
						"default_value"=>array(
							'desktop_top'=>'0',
							'desktop_right'=>'0',
							'desktop_bottom'=>'0',
							'desktop_left'=>'0',
							'tablet_top'=>'',
							'tablet_right'=>'',
							'tablet_bottom'=>'',
							'tablet_left'=>'',
							'mobile_top'=>'',
							'mobile_right'=>'',
							'mobile_bottom'=>'',
							'mobile_left'=>'',
							'metric_desktop'=>'px',
							'metric_tablet'=>'px',
							'metric_mobile'=>'px',
						),
						"metric"=>array("px"),
						"function_name"=>"margin_padding_input",
						"responsive"=>true,
					),
					
				)
			),
			"line_css"=>array(
				"heading_name"=>"Line style",
				"params"=>array(					
					"line_color"=>array(
						"title"=>"Set the line color.",
						"description"=>"Select line color",
						"default_value"=>"#cccccc",
						"function_name"=>"color_input",
					),
					
					"line_height"=>array(
						"title"=>"Line Height",
						"description"=>"Type the line height.",
						"default_value"=>array('desktop'=>'1','metric_desktop'=>'px'),
						"function_name"=>"simple_input",
						"metric"=>array("px"),
					),
					
					
				),
			),
			"items_css"=>array(
				"heading_name"=>"Item style",
				"pro"=>true,
				"params"=>array(					
					"item_bg_color"=>array(
						"title"=>"Background Color",
						"description"=>"Select item background color",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>"0"),
						"default_value"=>array("color1"=>"#ffffff","color2"=>"#ffffff","gradient"=>"none"),
						"function_name"=>"gradient_color_input",
						"pro"=>true,
					),
					"item_min_width"=>array(
						"title"=>"Minimum Width",
						"description"=>"Type minimum Width",
						"default_value"=>array('desktop'=>'120','tablet'=>'','mobile'=>'','metric_desktop'=>'px'),
						"metric"=>array("px"),
						"responsive"=>true,
						"function_name"=>"simple_input",
						"pro"=>true,
					),
					"item_min_height"=>array(
						"title"=>"Minimum Height",
						"description"=>"Type minimum Height",
						"default_value"=>array('desktop'=>'130','tablet'=>'','mobile'=>'','metric_desktop'=>'px'),
						"metric"=>array("px",'%'),
						"responsive"=>true,
						"function_name"=>"simple_input",
						"pro"=>true,
					),
					"item_min_max_width"=>array(
						"title"=>"Maximum Width",
						"description"=>"Type maximum Width",
						"default_value"=>array('desktop'=>'','tablet'=>'','mobile'=>'','metric_desktop'=>'px'),
						"metric"=>array("px"),
						"responsive"=>true,
						"function_name"=>"simple_input",
						"pro"=>true,
					),
					"item_img_max_width"=>array(
						"title"=>"Image width",
						"description"=>"Type image width",
						"default_value"=>array('desktop'=>'120','metric_desktop'=>'px'),
						"metric"=>array("px",'%'),
						"function_name"=>"simple_input",
						"pro"=>true,
					),
									
					"item_img_max_height"=>array(
						"title"=>"Image height",
						"description"=>"Type image height",
						"default_value"=>array('desktop'=>'130','metric_desktop'=>'px'),
						"metric"=>array("px",'%'),
						"function_name"=>"simple_input",
						"pro"=>true,
					),
					"item_img_border_radius"=>array(
						"title"=>"Image Border Radius",
						"description"=>"Type image border radius",
						"default_value"=>array('desktop'=>'0','metric_desktop'=>'px'),
						"metric"=>array("px","%"),
						"preview" => array('id'=>'item_border_demo','action'=>'border-radius'),
						"function_name"=>"simple_input",
						"pro"=>true,
					),
					"item_img_margin"=>array(
						"title"=>"Image Margin",
						"description"=>"Type image margin",
						"default_value"=>array(
							'desktop_top'=>'0',
							'desktop_right'=>'0',
							'desktop_bottom'=>'0',
							'desktop_left'=>'0',
							'tablet_top'=>'',
							'tablet_right'=>'',
							'tablet_bottom'=>'',
							'tablet_left'=>'',
							'mobile_top'=>'',
							'mobile_right'=>'',
							'mobile_bottom'=>'',
							'mobile_left'=>'',
							'metric_desktop'=>'px',
							'metric_tablet'=>'px',
							'metric_mobile'=>'px',
						),
						"metric"=>array("px",'%'),
						"function_name"=>"margin_padding_input",
						"responsive"=>true,
						"pro"=>true,
					),	
					"item_title_font_popup"=>array(
						"title"=>"Title font",
						"description"=>"Configure the title font style.",
						"function_name"=>"popup",
						"pro"=>true,
						"params" => array(
							"item_title_font_family"=>array(
								"title"=>"Font Family",
								"description"=>"Select font family",				
								"function_name"=>"simple_select",
								"values"=>wpda_org_chart_library::fonts_select(),
								"default_value"=>"serif",
								"preview" => array('id'=>'item_title_demo_text','action'=>'font-family'),
							),
							"item_title_color"=>array(
								"title"=>"Color",
								"description"=>"Select color",
								"default_value"=>"#000000",
								"function_name"=>"color_input",
								"preview" => array('id'=>'item_title_demo_text','action'=>'color'),
							),
							"item_title_font_size"=>array(
								"title"=>"Font Size",
								"description"=>"Font size:",
								"default_value"=>array('desktop'=>'14','metric_desktop'=>'px'),
								"function_name"=>"simple_input",
								"responsive"=>true,
								"metric"=>array("px","em","rem","vw"),								
								"preview" => array('id'=>'item_title_demo_text','action'=>'font-size'),
							),
							"item_title_line_height"=>array(
								"title"=>"Line Height",
								"description"=>"Line height",
								"default_value"=>array('desktop'=>'normal','metric_desktop'=>'px'),
								"function_name"=>"simple_input",
								"metric"=>array("px","em","rem","vw"),
								"preview" => array('id'=>'item_title_demo_text','action'=>'line-height'),
							),
							"item_title_letter_spacing"=>array(
								"title"=>"Letter Spacing",
								"description"=>"Letter spacing",
								"default_value"=>array('desktop'=>'normal','metric_desktop'=>'px'),
								"function_name"=>"simple_input",
								"metric"=>array("px","em","rem","vw"),
								"preview" => array('id'=>'item_title_demo_text','action'=>'letter-spacing'),
							),
							"item_title_font_weight"=>array(
								"title"=>"Font Weight",
								"description"=>"Select font weight",				
								"function_name"=>"simple_select",
								"values"=>array('initial'=>'Initial','100'=>'100','200'=>'200','300'=>'300','400'=>'400','500'=>'500','600'=>'600','700'=>'700','800'=>'800','900'=>'900','normal'=>'Normal','bold'=>'Bold',),
								"default_value"=>"initial",
								"preview" => array('id'=>'item_title_demo_text','action'=>'font-weight'),
							),
							"item_title_font_style"=>array(
								"title"=>"Font Style",
								"description"=>"Select font style",				
								"function_name"=>"simple_select",
								"values"=>array('initial'=>'Initial','normal'=>'Normal','italic'=>'Italic','oblique'=>'Oblique'),
								"default_value"=>"initial",
								"preview" => array('id'=>'item_title_demo_text','action'=>'font-style'),
							),
						)
					),
					"item_title_demo_text"=>array(
						"title"=>"ABCDEFGHIK LMNOPQRSTVXYZ abcdefghik lmnopqrstvxyz",
						"function_name"=>"demo_text",
					),
					"item_title_margin"=>array(
						"title"=>"Title Margin",
						"description"=>"Type title margin",
						"default_value"=>array(
							'desktop_top'=>'0',
							'desktop_right'=>'0',
							'desktop_bottom'=>'0',
							'desktop_left'=>'0',
							'tablet_top'=>'',
							'tablet_right'=>'',
							'tablet_bottom'=>'',
							'tablet_left'=>'',
							'mobile_top'=>'',
							'mobile_right'=>'',
							'mobile_bottom'=>'',
							'mobile_left'=>'',
							'metric_desktop'=>'px',
							'metric_tablet'=>'px',
							'metric_mobile'=>'px',
						),
						"metric"=>array("px",'%'),
						"function_name"=>"margin_padding_input",
						"responsive"=>true,
						"pro"=>true,
					),
					"item_description_font_popup"=>array(
						"title"=>"Description font",
						"description"=>"Configure the description font style",
						"function_name"=>"popup",
						"pro"=>true,
						"params" => array(
							"item_description_font_family"=>array(
								"title"=>"Font Family",
								"description"=>"Select font family",				
								"function_name"=>"simple_select",
								"values"=>wpda_org_chart_library::fonts_select(),
								"default_value"=>"serif",
								"preview" => array('id'=>'item_description_demo_text','action'=>'font-family'),
							),
							"item_description_color"=>array(
								"title"=>"Color",
								"description"=>"Select clor",
								"default_value"=>"#000000",
								"function_name"=>"color_input",
								"preview" => array('id'=>'item_description_demo_text','action'=>'color'),
							),
							"item_description_font_size"=>array(
								"title"=>"Font Size",
								"description"=>"Font size",
								"default_value"=>array('desktop'=>'14','metric_desktop'=>'px'),
								"function_name"=>"simple_input",
								"responsive"=>true,
								"metric"=>array("px","em","rem","vw"),								
								"preview" => array('id'=>'item_description_demo_text','action'=>'font-size'),
							),
							"item_description_line_height"=>array(
								"title"=>"Line Height",
								"description"=>"Line height",
								"default_value"=>array('desktop'=>'normal','metric_desktop'=>'px'),
								"function_name"=>"simple_input",
								"metric"=>array("px","em","rem","vw"),
								"preview" => array('id'=>'item_description_demo_text','action'=>'line-height'),
							),
							"item_description_letter_spacing"=>array(
								"title"=>"Letter Spacing",
								"description"=>"Letter spacing",
								"default_value"=>array('desktop'=>'normal','metric_desktop'=>'px'),
								"function_name"=>"simple_input",
								"metric"=>array("px","em","rem","vw"),
								"preview" => array('id'=>'item_description_demo_text','action'=>'letter-spacing'),
							),
							"item_description_font_weight"=>array(
								"title"=>"Font Weight",
								"description"=>"Select font weight",				
								"function_name"=>"simple_select",
								"values"=>array('initial'=>'Initial','100'=>'100','200'=>'200','300'=>'300','400'=>'400','500'=>'500','600'=>'600','700'=>'700','800'=>'800','900'=>'900','normal'=>'Normal','bold'=>'Bold',),
								"default_value"=>"initial",
								"preview" => array('id'=>'item_description_demo_text','action'=>'font-weight'),
							),
							"item_description_font_style"=>array(
								"title"=>"Font Style",
								"description"=>"Select font style",				
								"function_name"=>"simple_select",
								"values"=>array('initial'=>'Initial','normal'=>'Normal','italic'=>'Italic','oblique'=>'Oblique'),
								"default_value"=>"initial",
								"preview" => array('id'=>'item_description_demo_text','action'=>'font-style'),
							),
						),
					),
					"item_description_demo_text"=>array(
						"title"=>"DABCDEFGHIK LMNOPQRSTVXYZ abcdefghik lmnopqrstvxyz",
						"function_name"=>"demo_text",
					),
					"item_description_margin"=>array(
						"title"=>"Description margin",
						"description"=>"Type description margin",
						"default_value"=>array(
							'desktop_top'=>'0',
							'desktop_right'=>'0',
							'desktop_bottom'=>'0',
							'desktop_left'=>'0',
							'tablet_top'=>'',
							'tablet_right'=>'',
							'tablet_bottom'=>'',
							'tablet_left'=>'',
							'mobile_top'=>'',
							'mobile_right'=>'',
							'mobile_bottom'=>'',
							'mobile_left'=>'',
							'metric_desktop'=>'px',
							'metric_tablet'=>'px',
							'metric_mobile'=>'px',
						),
						"metric"=>array("px",'%'),
						"function_name"=>"margin_padding_input",
						"responsive"=>true,
						"pro"=>true,
					),
					"item_border_popup"=>array(
						"title"=>"Item Border",
						"description"=>"Select item border",
						"function_name"=>"popup",
						"pro"=>true,
						"params" => array(
							"item_border_type"=>array(
								"title"=>"Item Border Type",
								"description"=>"Select border type",				
								"function_name"=>"simple_select",
								"preview" => array('id'=>'item_border_demo','action'=>'border-style'),
								"values"=>array("solid"=>"Solid","dotted"=>"Dotted","dashed"=>"Dashed","double"=>"Double","groove"=>"Groove","ridge"=>"Ridge","inset"=>"Inset","outset"=>"Outset"),
								"default_value"=>"solid",
							),
							"item_border_color"=>array(
								"title"=>"Item Border Color",
								"description"=>"Select item border color",
								"default_value"=>"#cccccc",
								"preview" => array('id'=>'item_border_demo','action'=>'border-color'),
								"function_name"=>"color_input",
							),
							"item_border_width"=>array(
								"title"=>"Border Width",
								"description"=>"Select border width",
								"default_value"=>array('desktop'=>'1','metric_desktop'=>'px'),
								"metric"=>array("px"),
								"preview" => array('id'=>'item_border_demo','action'=>'border-width'),
								"function_name"=>"simple_input",
							),										
							"item_border_radius"=>array(
								"title"=>"Border Radius",
								"description"=>"Select border radius",
								"default_value"=>array('desktop'=>'0','metric_desktop'=>'px'),
								"metric"=>array("px","%"),
								"preview" => array('id'=>'item_border_demo','action'=>'border-radius'),
								"function_name"=>"simple_input",
							),
						)
					),
					"item_border_demo"=>array(
						"title"=>"Border preview",
						"function_name"=>"demo_border",
					),
				),
			),
		);
	}
	
	public static function get_default_values_array(){
		$array_of_returned=array();
		$options=self::return_params_array();
		foreach($options as $param_heading_key=>$param_heading_value){
			foreach($param_heading_value['params'] as $key=>$value){
				$array_of_returned[$key]=$value['default_value'];
			}
		}	
		return $array_of_returned;
	}
	
	public function controller_page(){
		global $wpdb;
		$task="default";
		$id=0;
		if(isset($_GET["task"])){
			$task=$_GET["task"];
		}
		if(isset($_GET["id"])){
			$id=$_GET["id"];
		}		
		switch($task){
		case 'add_edit_theme':	
			$this->add_edit_theme($id);
			break;
			
		case 'add_edit_theme':	
			$this->add_edit_theme($id);
			break;
		
		case 'save_theme':		
			if($id)	
				$this->update_theme($id);
			else
				$this->save_theme();
				
			$this->display_table_list_theme();	
			break;			
		case 'update_theme':		
			if($id){
				$this->update_theme($id);
			}else{
				$this->save_theme();
				$_GET['id']=$wpdb->get_var("SELECT MAX(id) FROM ".wpda_org_chart_databese::$table_names['theme']);
				$id=intval($_GET['id']);
			}
			$this->add_edit_theme($id);
			break;
		case 'set_default_theme':
			$this->set_default_theme($id);
			$this->display_table_list_theme();	
		break;
		case 'duplicate_theme':	
				$this->duplicate_theme($id);
				$this->display_table_list_theme();
			break;
		case 'remove_theme':	
			$this->remove_theme($id);
			$this->display_table_list_theme();
			break;				
		default:
			$this->display_table_list_theme();
		}
	}
	
/*############  Save function  ################*/
	
	private function save_theme(){
		global $wpdb;
		if(count($_POST)==0)
			return;		
		$params_array=array();
		if(isset($_POST['name'])){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="theme";
		}
		
		$params_array=array('name'=>sanitize_text_field($name));
		foreach($this->options as $param_heading_key=>$param_heading_value){
			foreach($param_heading_value['params'] as $key=>$value){
				if($value['function_name']=='demo_text' || $value['function_name']=='demo_border'){
					continue;
				}
				if(isset($value['params'])){
					foreach($value['params'] as $ins_key=>$ins_value){
						if(isset($_POST[$ins_key])){
							if(is_array($_POST[$ins_key])){								
								$params_array[$ins_key]=$this->sanitize_array($_POST[$ins_key]);
							}else{
								$params_array[$ins_key]=stripslashes(sanitize_text_field($_POST[$ins_key]));
							}
						}else{
							$params_array[$ins_key]=$ins_value['default_value'];
						}
					}
					
				}else{
					if(isset($_POST[$key])){
						if(is_array($_POST[$key])){
							$params_array[$key]=$this->sanitize_array($_POST[$key]);
						}else{
							$params_array[$key]=stripslashes(sanitize_text_field($_POST[$key]));
						}
					}else{
						$params_array[$key]=$value['default_value'];
					}
				}
			}
		}	
		
		$save_or_no=$wpdb->insert( wpda_org_chart_databese::$table_names['theme'], 
			array( 
				'name' => $name,
				'option_value' => json_encode($params_array),
			), 
			array( 
				'%s', 
				'%s',
			) 
		);
		if($save_or_no){
			?><div class="updated"><p><strong>Item Saved</strong></p></div><?php
		}
		else{
			?><div id="message" class="error"><p>Error please reinstall plugin</p></div> <?php
		}
	}
	
/*############  Update theme ID function  ################*/
	
	private function update_theme($id){
		global $wpdb;
		if(count($_POST)==0)
			return;
		$params_array=array();
		if(isset($_POST['name'])){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="theme";
		}
		$params_array=array('name'=>sanitize_text_field($name));
		foreach($this->options as $param_heading_key=>$param_heading_value){
			foreach($param_heading_value['params'] as $key=>$value){
				if($value['function_name']=='demo_text' || $value['function_name']=='demo_border'){
					continue;
				}
				if(isset($value['params'])){
					foreach($value['params'] as $ins_key=>$ins_value){
						if(isset($_POST[$ins_key])){
							if(is_array($_POST[$ins_key])){								
								$params_array[$ins_key]=$this->sanitize_array($_POST[$ins_key]);
							}else{
								$params_array[$ins_key]=stripslashes(sanitize_text_field($_POST[$ins_key]));
							}
						}else{
							$params_array[$ins_key]=$ins_value['default_value'];
						}
					}
					
				}else{
					if(isset($_POST[$key])){
						if(is_array($_POST[$key])){
							$params_array[$key]=$this->sanitize_array($_POST[$key]);
						}else{
							$params_array[$key]=stripslashes(sanitize_text_field($_POST[$key]));
						}
					}else{
						$params_array[$key]=$value['default_value'];
					}
				}
			}
		}		
		$wpdb->update( wpda_org_chart_databese::$table_names['theme'], 
			array( 
				'name' => $name,
				'option_value' => json_encode($params_array),
			), 
			array( 
				'id'=>$id 
			),
			array( 
				'%s', 
				'%s'
			),
			array( 
				'%d'
			)  
		);
		
		?><div class="updated"><p><strong>Item Saved</strong></p></div><?php
		
	}	
	private function sanitize_array($array){
		$sinitized_array=array();
		if(is_array($array)){
			foreach($array as $key => $value){
				if(is_array($value)){
					$sinitized_array[$key]=$this->sanitize_array($value);
				}else{
					$sinitized_array[$key]=sanitize_text_field($value);
				}
			}
		}
		return $sinitized_array;		
	}
	
	private function remove_theme($id){
		global $wpdb;
		$default_theme = $wpdb->get_var($wpdb->prepare('SELECT `default` FROM ' . wpda_org_chart_databese::$table_names['theme'].' WHERE id="%d"', $id));
		if (!$default_theme) {
			$wpdb->query($wpdb->prepare('DELETE FROM ' . wpda_org_chart_databese::$table_names['theme'].' WHERE id="%d"', $id));
		}
		else{
			?><div id="message" class="error"><p>You cannot remove default theme</p></div> <?php
		}
	}
	
	private function duplicate_theme($id){
		global $wpdb;
		$wpdb->query($wpdb->prepare('INSERT INTO '. wpda_org_chart_databese::$table_names['theme'].' ( `name`, `option_value`, `default` ) SELECT CONCAT(`name`,"(duplicate)"), `option_value`, 0 FROM '. wpda_org_chart_databese::$table_names['theme'].' WHERE id="%d"', $id));
		?><div class="updated"><p><strong>Item Duplicated</strong></p></div><?php
	}
	
	private function display_table_list_theme(){	
		?>
        <script> var my_table_list=<?php echo $this->generete_jsone_list(); ?></script>
        <div class="wrap">
            <form method="post"  action="" id="admin_form" name="admin_form" ng-app="" ng-controller="customersController">
			<div class="wpdevart_plugins_header div-for-clear">
				<div class="wpdevart_plugins_get_pro div-for-clear">
					<div class="wpdevart_plugins_get_pro_info">
						<h3>WpDevArt organization chart Premium</h3>
						<p>Powerful and Customizable organization chart</p>
					</div>
						<a target="blank" href="https://wpdevart.com/wordpress-organization-chart-plugin/" class="wpdevart_upgrade">Upgrade</a>
				</div>
				<a target="blank" href="<?php echo wpda_org_chart_support_url; ?>" class="wpdevart_support">Have any Questions? Get quick support!</a>
			</div>	
			<h2>Theme <a href="admin.php?page=wpda_chart_tree_themes&task=add_edit_theme" class="add-new-h2">Add New</a></h2>            
   
            <div class="tablenav top" style="width:95%">  
                <input type="text" placeholder="Search" ng-change="filtering_table();" ng-model="searchText">            
                <div class="tablenav-pages"><span class="displaying-num">{{filtering_table().length}} items</span>
                <span ng-show="(numberOfPages()-1)>=1">
                    <span class="pagination-links"><a class="first-page" ng-class="{disabled:(curPage < 1 )}" title="Go to the first page" ng-click="curPage=0">«</a>
                    <a class="prev-page" title="Go to the previous page" ng-class="{disabled:(curPage < 1 )}" ng-click="curPage=curPage-1; curect()">‹</a>
                    <span class="paging-input"><span class="total-pages">{{curPage + 1}}</span> of <span class="total-pages">{{ numberOfPages() }}</span></span>
                    <a class="next-page" title="Go to the next page" ng-class="{disabled:(curPage >= (numberOfPages() - 1))}" ng-click=" curPage=curPage+1; curect()">›</a>
                    <a class="last-page" title="Go to the last page" ng-class="{disabled:(curPage >= (numberOfPages() - 1))}" ng-click="curPage=numberOfPages()-1">»</a></span></div>
                </span>
            </div>
            <table class="wp-list-table widefat fixed pages" style="width:95%">
                <thead>
                    <tr>
                        <th style="width: 100px;" id='oreder_by_id' data-ng-click="order_by='id'; reverse=!reverse; ordering($event,order_by,reverse);" class="manage-column sortable desc" scope="col"><a><span>ID</span><span class="sorting-indicator"></span></a></th>
                        <th data-ng-click="order_by='name'; reverse=!reverse; ordering($event,order_by,reverse)" class="manage-column sortable desc"><a><span>Name</span><span class="sorting-indicator"></span></a></th>
                        <th style="width:100px"><a>Default</span></a></th>
                        <th style="width:80px">Edit</th>
						<th style="width:80px">Duplicate</th>                        
                        <th  style="width:80px">Delete</th>
                    </tr>
                </thead>
                <tbody>
                 <tr ng-repeat="rows in names | filter:filtering_table" class="description_row">
					 <td>{{rows.id}}</td>
					 <td><a href="admin.php?page=wpda_chart_tree_themes&task=add_edit_theme&id={{rows.id}}">{{rows.name}}</a></td>
					 <td><a href="admin.php?page=wpda_chart_tree_themes&task=set_default_theme&id={{rows.id}}"><img src="<?php echo wpda_org_chart_plugin_url.'admin/images/default' ?>{{rows.default}}.png"></a></td>
					 <td><a href="admin.php?page=wpda_chart_tree_themes&task=add_edit_theme&id={{rows.id}}">Edit</a></td>
					 <td><a href="admin.php?page=wpda_chart_tree_themes&task=duplicate_theme&id={{rows.id}}">Duplicate</a></td>
					 <td><a href="admin.php?page=wpda_chart_tree_themes&task=remove_theme&id={{rows.id}}">Delete</a></td>                               
                  </tr> 
                </tbody>
            </table>
        </form>
        </div>
    <script>

jQuery(document).ready(function(e) {
    jQuery('a.disabled').click(function(){return false});
	jQuery('form').on("keyup keypress", function(e) {
		var code = e.keyCode || e.which; 
		if (code  == 13) {               
			e.preventDefault();
			return false;
		}
	});
});
    function customersController($scope,$filter) {
		var orderBy = $filter('orderBy');
		$scope.previsu_search_result='';
		$scope.oredering=new Array();
		$scope.baza = my_table_list;
		$scope.curPage = 0;
		$scope.pageSize = 20;
		$scope.names=$scope.baza.slice( $scope.curPage* $scope.pageSize,( $scope.curPage+1)* $scope.pageSize)
		$scope.numberOfPages = function(){
		   return Math.ceil($scope.filtering_table().length / $scope.pageSize);
	   };
	   $scope.filtering_table=function(){
		   var new_searched_date_array=new Array;
		   new_searched_date_array=[];
		   angular.forEach($scope.baza,function(value,key){
			   var catched=0;
			   angular.forEach(value,function(value_loc,key_loc){
				   if((''+value_loc).indexOf($scope.searchText)!=-1 || $scope.searchText=='' || typeof($scope.searchText) == 'undefined')
					  catched=1;
			   })
			  if(catched)
				  new_searched_date_array.push(value);
		   })
		   if($scope.previsu_search_result != $scope.searchText){
			  
			  $scope.previsu_search_result=$scope.searchText;
			   $scope.ordering($scope.oredering[0],$scope.oredering[1], $scope.oredering[2]);
			   
		   }
		   if(new_searched_date_array.length<=$scope.pageSize)
		   		$scope.curPage = 0;
		   return new_searched_date_array;
	   }
	   $scope.curect=function(){
		   if( $scope.curPage<0){
				$scope.curPage=0;
		   }
		   if( $scope.curPage> $scope.numberOfPages()-1)
			   $scope.curPage=$scope.numberOfPages()-1;
		  $scope.names=$scope.filtering_table().slice( $scope.curPage* $scope.pageSize,( $scope.curPage+1)* $scope.pageSize)
	   }
		
		$scope.ordering=function($event,order_by,revers){
		   if( typeof($event) != 'undefined' && typeof($event.currentTarget) != 'undefined')
		   		element=$event.currentTarget;
			else
				element=jQuery();
		   
			if(revers)
			  indicator='asc'
			else
			  indicator='desc'
			 $scope.oredering[0]=$event;
			 $scope.oredering[1]=order_by;
			 $scope.oredering[2]=revers;
			jQuery(element).parent().find('.manage-column').removeClass('sortable desc asc sorted');
			jQuery(element).parent().find('.manage-column').not(element).addClass('sortable desc');
			jQuery(element).addClass('sorted '+indicator);		  
			$scope.names=orderBy($scope.filtering_table(),order_by,revers).slice( $scope.curPage* $scope.pageSize,( $scope.curPage+1)* $scope.pageSize)
		}
	}
    </script>
		<?php
		$this->generete_jsone_list();
	}
	
	private function generete_jsone_list(){
		global $wpdb;
		$query = "SELECT `id`,`name`,`default` FROM ".wpda_org_chart_databese::$table_names['theme'];
		$rows=$wpdb->get_results($query);
		$json="[";
		$no_frst_storaket=1;
		foreach($rows as $row){
			$json.=(($no_frst_storaket) ? '' : ',' )."{";
			$no_frst_storaket=1;
			foreach($row as $key=>$value){
				if($key!='id'){
					$json.= "".(($no_frst_storaket) ? '' : ',' )."'".$key."':"."'".(($value)?preg_replace('/^\s+|\n|\r|\s+$/m', '',htmlspecialchars_decode(addslashes(strip_tags($value)))):'0')."'";				
				}
				else{					
					$json.= "".(($no_frst_storaket) ? '' : ',' )."'".$key."':".(($value)?htmlspecialchars_decode(addslashes($value)):'0'); 
				}
				
				$no_frst_storaket=0;
			 }			 
			 $json.="}";
		}
		$json.="]";
		return $json;
	}	
	
	private function generete_theme_parametrs($id=0){
		global $wpdb;	
		$theme_params = NULL;
		$new_theme=1;
		if($id){
			$theme_params = $wpdb->get_row('SELECT * FROM '.wpda_org_chart_databese::$table_names['theme'].' WHERE id='.$id);	
			$new_theme=0;
		}else{
			$theme_params = $wpdb->get_row('SELECT * FROM '.wpda_org_chart_databese::$table_names['theme'].' WHERE `default`=1');	
			
		}
		if($theme_params==NULL){			
			foreach($this->options as $param_heading_key=>$param_heading_value){
				foreach($param_heading_value['params'] as $key=>$value){
					$this->options[$param_heading_key]['params'][$key]["value"]=isset($this->options[$param_heading_key]['params'][$key]["default_value"])?$this->options[$param_heading_key]['params'][$key]["default_value"]:'';
				}
			}
		}else{
			$databases_parametrs=json_decode($theme_params->option_value, true);
			foreach($this->options as $param_heading_key=>$param_heading_value){
				foreach($param_heading_value['params'] as $key=>$value){
					if($this->options[$param_heading_key]['params'][$key]["function_name"]=='demo_text' || $this->options[$param_heading_key]['params'][$key]["function_name"]=='demo_border'){
						continue;
					}
					if($this->options[$param_heading_key]['params'][$key]["function_name"]=='popup'){
						foreach($this->options[$param_heading_key]['params'][$key]["params"] as $ins_key => $ins_value){
							if(isset($databases_parametrs[$ins_key])){
								$this->options[$param_heading_key]['params'][$key]['params'][$ins_key]["value"]=$databases_parametrs[$ins_key];
							}else{
								$this->options[$param_heading_key]['params'][$key]['params'][$ins_key]["value"]=$this->options[$param_heading_key]['params'][$key]['params'][$ins_key]["default_value"];
							}
						}
					}else{
						if(isset($databases_parametrs[$key])){
							$this->options[$param_heading_key]['params'][$key]["value"]=$databases_parametrs[$key];
						}else{
							$this->options[$param_heading_key]['params'][$key]["value"]=$this->options[$param_heading_key]['params'][$key]["default_value"];
						}
					}
				}
			}
			if($new_theme){
				return "New Theme";
			}else{
				return $theme_params->name;
			}
		}
	}	
	
	private function add_edit_theme($id=0){
		global $wpdb;
		$name=$this->generete_theme_parametrs($id);
		?><div class="wpdevart_plugins_header full_width div-for-clear">
			<div class="wpdevart_plugins_get_pro div-for-clear">
				<div class="wpdevart_plugins_get_pro_info">
					<h3>WpDevArt organization chart Premium</h3>
					<p>Powerful and Customizable organization chart</p>
				</div>
					<a target="blank" href="https://wpdevart.com/wordpress-organization-chart-plugin/" class="wpdevart_upgrade">Upgrade</a>
			</div>
			<a target="blank" href="<?php echo wpda_org_chart_support_url; ?>" class="wpdevart_support">Have any Questions? Get quick support!</a>
		</div>
		<form action="admin.php?page=wpda_chart_tree_themes<?php if($id) echo '&id='.$id; ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
            <div class="conteiner">
                <div class="header">
                    <span><h2 class="wpda_theme_title"><?php echo $id?"Edit":"Add" ?> the Theme</h2></span>
                    <div class="header_action_buttons">
                        <span><input type="button" onclick="submitbutton('save_theme')" value="Save" class="button-primary action"> </span> 
                        <span><input type="button" onclick="submitbutton('update_theme')" value="Apply" class="button-primary action"> </span> 
                        <span><input type="button" onclick="window.location.href='admin.php?page=wpda_chart_tree_themes'" value="Cancel" class="button-secondary action"> </span> 
                    </div>
                </div>
                <div class="option_panel">            
                    <div class="parametr_name"></div>
                    <div class="all_options_panel">
                        <input type="text" class="theme_name" name="name" placeholder="Enter name here" value="<?php echo isset($name)?$name:'' ?>" >
						<?php 
							$tabs_titles=array();
							$tabs_content=array();
							$pro_span = '<span class="pro_heading">(Pro)</span>';
							foreach($this->options as $params_grup_name =>$params_group_value){	
								$tab_html='';
								foreach($params_group_value['params'] as $param_name => $param_value){
									$args=array(
										"name"=>$param_name,
										"heading_name"=>$params_group_value['heading_name'],
										"heading_group"=>$params_grup_name,
									);
									$args=array_merge($args,$param_value);
									$tab_html.=wpda_org_chart_library::create_setting($args);
								}	
								if(isset($params_group_value['pro']) && $params_group_value['pro']==true)
									$tabs_titles[] = $params_group_value['heading_name'].$pro_span;
								else
									$tabs_titles[] = $params_group_value['heading_name'];
								$tabs_content[] = $tab_html;
							}
							echo wpda_org_chart_library::create_tab($tabs_titles,$tabs_content);
						?>
					</div>
                </div>
            </div>
		</form><?php			 
	}
	
	private function set_default_theme($id){
		global $wpdb;
		$wpdb->update(wpda_org_chart_databese::$table_names['theme'], array('default' => 0), array('default' => 1));
		$save = $wpdb->update(wpda_org_chart_databese::$table_names['theme'], array('default' => 1), array('id' => $id));		
	}}


 ?>