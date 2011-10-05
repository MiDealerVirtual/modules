<div class="mod_filters clearfix">
<? 
	# Display filters
	if( isset( $filter_html ) && $filter_html != '' ):
?>
	<div class="mod_filters_selects clearfix">
	<form id="jq_filters" method="get" action="<?=$base_url.$mod_uri_slug?>">
	<? 
		// Display Filters			
		echo $filter_html;
	?>
			<div class="btn_3 fl"><a href="#" title="Filtar" id="jq_filters_submit">Filtrar</a></div>
			<div class="btn_close"><a href="#" title="Limpiar Filtros" id="jq_view_all_submit"></a></div>
	</form>
	</div>
<?
	endif;
	# End Display Filters
	
	# Display Sorting / Display Options
?>
	<div class="mod_filters_sort">
		<ul>
			<?
				# Display Sort HTML
				if( isset( $sort_html ) && $sort_html != "" )
					echo $sort_html;
				# End Display Sort HTML
			?>
			<li class="icon_list"><a href="#" id="jq_inventory_list_view">Lista</a></li>
			<li class="icon_squared active"><a href="#" id="jq_inventory_box_view">Galer&iacute;a</a></li>
			<? if( isset( $pagination ) && $pagination != false ): ?><li class="sort_numbers"><?=$pagination?></li><? endif; ?>
		</ul>
	</div>
<?
	# End Display Sorting / Display Options
?>
</div>