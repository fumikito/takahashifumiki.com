<?php
/**
 * ウェブサービスの基底クラス
 */
class Web_Service{
	var $key;

	function __construct(){

	}

	function error(){
		header('HTTP/1.0 408 Request Timeout');
	}
}

class googleSearch{
	var $q;
	var $endPoint;

	function __construct($query,$opt){
		if($opt == 'site'){
			$this->q = rawurlencode($query);
			$this->endPoint = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&hl=ja&key=ABQIAAAAivVxgqLaSOaph6D0d9Al4xTS0YYOioHdfwmeSLzl9ANu5aNF6RQPuDzy83-F7dfgnFD5FxnT__TSBg&rsz=large&q=";
		}elseif($opt == 'link'){
			$this->q = rawurlencode("link:takahashifumiki.com");
			$this->endPoint = "http://ajax.googleapis.com/ajax/services/search/blogs?v=1.0&hl=ja&key=ABQIAAAAivVxgqLaSOaph6D0d9Al4xTS0YYOioHdfwmeSLzl9ANu5aNF6RQPuDzy83-F7dfgnFD5FxnT__TSBg&q=";
		}
	}

	function get_result(){
		return file_get_contents($this->endPoint.$this->q);
	}
}

/**
 * ツイッターへのリクエスト
 */
class Twitter{
	var $endpoint = "http://twitter.com/statuses/user_timeline/takahashifumiki.json";
	var $cache = "./cache/tweet.json";
	var $flg;

	function __contruct(){
		$time = time();
		if(file_exists($this->cache) && ($time - filemtime($this->cache)) / 1000 / 60 < 20) $this->flg = "local";
	}

	function get_result(){
		header('Content-Type: text/javascript; charset=utf-8');
		if($this->flg == 'local'): echo file_get_contents($this->cache);
		else:
			$con = file_get_contents($this->endpoint);
			file_put_contents($this->cache,$con);
			echo $con;
		endif;
	}
}

/**
 * はてなへのリクエスト
 */
class Hatena{
	var $endpoint = 'http://b.hatena.ne.jp/entrylist?sort=hot&amp;threshold=&amp;url=http://takahashifumiki.com/&amp;mode=rss';
	var $cache = "./cache/hatena.xml";
	var $flg;

	function __construct(){
		$time = time();
		if(file_exists($this->cache) && ($time - filemtime($this->cache)) / 1000 /60 < 20) $this->flg = "local";
	}

	function get_result(){
		header('Content-Type: text/xml; charset=utf-8');
		if($this->flg == 'local'): echo file_get_contents($this->cache);
		else:
			$con = file_get_contents($this->endpoint);
			file_put_contents($this->cache,$con);
			echo $con;
		endif;
	}
}

if(isset($_GET['mode'])):
	$mode = $_GET['mode'];
	//どのWebサービスを利用するかによって分岐
	if($mode == "gsearch"):
		ini_set('default_socket_timeout',5);
		$req = new googleSearch($_GET['q'],$_GET['opt']);
		header('Content-Type: text/javascript; charset=utf-8');
		echo $req->get_result();
	elseif($mode == 'gblog'):
		ini_set('default_socket_timeout',5);
		$req = new googleSearch('','link');
		header('Content-Type: text/javascript; charset=utf-8');
		echo $req->get_result();
		elseif($mode == "yahoo"):
	elseif($mode == "twitter"):
		ini_set('default_socket_timeout',10);
		$req = new Twitter();
		$req->get_result();
	elseif($mode == "amazon"):
	elseif($mode == "hatena"):
		ini_set('default_socket_timeout',5);
		$req = new Hatena();
		$req->get_result();
	elseif($mode == "skype"):
	else:
		header('Location: '.$_SERVER['HTTP_HOST']);
	endif;
else:
	//直接アクセスされた場合
	header('Location: '.$_SERVER['HTTP_HOST']);
endif;

?>
