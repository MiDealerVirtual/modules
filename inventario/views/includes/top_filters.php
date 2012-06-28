				<header class="heading">
					<h2>SHOWROOM VIRTUAL</h2>
					<section class="inventory-control">
<?
	// check to see if filters are there
	if( isset( $filter_html ) && $filter_html != '' ):
?>
						<form class="inventory-filters" method="get" action="<?=$base_url.$mod_uri_slug?>">
						<fieldset>
<?
	// display Filters
	echo $filter_html;
?>
							<input type="submit" value="BUSCAR" id="jq_filters_submit">
							<strong><a href="#" title="Limpiar Filtros" id="view-all-results"><span>comenzar</span> de nuevo</a></strong>
						</fieldset>
						</form>
<?
	endif;
	# End Display Filters
	
	# Display Sorting / Display Options
	
?>
						<div class="filter-block">
							<dl>
								<dt><strong>Ordenar por:</strong></dt>
								<dd>
									<ul>
<?
	// display sort html
	if( isset( $sort_html ) && $sort_html != "" )
		echo str_replace( "<li>Ordenar por:</li>", '', $sort_html );
?>
									</ul>
								</dd>
							</dl>
							<ul class="view-type">
								<li class="active"><a href="#items-list" class="view-change">GALERIA</a></li>
								<li><a href="#inventory-list" class="view-change">LISTA</a></li>
							</ul>
							<dl>
								<dt><strong>Página:</strong></dt>
								<dd>
<?
	// display pagination
	if( isset( $pagination_small ) && $pagination_small != false )
		echo $pagination_small;	// remove title
?>
								</dd>
							</dl>
						</div>
					</section>
				</header>