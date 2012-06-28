		<div class="m1">
			<div class="carousel">
				<div class="frame">
					<ul class="mycarousel">
{pyro:widget_fetcher:area slug="virtual-showroom"}
					</ul>
				</div>
<?
	// Filters and Sorting Options
	$this->load->view( 'includes/top_filters' );
?>
			</div>
		</div>
		<div class="main-holder">
			<div class="m1">
				<div class="m2">
<?
	// Display filter alert
	if( $this->mdv_filters->detectMismatch() ):
?>
					<div class="media-holder">
						{pyro:theme:image file="img-inventory-404.png" alt="Inventario de {pyro:variables:dealer_inc_name}"}
                         </div>
<?
	endif;
?>
					<div class="content-holder">
						<div class="inventory-content">
<?
	// check to see if any results present
	if( isset( $results ) && $results != false )
	{
		// prepare vehicle results
		$i = 1;
		$veh_list = array();
		$veh_gall = array();
		foreach( $results as $v )
		{
			// create vehicle link
			$v_link = 'http://'.$_SERVER['SERVER_NAME'].'/'.getVehicleLink( $v, $mod_uri_slug, $cms_vars );
			
			// create vehicle title
			$v_label = getVehicleLabel( $v );
			
			// mask vin number (if enabled)
			$masked_vin = $v->VIN;
			if( is_array( $cms_vars['vin_num_mask'] ) && $cms_vars['vin_num_mask']['enabled'] == 'yes' ):
				$masked_vin = substr( $masked_vin, ( strlen( $masked_vin ) - $cms_vars['vin_num_mask']['show'] ) );
			endif;
			
			// parse color
			$v_color = implode( " ", array_slice( explode( " ", $v->COLOR ), 0, 2 ) );
			
			// translate vehicle attributes
			transalateVehicleAttr( $v );
			
			// save vehicle for later use
			$list_v =
'								<!-- vehicle #'.$i.' -->
								<li>
									<img src="'.getVehicleImagePath( $this->config, $v, "thumb", "thumb_" ).'" alt="'.$v_label.'" title="'.$v_label.'" />
									<h3><a href="'.$v_link.'" title="'.$v_label.'">'.$v->MAKE." ".$v->MODEL.'</a></h3>
									<dl>
										<dt><strong>Color:</strong></dt>
										<dd>'.$v_color.'</dd>
										<dt><strong>Condición:</strong></dt>
										<dd>'.$v->CONDITION.'</dd>
										<dt><strong>Trans.:</strong></dt>
										<dd>'.$v->TRANSMISSION.'</dd>
										<dt>VIN:</dt>
										<dd>'.$masked_vin.'</dd>
									</dl>
									<div class="box">
										<strong>'.$v->YEAR.'</strong>
										<a href="'.$v_link.'" title="'.$v_label.'">DETALLES</a>
									</div>
								</li>
								<!-- /vehicle #'.$i.' -->';
			$gall_v = 
'								<!-- vehicle #'.$i.' -->
								<li>
									<h3><a href="'.$v_link.'" title="'.$v_label.'">'.$v->MAKE." ".$v->MODEL." ".$v->TRIM.'</a></h3>
									<div class="specs">
										<dl>
											<dt><strong>Año:</strong></dt>
											<dd>'.$v->YEAR.'</dd>
											<dt><strong>Color:</strong></dt>
											<dd class="limit-color">'.$v_color.'</dd>
										</dl>
										<dl>
											<dt><strong>Condición:</strong></dt>
											<dd>'.$v->CONDITION.'</dd>
											<dt><strong>Trans.:</strong></dt>
											<dd>'.$v->TRANSMISSION.'</dd>
										</dl>
									</div>
									<div class="box">
										<img src="'.getVehicleImagePath( $this->config, $v, "thumb", "thumb_" ).'" alt="'.$v_label.'" title="'.$v_label.'" />
										<div class="box">
											<strong>'.$v->YEAR.'</strong>
											<a href="'.$v_link.'" title="'.$v_label.'">DETALLES</a>
										</div>
									</div>
								</li>
								<!-- /vehicle #'.$i++.' -->';
			array_push( $veh_list, $list_v );
			array_push( $veh_gall, $gall_v );
		}
?>
							<ul class="inventory-results inventory-list inactive" id="inventory-list">
<?
		// display list view
		foreach( $veh_list as $v ):
			echo $v;
		endforeach;
?>
							</ul>
							<ul class="inventory-results items-list" id="items-list">
<?
		// display gallery view
		foreach( $veh_gall as $v ):
			echo $v;
		endforeach;
?>
							</ul>
<?
	}
	
	// display pagination
	if( isset( $pagination ) && $pagination != false )
		echo str_replace( "<li>P&aacute;gina: </li>", "", $pagination );	// remove title
?>
						</div>
					</div>
				</div>
			</div>
			<div class="bg">{pyro:theme:image file="inner-img.jpg" alt=""}</div>
		</div>
		<!-- used vehicle showroom -->
{pyro:widget_fetcher:instance id="23"}
		<!-- /used vehicle showroom -->
<? # JS corresponding to this page ?>
<script>
// Callbacks to execute on page load
var callbacks = [];

// Page configuration
callbacks[0] = function()
{
	// init tabs api (custom)
	tabs_api.init( { tab_select_apply: 'parent', tab_selector: '.view-change', tab_content: '.inventory-results', tab_hidden: 'inactive', tab_active: 'active' } );
	
	// prepare filters form
	$( '#view-all-results', 'form.inventory-filters' ).click(
		function( e )
		{
			// clear form and submit empty form
			$( 'select', 'form.inventory-filters' ).each(
				function()
				{
					this.selectedIndex = 0;
				} );
			$( 'form.inventory-filters' ).submit();
			
			// stop defualt behavior
			e.preventDefault();
		} );
};

// Execute all callbacks
cms_API.onJQReady( callbacks );
</script>