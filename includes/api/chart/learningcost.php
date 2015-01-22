<?php

namespace Fumiki\API\Chart;

/**
 * Class LearningCost
 * @package Fumiki\api\chart
 */
class LearningCost extends Prototype
{

	protected $title = '学習の費用対効果';


	/**
	 * @var string
	 */
	protected $chart = 'LineChart';

	protected $valid_query = array(
		'technic', 'amount', 'consume', 'save', 'work', 'maintain', 'range'
	);

	/**
	 * Get JSON data
	 *
	 * @return array
	 * @throws \Exception
	 */
	protected function get_json_data() {
		$data = array(
			'cols' => array(
				array(
					'label' => '経過月',
					'id' => 'month',
					'type' => 'string',
				),
				array(
					'label' => '勉強した場合',
					'id' => 'learned',
					'type' => 'number',
					'pattern' => '##.#時間',
				),
				array(
					'label' => null,
					'type' => 'string',
					'role' => 'annotation',
				),
				array(
					'label' => null,
					'type' => 'string',
					'role' => 'annotationText',
				),
				array(
					'label' => 'しなかった場合',
					'id' => 'unlearned',
					'type' => 'number',
					'pattern' => '##.#時間',
				),
			),
			'rows' => array(),
		);
		$amount = intval($this->value('amount', 8));
		$consume = floatval($this->value('consume', 2));
		$work = floatval($this->value('work', 1));
		$save = floatval($this->value('save', 0.8));
		$maintain = floatval($this->value('maintain', 0.1));
		$range = min(36, max(3, intval($this->value('range', 6))));
		// Initial value
		$learned = 0;
		$unlearned = 0;
		$studied = 0;
		$overwhealmed = false;
		for( $month = 0; $month < $range; $month++ ){
			for( $week = 0; $week < 4; $week++){
				$finish_studying = false;
				for( $day = 0; $day < 5; $day++){
					$unlearned += $work;
					if( $studied < $amount ){
						// Not learned.
						$studied += $consume;
						$learned += $consume + $work;
						if( $studied >= $amount ){
							$finish_studying = true;
						}
					}else{
						// Finish learning
						$learned += $work - $save + $maintain;
					}
				}
				if( $week ){
					$title = '';
				}else{
					$title = sprintf('%dヶ月目', $month + 1);
				}
				if( $finish_studying ){
					$annote = array('v' => '★');
					$annote_text = array('v' => sprintf('%dヶ月%d週間で学習完了', $month + 1, $week + 1));
				}elseif( !$overwhealmed && $learned < $unlearned ){
					$annote = array('v' => '♥');
					$annote_text = array('v' => sprintf('%dヶ月%d週間で努力が報われる', $month + 1, $week + 1));
					$overwhealmed = true;
				}else{
					$annote = null;
					$annote_text = null;
				}
				$data['rows'][] = array(
					'c' => array(
						array(
							'v' => $title,
						),
						array(
							'v' => $learned,
							'f' => sprintf('%s時間', round($learned, 1)),
						),
						$annote,
						$annote_text,
						array(
							'v' => $unlearned,
							'f' => sprintf('%s時間', round($unlearned, 1)),
						),
					)
				);
			}
		}
		return $data;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title(){
		return $this->value('technic', 'Gulp').$this->title;
	}

	/**
	 * Chart options
	 */
	protected function get_options() {
		return array(
			'title' => sprintf('%sあり／なしの総労働時間', $this->value('technic', 'Gulp')),
			'curveType' => 'function',
			'legend' => array(
				'position' => 'bottom'
			),
			'colors' => array('#73BD97', '#bd4b45'),
			'lineWidth' => 2,
		);
	}


	/**
	 * Render form
	 *
	 * @return void
	 */
	public function form() {
		?>
		<label>
			学ぶ技術の名前
			<input type="text" name="technic" value="<?= esc_attr($this->value('technic', 'Gulp')) ?>" />
		</label>
		<p class="description">
			このチャートでは、労働コスト改善型の技術を頑張って身につける場合、
			そのコストの回収にどれぐらいかかるの年月がかかるのかを表示します。
			1週間に5日働き、1ヶ月を4週間として計算します。
		</p>
		<label>
			学習完了に必要な時間
			<input type="number" name="amount" value="<?= intval($this->value('amount', 16)) ?>" />
		</label>
		<label>
			技術習得に割ける学習時間<small>1日あたり</small>
			<input type="number" step="0.1" name="consume" value="<?= floatval($this->value('consume', 1)) ?>" />
		</label>
		<label>
			その技術がない場合の対象労働時間<small>1日あたり</small>
			<input type="number" step="0.1" name="work" value="<?= floatval($this->value('work', 2)) ?>" />
		</label>
		<label>
			学習完了時に削減できる労働時間<small>1日あたり</small>
			<input type="number" step="0.1" name="save" value="<?= floatval($this->value('save', 1)) ?>" />
		</label>
		<label>
			キャッチアップに必要な時間<small>1日あたり</small>
			<input type="number" step="0.1" name="maintain" value="<?= floatval($this->value('maintain', 0.1)) ?>" />
		</label>
		<label>
			計測期間<small>3ヶ月〜36ヶ月</small>
			<input type="number" name="range" value="<?= intval($this->value('range', 6)) ?>" />
		</label>
		<?php
	}

}
