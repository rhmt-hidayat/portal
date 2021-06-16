<?php

class wpda_org_chart_front_tree_maker{
	
	private $tree_nodes,$theme_options,$ids;
	private static $id_for_tree=0;
	private static $id_for_node=0;
	private $hide_first_node = false;
	function __construct($atts){
		$this->ids['tree']=$this->ids['theme']=0;
		if(isset($atts['tree_id']))
			$this->ids['tree']=$atts['tree_id'];
		if(isset($atts['theme_id']))
			$this->ids['theme']=$atts['theme_id'];
	}
	
	public function controller(){		
		if(!$this->ids['tree']){
			return $tree_html='<h2>Organization Chart tree id dont found</h2>';
		}
		$this->tree_nodes=$this->get_tree($this->ids['tree']);
		if($this->tree_nodes == null){
			return $tree_html='<h2>Organization Chart dont found</h2>';
		}
		$this->tree_nodes=json_decode($this->tree_nodes->tree_nodes,true);
		$this->theme_options['default'] = $this->get_theme($this->ids['theme']);
		if($this->theme_options['default'] == null){
			return $tree_html='<h2>Organization Chart theme dont found</h2>';
		}
		$this->theme_options['default'] = json_decode($this->theme_options['default']->option_value, true);
		$this->correct_gradients();
		return $this->tree_html();
	}
	
	public function tree_html(){
		self::$id_for_tree++;
		$this->hide_first_node = ($this->tree_nodes[0]['node_info']['image_url'] == '' && $this->tree_nodes[0]['node_info']['node_title'] == '' && $this->tree_nodes[0]['node_info']['node_description'] == '');
		$html='<div class="wpdevart_org_chart_conteiner_parent" id="wpdevart_org_chart_conteiner_parent_'.self::$id_for_tree.'"><div class="wpdevart_org_chart_conteiner '.($this->hide_first_node?'first_child_hidden':'').'" id="wpdevart_org_chart_conteiner_'.self::$id_for_tree.'">';				
		$html.=$this->constructe_nodes($this->tree_nodes);
		$html.='</div></div>';
		return $html.$this->tree_js().$this->tree_css();
		
	}
	
	public function tree_js(){
		$options['def_scroll'] = isset($this->theme_options['default']['scroll_position'])?$this->theme_options['default']['scroll_position']:'0';
		$js='<script>';
		$js_options='{mobile_frendly:"'.$this->theme_options['default']["mobile_frendly"].'",mobile_size:'.wpda_org_chart_responsive_sizes['mobile'].',def_scroll:'.$options['def_scroll'].'}';
		$js.='document.addEventListener("DOMContentLoaded", function(event) { ';
		$js.='var wpdev_org_chart_'.self::$id_for_tree.'= new wpdevart_org_chart_front("wpdevart_org_chart_conteiner_'.self::$id_for_tree.'",'.$js_options.')';
		$js.='});';
		$js.='</script>';
		return $js;		
	}
	
	private function constructe_nodes($nods_info){
		$html='<ul>';
			foreach($nods_info as $key => $node){
				self::$id_for_node++;
				$link = $this->make_node_link($node);
				$html.='<li class="' . (count($node['chidrens'])>0 ? 'has_children' : 'no_children') . ' ' . ((isset($nods_info[$key+1]['chidrens']) && count($nods_info[$key+1]['chidrens'])>0) ? 'next_children' : 'next_no_children') . '" data-children=' . count($node['chidrens']) . '>';
				$html.='<div class="wpda_tree_item_container" id="wpda_item_conteiner_'.self::$id_for_node.'" >';
				$html.='<span class="wpda_tree_line"></span>';
				if(!$this->hide_first_node){
					$html.='<div>';
					if( $node['node_info']['image_url'] != '' ){
						$html.='<div class="wpda_tree_item_img_cont">'.'<img class="wpda_tree_item_img" src="'.$node['node_info']['image_url'].'">'.$link['open_image'].$link['close_image'].'</div>';
					}
					$html.='<div class="wpda_tree_item_title">'.htmlspecialchars_decode($node['node_info']['node_title']).$link['open_title'].$link['close_title'].'</div>';
					$html.='<div class="wpda_tree_item_desc">'.htmlspecialchars_decode($node['node_info']['node_description']).$link['open_desc'].$link['close_desc'].'</div>';
					$html.=$link['open_item'].$link['close_item'];
					$html.='</div>';
				}
				$this->hide_first_node = false;
				$html.='</div>';
				if(count($node['chidrens'])>0){
					$html.=$this->constructe_nodes($node['chidrens']);
				}
				$html.='</li>';
			}
		$html.='</ul>';
		return $html;
	}
	
	private function make_node_link($node){
		$link = array(
			'open_item' => '',
			'close_item' => '',
			'open_image' => '',
			'close_image' => '',
			'open_title' => '',
			'close_title' => '',
			'open_desc' => '',
			'close_desc' => '',			
		);
		if(isset($node['node_info']['node_url']) && $node['node_info']['node_url'] != '' ){
			$blank='';
			if(isset($node['node_info']['node_url_o_n_t']) && $node['node_info']['node_url_o_n_t']){
				$blank='target="_blank"';
			}
			$open_link = '<a class="wpda_tree_node_link" href="'.$node['node_info']['node_url'].'" '.$blank.'>';
			$close_link = '</a>';
			if($node['node_info']['node_url_o_a']['item'] != ''){
				$link['open_item'] = $open_link;
				$link['close_item'] = $close_link;
				return $link;
			}
			if($node['node_info']['node_url_o_a']['image'] != ''){
				$link['open_image'] = $open_link;
				$link['close_image'] = $close_link;
			}
			if($node['node_info']['node_url_o_a']['title'] != ''){
				$link['open_title'] = $open_link;
				$link['close_title'] = $close_link;
			}
			if($node['node_info']['node_url_o_a']['desc'] != ''){
				$link['open_desc'] = $open_link;
				$link['close_desc'] = $close_link;
			}
		}
		return $link;
	}
	
	private function tree_css(){
		$main_id='#wpdevart_org_chart_conteiner_'.self::$id_for_tree;
		$main_parent_id='#wpdevart_org_chart_conteiner_parent_'.self::$id_for_tree;
		$css='<style>';
		if($this->theme_options['default']['mobile_frendly']!=='mobile'){
			$css.=$main_parent_id.'{overflow-x:auto;}';
		}
		$css.=$main_id.'{
			background-image: linear-gradient('.$this->theme_options['default']['background_color']['gradient'].', '.$this->theme_options['default']['background_color']['color1'].', '.$this->theme_options['default']['background_color']['color2'].');
			padding-top:'.$this->fixd_value('default','padding','desktop_top').';
			padding-right:'.$this->fixd_value('default','padding','desktop_right').';
			padding-bottom:'.$this->fixd_value('default','padding','desktop_bottom').';
			padding-left:'.$this->fixd_value('default','padding','desktop_left').';		
		}';
		$border=$this->theme_options['default']['border_radius']['desktop'];
		if(is_numeric ($this->theme_options['default']['border_radius']['desktop'])){
			$border.=$this->theme_options['default']['border_radius']['metric_desktop'];
		}		
		$css.=$main_id.'{border-radius:'.$border.'}';
		// line color and line height
		//desktop
		$css.=$main_id.' li{margin-top: '.$this->theme_options['default']['line_height']['desktop'].'px;}';
		$css.=$main_id.' ul ul::before{left: calc(50% - '.($this->theme_options['default']['line_height']['desktop']/2).'px);
			border-left: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
			height: '.(20+$this->theme_options['default']['line_height']['desktop']).'px;
			top: 0px;
		}';
		$css.=$main_id.' li::before, '.$main_id.' li::after{
			top: -'.$this->theme_options['default']['line_height']['desktop'].'px;
			right: calc(50% - '.($this->theme_options['default']['line_height']['desktop']/2).'px);
			width: calc(50% + '.($this->theme_options['default']['line_height']['desktop']/*/2*/).'px);
			border-top: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
			height: '.($this->theme_options['default']['line_height']['desktop']+20).'px;
		}';
		$css.=$main_id.' li:after{
			left: calc(50% - '.($this->theme_options['default']['line_height']['desktop']/2).'px);
			border-left: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
		}';
		$css.=$main_id.' li:last-child::before{
			border-right: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
		}';
		$css.=$main_id.' li:first-child::before,
		'.$main_id.' li:last-child::after {
		  border: 0 none;
		}';
		//tablet
		$css.='@media screen and (max-width: 1000px) {';
		$css.=$main_id.'{
			padding-top:'.$this->fixd_value('default','padding','tablet_top').';
			padding-right:'.$this->fixd_value('default','padding','tablet_right').';
			padding-bottom:'.$this->fixd_value('default','padding','tablet_bottom').';
			padding-left:'.$this->fixd_value('default','padding','tablet_left').';		
		}';
		$css.='}';
		
		// mobile line
		$css.='@media screen and (max-width: 450px) {';
		$css.=$main_id.'{
			padding-top:'.$this->fixd_value('default','padding','mobile_top').';
			padding-right:'.$this->fixd_value('default','padding','mobile_right').';
			padding-bottom:'.$this->fixd_value('default','padding','mobile_bottom').';
			padding-left:'.$this->fixd_value('default','padding','mobile_left').';		
		}';
		$css.='}';
		$css.='.wpdev_mobile'.$main_id.' li.has_children > ul:before{
			top:-80px;
			left:0px;
			height:80px;
		}';
		
		$css.='.wpdev_mobile'.$main_id.' li.has_children li .wpda_tree_item_container:after{
			border-top: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
		}';
		$css.='.wpdev_mobile'.$main_id.' > ul > li > ul li{
			border-left:'.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
		}';
		$css.='.wpdev_mobile'.$main_id.' li.has_children > .wpda_tree_item_container:before{
			content: "";
			border-left:'.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
		}';
		$css.='.wpdev_mobile'.$main_id.' li{
			margin-top:0px;
		}';
		$css.='.wpdev_mobile'.$main_id.' > ul > li > ul li:last-child{
			border-left: 0;
		}';
		$css.='.wpdev_mobile'.$main_id.' > ul > li > ul li:last-child > div > span.wpda_tree_line{
			border-left: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
		}';
		$css.='.wpdev_mobile'.$main_id.' li.has_children li .wpda_tree_item_container:after {
			top: calc(50% - '.($this->theme_options['default']['line_height']['desktop']/2).'px);
		}';
		$css.='.wpdev_mobile.first_child_hidden'.$main_id.' > ul > li > ul > li:first-child::before{
			border-left: '.$this->theme_options['default']['line_height']['desktop'].'px solid '.$this->theme_options['default']['line_color'].';
			top: 80px;
			height: calc(100% - 80px);
			left:0px;
			width:0px;
		}';
		$css.='.wpdev_mobile.first_child_hidden'.$main_id.'  > ul > li > div.wpda_tree_item_container:before{
			border:none;
		}';
		$css.='.wpdev_mobile'.$main_id.'  > ul > li > ul li:last-child > .wpda_tree_item_container{
			padding-left: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css.='.wpdev_mobile'.$main_id.'  > ul > li > ul li:last-child > .wpda_tree_item_container:after{
			width: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css.='.wpdev_mobile'.$main_id.'  > ul > li > ul li:last-child > .wpda_tree_item_container:before{
			left: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css.='.wpdev_mobile'.$main_id.' > ul > li > ul li:last-child >ul{
			margin-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px;
		}';
		$css.='</style>';
		return $css;
		
	}
	
	private function correct_gradients($theme_id="default"){
		$gradient_lists=['background_color','item_bg_color'];
		foreach($gradient_lists as $gradient_elem){
			if($this->theme_options[$theme_id][$gradient_elem]['gradient']=='none'){
				$this->theme_options[$theme_id][$gradient_elem]['color2']=$this->theme_options[$theme_id][$gradient_elem]['color1'];
				$this->theme_options[$theme_id][$gradient_elem]['gradient']='to right';
			}
		}
	}
	
	private function fixd_value($theme_id="default",$index,$responsive='desktop',$style=''){
		$responsive_metric=str_replace('_top','',$responsive);
		$responsive_metric=str_replace('_right','',$responsive_metric);
		$responsive_metric=str_replace('_bottom','',$responsive_metric);
		$responsive_metric=str_replace('_left','',$responsive_metric);
		$res_metric='metric_'.$responsive_metric;
		$value='';		
		if($this->theme_options[$theme_id][$index][$responsive]==''){
			return '';
		}
		$value.=$this->theme_options[$theme_id][$index][$responsive];
		if(is_numeric ($this->theme_options[$theme_id][$index][$responsive])){
			$value.=$this->theme_options[$theme_id][$index][$res_metric];
		}
		if($style!='')
			return $style.$value.';';
		return $value;
	}
	
	private function get_theme($id){
		global $wpdb;
		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".wpda_org_chart_databese::$table_names["theme"]." WHERE `id`=%d",$id));
		if($row == null){
			$row = $wpdb->get_row("SELECT * FROM ".wpda_org_chart_databese::$table_names["theme"]." WHERE `default`=1");
		}
		return $row;	 
	}
	
	private function get_tree($id){
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare("SELECT * FROM ".wpda_org_chart_databese::$table_names["tree"]." WHERE `id`=%d",$id));	
	}
}
?>