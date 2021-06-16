class wpdevart_org_chart_front{
	constructor(conteiner,options={}){
		var def_options={
			mobile_frendly:'mobile',
			mobile_size: 450,
			def_scroll: 0,
		}
		this.options = Object.assign(def_options, options);
		var self = this;
		this.conteiner=document.getElementById(conteiner);
		this.conteiner_id=this.conteiner.getAttribute("id");
		this.conteiner_width=this.conteiner.clientWidth;
		if(options.mobile_frendly == 'mobile' || options.mobile_frendly == 'mob_view_only_on_mob'){	
			window.addEventListener('resize', function(){ self.set_mobile_class(); self.create_tree_line_mobile_css(); });			
			self.conteiner_width=self.conteiner.clientWidth;
			self.set_mobile_class();
			self.create_tree_line_mobile_css();			
		}
		self.set_def_scroll();
	}
	set_mobile_class(){
		var self = this, check_only_mob = true;
		self.mob_width = Math.min(window.innerWidth,self.conteiner.parentElement.parentElement.clientWidth);
		if(this.options.mobile_frendly == 'mob_view_only_on_mob'){
			check_only_mob = (window.innerWidth <= this.options.mobile_size)
		}
		if(self.mob_width <= self.conteiner_width && check_only_mob){
			self.conteiner.classList.add('wpdev_mobile');
		}else{
			self.conteiner.classList.remove('wpdev_mobile');
			self.conteiner.style.marginTop = "0";
		}
	}
	set_def_scroll(){
		var self = this,scroll_pixels = 0,diff = 0;
		diff = (self.conteiner.parentElement.parentElement.clientWidth - self.conteiner_width)
		if(diff>=0){
			return;
		}		
		scroll_pixels=parseInt(Math.abs(diff)*self.options.def_scroll/100);
		self.conteiner.parentElement.scrollTo(scroll_pixels,0);
	}
	create_tree_line_mobile_css(){
		let self = this;
		if(self.conteiner.classList.contains('first_child_hidden') && self.conteiner.classList.contains('wpdev_mobile')){
			let firstElementHeight = self.conteiner.getElementsByTagName('ul')[0].getElementsByTagName('li')[0].getElementsByTagName('ul')[0].getElementsByTagName('li')[0].getElementsByClassName('wpda_tree_item_container')[0].offsetHeight;
			let line_css = document.getElementById(self.conteiner_id + "_line_css");
			
			if(line_css == null){
				line_css = document.createElement("style");
				line_css.setAttribute("id", self.conteiner_id + "_line_css");
				line_css.innerHTML = '.wpdev_mobile.first_child_hidden#' + self.conteiner_id + ' > ul > li > ul > li:first-child::before{top: ' + parseInt(firstElementHeight/2) + 'px; height: calc(100% -  ' + parseInt(firstElementHeight/2) + 'px); }';
				document.getElementsByTagName('body')[0].appendChild(line_css);
				console.log(line_css)
				
			}else{
				line_css.innerHTML = '.wpdev_mobile.first_child_hidden#' + self.conteiner_id + ' > ul > li > ul > li:first-child::before{top: ' + parseInt(firstElementHeight/2) + 'px; height: calc(100% -  ' + parseInt(firstElementHeight/2) + 'px); }';
			}
		}
		
	}
}


