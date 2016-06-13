<?php

use \Gianism\Cron\Daily;

/**
 * Get data from GA
 */
class FumikiDailyRanking extends Daily
{

    const CATEGORY = 'general';

    /**
     * Get result
     *
     * @return array
     */
    public function get_results()
    {
        $three_days_ago = date('Y-m-d', strtotime('-3days'));
        $result = $this->fetch($three_days_ago, $three_days_ago, 'ga:pageviews', array(
            'max-results' => 100,
            'dimensions' => 'ga:pagePath',
            'filters' => 'ga:dimension3==post'  ,
            'sort' => '-ga:pageviews',
        ));
        foreach( $result as $key => $row ){
            $result[$key][] = $three_days_ago;
        }
        return $result;
    }

    /**
     * Applied for each result
     *
     * @param $result
     * @return void
     */
    protected function parse_row($result)
    {
        list($path, $pv, $date) = $result;
        $this->save($date, preg_replace('/[^0-9]/', '', $path), $pv);
    }
}
