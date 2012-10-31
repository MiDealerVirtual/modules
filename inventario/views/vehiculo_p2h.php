<?php
	// display brand header image
	$brands = array( "buick", "cadillac", "chevrolet", "chrysler", "dodge", "ford", "gmc", "jeep", "suzuki", "mazda", "mitsubishi", "nissan" );
	$brand_to_use = ( in_array( strtolower( $v->MAKE ), $brands ) ) ? strtolower( $v->MAKE ) : "used-generic";
?>
            <section class="visual">
                <div class="visual-holder">
                    <div class="visual-frame">
                        <div class="photo vehicle-detail-page">
                            {pyro:theme:image file="img-brand-bg-<?=$brand_to_use?>.jpg" alt="<?=$seo_vehicle_label?>"}
                            <div class="text-box">
                                <div class="text-holder">
                                    <h1>INVENTARIO VIRTUAL</h1>
                                </div>
                            </div>
                            <span class="overlay"></span>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content-section">
                <div class="holder">
                    <div class="two-columns">
                        <div class="column same-height">
                            <div class="gallery-block2">
                                <div class="gmask">
                                    <ul>
<?php
	// display images ( in web mode )
	if ( $images != false ) {
		$img_index = 0;
		foreach ( $images as $i ) {
?>
                                        <li>
                                            <a href="<?=$IMAGE_WEB_PATH.$i->IMAGE_NAME?>" title="<?=$seo_image_label?>" rel="lightbox">
                                                <img src="<?=$IMAGE_WEB_PATH.$i->IMAGE_NAME?>" alt="<?=$seo_image_label?>" title="<?=$seo_image_label?>" />
                                                <span class="btn-more">more</span>
                                            </a>
                                        </li>
<?php
		}
	}
?>
                                    </ul>
                                </div>
<?php
	// display images ( in web thumbnail )
	if ( $images != false && count( $images ) > 1 ) {
?>
                                <div class="gallery-nav">
                                    <a href="#" class="btn-prev">previous</a>
                                    <a href="#" class="btn-next">next</a>
                                    <div class="thumbs-list">
                                        <ul>
<?php
		$img_index = 0;
		foreach ( $images as $i ) {
?>
                                            <li>
                                                <a href="<?=$IMAGE_WEB_PATH.$i->IMAGE_NAME?>" title="<?=$seo_image_label?>">
                                                    <img src="<?=$IMAGE_THUMB_PATH.$i->IMAGE_NAME?>" alt="<?=$seo_image_label?>" title="<?=$seo_image_label?>" />
                                                </a>
                                            </li>
<?php
		}
?>
                                        </ul>
                                    </div>
                                </div>
<?php
	}
?>
<?php
/*                                
                                <ul class="social">
                                    <li><a href="#" class="facebook">facebook</a></li>
                                    <li><a href="#" class="twitter">twitter</a></li>
                                    <li><a href="#" class="mail">mail</a></li>
                                    <li><a href="#" class="print">print</a></li>
                                    <li><a href="#" class="share">share</a></li>
                                </ul>*/
?>
                                <ul class="menu">
                                    <li><a href="#" class="icon pdf-icon">pdf-icon</a></li>
                                    <li><a href="#" class="icon icon-2">icon</a></li>
                                    <li><a href="#" class="icon icon-3">icon</a></li>
                                    <li><a href="#" class="icon icon-4">icon</a></li>
                                </ul>
                            </div>
                            <form class="form contact-form">
                                <input type="hidden" name="form_suffix" value="_frm_1" />
                                <input type="hidden" id="lms_client_id_frm_1" name="cid" value="<?=( isset( $cms_vars['redirect_client_id'] ) && $cms_vars['redirect_client_id'] != '' ) ? $cms_vars['redirect_client_id'] : $v->CLIENT_ID?>" />
                                <input type="hidden" id="lms_lead_type_frm_1" name="lead_type" value="reservation" />
                                <input type="hidden" id="lms_veh_id_frm_1" name="veh_id" value="<?=$v->VEH_ID?>" />
                                <input type="hidden" id="lms_veh_vin_frm_1" name="veh_vin" value="<?=$v->VIN?>" />
                                <input type="hidden" id="lms_vehicle_frm_1" name="vehicle" value="<?=$seo_vehicle_label?>" />
                                <input type="hidden" id="lms_veh_price_frm_1" name="veh_price" value="<?=$v_price['price']?>" />
                                <input type="hidden" id="lms_veh_subject_frm_1" name="subject" value="Estoy interesado en este vehículo" />
                                <fieldset>
                                    <h2>SOLICITAR PRECIO</h2>
                                    <div class="row">
                                        <div class="row-col">
                                            <label for="lms_fname_frm_1">Nombre: <span class="mark">*</span></label>
                                            <div class="text"><input type="text" placeholder="Su nombre aquí" id="lms_fname_frm_1" name="fname" class="field-required"></div>
                                        </div>
                                        <div class="row-col">
                                            <label for="lms_lname_frm_1">Apellido: <span class="mark">*</span></label>
                                            <div class="text"><input type="text" placeholder="Su apellido aquí" id="lms_lname_frm_1" name="lname" class="field-required"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row-col">
                                            <label for="lms_telephone_frm_1">Número telefónico: <span class="mark">*</span></label>
                                            <div class="text"><input type="text" placeholder="Su teléfono aquí" id="lms_telephone_frm_1" name="telephone" class="is-telephone field-required"></div>
                                        </div>
                                        <div class="row-col">
                                            <label for="lms_email_frm_1">Correo electrónico: <span class="mark">*</span></label>
                                            <div class="text"><input type="text" placeholder="Su email aquí" id="lms_email_frm_1" name="email" class="field-required"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row-col">
                                            <label>Vehículo interesado:</label>
                                            <p><?=$seo_vehicle_label?></p>
                                        </div>
                                        <div class="row-col">
                                            <label>Precio del vehículo:</label>
                                            <p><?=$v_price['price']?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="lms_message_frm_1">Mensaje / Pregunta:</label>
                                        <div class="area"><textarea cols="30" rows="10" id="lms_message_frm_1" name="message" placeholder="Su mensaje aquí"></textarea></div>
                                    </div>
                                    <div class="row">
                                        <input type="submit" value="ENVIAR" />
                                        <input type="reset" value="RESET" />
                                    </div>
                                    <div class="address-block">
                                        <h3>Vehículo Ubicado en:</h3>
                                        <address>{pyro:variables:lot_addresses}</address>
                                        <div class="map">
                                            <a href="{pyro:url:site}<?=$cms_vars['contact_map_url']?>">{pyro:theme:image file="map.png"}</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="products-box">
                                <h2>VEHÍCULOS SIMILARES</h2>
                                <ul class="product-list line-list js-similar-widget">
{pyro:inventory_fetcher:similar veh_id="<?=$v->VEH_ID?>" make="<?=$v->MAKE?>" model="<?=$v->MODEL?>" type="<?=$v->TYPE?>" limit="<?=$max_similar?>"}
                                    <li>
                                        <table class="visual-box">
                                            <tr>
                                                <td>
                                                    <div class="image-box">
                                                        <a href="{pyro:VEH_URL}" title="{pyro:SEO_VEH_LABEL}"><img src="{pyro:IMAGE_W_PATH}" alt="{pyro:SEO_VEH_LABEL}" title="{pyro:SEO_VEH_LABEL}" /></a>
                                                        <a href="{pyro:VEH_URL}" class="btn-more">more</a>
                                                    </div>
                                                    <h3><a href="{pyro:VEH_URL}">{pyro:MAKE}<br />{pyro:MODEL} {pyro:TRIM}</a></h3>
                                                </td>
                                                <td class="col2">
                                                    <dl class="properties">
                                                        <dt>Año:</dt>
                                                        <dd>{pyro:YEAR}&nbsp;</dd>
                                                        <dt>Color:</dt>
                                                        <dd>{pyro:COLOR}&nbsp;</dd>
                                                        <dt>Condición:</dt>
                                                        <dd>{if '{pyro:CONDITION}' == 'new'}Nuevo{else}Usado{/if}&nbsp;</dd>
                                                        <dt>Trans.:</dt>
                                                        <dd>{if '{pyro:TRANSMISSION}' == 'automatic'}Automática{else}Manual{/if}&nbsp;</dd>
                                                    </dl>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
{/pyro:inventory_fetcher:similar}
                                </ul>
                            </div>
                            <div class="note">
                                <p>* Es posible que el precio publicado varíe en el local. Los precios desplegado en gamas abarcan todas las posibles combinaciones de especificaciones del modelo, no solo de la unidad publicada. Nos reservamos el derecho de modificar los precios sin previo aviso.</p>
                                <p>** Es posible que algunos de los equipamientos ilustrados o descritos no se provean como equipamiento estándar y pueden tener un costo adicional. Nos reservamos el derecho a cambiar las especificaciones y el equipamiento sin previo aviso.</p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="info same-height">
                                <div class="property-list">
                                    <div class="heading">
                                        <h1><?=$v->YEAR?><br/><?=$v->MAKE?><br/><?=$v->MODEL.( ( $v->TRIM != "" ) ? " ".$v->TRIM : "" )?></h1>
                                    </div>
                                    <dl>
                                        <dt>Precio:</dt>
                                        <dd><?=$v_price['price']?></dd>
                                        <dt>Teléfono:</dt>
                                        <dd class="even">{pyro:variables:official_telephone}</dd>
                                        <dt>Año:</dt>
                                        <dd><?=( $v->YEAR != "" ) ? $v->YEAR : "&nbsp;" ?></dd>
                                        <dt>Color:</dt>
                                        <dd class="even"><?=( $v->COLOR != "" ) ? $v->COLOR : "&nbsp;" ?></dd>
                                        <dt>Condición:</dt>
                                        <dd><?=( $v->TRANSMISSION != "" ) ? $v->CONDITION : "&nbsp;" ?></dd>
                                        <dt>Transmisión:</dt>
                                        <dd class="even"><?=( $v->TRANSMISSION != "" ) ? $v->TRANSMISSION : "&nbsp;" ?></dd>
                                        <dt>VIN:</dt>
                                        <dd><?=( $masked_vin != "" ) ? $masked_vin : "&nbsp;" ?></dd>
                                    </dl>
<?php
	// display features (if present)
	if ( $v->FEATURES != "" ) {
		
		// get disclaimer and move it
		$cutout_disclaimer = array( 'start' => strpos( $v->FEATURES, '<div style="clear:both; width:100%; padding-top:50px;"><p style="font-size:11px; line-height:11px;">' ), 'stop' => ( strpos( $v->FEATURES, '</p></div>' ) + 10 ) );
		$cutout_disclaimer = substr( $v->FEATURES, $cutout_disclaimer['start'], ( $cutout_disclaimer['stop'] - $cutout_disclaimer['start'] ) );
		$v->FEATURES = str_replace( $cutout_disclaimer, "", $v->FEATURES );
		
		// format features
		$feats = str_replace( '</li></ul></div><div class="detail_inner_box"><p><strong>', '</li></ul></div><div class="list-holder"><h2>', $v->FEATURES );
		$feats = str_replace( '</strong></p><ul><li>', '</h2><ul><li>', $feats );
		$feats = str_replace( '</li><p><strong>', '</li></ul></div><div class="list-holder"><h2>', $feats );
		$feats = str_replace( '</strong></p><li>', '</h2><ul><li>', $feats );
		$feats = str_replace( '<div class="detail_inner_box"><p><strong>', '<div class="list-holder"><h2>', $feats );
		
		// display newlye formated features data
		echo htmlspecialchars_decode( $feats );
		
	}
?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#wrapper" class="back-top">back-top</a>
                </div>
            </section>
            
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
	
	// intiate form api
	forms_api.init( { "form_class":"form"} );
};

// Fix rollovers
callbacks[1] = function () {
	// similar vehicles widget
	anchorApi.addToAnchors( ".js-similar-widget li  table h3 a", "parentPreviousSecondChild", "activateEnlargeIconHover" );
    anchorApi.addToAnchors( ".js-similar-widget li table .image-box a:not( .btn-more )", "next", "activateEnlargeIconHover" );
};

// Execute all callbacks
cms_API.onJQReady( callbacks );
</script>
<!-- /work page's javascript -->