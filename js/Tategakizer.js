var Tategakizer = new Class({
	Implements: [Options],
	options: {
		
	},
	
	initialize: function(element){
		
	},
	
	/**
	 * 指定された要素を特定の要素で区切って縦書きにする
	 */
	devide: function(element,splitter){
		var txt = element.get('text');
		var lines = (splitter) ? txt.split(splitter) : [txt];
		element.empty();
		lines.each((function(elt,index){
			var str = (elt != "") ? elt + splitter : elt;
			var line = this.line(str, 'p');
			if(line.get('text')) line.inject(element);
		}),this);
		return element.addClass('tategaki');
	},
	
	/**
	 * 指定された要素を指定の文字数で区切って返す
	 */
	make: function(element,limit){
		var txt = this.applyTcy(element.get('text')).split(':::');
		// TODO: 縦中横の実装 txt = this.applyTcy(txt);
		var pArr = [];
		var counter = 0;
		txt.each(function(elt,index){
			if(counter % limit == 0) pArr.push(new Element('p'));
			if(elt.match(/^autoAscii/)){
				/*new Element('span').set('text',elt.replace(/^autoAscii/,"")).addClass('ascii').setStyles({
					width: (elt.length - 9) + 'em',
					height: (elt.length - 9) + 'em'
				}).inject(pArr[counter]);*/
				new Element('span').set('text',elt.replace(/^autoAscii/,"")).addClass('ascii').inject(pArr[counter]);
			}else if(elt.match(/^autoTcy/)){
				new Element('span').set('text',elt.replace(/^autoTcy/,"")).addClass('horizontal').inject(pArr[counter]);
			}else{
				var arr = elt.split('');
				arr.each(function(letter,idx){
					this.wrap(letter,'span').inject(pArr[counter]);
				},this);
			}
		},this);
		//.asciiの文字を全部分割して、入れ替える
		$$(".ascii").each(function (elt, index){
			var str = elt.get("text").split("");
			for(var i = 0, l = str.length; i < l; i++){
				new Element("span").addClass("ascii").set("text", str[i]).inject(elt, "before");
			}
			elt.dispose();
		});
		element.empty().addClass('tategaki');
		pArr.each(function(elt,index){
			elt.inject(element);
		});
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
		if(this.shibu.contains(element.get('text')))
			element.addClass('shibu');
		if(this.nibu.contains(element.get('text')))
			element.addClass('nibu');
		if(this.tcy.contains(element.get('text')))
			element.addClass('tcy');
		return element;
	},
	
	apply: function(){
		
	},
	
	applyTcy: function(str){
		var newStr = str.replace(/(^|[^ -~])([ -~]{4,})([^ -~]|$)/g, "$1:::autoAscii$2:::$3")
		                .replace(/(:::[^ -~])([ -~]{4,})([^ -~]|$)/,  "$1:::autoAscii$2:::$3")
		                .replace(/:::autoAscii([0-9]+):::/, "$1")
		                .replace(/(^|[^ -~])([ -~][ -~])([^ -~]|$)/g,"$1:::autoTcy$2:::$3");
		console.log(newStr);
		return newStr.replace(/^:::/,"").replace(/:::$/,"");
	},
	
	//文字列をチェックする属性
	tcy: ["「","」","（","）","：","ー","＝", "【", "】", "〜"],
	tcy_demi: [],
	shibu: ["。","、"],
	nibu: ["ぁ","ぃ","ぅ","ぇ","ぉ","ゃ","ゅ","ょ","っ","ァ","ィ","ゥ","ェ","ォ","ッ","ャ","ュ","ョ"]
});