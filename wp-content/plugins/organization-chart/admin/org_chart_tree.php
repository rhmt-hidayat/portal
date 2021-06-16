<?php
class wpda_org_chart_admin_tree{
	
	function __construct(){
		$this->controller();
	}
	
	private function controller(){
		global $wpdb;
		$task="default";
		$id=0;
		if(isset($_GET["task"])){
			$task=sanitize_text_field($_GET["task"]);
		}
		if(isset($_GET["id"])){
			$id=intval($_GET["id"]);
		}
		switch($task){
			
			case 'add_tree':	
				$this->add_edit_tree();
			break;
			case 'edit_tree':	
				$this->add_edit_tree($id);
			break;
			
			case 'save_tree':
				if($id){
					$this->update_tree($id);
				}else{
					$this->save_tree($id);
				}
				$this->display_table_list();
			break;
			
			case 'remove_tree':	
				$this->remove_tree($id);
				$this->display_table_list();
			break;
			
			case 'duplicate_tree':	
				$this->duplicate_tree($id);
				$this->display_table_list();
			break;
				
				
			case 'update_tree':		
				if($id){
					$this->update_tree($id);
				}else{
					$this->save_tree();
					$_GET['id']=$wpdb->get_var("SELECT MAX(id) FROM ".wpda_org_chart_databese::$table_names['tree']);
					$id=$_GET['id'];
				}
				$this->add_edit_tree($id);
			break;
			case 'remove_theme':	
				$this->remove_theme($id);
				$this->display_table_list();
				break;				
			default:
				$this->display_table_list();
		}		
	}
	
	private function get_tree_info($id){
		global $wpdb;
		$tree=$wpdb->get_row('SELECT * FROM '.wpda_org_chart_databese::$table_names['tree'].' WHERE id='.$id);
		return $tree;
	}
	
	private function display_table_list(){
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
			<h2 style="width: 95%">Tree - Organization Chart <a href="admin.php?page=wpda_chart_tree_page&task=add_tree" class="add-new-h2">Add New</a> </h2>
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
                        <th style="width:80px">Edit</th>
						<th style="width:80px">Duplicate</th>						
                        <th  style="width:80px">Delete</th>
                    </tr>
                </thead>
                <tbody>
                 <tr ng-repeat="rows in names | filter:filtering_table" class="description_row">
					 <td>{{rows.id}}</td>
					 <td><a href="admin.php?page=wpda_chart_tree_page&task=edit_tree&id={{rows.id}}">{{rows.name}}</a></td>					 
					 <td><a href="admin.php?page=wpda_chart_tree_page&task=edit_tree&id={{rows.id}}">Edit</a></td>
					 <td><a href="admin.php?page=wpda_chart_tree_page&task=duplicate_tree&id={{rows.id}}">Duplicate</a></td>
					 <td><a href="admin.php?page=wpda_chart_tree_page&task=remove_tree&id={{rows.id}}">Delete</a></td>                               
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
	}
	
	private function generete_jsone_list(){
		global $wpdb;
		$query = "SELECT `id`,`name` FROM ".wpda_org_chart_databese::$table_names['tree'];
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
	
	private function add_edit_tree($id=0){
		global $wpdb;
		if($id){
			$tree=$this->get_tree_info($id);
			$name=$tree->name;
		}
		$standart_json=json_encode(
			array(
			'image_url' => wpda_org_chart_plugin_url.'admin/images/staff-icon.jpg',
			'node_title' => 'Title',
			'node_description' => 'Description',
			'theme' => '0',
			)
		);
		?>		
		<div class="wpdevart_plugins_header full_width div-for-clear">
			<div class="wpdevart_plugins_get_pro div-for-clear">
				<div class="wpdevart_plugins_get_pro_info">
					<h3>WpDevArt organization chart Premium</h3>
					<p>Powerful and Customizable organization chart</p>
				</div>
					<a target="blank" href="https://wpdevart.com/wordpress-organization-chart-plugin/" class="wpdevart_upgrade">Upgrade</a>
			</div>
			<a target="blank" href="<?php echo wpda_org_chart_support_url; ?>" class="wpdevart_support">Have any Questions? Get quick support!</a>
		</div>			
		<form action="admin.php?page=wpda_chart_tree_page<?php if($id) echo '&id='.$id; ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
            <div class="conteiner">
                <div class="header">
                    <span><h2 class="wpda_chart_tree_title"><?php if($id) {echo "Edit the Organization chart ".(isset($name)?'<span style="color:#7052fb">'.$name.'</span>':'');}else{echo "Add chart tree";} ?></h2></span>
                    <div class="header_action_buttons">
                        <span><input type="button" onclick="submitbutton('save_tree')" value="Save" class="button-primary action"> </span> 
                        <span><input type="button" onclick="submitbutton('update_tree')" value="Apply" class="button-primary action"> </span> 
                        <span><input type="button" onclick="window.location.href='admin.php?page=wpda_chart_tree_page'" value="Cancel" class="button-secondary action"> </span> 
                    </div>
                </div>
				<input type="text" class="tree_name" name="name" placeholder="Enter name here" value="<?php if($id){echo $name;} ?>">
                <div class="option_panel">            
                    <div class="org_chart_conteiner">
						<div id="wpdevart_tree" class='tree'>
							<ul >
								<li>
									<div class="wpdevart_tree_node">
										<img src="<?php echo wpda_org_chart_plugin_url.'admin/' ?>images/staff-icon.jpg">
										<br>
										<button type="button" class="add_child_button"></button>
										<span class="dashicons dashicons-edit edit_tree_node"></span>
										<div class="node_title">Title</div>
										<div class="node_desc">Description</div>
										<input class="wpdevart_node_info" type="hidden" value='<?php echo isset($tree->tree_nodes)?$tree->tree_nodes:$standart_json;  ?>'>
									</div>									
								</li>
							</ul>
						</div>
					</div>
					<script>
					var wpda_org_chart_plugin_url="<?php echo wpda_org_chart_plugin_url.'admin/' ?>";
					window.addEventListener("load", function(event) {
						<?php	if($id){
							echo "wpdevart_chart.initial_tree_string='".(isset($tree->tree_nodes)?str_replace("'","\\'",$this->decode_node_value($tree->tree_nodes)):'')."';";
						} 
						echo "\r\n wpdevart_chart.themes_select='".$this->get_tree_themes('')."';";
						?>
						
						wpdevart_chart.start();
					});
					</script>
                </div>
            </div>
			<input type="hidden" id="wpdevart_chart_tree_all_info" name="wpdevart_chart_tree_all_info" value="">
		</form>
		<?php		 
	}
	
	private function save_tree(){
		global $wpdb;
		if(count($_POST)==0)
			return;		
		$params_array=array();
		if(isset($_POST['name']) && $_POST['name']!=''){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="Unnamed";
		}
		$tree_nodes = $this->sanitize_node_values( $_POST['wpdevart_chart_tree_all_info']);
		$save_or_no=$wpdb->insert( wpda_org_chart_databese::$table_names['tree'], 
			array( 
				'name' => $name,
				'tree_nodes' => $tree_nodes,
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
	
	private function update_tree($id){
		global $wpdb;
		if(count($_POST)==0)
			return;		
		$params_array=array();
		if(isset($_POST['name']) && $_POST['name']!=''){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="Unnamed";
		}
		$tree_nodes = $this->sanitize_node_values( $_POST['wpdevart_chart_tree_all_info']);
		$wpdb->update( wpda_org_chart_databese::$table_names['tree'], 
			array( 				
				'name' => $name,
				'tree_nodes' => $tree_nodes,
			), 
			array( 
				'id' => $id,
			),
			array( 
				'%s', 
				'%s',
			), 
			array( 
				'%d',
			) 
		);
		
		?><div class="updated"><p><strong>Item Saved</strong></p></div><?php
		
	}
	
	private function sanitize_node_values($jsone_string){
		
		$json_array = json_decode(stripslashes($jsone_string),true);
		if( $json_array == null ){
			return '';
		}
		return json_encode( $this->sanitize_node_helper( $json_array ), JSON_UNESCAPED_UNICODE );
		
	}
	
	private function sanitize_node_helper($nodes){
		if(count( $nodes ) == 0 ){
			return array();
		}
		$returned_array = array();
		for($i=0; $i<count($nodes); $i++){
			if(count($nodes[$i]['node_info']) == 0){
				$returned_array[$i]['node_info'] = array();
			}
			foreach($nodes[$i]['node_info'] as $key => $value){
				if(is_array( $value )){
					if(count($value)>0){
						foreach($value as $key_1 => $value_1){
							$returned_array[$i]['node_info'][$key][$key_1] = sanitize_text_field(htmlspecialchars($value_1));
						}
					}else{
						$returned_array[$i]['node_info'][$key][$key_1] = array();
					}
				}else{
					$returned_array[$i]['node_info'][$key] = sanitize_text_field(htmlspecialchars($value));
				}
			}
			$returned_array[$i]['chidrens'] = $this->sanitize_node_helper($nodes[$i]['chidrens'] );
		}
		return $returned_array;
	}
	
	private function decode_node_value($jsone_string){
		$json_array = json_decode(stripslashes($jsone_string),true);
		if( $json_array == null ){
			return '';
		}
		return json_encode( $this->decode_node_value_helper( $json_array ),JSON_UNESCAPED_UNICODE );
	}
	
	private function decode_node_value_helper($nodes){
		if(count( $nodes ) == 0 ){
			return array();
		}
		$returned_array = array($nodes);
		for($i=0; $i<count($nodes); $i++){
			if(count($nodes[$i]['node_info']) == 0){
				$returned_array[$i]['node_info'] = array();
			}
			foreach($nodes[$i]['node_info'] as $key => $value){
				if(is_array( $value )){
					if(count($value)>0){
						foreach($value as $key_1 => $value_1){
							$returned_array[$i]['node_info'][$key][$key_1] = str_replace('"','\\"',htmlspecialchars_decode($value_1));
						}
					}else{
						$returned_array[$i]['node_info'][$key][$key_1] = array();
					}
				}else{
					$returned_array[$i]['node_info'][$key] = str_replace('"','\\"',htmlspecialchars_decode($value));
				}
			}
			$returned_array[$i]['chidrens'] = $this->decode_node_value_helper($nodes[$i]['chidrens'] );
		}
		return $returned_array;
	}
	
	private function get_tree_themes($value=''){
		global $wpdb;
		$html='<select id="node_theme">';
		$themes=$wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_databese::$table_names['theme'].'');
		$html.='<option selected="selected" value="0" '.str_replace("'",'"',selected('',$value,false)).'>Shortcode theme</option>';
		foreach($themes as $theme){
			$html.='<option value="'.$theme->id.'" '.str_replace("'",'"',selected($theme->id,$value,false)).'>'.$theme->name.'</option>';
		}
		$html.='</select>';
		return $html;
		
	}
	
	private function duplicate_tree($id){
		global $wpdb;
		$wpdb->query($wpdb->prepare('INSERT INTO '. wpda_org_chart_databese::$table_names['tree'].' ( name, tree_nodes ) SELECT CONCAT(name,"(duplicate)"), tree_nodes FROM '. wpda_org_chart_databese::$table_names['tree'].' WHERE id="%d"', $id));
		?><div class="updated"><p><strong>Item Duplicated</strong></p></div><?php
	}
	
	private function remove_tree($id){ 
		global $wpdb;
		$wpdb->query($wpdb->prepare('DELETE FROM ' . wpda_org_chart_databese::$table_names['tree'].' WHERE id="%d"', $id));
		?><div class="updated"><p><strong>Item Deleted</strong></p></div><?php
	}
	
}

?>