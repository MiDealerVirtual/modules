<?php
	# MDV Sort Library
	class Mdv_Sort
	{
		# Private Data Members
		private $CI;
		private $db_table;
		private $options;
		private $options_selected;
		private $options_labels;
		private $sort_html;
		private $sort_direction;
		private $sort_selected;
		private $default_sort_selected;
		private $default_sort_direction;
		private $base_url;
		
		# Constructor
		function __construct( $config = array() )
		{
			// Grabs global instance by reference
			if( array_key_exists( 'CI', $config ) )
				$this->CI =& $config['CI'];
			else
				die( "CI Instance M.I.A." );
			
			// Assign DB Table
			if( array_key_exists( 'db_table', $config ) )
				$this->db_table = $config['db_table'];
			else
				die( "No DB Table Selected" );
			
			// Assign Filters to Library
			if( array_key_exists( 'options_selected', $config ) )
				$this->options_selected = $config['options_selected'];
			else
				die( "No Sort Options Selected" );
				
			// Build default URL
			$this->_buildBaseURL();
				
			// Assign Sort and Directions
			$this->default_sort_selected = "year";
			$this->default_sort_direction = "DESC";
			$this->sort_selected = ( array_key_exists( 'sort_selected', $config ) && $config['sort_selected'] != FALSE ) ? $config['sort_selected'] : $this->default_sort_selected;
			$this->sort_direction = ( array_key_exists( 'sort_direction', $config ) && $config['sort_direction'] != FALSE ) ? $config['sort_direction'] : $this->default_sort_direction;
			
			// Load SQL
			$this->_populateSQL();
			
			// Create HTML
			$this->_createHTML();
		}
		
		# Private Methods
			
			# Populate Options Available
			private function _populateSQL()
			{
				/* Year */ $this->options['year'] = array( "SQL" => "`$this->db_table`.`YEAR` $this->sort_direction", "TITLE" => "A&ntilde;o" );
				/* Make */ $this->options['make'] = array( "SQL" => "`$this->db_table`.`MAKE` $this->sort_direction", "TITLE" => "Marca" );
				/* Model */ $this->options['model'] = array( "SQL" => "`$this->db_table`.`MODEL` $this->sort_direction", "TITLE" => "Modelo" );
				/* Condition */ $this->options['condition'] = array( "SQL" => "`$this->db_table`.`CONDITION` $this->sort_direction", "TITLE" => "Condici&oacute;n" );
				/* Transmission */ $this->options['transmission'] = array( "SQL" => "`$this->db_table`.`TRANSMISSION` $this->sort_direction", "TITLE" => "Transmisi&oacute;n" );
				/* Miles */ $this->options['miles'] = array( "SQL" => "`$this->db_table`.`MILEAGE_RANGE` $this->sort_direction", "TITLE" => "Millaje" );
				/* Price */ $this->options['price'] = array( "SQL" => "`$this->db_table`.`PRICE_RANGE` $this->sort_direction", "TITLE" => "Precio" );
			}
			
			# Create HTML For Display
			private function _createHTML()
			{
				// Initiate HTML
				$this->sort_html = "<li>Ordenar por:</li>";
				
				// Add Year
				foreach( $this->options as $key => $value )
				{
					if( in_array( $key, $this->options_selected ) )
					{
						// Prepare Class
						$sort_dir = "";
						if( $this->sort_selected == $key && $this->sort_direction == "ASC" )
						{
							$class = " class=\"sort_up\"";
							$sort_dir = "DESC";	// Invert Direction
						}
						else if( $this->sort_selected == $key && $this->sort_direction == "DESC" )
						{
							$class = " class=\"sort_down\"";
							$sort_dir = "ASC";	// Invert Direction
						}
						else
						{
							$class = "";
							$sort_dir = "ASC";
						}
						
						// Prepare Link
						$link = $this->base_url.$key."&sort_dir=".$sort_dir;
						
						// Append HTML
						$this->sort_html .= "<li".$class."><a href=\"".$link."\">".$this->options[$key]["TITLE"]."</a></li>";
					}
				}
			}
			
			# Build Default URL For Sorting Links
			private function _buildBaseURL()
			{
				// Set Flag
				$is_first = true;
				
				// Initiate base_url
				$this->base_url = $this->CI->config->item( 'base_url' ).$this->CI->uri->uri_string()."?";
				
				// Loop and attach previous $_GET vars
				foreach( $_GET as $k => $v )
				{
					// Only if $v isn't empty
					if( $v != '' && $k != "sort" && $k != "sort_dir" && $k != "offset" )
					{
						// Determine status of leading & sign
						if( $is_first )
							$is_first = false;
						else
							$this->base_url .= "&amp;";
						
						// Append GET var	
						$this->base_url .= $k.'='.$v;
					}
				}
				
				// Prepare for offset number
				$this->base_url .= ( ( $is_first ) ? "" : "&amp;" ).'sort=';
			}
		
		# Public Methods
		
			# Get Sort
			public function getSort()
			{
				return $this->sort_html;	
			}
			
			# Get Sort SQL
			public function getSortSQL( $key )
			{
				if( array_key_exists( $key, $this->options ) )
					return $this->options[$key]['SQL'];
				return FALSE;	
			}
		
	}
?>