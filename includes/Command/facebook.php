<?php

namespace Fumiki\Command;

/**
 * Facebookコメントを引っこ抜く
 *
 * @package Fumiki\Command
 */
class Facebook extends \WP_CLI_Command  {


	const COMMAND_NAME = 'facebook';

	/**
	 * Get facebook thread
	 *
	 * @synopsis <comment_id> <path>
	 * @param array $args
	 * @param array $assoc
	 */
	public function thread( $args, $assoc ) {
		list( $comment_id, $path ) = $args;
		try {
			$fb = gianism_fb_admin();
			if ( is_wp_error( $fb ) ) {
				throw new \Exception( $fb->get_error_message(), $fb->get_error_code() );
			}
			$comments = $fb->api( "{$comment_id}/comments" );
			if ( $comments['data'] ) {
				$result = [];
				$next = true;
				while ( $comments['data'] && $next ) {
					foreach ( $comments['data'] as $comment ) {
						$result[] = $this->get_children( $fb, $comment );
					}
					if ( isset( $comments['paging']['next'] ) ) {
						$next = true;
						$comments = $fb->api( "{$comment_id}/comments", [
							'after' => $comments['paging']['cursors']['after'],
						] );
					} else {
						$next = false;
					}
				}
				if ( ! file_put_contents( $path, json_encode( $result ) ) ) {
					\WP_CLI::error( 'ファイルの書き込みに失敗しました。' );
				} else {
					\WP_CLI::success( 'ファイルを出力しました。' );
				}
			}
		} catch ( \Exception $e ) {
			\WP_CLI::error( sprintf( '%s, %s', $e->getCode(), $e->getMessage() ) );
		}
	}


	/**
	 * Get comment children
	 *
	 * @param \Facebook $fb
	 * @param $comment
	 *
	 * @return mixed
	 */
	protected function get_children( \Facebook $fb, $comment ) {
		if ( ! isset( $comment['children'] ) ) {
			$comment['children'] = [];
		}
		try {
			$request = $fb->api( "{$comment['id']}/comments" );
			if ( $request && $request['data'] ) {
				foreach ( $request['data'] as $c ) {
					$comment['children'][] = $c;
				}
			}
		} catch ( \Exception $e ) {
			\WP_CLI::warning( sprintf( '%s, %s', $e->getCode(), $e->getMessage() ) );
		} finally {
			return $comment;
		}
	}
}
