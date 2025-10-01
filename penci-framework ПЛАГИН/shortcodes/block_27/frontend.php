<?php
$atts              = vc_map_get_attributes( $this->getShortcode(), $atts );
$show_on_shortcode = Penci_Helper_Shortcode::show_on_shortcode( $atts );
if ( ! $show_on_shortcode ) {
	return;
}

list( $atts , $block_content_id, $unique_id ) = Penci_Helper_Shortcode::get_general_param_frontend_shortcode( $atts, 'block_27' );

$class = Penci_Framework_Helper::get_class_block( array( $this->getCSSAnimation( $atts['css_animation'] ) ), $atts );
$class = preg_replace( '/\s+/', ' ', apply_filters( 'vc_shortcodes_css_class', implode( ' ', array_filter( array_unique( $class ) ) ), 'penci_block_27', $atts ) );

$query_slider = Penci_Pre_Query::do_query( $atts );

if ( ! $query_slider->have_posts() ) {
	return;
}

$items = include dirname( __FILE__ ) . "/content-items.php";
$data_filter = Penci_Helper_Shortcode::get_data_filter( 'block_27',$atts, $content );
?>

<div id="<?php echo esc_attr( $unique_id ); ?>" class="penci-block-vc penci-block_27 penci__general-meta <?php echo esc_attr( $class ); ?>" data-current="1" data-blockUid="<?php echo esc_attr( $unique_id ); ?>" <?php echo $data_filter; ?>>
	<div class="penci-block-heading">
		<?php Penci_Helper_Shortcode::get_block_title( $atts ); ?>
		<?php Penci_Helper_Shortcode::get_pull_down_filter( $atts, 'block_27', $block_content_id ); ?>
		<?php Penci_Helper_Shortcode::get_slider_nav( $block_content_id, $atts, $query_slider ); ?>
	</div>
	<div id="<?php echo esc_attr( $block_content_id ); ?>" class="penci-block_content">
		<?php  echo $items; ?>
	</div>
	<?php Penci_Helper_Shortcode::get_pagination( $atts, $query_slider ); ?>
</div>
<?php
$id_block_27 = '#' . $unique_id;


$css_custom  = Penci_Helper_Shortcode::get_general_css_custom( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_post_meta_css_custom( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_post_cat_css_custom( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_ajax_loading_css_custom( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_text_filter_css_custom( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_pagination_css_custom( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom_pagination( $id_block_27, $atts );
$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom_cat( $id_block_27, $atts );

if ( 'custom' == $atts['image_type'] ) {
	if ( $atts['big_image_ratio'] ) {
		$css_custom .= $id_block_27 . '.penci-imgtype-custom .block27_last_item .penci-image-holder:before{ padding-top: ' . floatval( $atts['big_image_ratio'] ) * 100 . '%; }';
	}

	if ( $atts['image_ratio'] ) {
		$css_custom .= $id_block_27 . '.penci-imgtype-custom .block27_items .penci-image-holder:before{ padding-top: ' . floatval( $atts['image_ratio'] ) * 100 . '%; }';
	}
}

// First posts
if ( ! empty( $atts['right_post_title_color'] ) ) :
	$css_custom .= sprintf(
		'%s .block27_last_item .penci__post-title a{ color:%s !important; }',
		$id_block_27, $atts['right_post_title_color'] );
endif;
if ( ! empty( $atts['right_post_title_hover_color'] ) ) :
	$css_custom .= sprintf(
		'%s .block27_last_item .penci__post-title a:hover { color:%s !important; }',
		$id_block_27, $atts['right_post_title_hover_color']
	);
endif;

if ( ! empty( $atts['right_post_meta_color'] ) ) :
	$css_custom .= sprintf(
		'%s .block27_last_item .penci_post-meta{ color:%s !important; }',
		$id_block_27, $atts['right_post_meta_color'] );
endif;
if ( ! empty( $atts['first_post_meta_hover_color'] ) ) :
	$css_custom .= sprintf(
		'%s .block27_last_item .penci_post-meta a:hover { color:%s !important; }',
		$id_block_27, $atts['right_post_meta_hover_color']
	);
endif;

if ( $atts['excrept_color'] ) {
	$css_custom .= sprintf( '%s .penci-post-excerpt{ color:%s; }', $id_block_27, $atts['excrept_color'] );
}

if ( $atts['right_post_bg_color'] ) {
	$css_custom .= sprintf( '%s .block27_last_item .penci_post_item_content{ background-color:%s; }', $id_block_27, $atts['right_post_bg_color'] );
}

$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom_block_heading( $id_block_27, $atts );

$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom( array(
	'e_admin'      => 'post_title',
	'font-size'    => '18px',
	'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'muktavaani' ),
	'template' =>  $id_block_27 .' .penci__post-title{ %s }' ,
), $atts
);


$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom( array(
	'e_admin'      => 'post_meta',
	'font-size'    => '12px',
	'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'roboto' ),
	'template' => $id_block_27 .'.penci__general-meta .penci_post-meta{ %s }' ,
), $atts
);

$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom( array(
	'e_admin'      => 'post_excrept',
	'font-size'    => '14px',
	'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'roboto' ),
	'template' => $id_block_27 .' .penci-post-excerpt{ %s }' ,
), $atts
);

if ( $css_custom ) {
	echo '<style>';
	echo $css_custom;
	echo '</style>';
}

Penci_Helper_Shortcode::get_block_script( $unique_id, $atts, $content );

