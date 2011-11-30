			<!-- start column left-->
			<div class="column_left">
            
                <!-- start box top -->
                <div class="box_top_left clearfix">
                	<h2 class="inventory_new">Detalles del Veh&iacute;culo</h2>
                	<div class="breadcrumb"><a href="<?=$inventory_url?>">Inventario</a> &raquo; <?=$bread_crumb_extras?> <?=$seo_vehicle_label?></div>
                
                    <!-- start social media -->
                    {pyro:widgets:instance id="27"} <!-- instance 27: Add This Plugin -->
                    <!-- end social media -->
                
                </div>
                <!--end box top-->
                
                <!-- start content -->
                <div class="content">
                	
                    <div class="title_detail"><h1><?=$seo_vehicle_label?></h1></div>
                    
                    <div class="box_detail_2">
                        <div class="thumb_med">
							<a href="<?=$IMAGE_WEB_PATH.$v->IMAGE?>" title="<?=$seo_image_label?>"><img src="<?=$IMAGE_MED_PATH.$v->IMAGE?>" title="<?=$seo_image_label?>" alt="<?=$seo_image_label?>" /></a>
                        </div>
                        <div class="thumb_med_tools">
                        	<div class="previous"> <a href="#"> </a></div>
                        	<div class="next"> <a href="#"> </a></div>
                        </div>
                    </div>
                    
                    <div class="box_detail_1">
                        <ul>
                        	<li class="price"><strong>Precio:</strong> <span><?=$v_price['price']?></span></li>
                            <li><strong>Tel&eacute;fono:</strong> <a>{pyro:variables:official_telephone}</a></li>
                            <li><strong>A&ntilde;o:</strong> <?=$v->YEAR?></li>
                            <li><strong>Color:</strong> <?=$v->COLOR?></li>
                            <li><strong>Condici&oacute;n:</strong> <?=$v->CONDITION?></li>
                            <li><strong>Transmisi&oacute;n:</strong> <?=$v->TRANSMISSION?></li>
                            <li><strong>VIN:</strong> <?=$v->VIN?></li>
						<?
                            # Display Milleage if used vehicle
                            if( $v->CONDITION != 'Nuevo' && $v->MILEAGE > 0 ):
                            ?>
                        	<li><strong>Millaje:</strong> <?=number_format( $v->MILEAGE, 0, '', ',' )?></li>
                            <?
                            endif;
                            # End Display Milleage if used vehicle
                        ?>
                        </ul>
					</div>
                    
					<div class="box_detail_3">
                        <?
							# Display Images( in thumbnail mode ), if any
							if( $images != false ):
								foreach( $images as $i ):
						?>
							<div class="thumb_tiny"><a href="#<?=$IMAGE_MED_PATH.$i->IMAGE_NAME?>" title="<?=$seo_image_label?>"><img src="<?=$IMAGE_TINY_PATH.$i->IMAGE_NAME?>" alt="<?=$seo_image_label?>" title="<?=$seo_image_label?>" /></a></div>
						<?
								endforeach;
								?><div class="clear"></div><?
							endif;	// End Display Images
						?>
					</div>
                    <div class="clear"></div>
                    
                    <!-- box detail 4 tabs -->
                    <div class="box_tabs">
                        <ul class="tabs clearfix">
                            <li class="active"><a href="#jq_contact_box">Contactar</a></li>
                            <? if( $v->DESCRIPTION != "not yet available" && $v->DESCRIPTION != "" ): ?><li><a href="#jq_description_box">Descripci&oacute;n</a></li><? endif; ?>
                            <? if( $v->FEATURES != "" ): ?><li><a href="#jq_features_box">Especificaciones</a></li><? endif; ?>
                        </ul>
                    </div>
                    <!-- end box detail 4 tabs -->
                    
                    <!-- box detail 4 contactar -->
                    <div class="box_detail_4" id="jq_contact_box">
                    	<!-- start reservation form -->
                    	{pyro:mdv_forms:reservation form_suffix="_frm_1" client_id="<?=$v->CLIENT_ID?>" lead_type="reservation" veh_id="<?=$v->VEH_ID?>" veh_vin="<?=$v->VIN?>" veh_price="<?=$v_price['price']?>" vehicle="<?=$seo_vehicle_label?>"}
                        <!-- end reservation form -->
                        
                        <!--detail address-->
                        <div class="box_detail_address">
                            Este veh&iacute;culo est&aacute; ubicado en:<br /><br>
                        <?
                            // Display Address Dynamically
                            echo $cms_vars['lot_addresses'][$v->CLIENT_ID];
                        ?>
                        </div>
                        <!--end detail address-->
                        
                        <!--detail map-->
                        <div class="box_detail_map">
                        	<div class="image_location_1"><a href="{pyro:url:site}contactenos"></a></div>
                        </div>
                        <!-- end detail map-->
                        
                        <div class="clear"></div>
                    
                    </div>
                    <!-- end box detail 4 contactar -->
                    
                    <? if( $v->DESCRIPTION != "not yet available" && $v->DESCRIPTION != "" ): ?>
                    <!-- box detail 4 description -->
                    <div class="box_detail_4 jq_hide" id="jq_description_box">
                        <?=$v->DESCRIPTION?>
                        
                        <!-- clear -->
                        <div class="clear"></div>
                    </div>
                    <!-- end detail 4 description -->
                    <? endif; ?>
                    
                    <? if( $v->FEATURES != "" ): ?>
                    <!-- box detail 4 features -->
                    <div class="box_detail_4 jq_hide" id="jq_features_box">
                        <?=htmlspecialchars_decode( $v->FEATURES )?>
                        
                        <!-- clear -->
                        <div class="clear"></div>
                    </div>
                    <!-- end box detail 4 features -->
                    <? endif; ?>
                
                </div>
                <!-- end content -->
            
            </div>
            <!-- end column left-->
            
            <!-- start column right-->
            <div class="column_right">
            
                <!-- strat mod inventario similares-->
                <div class="box_similares clearfix">
                    <h2 class="related">Otros Veh&iacute;culos</h2>
                    
                {pyro:inventory_fetcher:similar veh_id="<?=$v->VEH_ID?>" make="<?=$v->MAKE?>" model="<?=$v->MODEL?>" type="<?=$v->TYPE?>" limit="<?=$max_similar?>"}
                    <!-- result -->
                    <div class="box_similares_result clearfix">
                        <div class="box_similares_thumb"><a href="{pyro:VEH_URL}" title="{pyro:SEO_VEH_LABEL}"><img src="{pyro:IMAGE_W_PATH}" alt="{pyro:SEO_VEH_LABEL}" title="{pyro:SEO_VEH_LABEL}" /></a></div>
						<ul>
                            <li class="box_similares_title"><a href="{pyro:VEH_URL}" title="{pyro:SEO_VEH_LABEL}">{pyro:MAKE} {pyro:MODEL} {pyro:TRIM}</a></li>
                            <li class="box_similares_year"><strong>A&ntilde;o:</strong> {pyro:YEAR}</li>
                        </ul>
                    </div>
                    <!--  end result -->
				{/pyro:inventory_fetcher:similar}
                
                </div>
                <!-- end mod inventario similares-->
                
                <!-- start ads right -->
                <div class="box_ads_right">
                	{pyro:widget_fetcher:area slug="vehicle-sidebar-ads"}
				</div>
                <!-- end ads right -->
            
            </div>
            <!-- end column right-->
            
			<!-- start box column center -->
			<div id="column_center" class="clearfix">
            
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
	callbacks[0] = vehicle_pg_API.initCallback;
	
	// Execute all callbacks
	cms_API.onJQReady( callbacks );
	
</script>