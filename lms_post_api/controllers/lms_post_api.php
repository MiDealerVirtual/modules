<?php
class Lms_post_api extends Public_Controller
{
# Private Data
	private $mod_cms_vars = array();
	private $post;
	private $mdv_db;
	private $json_msg_0;
	private $json_msg_1;
	private $json_msg_2;
	
# Private Methods
	
	
# Public Methods

	// Constructor
	public function __construct()
	{
		// Inherit from parents
		parent::__construct();
		
		// Save $_POST
		$this->post = $_POST;
		
		// Connecto MDV DB
		$this->mdv_db = $this->load->database( $this->config->item( 'mdvdb_creds' ), TRUE );
		
		// JSON messages
		$this->json_msg_0 = array( 'status' => 0, 'msg' => "MySQL connection couldn't be established.", 'alert' => "Ha%20ocurrido%20un%20error.%20Por%20favor%20intente%20de%20nuevo%20m%E1s%20tarde." );
		$this->json_msg_1 = array( 'status' => 1, 'msg' => "Missing required fields.", 'alert' => "Le%20faltan%20campos%20obligatorios.%20Por%20favor%20ll%E9nelos%20y%20vuelve%20a%20enviarlo." );
		$this->json_msg_2 = array( 'status' => 2, 'msg' => "Lead has been saved.", 'alert' => "Gracias%20por%20su%20inter%E9s.%20Uno%20de%20nuestros%20representantes%20se%20pondr%E1%20en%20contacto%20con%20usted%20lo%20m%E1s%20antes%20posible." );
		
		// Fetch CMS vars (needed)
		$this->mod_cms_vars['crm_type'] = processArrayVar( '{pyro:variables:crm_type}' );
		$this->mod_cms_vars['crm_email'] = processArrayVar( '{pyro:variables:crm_email}' );
	}
	
	// Index method
	public function index()
	{
		echo "No $_POST vars present.";
	}
	
	// Newsletter Subscriber Form
	public function newsletter()
	{
		// Validate two fields
		$email = $this->_postItem( 'email' );
		$client_id = $this->_postItem( 'cid' );
		if( $client_id && ( $email != false && strpos( $email, "@" ) != false ) )
		{
			// loop and send to each branch
			$success = array();
			foreach( explode( ",", $client_id ) as $cid )
			{
				// create sql
				$sql = "INSERT INTO `website_email_capture` ( `CLIENT_ID`, `EMAIL`, `DATE_SUBSCRIBED` ) VALUES ( '".$cid."', '".$email."' ,'".date( 'Y-m-d H:i:s' )."')";
				
				// process insert query
				array_push( $success, $this->mdv_db->query( $sql ) );
			}
			
			// return
			if( !in_array( false, $success ) )
			{
				echo json_encode( $this->json_msg_2 );
			}
			else
			{
				echo json_encode( $this->json_msg_0 );
			}
		}
		else
			echo json_encode( $this->json_msg_1 );
			
	}
	
	// Process Reservation Form
	public function reservation()
	{
		// main fields required
		$main_fields_required = array( 'CLIENT_ID', 'TYPE', 'CONTACT_NAME', 'CONTACT_TELEPHONE' );
		
		// additional fields required
		$add_fields = array( "veh_id", "veh_vin", "vehicle", "veh_price" );
		
		// call post template
		$this->_postTemplate( 'contact', $main_fields_required, $add_fields );
	}
	
	public function part()
	{
		// main fields required
		$main_fields_required = array( 'CLIENT_ID', 'TYPE', 'CONTACT_NAME', 'CONTACT_TELEPHONE', 'CONTACT_EMAIL' );
		
		// additional fields required
		$add_fields = array( array( 'year', true ), array( 'make', true ), array( 'model', true ), 'trim', 'parts_for', 'urgency', 'description', 'dealer' );
		
		// call post template
		$this->_postTemplate( 'parts', $main_fields_required, $add_fields );
	}
	
	public function service()
	{
		// main fields required
		$main_fields_required = array( 'CLIENT_ID', 'TYPE', 'CONTACT_NAME', 'CONTACT_TELEPHONE', 'CONTACT_EMAIL' );
		
		// additional fields required
		$add_fields = array( array( 'preferred_date', true ), 'preferred_time', 'service_type', 'year', array( 'make', true ), 'model', array( 'mileage', true ), 'dealer' );
		
		// call post template
		$this->_postTemplate( 'service_apt', $main_fields_required, $add_fields );
	}
	
	public function trade()
	{
		// main fields required
		$main_fields_required = array( 'CLIENT_ID', 'TYPE', 'CONTACT_NAME', 'CONTACT_TELEPHONE' );
		
		// additional fields required
		$add_fields = array( array( 'make', true ), array( 'model', true ), array( 'year', true ), array( 'mileage', true ), array( 'vin', true ), array( 'condition', true ), 'color_exterior', 'color_interior', 'dealer' );
		
		// call post template
		$this->_postTemplate( 'trade_in', $main_fields_required, $add_fields );
	}
	
	public function finance()
	{
		// main fields required
		$main_fields_required = array( 'CLIENT_ID', 'TYPE', 'CONTACT_NAME', 'CONTACT_TELEPHONE' );
		
		// additional fields required
		$add_fields = array( 'month', 'day', 'year', array( 'civil_status', true ), array( 'address', true ), 'neighborhood', array( 'city', true ), array( 'zip', true ), array( 'employment_status', true ), array( 'monthly_income', true ), 'housing_status', 'housing_payment', 'dealer', array( 'vehicle_intrested', true ) );
		
		// call post template
		$this->_postTemplate( 'credit', $main_fields_required, $add_fields );
	}
	
	public function contact()
	{
		// main fields required
		$main_fields_required = array( 'CLIENT_ID', 'TYPE', 'CONTACT_NAME', 'CONTACT_TELEPHONE' );
		
		// additional fields required
		$add_fields = array( 'subject', 'message' );
		
		// call post template
		$this->_postTemplate( 'contact', $main_fields_required, $add_fields );
	}
	
/* PRIVATE METHODS */

	private function _postTemplate( $type, $main_fields, $add_fields )
	{
		// arrays required
		$unique_data = array();
		$required_additional = array();
		
		// fetch common data
		$db_data = $this->_dbDataTemplate( $type );
		
		// fetch values
		foreach( $add_fields as $f )
		{
			// variables used
			$req = false;
			$temp = NULL;
			
			// check if field is required
			if( is_array( $f ) )
			{
				$req = true;	// set flag
				$f = $f[0];		// exract from array
			}
			
			// save value in a temp var
			$temp = $this->_postItem( $f );
			
			// save value, if present
			if( $temp != false )
			{
				// add to unique data
				$unique_data[$f] = $temp;
				
				// and if its required, add to required array
				if( $req )
				{
					array_push( $required_additional, $f );
				}
			}
		}
		
		// check for DOB
		if( array_key_exists( "month", $unique_data ) && array_key_exists( "day", $unique_data ) && array_key_exists( "year", $unique_data ) )
		{
			// create DOB and delete M D Y from "add_fields"
			$unique_data['dob'] = $unique_data['month']."/".$unique_data['day']."/".$unique_data['year'];
			
			// make it required
			array_push( $required_additional, "dob" );
			
			// delete M D Y from "unique_data"
			unset( $unique_data['month'], $unique_data['day'], $unique_data['year'] );
		}
		
		// add unique data
		if( count( $unique_data ) > 0 )
			$db_data['DATA'] = $unique_data;
			
		// ensure all rules are met
		$validate_all = NULL;
		$validate_main = $this->_validateData( $db_data, $main_fields );
		if( count( $required_additional ) > 0 )
		{
			$validate_additional = $this->_validateData( $unique_data, $required_additional );
			$validate_all = $validate_main && $validate_additional;
		}
		else
			$validate_all = $validate_main;
			
		// if validate passes, insert to DB
		if( $validate_all )
		{
			echo json_encode( $this->_insertToDB( $db_data ) );
		}
		else
			echo json_encode( $this->json_msg_1 );
	}
	
	private function _postItem( $key )
	{
		return ( ( isset( $this->post[$key] ) ) ? $this->post[$key] : false );
	}
	
	private function _dbDataTemplate( $lead_type )
	{
		// prepare temp
		$db_data_temp = array( 'CLIENT_ID' => $this->_postItem( 'cid' ),
							   'TYPE' => $lead_type,
							   // Removed  'SOURCE' => 'online',
							   'CONTACT_NAME' => trim( $this->_postItem( 'fname' ).' '.$this->_postItem( 'lname' ) ),
							   'ASIGNED_TO' => '0',
							   'STATUS' => 'Nuevo',
							   'HIGHLIGHTED' => '0',
							   'DATE_CONTACTED' => date( 'Y-m-d H:i:s' ) );
		
		// add email & telephone (if present)
		$telephone = $this->post['telephone'];
		$email = $this->post['email'];
		if( $telephone != false )
			$db_data_temp['CONTACT_TELEPHONE'] = $telephone;
		if( $email != false )
			$db_data_temp['CONTACT_EMAIL'] = $email;
			
		// return template
		return $db_data_temp;
	}
	
	private function _validateData( $data, $rules )
	{
		// is_valid flag
		$is_valid = array();
		
		// loop thru all the rules and verify they are met
		foreach( $rules as $r ){
			$current_valid = ( ( isset( $data[$r] ) && ( $data[$r] == false || $data[$r] == NULL || $data[$r] == "" ) ) ? false : true );
			array_push( $is_valid, $current_valid );
		}
		
		// return answer
		return !in_array( false, $is_valid );
	}
	
	private function _insertToDB( $data_to_push )
	{
		// clead data for json encode
		foreach( $data_to_push['DATA'] as $k => $v )
		{
			$data_to_push['DATA'][$k] = htmlspecialchars( $v );	// remove "
			$data_to_push['DATA'][$k] = str_replace( "'", "", $v );	// remove '
		}
		
		// determine if vehicle reservation is occuring
		$send_to_crm = $this->mod_cms_vars['crm_type'] && $this->mod_cms_vars['crm_email'];
		if( $send_to_crm && isset( $data_to_push['DATA']['veh_id'] ) )
		{
			$veh_obj = $this->mdv_db->query( "SELECT * FROM `vehicles_available_to_viewer` WHERE `VEH_ID` = '".$data_to_push['DATA']['veh_id']."'" );
			$veh_obj = ( $veh_obj ) ? $veh_obj->row() : $veh_obj->result() ;
			$veh_price = ( isset( $data_to_push['DATA']['veh_price'] ) ) ? $data_to_push['DATA']['veh_price'] : "Llame hoy";
		}
		
		// encode json data
		$data_to_push['DATA'] = json_encode( $data_to_push['DATA'] );
		
		// clean up rest of values
		foreach( $data_to_push as $k => $v )
		{
			if( $k != "DATA" )
			{
				$data_to_push[$k] = htmlspecialchars( $v );	// remove "
				$data_to_push[$k] = str_replace( "'", "", $v );	// remove '	
			}
		}
		
		// save keys and values
		$keys = "";
		$values = "";
		
		// prepare query
		foreach( $data_to_push as $k => $v )
		{
			$keys .= "`".$k."`, ";
			$values .= "'".$v."', ";
		}
		$sql = "INSERT INTO `leads_entries` ( ".rtrim( $keys, ", " )." ) VALUES ( ".rtrim( $values, ", " )." )";
		$sql = stripslashes( $sql );
		
		// process insert query
		if( $this->mdv_db->query( $sql ) != false )
		{
			// determine if we need to send lead to any crm, and which type of lead
			if( $send_to_crm )
			{
				// set 1st and 3rd parameters
				if( isset( $veh_obj ) )
				{
					$param_1 = $veh_obj;
					$param_2 = array( 'FNAME' => $this->_postItem( 'fname' ),
									  'LNAME' => $this->_postItem( 'lname' ),
									  'PRICE' => $veh_price );
					$param_3 = 'reservation';
				}
				else
				{
					$param_1 = NULL;
					$param_2 = array( 'CONTACT_NAME' => $this->_postItem( 'fname' ).' '.$this->_postItem( 'lname' ),
									  'SUBJECT' => $this->_postItem( 'subject' ),
									  'MESSAGE' => $this->_postItem( 'message' ) );
					$param_3 = 'contact';
				}
				
				// finish param_2
				$param_2['EMAIL'] = $this->_postItem( 'email' );
				$param_2['TELEPHONE'] = $this->_postItem( 'telephone' );
				
				// send to CRM
				$this->_sendToCRM( $param_1, $param_2, $param_3 );
			}
			//else
			//{
			//	return json_encode( array( 'msg' => 'not working' ) );	
			//}
			
			// return json message confirming success
			$this->json_msg_2['id'] = $this->mdv_db->insert_id();
			return $this->json_msg_2;
		}
		else
		{
			return $this->json_msg_0;
		}
	}
	
	private function _sendToCRM( $veh, $db_data, $type = 'reservation' )
	{
		// Prepare correct XML feed
		if( $type == 'reservation' )
		{
			// Prepare XML lead
			$format =
	'<?xml version="1.0" ?>
	<?adf version="1.0" ?>
	<adf>
		<prospect>
			<requestdate>'.date( 'Y-m-d g:i A' ).'</requestdate>
			<vehicle interest="buy" status="'.$veh->CONDITION.'">
				<year>'.$veh->YEAR.'</year>
				<make>'.$veh->MAKE.'</make>
				<model>'.$veh->MODEL.'</model>
				<trim>'.$veh->TRIM.'</trim>
				<vin>'.$veh->VIN.'</vin>
				<stock></stock>
			</vehicle>
			<customer>
				<contact>
					<name part="first">'.$db_data['FNAME'].'</name>
					<name part="last">'.$db_data['LNAME'].'</name>
					<email>'.$db_data['EMAIL'].'</email>
					<phone type="voice" time="day">'.$db_data['TELEPHONE'].'</phone>
					<phone type="cellphone"></phone>
				</contact>
				<comments>Vehicle\'s Internet Price: '.$db_data['PRICE'].' </comments>
			</customer>
			<vendor>
				<contact>
					<service>Mi Dealer Virtual</service>
					<url>http://www.MiDealerVirtual.com/</url>
				</contact>
			</vendor>
			<provider>
				<name>Mi Dealer Virtual
			</provider>
		</prospect>
	</adf>';
		}
		else
		{
			// Split `CONTACT_NAME`
			$db_data['CONTACT_NAME'] = explode( " ", $db_data['CONTACT_NAME'], 2 );
			
			// Prepare XML lead
			$format =
	'<?xml version="1.0" ?>
	<?adf version="1.0" ?>
	<adf>
		<prospect>
			<requestdate>'.date( 'Y-m-d g:i A' ).'</requestdate>
			<vehicle interest="" status="">
				<year></year>
				<make></make>
				<model></model>
				<trim></trim>
				<vin></vin>
				<stock></stock>
			</vehicle>
			<customer>
				<contact>
					<name part="first">'.$db_data['CONTACT_NAME'][0].'</name>
					<name part="last">'.$db_data['CONTACT_NAME'][1].'</name>
					<email>'.$db_data['EMAIL'].'</email>
					<phone type="voice" time="day">'.$db_data['TELEPHONE'].'</phone>
					<phone type="cellphone"></phone>
				</contact>
				<comments>'.$db_data['SUBJECT'].'
				
				'.$db_data['MESSAGE'].'</comments>
			</customer>
			<vendor>
				<contact>
					<service>Mi Dealer Virtual</service>
					<url>http://www.MiDealerVirtual.com/</url>
				</contact>
			</vendor>
			<provider>
				<name>Mi Dealer Virtual
			</provider>
		</prospect>
	</adf>';
		}

		// Load Email Library
		$this->load->library('email');
		
		// Configure email settings
		$this->email->initialize( /*array( 'mailtype' => 'html' )*/ );
		
		// Configure email reciepients
		$this->email->from( 'leads@midealervirtual.com', 'MiDealerVirtual.com' );
		$this->email->to( $this->mod_cms_vars['crm_email'] );
		
		// Configure email content
		$this->email->subject( 'Leads de Internet' );
		$this->email->message( $format );
		
		// Send email
		$this->email->send();
	}
}
?>