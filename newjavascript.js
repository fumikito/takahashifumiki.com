
Person = function(name, sex){
	
	/**
	 * 名前
	 * @type {String}
	 */
	this.name = name;
	
	/**
	 * 性別
	 * @type {String}
	 */
	this.sex = sex;
	
	/**
	 * 自己紹介をする
	 * @returns {undefined}
	 */
	this.sayHello = function(){
		alert('私の名前は' + this.name + 'です。');
	}
}
