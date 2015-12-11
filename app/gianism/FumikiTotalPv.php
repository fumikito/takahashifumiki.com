<?php

use Gianism\Api\Ga;


class FumikiTotalPv extends Ga
{

	const ACTION = 'fumiki_pv';

	const NONCE_ACTION = 'fumiki_total_pv';

	/**
	 * Should return metrics
	 *
	 * @see https://developers.google.com/analytics/devguides/reporting/core/dimsmets
	 * @return string CSV of metrics E.g., 'ga:visits,ga:pageviews'
	 */
	protected function get_metrics() {
		return 'ga:pageviews';
	}

	/**
	 * Should return parameters
	 *
	 * @see self::fetch
	 * @return array
	 */
	protected function get_params() {
		return array(
			'max-results' => 100,
			'dimensions' => 'ga:pagePath',
			'filters' => 'ga:dimension3==post'  ,
			'sort' => '-ga:pageviews',
		);
	}


}