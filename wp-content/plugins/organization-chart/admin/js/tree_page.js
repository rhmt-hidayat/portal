var params_for_chart={}
var wpdevart_chart={
	tree_id:'wpdevart_tree',
	def_img_src:req_urls['plug_url']+'admin/images/staff-icon.jpg',
	initial_tree_string:"{}",
	default_info:{"image_url":req_urls['plug_url']+'admin/images/staff-icon.jpg',"node_title":"Title","node_description":"Description","theme":"0"},
	number:1,
	themes_select:'',
	current_edited_element:null,	
	initial_exsisting_tree:function(){
		var self=this;
		var tree_info=JSON.parse(self.initial_tree_string);
		var main_node_info=self.default_info;
		if(Object.keys(tree_info).length==0){
			return false;
		}else{
			if(Object.keys(tree_info[0]['node_info']).length!=0){
				main_node_info=tree_info[0]['node_info'];
			}
			document.getElementById(self.tree_id).getElementsByClassName('wpdevart_node_info')[0].value=JSON.stringify(main_node_info);
			document.getElementById(self.tree_id).getElementsByClassName('wpdevart_tree_node')[0].getElementsByTagName('img')[0].setAttribute('src',main_node_info['image_url']);
			document.getElementById(self.tree_id).getElementsByClassName('node_title')[0].innerHTML=main_node_info['node_title'];
			document.getElementById(self.tree_id).getElementsByClassName('node_desc')[0].innerHTML=main_node_info['node_description'];
			self.make_tree_by_object(tree_info[0].chidrens,document.getElementById(self.tree_id).children[0].children[0]);
		}
	},
	
	make_tree_by_object:function(node_info,parent_element){
		var self=this,element_too_apended;
		var count_elements=Object.keys(node_info).length;
		for(var i=0;i<count_elements;i++){
			if(i==0){
				element_too_apended=self.tree_node_element(true,node_info[i]['node_info']);
				parent_element.appendChild(element_too_apended)
			}else{
				element_too_apended=self.tree_node_element(false,node_info[i]['node_info']);
				parent_element.getElementsByTagName('ul')[0].appendChild(element_too_apended)
			}
			if(Object.keys(node_info[i].chidrens).length!=0){
				if(i==0){
					self.make_tree_by_object(node_info[i].chidrens,element_too_apended.children[0])
				}else{
					self.make_tree_by_object(node_info[i].chidrens,element_too_apended)
				}
			}
		}
	},
	
	add_node_functionalty:function(add_button_node){
		var self=this;
		add_button_node.addEventListener("click", function(){
			var appended_node=this.parentNode.parentNode.getElementsByTagName('ul')[0];
			if(typeof(appended_node) != 'undefined' && appended_node != null){
				this.parentNode.parentNode.getElementsByTagName('ul')[0].appendChild(self.tree_node_element(false));
			}else{
				this.parentNode.parentNode.appendChild(self.tree_node_element(true));
			}
			
		});
	},
	
	add_bortehr_node_functionalyty:function(add_button_node,left=true){
		var self=this;
		add_button_node.addEventListener("click", function(){
			var target_element=this.parentNode.parentNode;
			if(left){				  
				  target_element.parentNode.insertBefore(self.tree_node_element(false),target_element);
			}else{
				target_element.parentNode.insertBefore(self.tree_node_element(false),target_element.nextSibling);
			}			
		});
	},
	
	remove_node_functionality:function(node){
		node.addEventListener("click", function(){
			var conf_answer;
			if(node.parentNode.parentNode.getElementsByTagName('ul').length>0){
				var conf_answer = confirm("Important! If you delete this element, then other elements under the following element will be removed as well.");
				if(conf_answer==false)
					return false;
			}
			parentode_ul=node.parentNode.parentNode.parentNode;
			if(parentode_ul.getElementsByTagName('li').length==1){
				parentode_ul.parentNode.removeChild(parentode_ul)
			}else{
				parentode_ul.removeChild(node.parentNode.parentNode);
			}
		});
		
	},
	
	edit_node_functionality:function(node){
		var self=this;
		node.addEventListener("click", function(){
			self.current_edited_element=this.parentNode;
			self.wpdevart_create_popup()
		});
	},
	
	wpdevart_create_popup:function(){
		var self=this;
		var overlay 				= document.createElement("div");
		var conteiner 				= document.createElement("div");		
		var header_line 			= document.createElement("div");
		var header_line_text 		= document.createElement("span");
		var close_button 			= document.createElement("button");
		
		var image_upload_input 		= document.createElement("input");
		var image_upload_button 	= document.createElement("button");
		var template 				= document.createElement("template");
		inner_html='<div id="wpdevart-popup-tabs-container" class="div-for-clear"><div id="wpdevart_popup-tabs" class="div-for-clear"><div id="wpdevart_popup-tab-info" class="wpdevart_tab show">Information</div><div id="wpdevart_popup-tab-style" class="wpdevart_tab">Styling</div></div><div id="wpdevart-tabs-item-container" class="div-for-clear"><div id="wpdevart_popup-tab-info_container" class="wpdevart_container wpdevart-item-section" style="display: block;"> <div class="paramter_line"><div class="param_desc"><span>Type the URL</span></div><div class="param"><input id="wpdevart_upload_image_for_tree" type="text"><button class="button" id="wpdevart_upload_button_image_for_tree">Upload</button></div></div><div class="paramter_line"><div class="param_desc"><span>Type the title</span></div><div class="param"><input type="text" id="node_title" class="title_input"></div></div><div class="paramter_line"><div class="param_desc"><span>Type the description</span></div><div class="param"><textarea id="node_description"></textarea></div></div><div class="paramter_line"><div class="param_desc"><span>Type a Url</span></div><div class="param"><input type="text" id="node_url" class="title_input"></div></div><div class="paramter_line"><div class="param_desc"><span>Select link area</span></div><div class="param"><input type="checkbox" id="node_url_all_item" value="all"><label for="node_url_all_item">All item</label><input type="checkbox" id="node_url_image" value="image"><label for="node_url_image">Image</label><input type="checkbox" id="node_url_title" value="title"><label for="node_url_title">Title</label><input type="checkbox" id="node_url_description" value="description"><label for="node_url_description">Description</label></div></div><div class="paramter_line"><div class="param_desc"><span>Open url in new tab</span></div><div class="param"><input type="checkbox" id="node_url_open_new_tab" value="yes"><label for="node_url_open_new_tab">Yes</label></div></div></div><div id="wpdevart_popup-tab-style_container" class="wpdevart_container wpdevart-item-section" style="display: none;"><div class="paramter_line"><div class="param_desc"><span>Select the theme</span></div><div class="param">'+self.themes_select+'</div></div></div><div><button type="button" class="button-primary action wpdevart_popup_update" id="wpdevart_update_tree_info">Update</button></div></div></div>';
		template.innerHTML=inner_html;
		var popup_content_html=template.content.firstChild;
		// set atributes to elements
		overlay.setAttribute('class','wpdevart_ovrlay');
		conteiner.setAttribute('class','wpdevart_popup_conteiner');
		header_line.setAttribute('class','wpdevart_popup_header_line');
		close_button.innerHTML="x";
		header_line_text.innerHTML="Edit the element information";		
		//conect elements tgheter
		
		document.body.appendChild(conteiner);
		document.body.appendChild(overlay);
		conteiner.appendChild(header_line);
		header_line.appendChild(header_line_text);
		header_line.appendChild(close_button);		
		
		conteiner.appendChild(popup_content_html);
		//set functionalty
		
		close_button.addEventListener('click',function(){			
			self.wpdevart_remove_popup();
		})
		
		overlay.addEventListener('click',function(){
			self.wpdevart_remove_popup();
		})
		self.add_tab_functionalyty();
		var mediaUploader;
		document.getElementById('wpdevart_upload_button_image_for_tree').addEventListener('click',function(e){
			e.preventDefault();
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}
			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				}, multiple: false 
			});
			mediaUploader.on('select', function() {
				var attachment = mediaUploader.state().get('selection').first().toJSON();
				document.getElementById('wpdevart_upload_image_for_tree').value=attachment.url;
			});
			mediaUploader.open();
		});
		document.getElementById('node_url_all_item').addEventListener('click',function(e){
			if(	document.getElementById('node_url_all_item').checked){
				document.getElementById('node_url_image').checked = true;
				document.getElementById('node_url_title').checked = true;
				document.getElementById('node_url_description').checked = true;
			}			
		});	
		document.getElementById('wpdevart_update_tree_info').addEventListener('click',function(e){
			self.update_tree_node_info();
		});
		
		self.write_node_info_inside_popup();
	},
	
	write_node_info_inside_popup:function(){
		var self=this,title='Title',desc='Description',image_url=this.def_img_src,theme='0',node_url='',node_url_open_area={'item':false,'image':false,'title':false,'desc':false},node_url_open_new_tab = false;	
		if(self.current_edited_element!=null){
			var info_string=self.current_edited_element.getElementsByClassName('wpdevart_node_info')[0].value;
			
			if(info_string!=''){
				var info_obj=JSON.parse(info_string)
				console.log(info_obj)
				title = info_obj['node_title']
				desc = info_obj['node_description']
				image_url = info_obj['image_url']				
				theme = info_obj['theme']
				if('node_url' in info_obj){
					node_url = info_obj['node_url']
				}
				if('node_url_o_a' in info_obj){
					if('item' in info_obj['node_url_o_a'])
						node_url_open_area['item'] = info_obj['node_url_o_a']['item'];
					if('image' in info_obj['node_url_o_a'])
						node_url_open_area['image'] = info_obj['node_url_o_a']['image'];
					if('title' in info_obj['node_url_o_a'])
						node_url_open_area['title'] = info_obj['node_url_o_a']['title'];
					if('desc' in info_obj['node_url_o_a'])
						node_url_open_area['desc'] = info_obj['node_url_o_a']['desc'];
				}
				if('node_url_o_n_t' in info_obj){					
					node_url_open_new_tab = info_obj['node_url_o_n_t']
				}
			}
		}
		document.getElementById('wpdevart_upload_image_for_tree').value = image_url;
		document.getElementById('node_title').value = title;
		document.getElementById('node_description').value = desc;
		document.getElementById('node_url').value = node_url;
		
		if(node_url_open_area['item'] === "1" || node_url_open_area['item'] === true)
			document.getElementById('node_url_all_item').checked = true;
			
		if(node_url_open_area['image'] === "1" || node_url_open_area['image'] === true)	
			document.getElementById('node_url_image').checked = true;
		if(node_url_open_area['title'] === "1" || node_url_open_area['title'] === true)	
			document.getElementById('node_url_title').checked = true;
		if(node_url_open_area['desc'] === "1" || node_url_open_area['desc'] === true)	
			document.getElementById('node_url_description').checked = true;
		if(node_url_open_new_tab === "1" || node_url_open_new_tab === true)	
			document.getElementById('node_url_open_new_tab').checked = true;
		
		document.getElementById('node_theme').value=theme;
	},
	
	update_tree_node_info:function(){
		var self=this,info_array={};
		info_array['image_url']=document.getElementById('wpdevart_upload_image_for_tree').value;
		info_array['node_title']=document.getElementById('node_title').value;
		info_array['node_description']=document.getElementById('node_description').value;
		info_array['node_url']=document.getElementById('node_url').value;
		info_array['node_url_o_a'] = {};
		info_array['node_url_o_a']['item'] = document.getElementById('node_url_all_item').checked;
		info_array['node_url_o_a']['image'] = document.getElementById('node_url_image').checked;
		info_array['node_url_o_a']['title'] = document.getElementById('node_url_title').checked;
		info_array['node_url_o_a']['desc'] = document.getElementById('node_url_description').checked;	
		info_array['node_url_o_n_t'] = document.getElementById('node_url_open_new_tab').checked;		
		info_array['theme'] = document.getElementById('node_theme').value;
		
		self.current_edited_element.getElementsByTagName('img')[0].setAttribute('src',info_array['image_url']);
		self.current_edited_element.getElementsByClassName('node_title')[0].innerHTML =info_array['node_title'];
		self.current_edited_element.getElementsByClassName('node_desc')[0].innerHTML=info_array['node_description'];
		self.current_edited_element.getElementsByClassName('wpdevart_node_info')[0].value=JSON.stringify(info_array);
		self.wpdevart_remove_popup();
	},
	
	//this is for popup
	add_tab_functionalyty:function(){
		var tabs=document.getElementById('wpdevart_popup-tabs').children;
		for(var i=0;i<tabs.length;i++){
			tabs[i].addEventListener('click',function(){
				var conteiner_id='';
				for(var j=0;j<tabs.length;j++){
					tabs[j].setAttribute('class','wpdevart_tab');
					conteiner_id=tabs[j].getAttribute('id')+'_container';
					document.getElementById(conteiner_id).style.display='none';
					
				}
				this.setAttribute('class','wpdevart_tab show');
				conteiner_id=this.getAttribute('id')+'_container';
				document.getElementById(conteiner_id).style.display='block';
				
			})
		}
	},
	
	wpdevart_remove_popup:function(){
		document.getElementsByClassName('wpdevart_ovrlay')[0].parentNode.removeChild(document.getElementsByClassName('wpdevart_ovrlay')[0])
		document.getElementsByClassName('wpdevart_popup_conteiner')[0].parentNode.removeChild(document.getElementsByClassName('wpdevart_popup_conteiner')[0]);
		this.current_edited_element=null;
	},
	
	tree_node_element:function(with_ul=true,info=null){
		var self=this;
		if(info==null || Object.keys(info).length==0){
			info=self.default_info;
		}
		var Ul = document.createElement("ul");
		var li = document.createElement("li");
		var Div = document.createElement("div");
		var Img = document.createElement("img");		
		var Br = document.createElement("br");
		var Button = document.createElement("button");
		var Button_bro_right = document.createElement("button");
		var Button_bro_left = document.createElement("button");
		var trash_icon = document.createElement("span");
		var edit_icon = document.createElement("span");
		var info_for_node= document.createElement("input");
		var title = document.createElement("div");
		var description = document.createElement("div");
		Ul.appendChild(li);
		Div.setAttribute('class','wpdevart_tree_node')
		li.appendChild(Div);
		Img.setAttribute('src',info['image_url'])		
		Div.appendChild(Img);
		Div.appendChild(Br);		
		Button.setAttribute('class','add_child_button');
		Button_bro_right.setAttribute('class','add_bro_right');
		Button_bro_left.setAttribute('class','add_bro_left');
		Button.setAttribute('type','button');
		Button_bro_right.setAttribute('type','button');
		Button_bro_left.setAttribute('type','button');		
		trash_icon.setAttribute('class','dashicons dashicons-trash remove_tree_node');
		edit_icon.setAttribute('class','dashicons dashicons-edit edit_tree_node');
		info_for_node.setAttribute('class','wpdevart_node_info');
		info_for_node.setAttribute('type','hidden');
		info_for_node.value=JSON.stringify(info)
		title.setAttribute('class','node_title');
		description.setAttribute('class','node_desc');
		title.innerHTML=info['node_title'];
		description.innerHTML=info['node_description']
		self.add_bortehr_node_functionalyty(Button_bro_right,false);
		self.add_bortehr_node_functionalyty(Button_bro_left,true);
		self.add_node_functionalty(Button);
		self.remove_node_functionality(trash_icon);
		self.edit_node_functionality(edit_icon);
		Div.appendChild(Button);
		Div.appendChild(Button_bro_right);
		Div.appendChild(Button_bro_left);
		Div.appendChild(trash_icon);
		Div.appendChild(edit_icon);
		Div.appendChild(title);	
		Div.appendChild(description);	
		Div.appendChild(info_for_node);		
		if(with_ul)
			return Ul
		return li
	},
	/*Save*/
	make_from_tree_json:function(){
		var tree={},self=this;
		tree_start_node=document.getElementById(self.tree_id).children[0].children[0].children[0];		
		tree=self.get_all_childs(tree_start_node,tree);
		return tree
	},
	
	get_all_childs:function(node,tree_json){
		var tree_childs=node.parentNode.parentNode.children,value='',self=this;
		for(var i=0;i<tree_childs.length;i++){
			tree_json[i]={};
			
			var node_info=tree_childs[i].children[0].getElementsByClassName('wpdevart_node_info')[0].value;
			if(node_info!='')
				tree_json[i]['node_info']=JSON.parse(node_info);
			else
				tree_json[i]['node_info']={};
			if(typeof(tree_childs[i].children[1])!='undefined'){
				tree_json[i]['chidrens']=self.get_all_childs(tree_childs[i].children[1].children[0].children[0],{});
			}else{
				tree_json[i]['chidrens']={};
			}
		}		
		return tree_json;
	},
	
	start:function(){
		var first_element_add_button=document.getElementById("wpdevart_tree").getElementsByClassName('wpdevart_tree_node')[0].getElementsByTagName('button')[0];
		var first_edit_icon=document.getElementById("wpdevart_tree").getElementsByClassName('wpdevart_tree_node')[0].getElementsByClassName('edit_tree_node')[0];		
		this.edit_node_functionality(first_edit_icon);
		this.add_node_functionalty(first_element_add_button);
		this.initial_exsisting_tree();
	}
	
}
function submitbutton(value){
	document.getElementById("adminForm").setAttribute("action",document.getElementById("adminForm").getAttribute("action")+"&task="+value);
	document.getElementById("wpdevart_chart_tree_all_info").value=JSON.stringify(wpdevart_chart.make_from_tree_json());
	document.getElementById("adminForm").submit();
}