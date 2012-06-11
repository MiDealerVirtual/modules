<? 
	# This script will collect all the URL's from the Kiosk Table
	# Only URL's that are not blank will be considered
	
	# We will add-on to the $routes[] (array)
	# This file is to be included into the system -> applicaiton -> config -> routes.php
	
	# This will allow CodeIgniter to add-on our kiosk's URLs to the system....
	# Sweet trickery!!!
	
	// Include the module's Configuration info!
	include( $_SERVER['DOCUMENT_ROOT']."/system/cms/config/mdv_config.php" );
	include( $_SERVER['DOCUMENT_ROOT']."/system/cms/config/database.php" );
	include( $_SERVER['DOCUMENT_ROOT']."/system/cms/helpers/mdv_helper.php" );
	
	// Connect to mdv database
	$cmsdb_link = mysql_connect( $db['live']['hostname'], $db['live']['username'], $db['live']['password'] );
	
	// Connect to cms database
	$mdvdb_link = mysql_connect( $config['mdvdb_creds']['hostname'], $config['mdvdb_creds']['username'], $config['mdvdb_creds']['password'] );
	
	// Fetch MDV Id(s) from CMS database
	if( TRUE )
	{
		// Select CMS database
		$db_select = $db['live']['database'];
		mysql_select_db( $db_select );
		
		// Fetch MDV Id(s)
		$sql = "SELECT * FROM `".$db_select."`.`default_variables` WHERE `name` = 'mdv_ids'";
		$mdv_id_res = mysql_query( $sql, $cmsdb_link );
		$mdv_id = mysql_fetch_assoc( $mdv_id_res );
		$mdv_id = $mdv_id['data'];
		
		// Fetch MDV Inv SEO
		$sql = "SELECT * FROM `".$db_select."`.`default_variables` WHERE `name` = 'mdv_inv_seo'";
		$mdv_inv_seo_res = mysql_query( $sql, $cmsdb_link );
		$mdv_inv_seo = mysql_fetch_assoc( $mdv_inv_seo_res );
		$mdv_inv_seo = $mdv_inv_seo['data'];
		
		// Fetch Merge Used Vehicles
		$sql = "SELECT * FROM `".$db_select."`.`default_variables` WHERE `name` = 'merge_used_vehicles'";
		$merge_used_vehicles_res = mysql_query( $sql, $cmsdb_link );
		if( mysql_num_rows( $merge_used_vehicles_res ) > 0 )
		{
			$merge_used_vehicles = mysql_fetch_assoc( $merge_used_vehicles_res );
			$merge_used_vehicles = json_decode( $merge_used_vehicles['data'] );
			$ids = $mdv_id;
			if( $merge_used_vehicles->merge )
			{
				$ids = explode( ",", $ids );
				$ids = array_merge( $ids, $merge_used_vehicles->ids );
				$ids = implode( ",", $ids );	
			}
			$mdv_id = $ids;	
		}
		
			// Parse MDV Inv SEO
			$mdv_inv_seo = explode( "|", $mdv_inv_seo );
			$temp_arr = array();
			
			foreach( $mdv_inv_seo as $v )
			{
				$v = explode( "=>", $v );
				$temp_arr[$v[0]] = $v[1];	
			}
			$mdv_inv_seo = $temp_arr;
			
		// Close connection
		mysql_close( $cmsdb_link );
	
		// Debug		
		// echo "mdv_id: ".$mdv_id."<br />";
		// echo "mdv_inv_seo: "; print_r( $mdv_inv_seo ); echo "<br /><br />";
	}
	
	// Proceed with Dynamic URL's
	if( TRUE && ( $mdv_id != "" && $mdv_id != NULL ) )
	{
		// Select CMS database
		$db_select = $config['mdvdb_creds']['database'];
		mysql_select_db( $db_select );
		
		// SEO Friendly URL for Vehicles
		$sql_veh = 
		"SELECT
			*
		FROM
			`".$db_select."`.`vehicles_available_to_viewer_final`
		WHERE
			`CLIENT_ID` IN (".$mdv_id.")";
			
		// Select our kiosks and URLs
		$res_veh = mysql_query( $sql_veh, $mdvdb_link );
		
		// Check to see if there are any in the sytem
		if( mysql_num_rows( $res_veh ) > 0 )
		{
			// Begin our while in which we will addon to out routes array
			while( $row_veh  = mysql_fetch_assoc( $res_veh ) )
			{
				# Create dynamic url
				$v_link = createVehiclePermaLink( array( 'mdv_inv_seo' => $mdv_inv_seo ),
												  array( 'ci' => $row_veh['CLIENT_ID'],
														 'mk' => $row_veh['MAKE'],
														 'md' => $row_veh['MODEL'],
														 'tr' => $row_veh['TRIM'],
														 'yr' => $row_veh['YEAR'],
														 'vn' => substr( $row_veh['VIN'], ( strlen( $row_veh['VIN'] ) - 3 ) )
												) );
				
				# Custom Page Route
				$route['inventario/'.strtolower( $v_link )] = "inventario/vehiculo/veh_id/".$row_veh['VEH_ID'];
			}
		}
		
		// Close connection
		mysql_close( $mdvdb_link );
	}
	// We are all done!!!
	// Thank you for using our dynamic routes script.
?>