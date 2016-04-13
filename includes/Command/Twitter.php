<?php

namespace Fumiki\Command;


class Twitter extends \WP_CLI_Command {

	const COMMAND_NAME = 'twitter';

	/**
	 * Grab CSV
	 *
	 * ## OPTIONS
	 * <out>
	 * : Target file name.
	 *
	 * ## EXAMPLES
	 *
	 *     wp twitter csv hoge.csv
	 *
	 * @synopsis <out>
	 *
	 * @param array $args
	 * @param array $assoc_args
	 */
	public function csv( $args, $assoc_args ) {
		list( $target ) = $args;
		if ( ! is_writable( dirname( $target ) ) ) {
			\WP_CLI::error( 'ターゲットディレクトリに書き込めません。' );
		}
		$twitter = \Gianism\Service\Twitter::get_instance();
		$handle  = fopen( $target, 'w' );
		$rows    = [];
		foreach (
			[
				'/friends/list'   => false,
				'/followers/list' => true,
			] as $endpoint => $is_follower
		) {
			\WP_CLI::line( sprintf( 'Retrieving %s...', ( $is_follower ? 'followers' : 'friends' ) ) );
			$cursor = '-1';
			while ( $result = $twitter->call_api( $endpoint, [
				'count'  => 200,
				'cursor' => $cursor,
			] ) ) {
				if ( ! is_array( $result->users ) ) {
					break;
				}
				foreach ( $result->users as $user ) {
					$row = [
						$user->followers_count,
						$user->friends_count,
						round( ( current_time( 'timestamp' ) - strtotime( $user->created_at ) ) / 60 / 60 / 24 ),
						$user->verified ? 1 : 0,
					];
					if ( isset( $rows [ $user->id_str ] ) ) {
						// 相互フォロー
						$rows[ $user->id_str ][4] = 0;
					} else {
						// 一方的
						$row[]                 = $is_follower ? 1 : - 1;
						$rows[ $user->id_str ] = $row;
					}
				}
				$cursor = $result->next_cursor;
				echo '.';
				if ( ! $result->next_cursor ) {
					break;
				}
				sleep( 60 );
			}
		}
		foreach ( $rows as $row ) {
			fputcsv( $handle, $row );
		}
		fclose( $handle );
		\WP_CLI::success( 'CSVを出力しました' );
	}


	/**
	 * Get unfollowing power user.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     wp twitter rank
	 *
	 * @param array $args
	 * @param array $assoc_args
	 */
	public function rank( $args, $assoc_args ) {
		$twitter = \Gianism\Service\Twitter::get_instance();
		$friends = [];
		foreach (
			[
				'/friends/list'   => false,
			] as $endpoint => $is_follower
		) {
			$cursor = '-1';
			while ( $result = $twitter->call_api( $endpoint, [
				'count'  => 200,
				'cursor' => $cursor,
			] ) ) {
				if ( ! is_array( $result->users ) ) {
					break;
				}
				foreach ( $result->users as $user ) {
					$friends[] = $user->id_str;
				}
				$cursor = $result->next_cursor;
				if ( ! $result->next_cursor ) {
					break;
				}
				sleep( 60 );
			}
		}
		foreach (
			[
				'/followers/list' => true,
			] as $endpoint => $is_follower
		) {
			$cursor = '-1';
			while ( $result = $twitter->call_api( $endpoint, [
				'count'  => 200,
				'cursor' => $cursor,
			] ) ) {
				if ( ! is_array( $result->users ) ) {
					break;
				}
				foreach ( $result->users as $user ) {
					if ( $user->followers_count < 2000  || false !== array_search( $user->id_str, $friends ) ) {
						continue;
					}
					\WP_CLI::line( sprintf( '%08d https://twitter.com/%s/', $user->followers_count, $user->screen_name ) );
				}
				$cursor = $result->next_cursor;
				if ( ! $result->next_cursor ) {
					break;
				}
				sleep( 60 );
			}
		}
	}
}
