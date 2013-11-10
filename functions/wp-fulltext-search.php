<?php
/**
 * WordPressで全文検索を試みる
 * 
 * initフックなどでインスタンス化してください。
 * あんまり遅いタイミングだとエラーを吐きます。
 * Singleton実装です。
 * 
 * <code>
 * // functions.phpなどに記載
 * add_action('init', function(){
 *     WP_Fulltext_Search::init();
 * });
 * </code>
 * 
 * @package WordPress
 * @author Takahashi Fumiki <takahashi.fumiki@hametuha.co.jp>
 */
class WP_Fulltext_Search{
	
	/**
	 * このインスタンス
	 * @var My_Fulltext_Search
	 */
	private static $instance = null;
	
	/**
	 * MySQLインデックスの名前
	 * @var string
	 */
	private static $index_key = 'wp_fulltext';
	
	/**
	 * 初期化を行う
	 */
	public static function init(){
		if(did_action('wp_loaded')){
			trigger_error('initフックで行ってください', E_USER_WARNING);
		}elseif(!self::$instance){
			self::$instance = new self();
			add_action('admin_init', array(self::$instance, 'check_index'));
			add_action('save_post', array(self::$instance, 'save_post'), 10, 2);
			add_filter('posts_search', array(self::$instance, 'search_query'), 10, 2);
		}
	}
	
	/**
	 * コンストラクタ
	 */
	private function __construct() {}
	
	/**
	 * インデックスがなければ付与する
	 * 
	 * @global wpdb $wpdb
	 */
	public function check_index(){
		global $wpdb;
		if(!$this->index_exists()){
			$key = self::$index_key;
			$wpdb->query("ALTER TABLE {$wpdb->posts} ADD FULLTEXT `{$key}` (post_content_filtered)");
		}
	}
	
	/**
	 * インデックスの有無を確認する
	 * 
	 * @global wpdb $wpdb
	 * @return boolean
	 */
	private function index_exists(){
		global $wpdb;
		return (boolean) $wpdb->get_var( $wpdb->prepare("SHOW INDEX FROM {$wpdb->posts} WHERE Key_name = %s", self::$index_key) );
	}
	
	/**
	 * save_postにかけるフック
	 * 
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public function save_post($post_id, $post){
		if(wp_is_post_autosave($post) || wp_is_post_revision($post)){
			return;
		}
		switch($post->post_type){
			case 'post':
				$this->update_content_filtered($post);
				break;
		}
	}
	
	/**
	 * WordPressの投稿テーブルに分かち書きを保存
	 * 
	 * @global wpdb $wpdb
	 * @param WP_Post $post
	 * @return boolean
	 */
	private function update_content_filtered($post){
		global $wpdb;
		$post = get_post($post);
		// 検索対象としたいカラム（タイトル、本文、抜粋）を合体。
		// 重み付けしたい場合は、このアプローチ使えません。
		$string = implode(' ', array($post->post_title, $post->post_content, $post->post_excerpt));
		$nodes = $this->get_nodes($string);
		if(!empty($nodes)){
			$wpdb->update($wpdb->posts, array(
				'post_content_filtered' => $nodes,
			), array(
				'ID' => $post->ID
			), array('%s'), array('%d'));
			update_post_meta($post->ID, '_last_chunked', current_time('mysql'));
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * テキストを分かち書きする
	 * 
	 * @param String $string
	 * @return String 分かち書きされたテキスト
	 */
	private function get_nodes($string){
		// タグ除去
		$stripped = $this->strip($string);
		// チャンキング開始
		$chunk = array();
		if(class_exists('Mecab')){
			$mecab = new Mecab();
			$nodes = $mecab->parseToNode($stripped);
			foreach($nodes as $node){
				$chunk[] = $node->surface;
			}
		}
		// 半角スペースで連結して返す
		return implode(' ', $chunk);
	}
	
	
	/**
	 * 文字列からタグを除去する
	 * 
	 * @param String $string
	 * @return string
	 */
	private function strip($string){
		// rtタグを中身ごと除去
		$string = preg_replace('/<rt>.*?<\/rt>/', '', $string);
		// rpタグを中身ごと除去
		$string = preg_replace('/<rp>.*?<\/rp>/', '', $string);
		// タグを削除
		$string = strip_tags($string);
		// ショートコードを除去
		$string = strip_shortcodes($string);
		// 連続する改行コードを削除
		$string = preg_replace('/\n{2,}/', "\n", $string);
		// 改行コードを半角スペースに変更する
		$string = str_replace("\n", " ", $string);
		// 連続する空白を圧縮
		$string = preg_replace('/\s{2,}/', ' ', $string);
		// これで生の文字列とする
		return $string;
	}
	
	/**
	 * 検索クエリを改変する
	 * 
	 * @global wpdb $wpdb
	 * @param string $where WHERE節
	 * @param WP_Query $wp_query 
	 * @return string
	 */
	public function search_query($where, &$wp_query){
		global $wpdb;
		// 検索の場合のみフィルタリング
		// NOTICE: この方法だと、すべての検索が変更されます。
		// 適宜、投稿タイプなどで場合わけしてください。
		if( $wp_query->is_search() ){
			$query = implode(' ', $wp_query->get('search_terms'));
			$where = $wpdb->prepare(" AND ( MATCH(post_content_filtered) AGAINST (%s) )", $query);
		}
		return $where;
	}
}
