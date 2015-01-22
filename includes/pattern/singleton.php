<?php

namespace Fumiki\Pattern;


/**
 * Singleton Interface
 *
 * @author Takahashi Fumiki
 * @
 */
abstract class  Singleton
{

	/**
	 * @var Singleton
	 */
	protected static $instances = array();

	/**
	 * @var array
	 */
	protected static $default_arguments = array();

	/**
	 * Constructor
	 *
	 * Constuctor should not be public.
	 *
	 * @param array $argument
	 */
	abstract protected function __construct( array $argument = array() );

	/**
	 * Get instance
	 *
	 * @param array $argument
	 * @return static
	 */
	public static function get_instance( array $argument = array() ){
		$class_name = get_called_class();
		if( !isset(self::$instances[$class_name]) ){
			// Merge arguments to default array
			$merged = array_merge(self::$default_arguments, $argument);
			self::$instances[$class_name] = new $class_name($merged);
		}
		return self::$instances[$class_name];
	}
}
