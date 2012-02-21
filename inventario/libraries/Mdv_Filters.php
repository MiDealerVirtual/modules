<?
	# MDV Filters Library
	class Mdv_Filters
	{
		# Private Data Members
		private $CI;
		private $db_results;
		private $db_last_query;
		private $mdv_ids;
		private $filters = array();
		private $years, $makes, $models, $conditions, $transmissions, $prices, $miles;
		private $filter_mismatch;
		private $get_vars;
		/* NEW */ private $mdv_sort;
		/* NEW */ private $mod_cms_vars;
		
		# Constructor
		function __construct( $config = array() )
		{
			// Grabs global instance by reference
			$this->CI =& get_instance();
			
			// Assign DB Last Query
			$this->db_last_query = $this->CI->mdv_db->last_query();
			
			// Assign DB Results to Library
			if( array_key_exists( 'db_results', $config ) )
				$this->db_results = $config['db_results'];
			else
				die( "No Data Present" );
				
			// Assing MDV Ids
			if( array_key_exists( 'mdv_ids', $config ) )
				$this->mdv_ids = $config['mdv_ids'];
			else
				die( "No IDs Present" );
				
			// Assign Filters to Library
			if( array_key_exists( 'filters', $config ) )
				$this->filters = $config['filters'];
			else
				die( "No Filters Applied" );
				
			// Assign $_GET Vars to Library
			if( array_key_exists( 'get_vars', $config ) )
				$this->get_vars = $config['get_vars'];
			
			// Assign Mod Cms Vars to Library
			if( array_key_exists( 'cms_vars', $config ) )
				$this->mod_cms_vars = $config['cms_vars'];
			
			// Initiate Private Data Members
			$this->years =
			$this->makes =
			$this->models =
			$this->conditions =
			$this->transmissions =
			$this->prices =
			$this->miles = array( 'VALUES' => array(), "COUNT" => array() );
			
			// Set mismatch to false
			$this->filter_mismatch = false;
			
			/* NEW - MDV Sort */
				// Include Class
				include( "Mdv_Sort.php" );
			
				// Initialize
				$mdv_sort_config = array( 'CI' => $this->CI,
										  'db_table' => 'filtered_vehicles',
										  'options_selected' => array( 'year', 'make', 'model', 'transmission', 'miles' ),
										  'sort_selected' => ( ( array_key_exists( 'sort', $this->get_vars ) ) ? $this->get_vars['sort'] : FALSE ),
										  'sort_direction' => ( ( array_key_exists( 'sort_dir', $this->get_vars ) ) ? $this->get_vars['sort_dir'] : FALSE ) );
				$this->mdv_sort = new Mdv_Sort( $mdv_sort_config );
			/* NEW - MDV Sort */
			
		}
		
		# Private Methods
			
			# DB Data Traverser
			private function _traverseData( $row, $column, &$value, $is_case_stmt = false )
			{
				// Collect `COLUMN`
				if( in_array( $column, $this->filters ) )
				{
					// If Case Statement, strip letters
					if( $is_case_stmt )
					{
						$row[$column] = substr( $row[$column], strpos( $row[$column], " " ) + 1 );
					}
					
					// Add Value to Array
					if( !in_array( $row[$column], $value['VALUES'] ) )
					{
						array_push( $value['VALUES'], $row[$column] );
						$value['COUNT'][$row[$column]] = 1;
					}
					else
						$value['COUNT'][$row[$column]]++;
				}
			}
			
			# Factory for `GET` Functions
			private function _createGet( $member_name, $order = "normal" )
			{
				// Sort Array and Return
				return $this->_sortMember( $member_name, $order );
			}
			
			# Prepare Dropdown HTML
			private function _prepareSelectHTML( $dd_data, $dd_selected, $dd_sort = "normal", $is_case_stmt = false, $group_prices = false )
			{
				// Set Value
				$dd_title = $dd_data['title'];
				$dd_name = $dd_data['name'];
				$dd_css = $dd_data['css'];
				
				// Sort Values
				$dd_values = $this->_sortMember( $dd_name, $dd_sort );
				
				// Group prices if necessary
				if( $group_prices )
				{
					// Set variables needed
					$group_labels = array( "Veh&iacute;culos Nuevos", "Veh&iacute;culos Usados" );
					$group_count = 0;
				}
				
				// Initiate HTML
				$html = "<select name=\"$dd_name\" id=\"$dd_name\" class=\"$dd_css\">";
				
					// Set Drop Down Title
					$html .= "<option value=\"\">$dd_title</option>";
				
					// Set flag
					$is_default_set = false;
					
					// Loop values
					$loop_html = "";
					foreach( $dd_values['VALUES'] as $v )
					{
						// Add Group, if necessary
						if( $group_prices && $group_count == 0 )
						{
							$loop_html .= "<optgroup label=\"".$group_labels[$group_count]."\">";
							$group_count++;
						}
						else if( $group_prices && $group_count == 1 && strpos( $v, "a-new" ) === FALSE )
						{
							$loop_html .= "</optgroup>";
							$loop_html .= "<optgroup label=\"".$group_labels[$group_count]."\">";
							$group_count++;
						}
						
						// Prepare Value for Case Statement
						if( $is_case_stmt /*&& $group_prices*/ )
						{
							$ov = substr( $v, strpos( $v, " " ) + 1 );
						}
						else
						{
							// Translate ( if necesary )
							if( $v == "new" )
								$ov = "Nuevo";
							elseif( $v == "used" )
								$ov = "Usado";
							elseif( $v == "certified" )
								$ov = "Certificado";
							elseif( $v == "automatic" )
								$ov = "Autom&aacute;tica";
							elseif( $v == "manual" )
								$ov = "Manual";
							else
								$ov = $v;
						}
						
						// Prepare the Count
						$count = "";//  [".$dd_values['COUNT'][$v]."]";
							
						// Add values
						$loop_html .= "<option value=\"$v\"";
							// Select Value
							if( $dd_selected != false && $dd_selected == $v )
							{
								$loop_html .= " selected=\"selected\"";
								$is_default_set = true;
							}
						$loop_html .= ">$ov$count</option>";
					}
					
					// If default not set, make one
					if( $dd_name == "models" && !$is_default_set && $dd_selected != "" )
					{
						$loop_html = "<option value=\"$dd_selected\" selected=\"selected\">$dd_selected</option>".$loop_html;
					}
					
					// Close Option Group
					if( $group_prices )
						$loop_html .= "</optgroup>";
				
				// Close HTML
				$html .= $loop_html."</select>";
				
				// Return HTML
				return $html;
			}
			
			# Sort Data Members
			private function _sortMember( $member_name, $sort_order = "normal" )
			{
				// Sort Array
				switch( $member_name )
				{
					case "years":
						( $sort_order == "reverse" ) ? rsort( $this->years['VALUES'] ) : sort( $this->years['VALUES'] );
						return $this->years;
					case "makes":
						( $sort_order == "reverse" ) ? rsort( $this->makes['VALUES'] ) : sort( $this->makes['VALUES'] );
						return $this->makes;
					case "models":
						( $sort_order == "reverse" ) ? rsort( $this->models['VALUES'] ) : sort( $this->models['VALUES'] );
						return $this->models;
					case "conditions":
						( $sort_order == "reverse" ) ? rsort( $this->conditions['VALUES'] ) : sort( $this->conditions['VALUES'] );
						return $this->conditions;
					case "transmissions":
						( $sort_order == "reverse" ) ? rsort( $this->transmissions['VALUES'] ) : sort( $this->transmissions['VALUES'] );
						return $this->transmissions;
					case "prices":
						( $sort_order == "reverse" ) ? rsort( $this->prices['VALUES'] ) : sort( $this->prices['VALUES'] );
						return $this->prices;
					case "miles":
						( $sort_order == "reverse" ) ? rsort( $this->miles['VALUES'] ) : sort( $this->miles['VALUES'] );
						return $this->miles;
				}
			}
			
			# Create WHERE clause
			private function createWhereClause( $vars )
			{
				// Optional flags
				$skip_optional_condition = false;
				
				// Initiate Where Clause
				$where = " 1=1 ";
				
				// Loop thru vars
				foreach( $vars as $k =>	$v )
				{
					if( $k == "years" && $v != '' )
						$where .= " AND `YEAR` = '".$v."'";
					elseif( $k == "makes" && $v != '' )
						$where .= " AND `MAKE` = '".$v."'";
					elseif( $k == "models" && $v != '' )
						$where .= " AND `MODEL` LIKE '%".$v."%'";
					elseif( $k == "conditions" && $v != '' )
					{
						$where .= " AND `CONDITION` = '".$v."'";
						
						// Set flag for future use
						$skip_optional_condition = true;
					}
					elseif( $k == "transmissions" && $v != '' )
						$where .= " AND `TRANSMISSION` = '".$v."'";
					elseif( $k == "miles" && $v != '' )
						$where .= " AND `MILEAGE_RANGE` = '".$v."'";
					elseif( $k == "prices" && $v != '' )
						$where .= " AND `PRICE_RANGE` = '".$v."'";
				}
				
				// Skip vehicle if stock image is present
				if( $this->mod_cms_vars['skip_stock_vehicles'] == 'yes' )
					$where .= " AND `IOL_IMAGE` = '0'";
					
				// Filter inventory by type (CMS option)
				if( $this->mod_cms_vars['filtered_inventory_allowed'] != '' && !$skip_optional_condition )
					$where .= " AND `CONDITION` IN (".$this->mod_cms_vars['filtered_inventory_allowed'].")";
			
				// Return where clause
				return $where;
			}
			
			# Create ORDER BY Clause
			private function createOrderByClause( $curr_sql )
			{
				$new_sql = $curr_sql;
				$order_sql = "";
				if( array_key_exists( "sort", $this->get_vars ) )
					$order_sql = $this->mdv_sort->getSortSQL( $this->get_vars['sort'] );
				
				if( $order_sql != "" )
					return $new_sql." ORDER BY ".$order_sql;
				return $new_sql;
			}
			
		# Public Methods
			
			# Get DropDowns
			public function getYearsDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "A&ntilde;o", 'name' => "years", 'css' => 'w_1' ), $selected, "reverse" ); }
			public function getMakesDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "Marca", 'name' => "makes", 'css' => 'w_2' ), $selected ); }
			public function getModelsDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "Modelo", 'name' => "models", 'css' => 'w_3' ), $selected ); }
			public function getConditionsDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "Condici&oacute;n", 'name' => "conditions", 'css' => 'w_4' ), $selected ); }
			public function getTransmissionsDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "Transmisi&oacute;n", 'name' => "transmissions", 'css' => 'w_5' ), $selected ); }
			public function getPricesDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "Precio", 'name' => "prices", 'css' => 'w_7' ), $selected, "normal", true, true ); }
			public function getMilesDD( $selected = false ){ return $this->_prepareSelectHTML( array( 'title' => "Millaje", 'name' => "miles", 'css' => 'w_6' ), $selected, "normal", true ); }
			
			# Printout Values (For Debugging)
			public function printValues( $data_value )
			{
				// Formatting
				$br = "<br />";
				
				// Loop and 
				foreach( $data_value['VALUES'] as $v )
				{
					echo $br.$v.": ".$data_value['COUNT'][$v].$br;
				}
				echo $br.$br;	
			}
			
			# Filter out $_GET array
			public function filterGet( $array_key )
			{
				return ( array_key_exists( $array_key, $this->get_vars ) && $this->get_vars[$array_key] != false ) ? $this->get_vars[$array_key] : false;	
			}
			
			# Apply Filters, if necessary
			public function applyFilters( /*$get_vars*/ )
			{
				// Prepare WHERE clause
				$where_clause = $this->createWhereClause( $this->get_vars );
				
				if( $where_clause != " 1=1 " || TRUE )
				{
					// Apply filters...
					$new_sql = "SELECT * 
								FROM (".$this->db_last_query.") as `filtered_vehicles` 
								WHERE ".$where_clause;
								
						// Apply Order
						$new_sql = $this->createOrderByClause( $new_sql );
					
					// Execute new SQL query	
					$now_filtered = $this->CI->mdv_db->query( $new_sql );
					
					// Determine if Filters produced a mismatch
					if( $now_filtered->num_rows() == 0 || $now_filtered == false )
						$this->filter_mismatch = true;
					
					// Return new, filtered results
					return $now_filtered->result();
				}
				else
					return false;
			}
			
			# Populate Data
			public function populateData( $new_filtered_result )
			{
				// Loop thru DB results, extract data requested
				foreach( /*$this->db_results*/ $new_filtered_result as $r )
				{
					// Type Cast Row
					$r = ( array ) $r;
					
					// Collect `YEAR`
					$this->_traverseData( $r, 'YEAR', $this->years );
						
					// Collect `MAKE`
					$this->_traverseData( $r, 'MAKE', $this->makes );
					
					// Collect `MODEL`
					$this->_traverseData( $r, 'MODEL', $this->models );
					
					// Collect `CONDITION`
					$this->_traverseData( $r, 'CONDITION', $this->conditions );
					
					// Collect `TRANSMISSION`
					$this->_traverseData( $r, 'TRANSMISSION', $this->transmissions );
					
					// Collect `PRICE_RANGE`
					$this->_traverseData( $r, 'PRICE_RANGE', $this->prices );
					
					// Collect `MILEAGE_RANGE`
					$this->_traverseData( $r, 'MILEAGE_RANGE', $this->miles );
				}
			}
			
			# Notify mismatch
			public function detectMismatch()
			{
				return $this->filter_mismatch;	
			}
			
			# Get Filters HTML
			public function getFiltersHTML()
			{
				return $this->getYearsDD( $this->filterGet( 'years' ) ).
					   $this->getMakesDD( $this->filterGet( 'makes' ) ).
					   $this->getModelsDD( $this->filterGet( 'models' ) ).
					   $this->getConditionsDD( $this->filterGet( 'conditions' ) ).
					   $this->getTransmissionsDD( $this->filterGet( 'transmissions' ) ).
					   $this->getMilesDD( $this->filterGet( 'miles' ) ).
					   $this->getPricesDD( $this->filterGet( 'prices' ) );
			}
			
			# Get Sort HTML
			public function getSortHTML()
			{
				return $this->mdv_sort->getSort();	
			}
	}
?>