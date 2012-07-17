<?php
/*
 * 自然言語処理のテスト
 * 
 */

/**
 * @var string アプリケーションID 
 */
define('YAHOO_APP_ID', 'fumikito');

/**
 * @var string エンドポイント 
 */
define('YAHOO_TEXT_PARSER_ENDPOINT', 'http://jlp.yahooapis.jp/MAService/V1/parse');

/**
 * Yahooテキスト解析の値 
 */
class Yahoo_Text_Parser_Filter{
	
	/**
	 * @var string 形容詞 
	 */
	const ADJECTIVE = 1;
	
	/**
	 * @var string 形容動詞
	 */
	const ADJECTIVE_VERB = 2;
	
	/**
	 * @var string 感動詞
	 */
	const EXCLAMATION = 3;
	
	/**
	 * @var string 副詞
	 */
	const ADVERB = 4;
	
	/**
	 * 連体詞
	 */
	const SUB_ADJECTIVE = 5;
	
	/**
	 * 接続詞
	 */
	const CONJUNCTION = 6;
	
	/**
	 * @var string 接頭辞
	 */
	const PREFIX = 7;
	
	/**
	 * @var string 接尾辞
	 */
	const SUFFIX = 8;
	
	/**
	 * @var string 名詞
	 */
	const NOUN = 9;
	
	/**
	 * @var string 動詞
	 */
	const VERB = 10;
	
	/**
	 * @var string 助詞
	 */
	const PARTICLE = 11;
	
	/**
	 * @var string 助動詞
	 */
	const AUXILIARY_VERB = 12;
	
	/**
	 * @var string 特殊（句読点、カッコ、記号など）
	 */
	const OTHERS = 13;
}

/**
 * Yahooリクエストを返す
 * @param type $text 
 */
function get_yahoo_parsed_text($text){
	var_dump($text);
	$request = array(
		'appid' => YAHOO_APP_ID,
		'results' => 'uniq',
		'sentence' => $text,
		'uniq_by_baseform' => 'true',
		'filter' => implode('|', array(
			Yahoo_Text_Parser_Filter::NOUN,
			Yahoo_Text_Parser_Filter::ADJECTIVE,
			Yahoo_Text_Parser_Filter::VERB
		))
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, YAHOO_TEXT_PARSER_ENDPOINT);//.'?appid='.YAHOO_APP_ID.'&results=ma&sentence='.rawurlencode('我が輩は猫である'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
	$result = curl_exec($ch);
	if(! ($err = curl_errno($ch))){
		$xml = simplexml_load_string($result);
		var_dump(number_format((double)$xml->uniq_result->filtered_count).'件の単語');
		foreach($xml->uniq_result->word_list->word as $word){
			var_dump($word);
		}
		
	}else{
		var_dump(get_status_header_desc($err));
	}
	curl_close($ch);
}