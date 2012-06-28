		<div class="m1">
			<div class="m2">
				<nav>
					<ul class="breadcrumbs">
						<li><strong><a href="<?=$inventory_url?>" title="Inventario de Vehículos de {pyro:variables:dealer_inc_name} | {pyro:variables:dealer_inc_name} {pyro:variables:page_title_seo_suffix}">Inventario</a></strong></li>
						<li><strong><?=$seo_vehicle_label?></strong></li>
					</ul>
				</nav>
				<h2><?=str_replace( " ".$v->YEAR, "", $seo_vehicle_label )?></h2>
				<div class="content-holder">
					<section id="content">
						<div class="c1">
							<section class="model-block">
								<div class="block">
									<em class="date"><?=$v->YEAR?></em>
									<ul class="specs">
										<li>
											<dl>
												<dt><strong>Precio:</strong></dt>
												<dd><?=$v_price['price']?></dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><strong>Teléfono:</strong></dt>
												<dd>{pyro:variables:official_telephone}</dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><strong>Año:</strong></dt>
												<dd><?=$v->YEAR?></dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><strong>Color:</strong></dt>
												<dd><?=$v->COLOR?></dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><strong>Condición:</strong></dt>
												<dd><?=$v->CONDITION?></dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><strong>Transmisión:</strong></dt>
												<dd><?=$v->TRANSMISSION?></dd>
											</dl>
										</li>
										<li>
											<dl>
												<dt><strong>VIN:</strong></dt>
												<dd><?=$masked_vin?></dd>
											</dl>
										</li>
									</ul>
								</div>
								<div class="gallery">
									<div class="holder">
										<ul>
<?
	# Display Images( in thumbnail mode ), if any
	if( $images != false ):
		$img_index = 0;
		foreach( $images as $i ):
?>
											<li<?=( $img_index == 0 )?' class="active"':''; ?>><a href="<?=$IMAGE_WEB_PATH.$i->IMAGE_NAME?>" title="<?=$seo_image_label?>" rel="lightbox"><img src="<?=$IMAGE_MED_PATH.$i->IMAGE_NAME?>" alt="<?=$seo_image_label?>" title="<?=$seo_image_label?>" /></a></li>
<?
		endforeach;
	endif;	// End Display Images
?>
										</ul>
									</div>
									<div class="pagination">
										<ul>
<?
	# Display Images( in thumbnail mode ), if any
	if( $images != false ):
		$img_index = 0;
		foreach( $images as $i ):
?>
											<li><a href="<?=$IMAGE_MED_PATH.$i->IMAGE_NAME?>" title="<?=$seo_image_label?>"><img src="<?=$IMAGE_MED_PATH.$i->IMAGE_NAME?>" alt="<?=$seo_image_label?>" title="<?=$seo_image_label?>" /></a></li>
<?
		endforeach;
	endif;	// End Display Images
?>
										</ul>
									</div>
								</div>
							</section>
							<div class="tabs-holder">
								<nav>
									<ul class="tabset">
										<li><a href="#tab-1" class="tab active">ME INTERESA</a></li>
<?
	// hide features tab if no features present
	if( $v->FEATURES != '' ):
?>
										<li><a href="#tab-2" class="tab">ESPECIFICACIONES</a></li>
<?
	endif;
?>
									</ul>
								</nav>
								<div class="tab-content" id="tab-1">
									<form action="lms_post_api/reservation" class="information-form information-form02" method="post">
										<input type="hidden" name="form_suffix" value="_frm_1" />
                                                  <input type="hidden" id="lms_client_id_frm_1" name="cid" value="<?=( isset( $cms_vars['redirect_client_id'] ) && $cms_vars['redirect_client_id'] != '' ) ? $cms_vars['redirect_client_id'] : $v->CLIENT_ID?>" />
										<input type="hidden" id="lms_lead_type_frm_1" name="lead_type" value="reservation" />
										<input type="hidden" id="lms_veh_id_frm_1" name="veh_id" value="<?=$v->VEH_ID?>" />
										<input type="hidden" id="lms_veh_vin_frm_1" name="veh_vin" value="<?=$v->VIN?>" />
										<input type="hidden" id="lms_vehicle_frm_1" name="vehicle" value="<?=$seo_vehicle_label?>" />
										<input type="hidden" id="lms_veh_price_frm_1" name="veh_price" value="<?=$v_price['price']?>" />
                                                  <input type="hidden" id="lms_veh_subject_frm_1" name="subject" value="Estoy interesado en este vehículo" />
										<fieldset>
											<section class="block">
												<div class="columns">
													<div class="col">
														<div class="holder">
															<label for="lms_fname_frm_1">Nombre: <span>*</span></label>
															<div class="row">
																<input type="text" placeholder="Su nombre aquí" id="lms_fname_frm_1" name="fname" class="field-required">
															</div>
														</div>
														<div class="holder">
															<label for="lms_lname_frm_1">Apellido: <span>*</span></label>
															<div class="row">
																<input type="text" placeholder="Su apellido aquí" id="lms_lname_frm_1" name="lname" class="field-required">
															</div>
														</div>
														<div class="holder">
															<label for="lms_telephone_frm_1">Número telefónico: <span>*</span></label>
															<div class="row">
																<input type="text" placeholder="Su teléfono aquí" id="lms_telephone_frm_1" name="telephone" class="is-telephone field-required">
															</div>
														</div>
														<div class="holder">
															<label for="lms_email_frm_1">Correo electrónico: <span>*</span></label>
															<div class="row">
																<input type="text" placeholder="Su email aquí" id="lms_email_frm_1" name="email" class="field-required">
															</div>
														</div>
														<div class="holder">
															<label for="lms_message_frm_1">Mensaje / Pregunta:</label>
															<div class="row">
																<textarea cols="20" rows="5" id="lms_message_frm_1" name="message" placeholder="Su mensaje aquí"></textarea>
															</div>
														</div>
														<div class="submit-holder">
															<div class="info"><span>*</span> = Requerido</div>
															<input type="submit" value="DETALLES">
														</div>
													</div>
													<div class="col">
														<dl>
															<dt>Vehículo interesado:</dt>
															<dd><?=$seo_vehicle_label?></dd>
														</dl>
														<dl>
															<dt>Este vehículo está ubicado en:</dt>
															<dd>
																<address>
<?
   // Display Address Dynamically
   echo $cms_vars['lot_addresses'][$v->CLIENT_ID];
?>
																</address>
															</dd>
														</dl>
														<dl>
															<dt>Precio del vehículo:</dt>
															<dd><?=$v_price['price']?></dd>
														</dl>
														<section class="map">
															<a href="{pyro:url:site}<?=$cms_vars['contact_map_url']?>">{pyro:theme:image file="img-map.jpg" alt="image description"}</a>
														</section>
													</div>
												</div>
											</section>
										</fieldset>
									</form>
								</div>
<?
	// hide features tab if no features present
	if( $v->FEATURES != '' ):
?>
								<div class="tab-content tab-hidden" id="tab-2">
									<section class="specs-holder">
										<div class="columns">
											<div class="col">
<?
	// get disclaimer and move it
	$cutout_disclaimer = array( 'start' => strpos( $v->FEATURES, '<div style="clear:both; width:100%; padding-top:50px;"><p style="font-size:11px; line-height:11px;">' ), 'stop' => ( strpos( $v->FEATURES, '</p></div>' ) + 10 ) );
	$cutout_disclaimer = substr( $v->FEATURES, $cutout_disclaimer['start'], ( $cutout_disclaimer['stop'] - $cutout_disclaimer['start'] ) );
	$v->FEATURES = str_replace( $cutout_disclaimer, "", $v->FEATURES );
	
	// format features
	$feats = str_replace( '<div class="detail_inner_box"><p><strong>', '<h3>', $v->FEATURES );
	$feats = str_replace( '</strong></p><ul>', '</h3><ul class="marked-list">', $feats );
	$feats = str_replace( '</li><p><strong>', '</li></ul><h3>', $feats );
	$feats = str_replace( '</strong></p><li>', '</h3><ul class="marked-list"><li>', $feats );
	$feats = str_replace( '</div><h3>', '</div><div class="col"><h3>', $feats );
	
	// display newlye formated features data
	echo htmlspecialchars_decode( $feats );
?>
										</div>
										<div class="description-info">
<?
	// format disclaimer and display
	$cutout_disclaimer = str_replace( '<div style="clear:both; width:100%; padding-top:50px;">', '', $cutout_disclaimer );
	$cutout_disclaimer = str_replace( '</p></div>', '', $cutout_disclaimer );
	$cutout_disclaimer = str_replace( '<p style="font-size:11px; line-height:11px;">', '', $cutout_disclaimer );
	$cutout_disclaimer = explode( "</p>", $cutout_disclaimer );
	echo "<p>".implode( "</p><p>", $cutout_disclaimer )."</p>";
?>
										</div>
									</section>
								</div>
<?
	endif;
	// end hide features tab
?>
							</div>
						</div>
					</section>
					<section id="sidebar">
						<div class="inventory">
							<h3>SIMLARES</h3>
							<ul class="items-list">
{pyro:inventory_fetcher:similar veh_id="<?=$v->VEH_ID?>" make="<?=$v->MAKE?>" model="<?=$v->MODEL?>" type="<?=$v->TYPE?>" limit="<?=$max_similar?>"}
								<!-- suggested vehicle result -->
								<li>
									<h3><a href="{pyro:VEH_URL}">{pyro:SIMPLE_VEH_LABEL}</a></h3>
									<div class="specs">
										<dl>
											<dt><strong>Año:</strong></dt>
											<dd>{pyro:YEAR}</dd>
											<dt><strong>Color:</strong></dt>
											<dd class="limit-color">{pyro:COLOR}</dd>
										</dl>
										<dl>
											<dt><strong>Condición:</strong></dt>
											<dd>{pyro:CONDITION}</dd>
											<dt><strong>Trans.:</strong></dt>
											<dd>{pyro:TRANSMISSION}</dd>
										</dl>
									</div>
									<div class="box">
										<a href="{pyro:VEH_URL}" title="{pyro:SEO_VEH_LABEL}"><img src="{pyro:IMAGE_W_PATH}" alt="{pyro:SEO_VEH_LABEL}" title="{pyro:SEO_VEH_LABEL}" /></a>
										<div class="box">
											<strong>{pyro:YEAR}</strong>
											<a href="{pyro:VEH_URL}">DETALLES</a>
										</div>
									</div>
								</li>
								<!-- /suggested vehicle result -->

{/pyro:inventory_fetcher:similar}
							</ul>
						</div>
					</section>
				</div>
			</div>
		</div>

<!-- load fancybox -->
{pyro:minifier:remote_theme_files alt_js_dir="p2h/fancybox2" js_files="jquery.fancybox.js,jquery.fancybox.pack.js,jquery.fancybox-thumbs.js,jquery.fancybox-buttons.js,jquery.mousewheel-3.0.6.pack.js,jquery.easing-1.3.pack.js?v={pyro:variables:file_version_number}" alt_css_dir="p2h/fancybox2" css_files="jquery.fancybox-buttons.css,jquery.fancybox.css,jquery.fancybox-thumbs.css?v={pyro:variables:file_version_number}"}
<!-- /load fancybox -->

<!-- work page's javascript -->
<script>
// Callbacks to execute on page load
var callbacks = [];

// Page configuration
callbacks[0] = function()
{
	// initiate fancybox2
	$( 'a[rel=lightbox]' ).fancybox( {
		openEffect:'none',
		closeEffect:'none',
		prevEffect:'none',
		nextEffect:'none'
	} );
	
	// init tabs api
	tabs_api.init();
	
	// intiate form api
	forms_api.init();
};

// Execute all callbacks
cms_API.onJQReady( callbacks );
</script>
<!-- /work page's javascript -->