<?
class DPD {

public $dpd_user='demo';
public $dpd_pass='o2Ijwe2';


protected $dpd_secret = 'FcJyN7vU7WKPtUh7m1bx';

public $dpd_import_link = 'https://weblabel.dpd.hu/dpd_wow/parcel_import.php';
public $dpd_delete_link = 'https://weblabel.dpd.hu/dpd_wow/parcel_delete.php';
public $dpd_status_link = 'https://weblabel.dpd.hu/dpd_wow/parcel_status.php';
public $dpd_print_link = 'https://weblabel.dpd.hu/dpd_wow/parcel_print.php';
public $dpd_datasend_link = 'https://weblabel.dpd.hu/dpd_wow/parcel_datasend.php';
public $dpd_parcelshop_link = 'https://weblabel.dpd.hu/dpd_wow/parcelshop_info.php';
public $dpd_pickup_link = 'https://weblabel.dpd.hu/dpd_wow/pickup_info.php';


	private function validate($string, $length)
		{
		return substr($string,0,$length);
		}

	public function dpd_login($dpd_user, $dpd_pass)
		{
		$this->dpd_user = $dpd_user;
		$this->dpd_pass = $dpd_pass;
		} 
	private function dpd_get_login()
		{
		return (array($this->dpd_user, $this->dpd_pass));
		}

	public function dpd_execute($what, $extra=null)
		{
			$credentials = $this->dpd_get_login();
			$my_user = $this->validate($credentials[0],20); $my_pass = $this->validate($credentials[1],20); 
			
			switch ($what)
			{
			case 'pickup':
			$my_link = $this->dpd_pickup_link;

			$postdata = http_build_query(
				array(
				'pickup_pcode'	=> $this->validate($extra['pickup_pcode'], 9),
				'pickup_date'	=> $this->validate($extra['pickup_date'], 10),	//This parameter is missing in the documentation, but it is mandatory!
				'secret'	=> $this->dpd_secret
				)
			);	

			break;
			case 'parcelshop':
			$my_link = $this->dpd_parcelshop_link;
						
			$postdata = http_build_query(
				array_filter(array(
				'username'	=> $my_user,
				'password'	=> $my_pass,
				'id'			=> $this->validate($extra['id'], 20),
				'company'		=> $this->validate($extra['company'], 40),
				'street'		=> $this->validate($extra['street'], 40),
				'city'			=> $this->validate($extra['city'], 40),
				'pcode'			=> $this->validate($extra['pcode'],5),
				'phone'			=> $this->validate($extra['phone'],30),
				'email'			=> $this->validate($extra['email'],30)
				))
			);
			
			break;
			case 'import':

				$my_link = $this->dpd_import_link;
	
				$postdata = http_build_query(
		    			array_filter(array(
		      			'username' 	=> $my_user,
		    			'password' 	=> $my_pass,
					'name1'		=> $this->validate($extra['name1'], 40),
					'name2'			=> $this->validate($extra['name2'], 40),
					'street'	=> $this->validate($extra['street'], 40),
					'city'		=> $this->validate($extra['city'], 40),
					'country'	=> $this->validate($extra['country'], 2),
					'pcode'		=> $this->validate($extra['pcode'], 9),
					'email'			=> $this->validate($extra['email'], 100),
					'phone'			=> $this->validate($extra['phone'], 50),
					'idm_sms_number'	=> $this->validate($extra['idm_sms_number'], 30),
					'remark'		=> $this->validate($extra['remark'], 100),
					'weight'	=> $this->validate($extra['weight'], 4),
					'num_of_parcel'	=> $this->validate($extra['num_of_parcel'], 2),
					'order_number'	=> $this->validate($extra['order_number'], 20),
					'parcel_type'	=> $this->validate($extra['parcel_type'], 10),
					'parcel_cod_type'	=> $this->validate($extra['parcel_cod_type'], 10),
					'cod_amount'		=> $this->validate($extra['cod_amount'], 10),
					'cod_purpose'		=> $this->validate($extra['cod_purpose'], 50),
					'delta_service'		=> $this->validate($extra['delta_service'], 1),
					'who_sends'		=> $this->validate($extra['who_sends'], 1),
					'who_prints'		=> $this->validate($extra['who_prints'], 1),
					'same_day_pickup'	=> $this->validate($extra['same_day_pickup'], 1),
						'pickup_date'	=> $this->validate($extra['pickup_date'], 8),
						'sender_name'	=> $this->validate($extra['sender_name'], 80),
						'sender_street'	=> $this->validate($extra['sender_street'], 80),
						'sender_city'	=> $this->validate($extra['sender_city'], 50),
						'sender_pcode'	=> $this->validate($extra['sender_pcode'], 7),
						'sender_country'=> $this->validate($extra['sender_country'], 50),
						'sender_phone'	=> $this->validate($extra['sender_phone'], 50),
						'sender_email'	=> $this->validate($extra['sender_email'], 50),
						'sender_contact'=> $this->validate($extra['sender_contact'], 50),
						'sender_note'		=> $this->validate($extra['sender_note'], 100),
					'parcelshop_id'		=> $this->validate($extra['parcelshop_id'], 4),
					'ekaer_number'		=> $this->validate($extra['ekaer_number'], 20),
					'ekaer_price'		=> $this->validate($extra['ekaer_price'], 10),
					'ekaer_risky'		=> $this->validate($extra['ekaer_risky'], 1)
					
					    ))
					);
				
				break;

			case 'delete':

				$my_link = $this->dpd_delete_link;

				$postdata = http_build_query(
		    			array(
		      			'username' 	=> $my_user,
		    			'password' 	=> $my_pass,
					'parcels'	=> $this->validate($extra['parcels'], 200)
					)
				);
				break;
			
			case 'status':

				$my_link = $this->dpd_status_link;

				$postdata = http_build_query(
		    			array(
					'secret'	=> $this->dpd_secret,
					'parcel_number'	=> $this->validate($extra['parcel_number'], 14)
					)
				);

				break;

			case 'print':

				$my_link = $this->dpd_print_link;

				$postdata = http_build_query(
		    			array(
		      			'username' 	=> $my_user,
		    			'password' 	=> $my_pass,
					'parcels'	=> $this->validate($extra['parcels'], 200)
					)
				);
				break;

			case 'datasend':

				$my_link = $this->dpd_datasend_link;

				$postdata = http_build_query(
		    			array(
		      			'username' 	=> $my_user,
		    			'password' 	=> $my_pass
					)
				);
				break;
			default:
				return false;

			}


			$opts = array('http' =>
			    array(
			        'method'  => 'POST',
			        'header'  => 'Content-type: application/x-www-form-urlencoded',
			        'content' => $postdata
				 )
			);
			

			$context  = stream_context_create($opts);
			$result = file_get_contents($my_link, false, $context);
			
			switch ($what)
			{
			case 'pickup':
			$rs = json_decode($result, true);
			if (isset($rs['status']))
			{
			return $rs['errmsg'];
			}
			else			
			{
			return $rs;
			}
			break;
			case 'parcelshop':		
			$rs = json_decode($result, true);
			if ($rs['status'] == 'err')
			{
			return $rs['errlog'];
			}
			else
			{
			return $rs['parcelshops'];
			}
			break;
			case 'import': 
			$rs = json_decode($result, true);
			
			$my_status = $rs['status']; 
			$my_errlog = $rs['errlog'];
			if 	($my_status == 'ok')
				{
				return $rs['pl_number'];
				}
			elseif	($my_status == 'err')
				{
				return $my_errlog;
				}
			elseif ($rs == '')
				{
				return $result;
				}
			break;

			case 'delete': 
			$rs = json_decode($result, true);
			$my_status = $rs['status']; 
			$my_errlog = $rs['errlog'];
			return $my_errlog;			
			break;

			case 'status': 
			$rs = json_decode($result, true);
			if (isset($rs['parcel_status']))
				{
				return $rs['parcel_status'];
				}
				else
				{
				return $rs['errmsg'];
				}
			break;


			case 'print': 
			
			if (substr($result,0,4) == '%PDF')
				{
				
				return $result;
				}
			else
			{
			
			$rs = json_decode($result, true);
			if (is_array($rs))
				{
				
				$my_status = $rs['status']; 
				$my_errlog = $rs['errlog'];
				return array($my_status,$my_errlog);
				}
			else
				{
				return $result;
				}
			}
			break;


			case 'datasend': 
			$rs = json_decode($result, true);
			$my_status = $rs['status']; 
			$my_errlog = $rs['errlog'];
			
			if 	($my_status == 'ok')
				{
				return $rs['parcels'];
				}
			elseif	($my_status == 'err')
				{
				return $my_errlog;
				}
			break;
			}

			

		}
}




?>
