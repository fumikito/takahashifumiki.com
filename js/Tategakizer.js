var Tategakizer = new Class({
	Implements: [Options],
	options: {
		
	},
	
	initialize: function(element){
		
	},
	
	make: function(element,splitter){
		var txt = element.get('text');
		var lines = txt.split(splitter);
		element.empty();
		lines.each((function(elt,index){
			var str = (elt != "") ? elt + splitter : elt;
			var line = this.line(str, 'p');
			if(line.get('text')) line.inject(element);
		}),this);
		return element
	},
	
	line: function(str, linewrapper){
		var arr = new Element(linewrapper);
		str.trim().split('').each((function(elt,index){
			this.wrap(elt, 'span').inject(arr);
		}),this);
		return arr;
	},
	
	wrap: function(str, tag){
		var element = new Element(tag).set('text',str);
		return this.filter(element);
	},
	
	split: function(string, needle){
		return string.split(needle);
	},
	
	filter: function(element){
		if(this.shibu.contains(element.get('text'))) element.addClass('shibu');
		return element;
	},
	
	apply: function(){
		
	},
	
	//文字列をチェックする属性
	tcy: ["「","」","（","）"],
	tcy_demi: [],
	shibu: ["。","、"]
});