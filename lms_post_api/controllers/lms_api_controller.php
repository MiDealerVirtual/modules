<?php
class Lms_Api_Controller extends Public_Controller
{
	public function __contruct() {
		// Inherit from parents
		parent::__construct();

		// Log lead
		$this->logLead( $this->input->post() );
	}

	protected function logLead( $data ) {
		if( array_key_exists( "cid", $data ) ) {
			// save data to be passed
			$cid  = $data["cid"];
			$data = json_encode( $data );

			// send via curl to api
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://www.mdvlms.com/api/log");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, true );
			curl_setopt($ch, CURLOPT_POSTFIELDS, "cid=$cid&data=$data" );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			$curlResp = curl_exec($ch);
			curl_close($ch);

			// return our data
			return $curlResp;
		}
	}

}