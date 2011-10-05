<?
	# Model for Inventory
	class inventario_model extends MY_Model
	{
		# Private members
		var $order_by;	// Used when a specific order is desired
		var $limit = 12;
		
		# Model Constructor
		function inventario_model()
		{
			// Call the Model constructor
			parent::MY_Model();
			
			// Initiate private members
			$this->order_by = NULL;
		}
		
		# Select Vehicles
		function fetchMultiVehicles( $table = 'vehicles_available_to_viewer_final', $in = "", $extra_where = array(), $order_by = NULL, $split = NULL )
		{
			// Prepare SQL
			$sql =
			"SELECT
				*,
				CASE 
					WHEN `PRICE` = 0 AND SUBSTRING( `PRICE_STRING`, 1, 5 ) = 'Desde' THEN CONCAT( 'a-new ', REPLACE( REPLACE( `PRICE_STRING`, ' Hasta: ', ' - ' ), 'Desde: ', '' ) )
					WHEN `PRICE` = 0 AND `PRICE_STRING` != 'Llama hoy' THEN CONCAT( 'z ', `PRICE_STRING` )
					WHEN `PRICE`<4000 THEN 'b $1 - $3,999'
					WHEN `PRICE`<8000 THEN 'c $4,000 - $7,999'
					WHEN `PRICE`<12000 THEN 'd $8,000 - $11,999'
					WHEN `PRICE`<16000 THEN 'e $12,000 - $15,999'
					WHEN `PRICE`<20000 THEN 'f $16,000 - $19,999'
					WHEN `PRICE`<24000 THEN 'g $20,000 - $23,999'
					WHEN `PRICE`<28000 THEN 'h $24,000 - $27,999'
					WHEN `PRICE`<32000 THEN 'i $28,000 - $31,999'
					WHEN `PRICE`<36000 THEN 'j $32,000 - $35,999'
					WHEN `PRICE`<40000 THEN 'k $36,000 - $39,999'
					WHEN `PRICE`<44000 THEN 'l $40,000 - $43,999'
					WHEN `PRICE`<48000 THEN 'm $44,000 - $47,999'
					WHEN `PRICE`<52000 THEN 'n $48,000 - $51,999'
					WHEN `PRICE`<56000 THEN 'o $52,000 - $55,999'
					WHEN `PRICE`<60000 THEN 'p $56,000 - $59,999'
					WHEN `PRICE`<64000 THEN 'q $60,000 - $63,999'
					WHEN `PRICE`<68000 THEN 'r $64,000 - $67,999'
					WHEN `PRICE`<72000 THEN 's $68,000 - $71,999'
					WHEN `PRICE`<76000 THEN 't $72,000 - $75,999'
					WHEN `PRICE`<80000 THEN 'u $76,000 - $79,999'
					ELSE 'v $80,000 +'
				END as `PRICE_RANGE`,
				CASE
					WHEN `MILEAGE` BETWEEN 0 AND 1000 THEN 'a 1 - 999'
					WHEN `MILEAGE`<5000 THEN 'b 1,000 - 4,999'
					WHEN `MILEAGE`<10000 THEN 'c 5,000 - 9,999'
					WHEN `MILEAGE`<20000 THEN 'd 10,000 - 19,999'
					WHEN `MILEAGE`<35000 THEN 'e 20,000 - 34,999'
					WHEN `MILEAGE`<50000 THEN 'f 35,000 - 49,999'
					WHEN `MILEAGE`<75000 THEN 'g 50,000 - 74,999'
					WHEN `MILEAGE`<100000 THEN 'h 75,000 - 99,999'
					WHEN `MILEAGE`<125000 THEN 'i 100,000 - 124,999'
					WHEN `MILEAGE`<150000 THEN 'j 125,000 - 149,999'
					WHEN `MILEAGE`<200000 THEN 'k 150,000 - 199,999'
					WHEN `MILEAGE`<250000 THEN 'l 200,000 - 249,999'
					WHEN `MILEAGE`>250000 THEN 'm 250,000 +'
				END as `MILEAGE_RANGE`
			FROM
				`".$table."` ";
				
			// Add `WHERE` clause
			$sql .=
			"WHERE `CLIENT_ID` IN (".$in.") ";
					
				// Detect if extra where clauses are needed
				if( count( $extra_where ) > 0 )
				{
					// Prepend initial AND
					$sql .= "AND ";
					
					// Add all clause
					$i = 1;
					foreach( $extra_where as $field => $value )
					{
						// Append sql
						$sql .= "`".$field."` = '".$value."' ";
						
						// Add `AND`, if needed
						if( $i != count( $extra_where ) )
						{
							$sql .= "AND ";
							$i++;
						}
					}
				}
				
				
				// Detect if `ORDER BY` clause is needed
				if( $order_by != NULL )
				{
					$sql .= "ORDER BY ".$order_by." ";	
				}
				
				// Limit results
				if( $split != NULL )
				{
					$sql .= "LIMIT ".$split['LIMIT'];
						if( isset( $split['OFFSET'] ) && $split['OFFSET'] > 0 )
							$sql .= ", ".$split['OFFSET']." ";
				}
				
			// Process Query
			$query = $this->mdv_db->query( $sql );
			
			// Check for resutls
			if( $query->num_rows() > 0 )
			{
				// Return Query
				return $query->result();
			}
			
			// Defualt return
			return false;
		}
		
		# Select Vehicle/Image
		function select_item( $id, $field = 'VEH_ID', $table = 'vehicles', $single = true, $select = '*', $order_by = NULL, $extra_where = NULL, $split = NULL, $like = NULL )
		{
			// Prepare SQL
			$this->mdv_db->select( $select );
			$this->mdv_db->where( $field, $id );
			$this->mdv_db->from( $table );
				// Optional
				if( $extra_where != NULL )
					$this->mdv_db->where( $extra_where );
				// Optional
				if( $like != NULL && is_array( $like ) )
					$this->mdv_db->like( $like['COLUMN'], $like['KEYWORD'] );
				// Optional
				if( $split != NULL && is_array( $split ) )
					$this->mdv_db->limit( $split['LIMIT'], $split['OFFSET'] );
				// Optional
				if( $order_by != NULL )
					$this->mdv_db->order_by( $order_by );
			
			// Fetch Client
			$results = $this->mdv_db->get();
			
			// Verify
			if( $results )
				return ( $single ) ? $results->row() : $results->result() ;
			
			// Default return
			return false;
		}
	}
?>