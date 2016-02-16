<?
require "dpd/dpd.php";
$dpd = new DPD();

//$dpd->dpd_login("uname", "pass"); Fill with DPD username/pass!

$parcel_data = array(
		'name1'=>'Customer Name', //1st level intended values are mandatory.
		'name2'=>'Second Name',
		'street'=>'Street Name nr. 1',
		'city'=>'Budapest',
		'country'=>'HU',
		'pcode'=>'1064',
			'email'=>'example@email.dom', //2nd level intended values are not required.
			'phone'=>'06201234567',
			'remark'=>'Notice to them',
		'weight'=>'0',
		'num_of_parcel'=>'4',
		'order_number'=> 'Unique reference number' ,
		'parcel_type'=>'D-COD', // D, D-DOCRET, D-COD, D-COD-DOCRET, D-SWAP, etc.
		'parcel_cod_type'=>'avg',
			'parcelshop_id'=>'1234',	
		'cod_amount'=>'200000', // Mandatory if COD in use
			'cod_purpose'=>'',
			'same_day_pickup'=>'I',
			'pickup_date'=>date('Ymd'),
			'delta_service'=>'I',
			'who_sends'=>'S',
			'who_prints'=>'F',
			'sender_name'=>'Delta Name',
			'sender_street'=>'Szív utca 32.',
			'sender_city'=>'Budapest',
			'sender_pcode'=>'1064',
			'sender_country'=>'HU',
			'sender_phone'=>'1234567896',
			'sender_email'=>'me@company.com',
			'sender_contact'=>'Delta Contact',
			'sender_note'=>'XXX XXXXX YYYYYYY'
		
		);

/* METHODS for dpd_execute function:
	
	import, delete, print, datasend, status, pickup, parcelshop
*/

// Import data and get parcel number(s).
$my_parcels = $dpd->dpd_execute('import', $parcel_data); // Returns: array of parcels. Example: array('12345678901234','12345678901235')

// Delete parcels.
$parcels = '12345678901234|12345678901235';
$deleted_parcels = $dpd->dpd_execute('delete',array('parcels'=>$parcels));  // Returns message about deleted parcels. Input: String of parcel numbers separated with | sign. 

// Print parcels.
// Use PDF header if printing: 
//header("Content-type:application/pdf");
$parcels = '12345678901234|12345678901235';
$result = $dpd->dpd_execute('print',array('parcels'=>$parcels)); // Returns PDF document on success. Input: String of parcel numbers separated with | sign. 

// Datasend. (Finalize parcels and inform DPD.)
$result = $dpd->dpd_execute('datasend'); // Returns number of successfully submitted parcels.

// Status check
$result = $dpd->dpd_execute('status',array('parcel_number'=>$parcel)); // Returns status of parcel. Input: one parcel number.

// Pickup
$result = $dpd->dpd_execute('pickup',array('pickup_date'=>date('Y-m-d'),'pickup_pcode'=>'1191')); // Returns: array.


// Parcelshop
$result = $dpd->dpd_execute('parcelshop',array('pcode'=>'1191')); // Returns: array.



?>
