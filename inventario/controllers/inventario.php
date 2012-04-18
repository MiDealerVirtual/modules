<?php
class Inventario extends Public_Controller
{
# Private Data
	private $mod_cms_vars = array();
	private $mod_uri_slug = "inventario";
	private $mod_uri_vars = NULL;
	private $mod_view_data = array();
	private $mod_get_vars = NULL;
	
# Private Methods
	
# Public Methods

	// Constructor
	public function __construct()
	{
		// Inherit from parents
		parent::__construct();
		
		// Load module config, helper, model, library
		$this->load->model( 'inventario_model' );
		
		// connect to the database
		$this->mdv_db = $this->load->database( $this->config->item( 'mdvdb_creds' ), TRUE );
		
		// Save $_GET to view data
		$this->mod_get_vars = $_GET;
		$this->mod_view_data['mod_get_vars'] = $this->mod_get_vars;
		
		// Save uri segment variables to view
		if( $this->mod_uri_vars == NULL )
		{
			$this->mod_uri_vars = $this->uri->ruri_to_assoc( 3 );
			$this->mod_view_data['mod_uri_vars'] = $this->mod_uri_vars;
		}
		
		// Save Slug and CMS vars
		$this->mod_view_data['mod_uri_slug'] = $this->mod_uri_slug;
		$this->mod_cms_vars = extractVars( varsToExtract() );
		
		// Fetch extra variables
		$this->mod_cms_vars['inventory_page_max'] = parseStr( '{pyro:variables:inventory_page_max}' );
		$this->mod_cms_vars['skip_stock_vehicles'] = parseStr( '{pyro:variables:skip_stock_vehicles}' );
		$this->mod_cms_vars['filtered_inventory_allowed'] = parseStr( '{pyro:variables:filtered_inventory_allowed}' );
		$this->mod_cms_vars['redirect_client_id'] = parseStr( '{pyro:variables:redirect_client_id}' );
			
			// Vin number masking
			$vin_num_mask = parseStr( '{pyro:variables:vin_num_mask}' );
			$vin_num_mask = ( $vin_num_mask == '' ) ? false : json_decode( $vin_num_mask, true );
			$this->mod_cms_vars['vin_num_mask'] = $vin_num_mask;
			
		// Pass CMS vars to view
		$this->mod_view_data['cms_vars'] = $this->mod_cms_vars;
	}
	
	// Index, main module method
	public function index()
	{
		// Extend cms variables
		$custom_alert = parseStr( '{pyro:variables:inventory_page_custom_alert}' );
		$custom_alert = ( $custom_alert == '' ) ? false : json_decode( $custom_alert, true );
		$this->mod_cms_vars['custom_alert'] = $custom_alert;
		$this->mod_view_data['cms_vars'] = $this->mod_cms_vars;
		
		// Fetch inventory
		$this->mod_view_data['applied_offset'] = ( array_key_exists( 'offset', $this->mod_get_vars ) ) ? $this->mod_get_vars['offset'] : 0 ;
		$this->mod_view_data['applied_perpage'] = ( $this->mod_view_data['cms_vars']['inventory_page_max'] == '' ) ? 20 : $this->mod_view_data['cms_vars']['inventory_page_max'];
		$this->mod_view_data['vehicles_collected'] = $this->inventario_model->fetchMultiVehicles( 'vehicles_available_to_viewer_final', $this->mod_cms_vars['mdv_ids'] );
		
		// Initiate Mdv Filter Library
		$this->load->library( 'Mdv_Filters', array( 'db_results' => $this->mod_view_data['vehicles_collected'], 'filters' => array( 'YEAR', 'MAKE', 'MODEL', 'CONDITION', 'TRANSMISSION', 'PRICE_RANGE', 'MILEAGE_RANGE' ), 'get_vars' => $this->mod_get_vars, 'mdv_ids' => $this->mod_cms_vars['mdv_ids'], 'cms_vars' => $this->mod_cms_vars ) );
		
		// Apply Mdv Filters ( if necesary )
		$filtered_results = $this->mdv_filters->applyFilters();
		$this->mod_view_data['results'] = ( $filtered_results != false ) ? $filtered_results : $this->mod_view_data['vehicles_collected'];
		$this->mdv_filters->populateData( $this->mod_view_data['results'] );
		
		// Paginate Results ( if necesary )
		$this->load->library( 'pagination' );
		$config['base_url'] = $this->mod_cms_vars['base_url']."/".$this->mod_uri_slug."?";
		$config['total_rows'] = count( $this->mod_view_data['results'] );
		$config['per_page'] = $this->mod_view_data['applied_perpage'];
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'offset';
		$config['num_links'] = 3;
		
			// Customizing Markup
			$config['full_tag_open'] = "<div class=\"pagination clearfix\"><ul><li>P&aacute;gina: </li>";
			$config['full_tag_close'] = "</ul></div>";
			$config['prev_link'] = "<span>&#171;</span>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tag_close'] = "</li>";
			$config['next_link'] = "<span>&#187;</span>";
			$config['next_tag_open'] = "<li>";
			$config['next_tag_close'] = "</li>";
			$config['first_link'] = $config['last_link'] = FALSE;
			$config['cur_tag_open'] = "<li class=\"active\"><a href=\"#\" id=\"jq_curr_pg_link\">";
			$config['cur_tag_close'] = "</a></li>";
			$config['num_tag_open'] = "<li>";
			$config['num_tag_close'] = "</li>";
			
		$this->pagination->initialize( $config );
		$this->mod_view_data['pagination'] = $this->pagination->create_links();
		$this->mod_view_data['results'] = $this->pagination->paginate_results( $this->mod_view_data['results'], $this->mod_view_data['applied_perpage'], $this->mod_view_data['applied_offset'] );
		
		// Get Filters & Sort Html
		$this->mod_view_data['filter_html'] = $this->mdv_filters->getFiltersHTML();
		$this->mod_view_data['sort_html'] = $this->mdv_filters->getSortHTML();
		
		// Load template and its data
		$this->template->
			set_metadata( 'description', "Vehículos Nuevos y Usados en ".$this->mod_cms_vars['dealer_name']." ".$this->mod_cms_vars['page_title_seo_suffix'] )->
			set_metadata( 'keywords', $this->mod_cms_vars['inventory_page_keywords'] )->
			build( 'index', $this->mod_view_data );
	}
	
	public function vehiculo()
	{
		// Extend CMS vars
		$this->mod_cms_vars['lot_addresses'] = processArrayVar( '{pyro:variables:lot_addresses}' );
		$this->mod_cms_vars['contact_map_url'] = parseStr( '{pyro:variables:contact_map_url}' );
			$this->mod_cms_vars['contact_map_url'] = ( $this->mod_cms_vars['contact_map_url'] == "" ) ? "contactenos" : $this->mod_cms_vars['contact_map_url'];
		$this->mod_cms_vars['sidebar_pre_content'] = parseStr( '{pyro:variables:vehicle_page_sidebar_pre_content}' );
		$this->mod_cms_vars['reserve_opt_req'] = parseStr( '{pyro:variables:vehicle_page_reserve_opt_req}' );
		$this->mod_view_data['cms_vars'] = $this->mod_cms_vars;
		
		// Save Vehicle ID
		$this->mod_view_data['veh_id'] = $this->mod_uri_vars['veh_id'];
		
		// Determine Max # of Similar
		$this->mod_view_data['max_similar'] = ( $this->mod_cms_vars['max_similar'] == "" ) ? 10 : $this->mod_cms_vars['max_similar'];
		
		// Fetch Vehicle
		$v = $this->inventario_model->select_item( $this->mod_view_data['veh_id'], 'VEH_ID', 'vehicles_available_to_viewer_final' );
		transalateVehicleAttr( $v );
		$this->mod_view_data['v'] = $v;
		
		// Fetch Vehilce Images
		$this->mod_view_data['images'] = $this->inventario_model->select_item( $this->mod_view_data['veh_id'], 'VEH_ID', 'vehicle_images', false, '*', '`IMAGE_ORDER` ASC' );
		$this->mod_view_data['images'] = array_slice( $this->mod_view_data['images'], 0, 5 );	// ensure only 5
		
		// Determine Correct Images Path
		$img_base_url = $this->config->item( 'images_base_url' );	// cache
		if( $v->IOL_IMAGE == 1 )
		{
			$this->mod_view_data['IMAGE_WEB_PATH'] = $img_base_url.$this->config->item( 'iol_vehicle_pictures_web_path' );
			$this->mod_view_data['IMAGE_MED_PATH'] = $img_base_url.$this->config->item( 'iol_vehicle_pictures_med_path' ).'med_';
			$this->mod_view_data['IMAGE_TINY_PATH'] = $img_base_url.$this->config->item( 'iol_vehicle_pictures_tiny_path' ).'tiny_';
		}
        else
        {
			$this->mod_view_data['IMAGE_WEB_PATH'] = $img_base_url.$this->config->item( 'vehicle_pictures_web_path' );
			$this->mod_view_data['IMAGE_MED_PATH'] = $img_base_url.$this->config->item( 'vehicle_pictures_med_path' ).'med_';
			$this->mod_view_data['IMAGE_TINY_PATH'] = $img_base_url.$this->config->item( 'vehicle_pictures_tiny_path' ).'tiny_';
        }
		
		// Determine Display of price
		$price_to_show = array( 'style' => false );
		if( $v->HIDE_PRICE == 0 )
        	$price_to_show['price'] = "$".number_format( $v->PRICE, 2, '.', ',' );
		elseif( $v->PRICE_STRING != '' && strpos( $v->PRICE_STRING, "Desde" ) !== FALSE )
		{
			$price_to_show['price'] = str_replace( "Desde: ", "", $v->PRICE_STRING );
			$price_to_show['price'] = str_replace( "Hasta:", "-", $price_to_show['price'] );
			$price_to_show['style'] = true;
		}
		elseif( $v->PRICE_STRING != '' )
			$price_to_show['price'] = $v->PRICE_STRING;
		else
            $price_to_show['price'] = "Llama hoy";
		$this->mod_view_data['v_price'] = $price_to_show;
		
		// Mask vin number (if enabled)
		$masked_vin = $v->VIN;
		if( is_array( $this->mod_cms_vars['vin_num_mask'] ) && $this->mod_cms_vars['vin_num_mask']['enabled'] == 'yes' )
			$masked_vin = substr( $masked_vin, ( strlen( $masked_vin ) - $this->mod_cms_vars['vin_num_mask']['show'] ) );
		$this->mod_view_data['masked_vin'] = $masked_vin;
		
		// Meta Content / SEO Vars
		$this->mod_view_data['seo_vehicle_label'] = $v->MAKE." ".$v->MODEL.( ( $v->TRIM != '' ) ? ' '.$v->TRIM : '' )." ".$v->YEAR;
		$this->mod_view_data['seo_vehicle_keywords'] = $v->KEYWORDS;
		$this->mod_view_data['seo_image_label'] = $this->mod_view_data['seo_vehicle_label']." en ".$this->mod_cms_vars['dealer_name'];
		$this->mod_view_data['inventory_url'] = ( strpos( $_SERVER['HTTP_REFERER'], $this->mod_uri_slug."?" ) != FALSE ) ? $_SERVER['HTTP_REFERER'] : $this->mod_cms_vars['base_url'].$this->mod_uri_slug ;
		$this->mod_view_data['bread_crumb_extras'] = '';
		
		// Load JS vars
		$this->mod_view_data['js_vars'] = array( "var lightbox_path = '".$this->config->item( 'lightbox_path' )."';" );
		
		// Load template and its data
		$this->template->
			set_metadata( 'description', $this->mod_view_data['seo_vehicle_label'].". Compralo hoy en ".$this->mod_cms_vars['dealer_name'] )->
			set_metadata( 'keywords', $this->mod_view_data['seo_vehicle_keywords'] )->
			build( 'vehiculo', $this->mod_view_data );
	}
	
	// Index, main module method
	public function request()
	{
		// Make sure that $_POST is present
		if( true || ( isset( $_POST ) && count( $_POST ) > 0 ) )
		{
			// Determine what action to perform
			
			// Return Models for quick search
			if( $this->input->get( 'action' ) == 'quick_search_model' )
			{
				// Prepare query
				$sql = "SELECT DISTINCT `MODEL` FROM `vehicles_available_to_viewer_final` WHERE `CLIENT_ID` IN (".$this->mod_cms_vars['mdv_ids'].") AND `MAKE` = '".$this->input->get( 'qs_make' )."'";
				
					// Restrict inventory (if enabled)
					if( $this->mod_cms_vars['filtered_inventory_allowed'] != '' )
						$sql .= " AND `CONDITION` IN (".$this->mod_cms_vars['filtered_inventory_allowed'].")";
					
					// Remove stock vehicles (if enabled)
					if( $this->mod_cms_vars['skip_stock_vehicles'] == 'yes' )
							$sql .= " AND `IOL_IMAGE` = '0'";
				
				// Finish query
				$sql .= " ORDER BY `MAKE` ASC";
				
				// Return models of vehicles
				$results = $this->mdv_db->query( $sql );
				$models = $results->result_array();
				
				// New options to return
				$html = '<option value="">Seleccione Modelo</option>';
				foreach( $models as $m )
				{
					$html .= '<option value="'.$m['MODEL'].'">'.$m['MODEL'].'</option>';	
				}
				echo $html;
			}
		}
	}
}
?>