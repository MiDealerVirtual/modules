			<!-- start box column center -->
			<div id="column_center" class="clearfix">
				<!-- start top box center -->
                <div class="box_top_center clearfix">
					<h2 class="<?=( isset( $_GET['conditions'] ) && $_GET['conditions'] == "used" ) ? "inventory_used" : "inventory_new" ?>">Inventario<? if( isset( $_GET['conditions'] ) && $_GET['conditions'] == "used" ): echo " Usado"; elseif( isset( $_GET['conditions'] ) && $_GET['conditions'] == "new" ): echo " Nuevo"; endif; ?></h2>
                    <?
						// Filters and Sorting Options
						$this->load->view( 'includes/top_filters' );
					?>
				</div>
				<!-- end top box center-->
                
                <!-- start content -->
                <div class="content">
<?
	# Display filter alert
	if( $this->mdv_filters->detectMismatch() ):
	?>
                    <!-- alert -->
                    <div class="alert_1">
                        No encontramos vechículos con esas especificaciones.
                        <br />
                        Intente aplicando menos filtros.
                    </div>
                    <!-- alert -->
	<?
	endif;
?>                
                
					<!-- start squared / list -->
					<div class="squared clearfix" id="jq_inventory_view">
<?
	if( isset( $results ) && $results != false )
	{
		$i = 1;
		foreach( $results as $v )
		{
			// create vehicle link
			$v_link = getVehicleLink( $v, $mod_uri_slug, $cms_vars );
			
			// create vehicle title
			$v_label = getVehicleLabel( $v );
?>
                        <!-- result -->
                        <div class="box_result clearfix">
                            <!-- start thumb -->
                            <div class="thumbs">
                                <a href="<?=$v_link?>" title="<?=$v_label?>"><img src="<?=getVehicleImagePath( $this->config, $v, "thumb", "thumb_" )?>" alt="<?=$v_label?>" title="<?=$v_label?>" /></a>
                            </div>
                            <!-- end thumb -->
                            
                            <!-- start info -->
                            <div class="info">
                                <div class="result_title"><a href="<?=$v_link?>" title="<?=$v_label?>"><?=$v_label?></a></div>
                                <ul>
                                    <li><strong>A&ntilde;o:</strong> <?=$v->YEAR?></li>
                                    <li><strong>Color:</strong> <?=$v->COLOR?></li>
                                </ul>
                                <ul>
                                    <li><strong>Condici&oacute;n:</strong> <?=transalateVehicleAttr( "CONDITION ", $v->CONDITION )?></li>
                                    <li><strong>Transmisi&oacute;n: </strong> <?=transalateVehicleAttr( "TRANSMISSION ", $v->TRANSMISSION )?></li>
                                </ul>
                                <ul>
                                    <li><strong>VIN:</strong><?=$v->VIN?></li>
								<? if( $v->MILEAGE > 0 ) : ?>
                                    <li><strong>Millaje:</strong> <?=translateNumber( $v->MILEAGE, 0 )?></li>
                                <? else: ?>
                                    <li>&nbsp;</li>
                                <? endif; ?>
                                </ul>
                            </div>
                            <!-- end info -->
                            
                            <!-- start price/message -->
                            <?=createVehicleMiniDetails( $v )?>
                            <!-- end price/message -->
                            
                            <!-- start details -->
                            <div class="details">
                                <div class="btn_3"><a href="<?=$v_link?>" title="<?=$v_label?>">ver</a></div>
                            </div>
                            <!-- end details -->
                        </div>
                        <!--  end result -->
<?
		}
	}
?>
                    </div>
                    <!-- end squared / list -->
<?
	# Only display links if any are present
	if( isset( $pagination ) && $pagination != false ):
		echo str_replace( "<li>P&aacute;gina: </li>", "", $pagination );	// Remove title
	endif;	// End Only display links if any present
?>
                    
                </div>
                <!-- end content -->
                
                <!-- bottom ads -->
                <div class="box_ads">
	                {pyro:widget_fetcher:area slug="homepage-ads"}	
                </div>
                <!-- end bottom ads -->
                
			</div>
			<!-- end box column center -->
            
<? # JS corresponding to this page ?>
<script>
	// Callbacks to execute on page load
	var callbacks = [];
	
	// Page & Reservation Form configuration
	callbacks[0] = inventory_API.initCallback;
	
	// Execute all callbacks
	cms_API.onJQReady( callbacks );
	
</script>