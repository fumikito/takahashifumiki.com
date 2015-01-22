<?php

namespace Fumiki\Utility;


use Fumiki\Pattern\Singleton;

class Input extends Singleton
{
	/**
	 * Constructor
	 *
	 * Constuctor should not be public.
	 *
	 * @param array $argument
	 */
	protected function __construct( array $argument = array() ) {
		// TODO: Implement __construct() method.
	}


	/**
	 * Get $_GET
	 *
	 * @param string $key
	 *
	 * @return null
	 */
	public function get($key){
		return isset($_GET[$key]) ? $_GET[$key] : null;
	}

	/**
	 * Get $_POST
	 *
	 * @param string $key
	 *
	 * @return null
	 */
	public function post($key){
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}

	/**
	 * Get $_REQUEST
	 *
	 * @param string $key
	 *
	 * @return null
	 */
	public function request($key){
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
	}

	/**
	 * Verify nonce
	 *
	 * @param string $action
	 * @param string $key Default, '_wpnonce'
	 *
	 * @return bool
	 */
	public function verify($action, $key = '_wpnonce'){
		return wp_verify_nonce($this->request($key), $action);
	}

}
