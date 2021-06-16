wpda_admin_library = {
	
	start:function(){
		var self=this;
		document.addEventListener("DOMContentLoaded", function(event) {
			self.initial_wpda_color_gradient();
			self.initial_color_input();
			self.initial_simple_input();
			self.initial_range_input();
			self.wdpa_margin_padding_input();			
			self.initial_wpdaTabs();
			self.initial_popups();
			self.initial_preview_elems()
			self.wpda_add_pro_feature();
		});
	},
	
	initial_wpda_color_gradient:function(){
		var elements=document.getElementsByClassName('wpda_option wpda_color_gradient');
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.gradient_color_input(elements[i]);
		}		
	},
	
	initial_color_input:function(){
		var elements=document.getElementsByClassName('wpda_option wpda_color_input');
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.color_input(elements[i]);
		}	
	},
	
	initial_popups:function(){
		var elements=document.getElementsByClassName('wpda_option wpda_popup');
		if(typeof ( elements[0] ) === 'undefined'){
			return false;
		}
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.popup(elements[i]);
		}
	},
	
	initial_wpdaTabs:function(){
		var elements=document.getElementsByClassName('wpda_tab_conteiner');
		if(typeof ( elements[0] ) === 'undefined'){
			return false;
		}
		wpda_admin_library_helper.wpdaTabs(elements[0]);
	},
	initial_preview_elems:function(){
		var elements=document.getElementsByClassName('with_preview');
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.conect_element_to_style(elements[i]);
		}	
	},
	initial_simple_input:function(){
		var elements=document.getElementsByClassName('wpda_option wpda_simple_input');
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.wdpa_simple_input(elements[i]);
		}		
	},
	initial_range_input:function(){
		var elements=document.getElementsByClassName('wpda_option wpda_range_input');
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.wdpa_range_input(elements[i]);
		}		
	},
	wdpa_margin_padding_input:function(){
		var elements=document.getElementsByClassName('wpda_option wpda_margin_padding_input');
		for(let i = 0; i < elements.length; i++){
			wpda_admin_library_helper.wdpa_simple_input(elements[i]);
		}		
	},
	wpda_add_pro_feature:function(){
		var elements=document.getElementsByClassName('wpda_pro_option');
		for(let i = 0; i < elements.length; i++){
			elements[i].addEventListener('click',function(){
				alert('If you want to use this feature upgrade to Organization Chart Pro');
				return false;
			})
		}	
	}
	
}

/*########################### Helper function for lib ################################*/
wpda_admin_library_helper={	
	gradient_color_input : function(main_div){
		// this function uses jquery
		jQuery(main_div).find('input.color').wpColorPicker();
		if(jQuery(main_div).find('select').eq(0).val()=='none'){
			jQuery(main_div).find('select').eq(0).parent().children().eq(1).hide();
		}
		jQuery(main_div).find('select').eq(0).change(function(){
			if(jQuery(this).val()=='none'){
				jQuery(this).parent().children().eq(1).hide();
			}else{
				jQuery(this).parent().children().eq(1).show();
			}
		});
	},
	
	color_input : function(main_div){
		jQuery(main_div).find('input.color').wpColorPicker({
			change: function (event, ui) {
				var element = event.target;
				var color = ui.color.toString();
				if(jQuery(event.target).hasClass('with_preview')){
					var targ_el_id=jQuery(event.target).attr('data-preview-id');
					var targ_el_css=jQuery(event.target).attr('data-preview-action');
					jQuery('#'+targ_el_id).css(targ_el_css,color);
				}
			},					
		});
	},
	popup : function(main_div){
		main_div.getElementsByClassName('wpda_popup_o_c_button')[0].addEventListener('click',function(e){
			if(this.parentElement.getElementsByClassName('wpda_popup_window')[0].style.display=='inline-block'){
				this.parentElement.getElementsByClassName('wpda_popup_window')[0].style.display='none';				
			}else{
				this.parentElement.getElementsByClassName('wpda_popup_window')[0].style.display='inline-block';
			}
		})
	},
	
	wpdaTabs : function(main_div){
		var linkElements=new Array();
		var tabElements=new Array();
		var currentAdminPage=window.location.search.replace('?','').split('&')[0].split('=')[1];
		linkElements=filterByTag( filterByTag ( filterByTag(main_div.children,'div')[0].children , 'ul' )[0].children , 'li' );		
		tabElements=filterByTag ( filterByTag(main_div.children,'div')[1].children , 'div' );
		
		for(let i=0;i<linkElements.length;i++){
			linkElements[i].addEventListener('click',function(){			
				for(let j=0;j<linkElements.length;j++){
					linkElements[j].classList.remove('active');
					tabElements[j].classList.remove('active');
				}
				linkElements[i].classList.add('active');
				tabElements[i].classList.add('active');
				saveLastOpenTab(i)
			})
		}
		openLastOpenTab();
		function saveLastOpenTab(tabIndex){			
			var storage=localStorage.getItem('wpdaLibraryTabs')
			if(storage!=null){
				storage=JSON.parse(storage);
				storage[currentAdminPage]=tabIndex;
			}else{
				storage={};
				storage[currentAdminPage]=tabIndex;
			}
			localStorage.setItem('wpdaLibraryTabs',JSON.stringify(storage));
		}
		function openLastOpenTab(){
			var storage=JSON.parse(localStorage.getItem('wpdaLibraryTabs')),Index=0;
			if( storage !== null && typeof( storage[ currentAdminPage ] ) != 'undefined' ){
				Index = storage[ currentAdminPage ];
			}
			main_div.getElementsByClassName('wpda_links_conteiner')[0].getElementsByTagName('li')[Index].click();
		}
		function filterByTag(elements,tag_name){
			var filteredElements=new Array();
			for(var i=0;i<elements.length;i++){
				if(elements[i].tagName.toLowerCase()===tag_name){
					filteredElements.push(elements[i]);
				}
			}
			return filteredElements;
		}
	},
	conect_element_to_style: function(element){
		var conect_elem_id=element.getAttribute('data-preview-id');
		var conect_elem_style=element.getAttribute('data-preview-action');
		conect_elem_style_in_js='';
		
		for(let i=0; i<conect_elem_style.length;i++){
			if(conect_elem_style[i]=='-'){				
				conect_elem_style=conect_elem_style.slice(0, i) +conect_elem_style[i+1].toUpperCase()+ conect_elem_style.slice(i+2);
			}
		}
		if( element.tagName == 'SELECT' ){
			element.addEventListener('change',function(){
				document.getElementById(conect_elem_id).style[conect_elem_style]=element.value;
			})
			document.getElementById(conect_elem_id).style[conect_elem_style]=element.value;
		}
		if(element.tagName == 'INPUT' && !element.classList.contains("color")){
			let metric='';
			if(element.parentElement.getElementsByClassName('wpda_input_metric').length > 0){
				let input_metric=element.parentElement.getElementsByClassName('wpda_input_metric')[0];
				input_metric.addEventListener('change',function(){
					if((!isNaN(parseFloat(element.value)) && isFinite(element.value)) && element.value !='' && element.parentElement.getElementsByClassName('wpda_input_metric').length > 0){
						metric=element.parentElement.getElementsByClassName('wpda_input_metric')[0].value;
					}
					document.getElementById(conect_elem_id).style[conect_elem_style]=element.value+metric;
				});
			}
			element.addEventListener('input',function(){
				let metric='';
				if((!isNaN(parseFloat(element.value)) && isFinite(element.value)) && element.value !='' && element.parentElement.getElementsByClassName('wpda_input_metric').length > 0){
					metric=element.parentElement.getElementsByClassName('wpda_input_metric')[0].value;
				}
				document.getElementById(conect_elem_id).style[conect_elem_style]=element.value+metric;
			});
			if((!isNaN(parseFloat(element.value)) && isFinite(element.value)) && element.value !='' && element.parentElement.getElementsByClassName('wpda_input_metric').length > 0){
				metric=element.parentElement.getElementsByClassName('wpda_input_metric')[0].value;
			}
			document.getElementById(conect_elem_id).style[conect_elem_style]=element.value+metric;
		}
		if(element.classList.contains("color")){
			document.getElementById(conect_elem_id).style[conect_elem_style]=element.value;
		}
	},
	wdpa_simple_input:function(main_div){
		if(main_div.getElementsByClassName('wpda_reponsive_select').length>0){
			var responsive_select= main_div.getElementsByClassName('wpda_reponsive_select')[0];
			let selectedIndex=0;
			responsive_select.addEventListener('change',function(){
				let selectedIndex=0;
				if(typeof(this.selectedIndex)!='undefined'){
					selectedIndex=this.selectedIndex
				}
				show_cur_device_input(selectedIndex);
			})
			show_cur_device_input(selectedIndex);
		}
		
		function show_cur_device_input(index){
			let inputs=main_div.getElementsByClassName('responsive_elements_coneitner');
			for(let i=0;i<inputs.length;i++){
				inputs[i].style.display='none';
			}
			inputs[index].style.display='block';
		}
	},
	wdpa_range_input:function(main_div){
		main_div.getElementsByTagName('input')[0].addEventListener('input',function(){
			main_div.getElementsByTagName('output')[0].innerHTML = this.value;
		})
	},
	wdpa_margin_padding_input:function(main_div){
		if(main_div.getElementsByClassName('wpda_reponsive_select').length>0){
			var responsive_select= main_div.getElementsByClassName('wpda_reponsive_select')[0];
			let selectedIndex=0;
			responsive_select.addEventListener('change',function(){
				let selectedIndex=0;
				if(typeof(this.selectedIndex)!='undefined'){
					selectedIndex=this.selectedIndex
				}
				show_cur_device_input(selectedIndex);
			})
			show_cur_device_input(selectedIndex);
		}
		
		function show_cur_device_input(index){
			let inputs=main_div.getElementsByClassName('responsive_elements_coneitner');
			for(let i=0;i<inputs.length;i++){
				inputs[i].style.display='none';
			}
			inputs[index].style.display='block';
		}
	}
	
}

wpda_admin_library.start();