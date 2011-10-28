<?php
class Lms_post_api extends Public_Controller
{
# Private Data
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
		// json encode lead data
		foreach( $data_to_push['DATA'] as $k => $v )
		{
			$data_to_push['DATA'][$k] = htmlspecialchars( $v );	// remove "
			$data_to_push['DATA'][$k] = str_replace( "'", "", $v );	// remove '
		}
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
			$this->json_msg_2['id'] = $this->mdv_db->insert_id();
			return $this->json_msg_2;
		}
		else
		{
			return $this->json_msg_0;
		}
	}
}
?>