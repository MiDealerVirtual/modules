            <div class="promo">
{pyro:widget_fetcher:instance id="26"}
            </div>
            <section class="content-section">
                <div class="holder">
                    <div class="page-title">
                        <ul class="social">
                            <li><a href="#" class="facebook">facebook</a></li>
                            <li><a href="#" class="twitter">twitter</a></li>
                            <li><a href="#" class="mail">mail</a></li>
                            <li><a href="#" class="print">print</a></li>
                            <li><a href="#" class="share">share</a></li>
                        </ul>
                        <h1>INVENTARIO VIRTUAL</h1>
                    </div>
                    <div id="two-columns">
                        <aside id="sidebar">
<?php
	// open filters form
	if ( isset( $filter_html ) && $filter_html != '' ) {
?>
                            <div class="sub-box">
                                <form action="#" class="form" id="filter-form">
                                    <fieldset>
                                        <h2>FILTROS</h2>
<?php
		// loop through filters and display
		foreach( $filter_html as $k => $v ) {
?>
		
                                        <div class="select-holder">
                                            <?=$v?>
                                        </div>
<?php
		}
?>
                                        <div class="row">
                                            <input type="submit" value="BUSCAR" id="jq_filters_submit" />
                                            <input type="reset" value="RESET" id="view-all-results" />
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
<?php
	}
?>
                            <div class="sub-box blue-box">
<script>
// models available
var models = {
	"Buick": ["Enclave", "Encore", "LaCrosse", "Regal", "Verano"],
	"Cadillac": ["ATS","CTS","Escalade","Escalade ESV","Escalade EXT","SRX","STS","XTS"],
	"Chevrolet": ["Avalanche","Camaro","Colorado Crew Cab","Colorado Extended Cab","Colorado Regular Cab","Corvette","Cruze","Equinox","Express 1500 Cargo","Express 1500 Passenger","Express 2500 Cargo","Express 2500 Passenger","Express 3500 Cargo","Express 3500 Passenger","Impala","Malibu","Silverado 1500 Crew Cab","Silverado 1500 Extended Cab","Silverado 1500 Regular Cab","Silverado 2500 HD Crew Cab","Silverado 2500 HD Extended Cab","Silverado 2500 HD Regular Cab","Silverado 3500 HD Crew Cab","Silverado 3500 HD Extended Cab","Silverado 3500 HD Regular Cab","Sonic","Spark","Suburban 1500","Suburban 2500","Tahoe","Traverse","Volt"],
	"Chrysler": ["200", "300", "Town & Country"],
	"Dodge": ["Avenger","Caliber","Challenger","Charger","Dart","Durango","Grand Caravan Cargo","Grand Caravan Passenger","Journey","Nitro"],
	"Ford": ["C-MAX Energi","C-MAX Hybrid","E150 Cargo","E150 Passenger","E250 Cargo","E350 Super Duty Cargo","E350 Super Duty Passenger","Edge","Escape","Expedition","Expedition EL","Explorer","F150 Regular Cab","F150 Super Cab","F150 SuperCrew Cab","F250 Super Duty Crew Cab","F250 Super Duty Regular Cab","F250 Super Duty Super Cab","F350 Super Duty Crew Cab","F350 Super Duty Regular Cab","F350 Super Duty Super Cab","F450 Super Duty Crew Cab","Fiesta","Flex","Focus","Focus ST","Fusion","Mustang","Ranger Regular Cab","Ranger Super Cab","Taurus","Transit Connect Cargo","Transit Connect Passenger"],
	"GMC": ["Acadia","Canyon Crew Cab","Canyon Extended Cab","Canyon Regular Cab","Savana 1500 Cargo","Savana 1500 Passenger","Savana 2500 Cargo","Savana 2500 Passenger","Savana 3500 Cargo","Savana 3500 Passenger","Sierra 1500 Crew Cab","Sierra 1500 Extended Cab","Sierra 1500 Regular Cab","Sierra 2500 HD Crew Cab","Sierra 2500 HD Extended Cab","Sierra 2500 HD Regular Cab","Sierra 3500 HD Crew Cab","Sierra 3500 HD Extended Cab","Sierra 3500 HD Regular Cab","Terrain","Yukon","Yukon XL 1500","Yukon XL 2500"],
	"Jeep": ["Compass","Grand Cherokee","Liberty","Patriot","Wrangler"],
	"Suzuki": ["Equator Crew Cab","Equator Extended Cab","Grand Vitara","Kizashi","SX4"],
	"Mazda": ["CX-5","CX-7","CX-9","MAZDA2","MAZDA3","MAZDA5","MAZDA6","Miata MX-5"],
	"Mitsubishi": ["Eclipse","Endeavor","Galant","i-MiEV","Lancer","Outlander","Outlander Sport"],
	"Nissan": ["370Z","Altima","Armada","cube","Frontier Crew Cab","Frontier King Cab","GT-R","JUKE","LEAF","Maxima","Murano","NV1500 Cargo","NV2500 HD Cargo","NV3500 HD Cargo","NV3500 HD Passenger","Pathfinder","Quest","Rogue","Sentra","Titan Crew Cab","Titan King Cab","Versa","Xterra"],
};
</script>
                                <form action="lms_post_api/contact" class="form" id="elite-order-form">
                                    <fieldset>
                                        <h2>¿NO ENCONTRASTE EL VEHICULO QUE BUSCAS?</h2>
                                        <p class="note">Escoge las opciones del vehículo que desea solicitar</p>
                                        <div class="select-holder">
                                            <select class="blue-select" id="xf_make" name="make">
                                                <option value="">Marca: *</option>
                                                <option value="Buick">Buick</option>
                                                <option value="Cadillac">Cadillac</option>
                                                <option value="Chevrolet">Chevrolet</option>
                                                <option value="Chrysler">Chrysler</option>
                                                <option value="Dodge">Dodge</option>
                                                <option value="Ford">Ford</option>
                                                <option value="GMC">GMC</option>
                                                <option value="Jeep">Jeep</option>
                                                <option value="Suzuki">Suzuki</option>
                                                <option value="Mazda">Mazda</option>
                                                <option value="Mitsubishi">Mitsubishi</option>
                                                <option value="Nissan">Nissan</option>
                                            </select>
                                        </div>
                                        <div class="select-holder">
                                            <select class="blue-select" id="xf_model" name="model">
                                                <option value="">Modelo: *</option>
                                            </select>
                                        </div>
                                        <div class="text"><input type="text" id="xf_color" name="color" value="Color: *" /></div>
                                        <div class="text"><input type="text" id="xf_message" name="message" value="Otro detalles: *" /></div>
                                        <div class="text"><input type="text" id="xf_name" name="name" value="Nombre: *" /></div>
                                        <div class="text"><input type="text" id="xf_telephone" name="telephone" value="Teléfono: *" /></div>
                                        <div class="text"><input type="text" id="xf_email" name="email" value="Email: *" /></div>
                                        <div class="note" id="xf_disclaimer"></div>
                                        <div class="row">
                                            <input type="submit" value="SOLICITAR" id="xf_submit" />
                                            <input type="reset" value="RESET" id="xf_close" />
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="notes">*May not represent actual vehicle.<br />(Options, colors, trim and body style may vary)</div>
                        </aside>
                        <section id="content">
                            <div class="tabs-area">
                                <div class="head-block">
                                    <div class="head-holder">
                                        <div class="pagination">
                                            <strong>Página:</strong>
<?php /*                                            <a href="#" class="prev-page">&lt;</a>*/ ?>
<?php
	// display small pagination
	echo $pagination_small;
?>
<?php /*                                            <a href="#" class="next-page">&gt;</a>*/ ?>
                                        </div>
                                        <ul class="tabset">
                                            <li><a href="#tab-gallery" class="tab gallery-tab active">GALLERIA</a></li>
                                            <li><a href="#tab-list" class="tab list-tab">LISTA</a></li>
                                        </ul>
                                    </div>
                                    <div class="sort-box">
                                        <nav class="sort-list">
                                            <strong>Ordenar por:</strong>
                                            <ul>
<?php
	// display sort html
	if ( isset( $sort_html ) && $sort_html != "" ) {
		echo str_replace( "<li>Ordenar por:</li>", '', $sort_html );
	}
?> 
                                            </ul>
                                        </nav>
<?php
	// display total count for results
	if ( $result_breakdown["total"] > 0 ) {
?>
                                        <span class="sort-result">(<?=$result_breakdown["start"]?> - <?=$result_breakdown["end"]?> de <?=$result_breakdown["total"]?> vehículos)</span>
<?php
	}
?>
                                    </div>
                                </div>
<?php
	// check to see if any results present
	if ( isset( $results ) && $results != false ) {
		// prepare vehicle results
		$i = 1;
		$veh_list = array();
		$veh_gall = array();
		foreach ( $results as $v ) {
			// create vehicle link
			$v_link = 'http://'.$_SERVER['SERVER_NAME'].'/'.getVehicleLink( $v, $mod_uri_slug, $cms_vars );
			
			// create vehicle title
			$v_label = getVehicleLabel( $v );
			
			// mask vin number (if enabled)
			$masked_vin = $v->VIN;
			if ( is_array( $cms_vars['vin_num_mask'] ) && $cms_vars['vin_num_mask']['enabled'] == 'yes' ) {
				$masked_vin = substr( $masked_vin, ( strlen( $masked_vin ) - $cms_vars['vin_num_mask']['show'] ) );
			}
			
			// parse color
			$v_color = implode( " ", array_slice( explode( " ", $v->COLOR ), 0, 2 ) );
			
			// translate vehicle attributes
			transalateVehicleAttr( $v );
			
			// save vehicle for later use
			$list_v =
'                                        <li>
                                            <table class="visual-box">
                                                <tr>
                                                    <td>
                                                        <div class="image-box">
                                                            <a href="'.$v_link.'" title="'.$v_label.'"><img src="'.getVehicleImagePath( $this->config, $v, "thumb", "thumb_" ).'" alt="'.$v_label.'" title="'.$v_label.'" /></a>
                                                            <a href="'.$v_link.'" title="'.$v_label.'" class="btn-more">more</a>
                                                        </div>
                                                        <h3><a href="'.$v_link.'" title="'.$v_label.'">'.$v->MAKE." ".$v->MODEL." ".$v->TRIM.'</a></h3>
                                                    </td>
                                                    <td class="col2">
                                                        <dl class="properties">
                                                            <dt>Color:</dt>
                                                            <dd>'.( ( $v_color == "" ) ? "&nbsp;" : $v_color ).'</dd>
                                                            <dt>Condición:</dt>
                                                            <dd>'.( ( $v->CONDITION == "" ) ? "&nbsp;" : $v->CONDITION ).'</dd>
                                                            <dt>Trans.:</dt>
                                                            <dd>'.( ( $v->TRANSMISSION == "" ) ? "&nbsp;" : $v->TRANSMISSION ).'</dd>
                                                            <dt>VIN:</dt>
                                                            <dd>'.( ( $masked_vin == "" ) ? "&nbsp;" : $masked_vin ).'</dd>
                                                        </dl>
                                                    </td>
                                                    <td class="col3"><em class="date">'.$v->YEAR.'</em></td>
                                                </tr>
                                            </table>
                                        </li>';
			$gall_v = 
'                                        <li>
                                            <div class="visual-box">
                                                <div class="heading">
                                                    <em class="date">'.$v->YEAR.'</em>
                                                    <h3><a href="'.$v_link.'" title="'.$v_label.'">'.$v->MAKE."<br />".$v->MODEL." ".$v->TRIM.'</a></h3>
                                                </div>
                                                <div class="image-box">
                                                    <a href="'.$v_link.'" title="'.$v_label.'"><img src="'.getVehicleImagePath( $this->config, $v, "thumb", "thumb_" ).'" alt="'.$v_label.'" title="'.$v_label.'" /></a>
                                                    <a href="'.$v_link.'" title="'.$v_label.'" class="btn-more">more</a>
                                                </div>
                                                <dl class="properties">
                                                    <dt>Color:</dt>
                                                    <dd>'.( ( $v_color == "" ) ? "&nbsp;" : $v_color ).'</dd>
                                                    <dt>Condición:</dt>
                                                    <dd>'.( ( $v->CONDITION == "" ) ? "&nbsp;" : $v->CONDITION ).'</dd>
                                                    <dt>Trans.:</dt>
                                                    <dd>'.( ( $v->TRANSMISSION == "" ) ? "&nbsp;" : $v->TRANSMISSION ).'</dd>
                                                    <dt>VIN:</dt>
                                                    <dd>'.( ( $masked_vin == "" ) ? "&nbsp;" : $masked_vin ).'</dd>
                                                </dl>
                                            </div>
                                        </li>
';
			array_push( $veh_list, $list_v );
			array_push( $veh_gall, $gall_v );
		}
?>
                                <div class="tab-content" id="tab-gallery">
                                    <ul class="product-list">
<?php
		// display gallery view
		foreach ( $veh_gall as $v ) {
			echo $v;
		}
?>
                                    </ul>
                                </div>
                                <div class="tab-content is-hidden" id="tab-list">
                                    <ul class="product-list line-list">
<?php
		// display list view
		foreach ( $veh_list as $v ) {
			echo $v;
		}
?>
                                    </ul>
                                </div>
<?php
	}
?>
                                <div class="pagination jq-bottom-pagination">
                                    <strong>Página:</strong>
<?php /*                                    <a href="#" class="prev-page">&lt;</a>*/ ?>
<?php
	// display bottom pagination
	echo $pagination;
?>
<?php /*                                    <a href="#" class="next-page">&gt;</a>*/ ?>
                                </div>
                            </div>
                        </section>
                    </div>
                    <a href="#wrapper" class="back-top">back-top</a>
                </div>
            </section>
{pyro:widget_fetcher:instance id="15"}
            
<? # JS corresponding to this page ?>
<script>
// Callbacks to execute on page load
var callbacks = [];

// Page configuration
callbacks[0] = function()
{
	// init tabs api (custom)
	tabs_api.init( { tab_selector: '.tab', tab_content: '.tab-content', tab_hidden: 'is-hidden', tab_active: 'active' } );
	
	// prepare filters form
	$( '#view-all-results', 'form#filter-form' ).click(
		function( e )
		{
			// clear form and submit empty form
			$( 'select', 'form#filter-form' ).each(
				function()
				{
					this.selectedIndex = 0;
				} );
			$( 'form#filter-form' ).submit();
			
			// stop defualt behavior
			e.preventDefault();
		} );
};

// Fix rollover icon
callbacks[1] = function() {
	// gallery view
	anchorApi.addToAnchors( "#tab-gallery .heading h3 a", "parentParentNextSecondChild", "activateEnlargeIconHover" );
    anchorApi.addToAnchors( "#tab-gallery .image-box a:not( .btn-more )", "next", "activateEnlargeIconHover" );
	
	// list view
	anchorApi.addToAnchors( "#tab-list h3 a", "parentPreviousSecondChild", "activateEnlargeIconHover" );
	anchorApi.addToAnchors( "#tab-list .image-box a:not( .btn-more )", "next", "activateEnlargeIconHover" );
	
	// used vehicle widget
	anchorApi.addToAnchors( ".js-used-widget .visual-box .heading h3 a", "parentParentNextNext", "activateEnlargeIconHover" );
	anchorApi.addToAnchors( ".js-used-widget .visual-box > a:not( .btn-more )", "next", "activateEnlargeIconHover" );
};

// Fix top pagination
callbacks[2] = function() {
	// select previous and next link, if any
	var prev = $( ".head-block .pagination ul.paging .prev" ).remove();
	var next = $( ".head-block .pagination ul.paging .next" ).remove();
	var hasPagination = $( ".head-block .pagination ul.paging" );
	
	if ( typeof hasPagination !== "undefined" && typeof prev !== "undefined" ) {
		prev = $( prev.html() ).addClass( 'prev-page' );
		$( hasPagination ).before( prev );
	}
	if ( typeof hasPagination !== "undefined" && typeof next !== "undefined" ) {
		next = $( next.html() ).addClass( 'next-page' );
		$( hasPagination ).before( next );
	}
};

// Fix bottom pagination
callbacks[3] = function() {
	// select previous and next link, if any
	var prev = $( ".jq-bottom-pagination .paging .prev" ).remove();
	var next = $( ".jq-bottom-pagination .paging .next" ).remove();
	var hasPagination = $( ".jq-bottom-pagination .paging" );
	
	if ( typeof hasPagination !== "undefined" && typeof prev !== "undefined" ) {
		prev = $( prev.html() ).addClass( 'prev-page' );
		$( hasPagination ).before( prev );
	}
	if ( typeof hasPagination !== "undefined" && typeof next !== "undefined" ) {
		next = $( next.html() ).addClass( 'next-page' );
		$( hasPagination ).before( next );
	}
};

callbacks[4] = function() {
	// event: select brand to show models
	$( "#elite-order-form #xf_make" ).change(
		function() {
			// variables required
			var newMake = $( this ).val();	// save new make
			var targetSelect = $( "#elite-order-form #xf_model" ).get( 0 );
			
			// empty list
			targetSelect.options.length = 1;
				
			// add models
			if ( typeof models[newMake] !== "undefined" ) {
				// add new ones
				$.each( models[newMake], function( key, value ) {
					$( targetSelect ).append( $( "<option></option>" ).attr( "value", value ).text( value ) );
				} );
			}
			
			// remake forms
       		jcf.customForms.updateElement( "xf_model" );
		} );
	
	// event: enter any field
	$( "#elite-order-form input[type=text]" ).focus(
		function( e ) {
			if ( this.value == this.defaultValue ) {
				this.value = "";	
			}
		} ).blur(
		function( e ) {
			if ( this.value == "" ) {
				this.value = this.defaultValue;	
			}
		} );
		
	// init elite form api
	xform_API.init();
};

// Execute all callbacks
cms_API.onJQReady( callbacks );
</script>