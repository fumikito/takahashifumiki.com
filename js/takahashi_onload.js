/**
 * @author Takahashi Fumiki
 * @version 1.2
 */

window.addEvent('domready',function(event){
	//フッターにリンクホバーアクションをつける
	$$('#footer li a').each(function(elt,index){
		var fx = new Fx.Morph(elt,{link:'cancel'});
		elt.addEvent('mouseenter',(function(){
			this.start({
				color:["#00A0E9"],
				backgroundColor:["#cee8f4"],
				paddingLeft:[10]
			});
		}).bindWithEvent(fx));
		elt.addEvent('mouseleave',(function(){
			this.start({
				color:["#cee8f4"],
				backgroundColor:["#00A0E9"],
				paddingLeft: [0]
			});
		}).bindWithEvent(fx));
	});
	
	//検索フォームの使い勝手を変える
	var box = $("s");
	if(box){
		box.addEvents({
			'focus': function(e){
				e.target.value = "";
			},
			'blur': function(e){
				if(box.value == ""){
					box.value = String.fromCharCode(8811) + "検索語句";
				}
			}
		});
	}
});