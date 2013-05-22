<?php

/**
 * Devot:ee Widget
 *
 * Display sales stats for last 30 days.
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Widget
 * @author		Chris Monnat
 * @link		http://chrismonnat.com
 */

class Wgt_devotee
{
	public $widget_name 		= 'devot:ee Sales';
	public $widget_description 	= 'Display your devot:ee sales for the past 30 days.';

	public $title;
	public $wclass;
	public $settings;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->title = 'devot:ee Sales';
	
		$this->settings = array(
			'api_key' 		=> '',
			'secret_key' 	=> ''
			);
		$this->wclass = 'contentMenu';
	}
	
	// ----------------------------------------------------------------

	/**
	 * Index Function
	 *
	 * @param	object
	 * @return 	string
	 */
	public function index($settings = NULL)
	{
		if($settings->api_key != '' AND $settings->secret_key != '')
		{
			// Create the post string
			$post_string = "api_key=".$settings->api_key."&secret_key=".$settings->secret_key."&start_dt=".(date('Y-m-d')-30)."&end_dt=".date('Y-m-d');
			
			// Process 	
			$url = "https://devot-ee.com/api/orders";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
			$response = urldecode(curl_exec($ch));
			$arr = json_decode($response, TRUE);	

			$display = '';
			if(count($arr['items'][0]) > 0)
			{
				foreach($arr['items'][0] as $item)
				{
					$display .= '
						<tr class="'.alternator('odd','even').'">
							<td>'.date('n/j/y h:i a', $item['purchase_date']).'</td>
							<td>'.$item['title'].'</td>
							<td>$'.$item['price'].'</td>
						</tr>';
				}
			}
			else
			{
				$display = '<tr><td colspan="3"><center>No sales have been recorded yet.</center></td></tr>';
			}
			
		}
		else
		{
			$display = '<tr><td colspan="3"><center>Click settings icon to enter API credentials.</center></td></tr>';
		}

		return '
			<table>
				<thead><tr><th>Date</th><th>Item</th><th>Price</th></tr></thead>
				<tbody>'.$display.'</tbody>
			</table>
		';

	}
	
	/**
	 * Settings Form Function
	 * Generate settings form for widget.
	 *
	 * @param	object
	 * @return 	string
	 */
	public function settings_form($settings)
	{
		return form_open('', array('class' => 'dashForm')).'
		
			<p>These values are found on your devot:ee profile page.</p>
			
			<p><label for="api_key">API Key:</label>
			<input type="text" name="api_key" value="'.$settings->api_key.'" /></p>
			
			<p><label for="secret_key">Secret Key:</label>
			<input type="text" name="secret_key" value="'.$settings->secret_key.'" /></p>
			
			<p><input type="submit" value="Save" /></p>
			
			'.form_close();
	}

}
/* End of file wgt.devotee.php */
/* Location: /system/expressionengine/third_party/dashee/widgets/wgt.devotee.php */