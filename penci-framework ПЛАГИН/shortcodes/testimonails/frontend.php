<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$unique_id = 'penci_testimonail__' . rand( 1000, 100000000 );
$atts              = vc_map_get_attributes( $this->getShortcode(), $atts );
$show_on_shortcode = Penci_Helper_Shortcode::show_on_shortcode( $atts );
if ( ! $show_on_shortcode ) {
	return;
}

$testimonials = (array) vc_param_group_parse_atts( $atts['testiminails'] );

if( empty( $testimonials ) ) {
	return;
}

$class = 'penci-testimonails penci-testimonails-slider';
$class .= $atts['_design_style'] ? ' penci-testi-' . esc_attr( $atts['_design_style'] ) : '';
$class .= isset( $atts['css'] ) && $atts['css'] ? ' ' . vc_shortcode_custom_css_class( $atts['css'], '' ) : '';
$class .= $atts['class'] ? ' ' . $atts['class'] : '';
$class .= ' ' . $this->getCSSAnimation( $atts['css_animation'] );
$class = preg_replace( '/\s+/', ' ', apply_filters( 'vc_shortcodes_css_class', $class, 'penci_testimonails', $atts ) );

// Data slider
$data = 'data-style="testimonial"';
$data .= ' data-items="' . esc_attr( $atts['limit_desk'] ) . '"';
$data .= ' data-autowidth="' . ( ! empty( $atts['autowidth'] ) ? 1 : 0 ) . '"';
$data .= ' data-auto="' . ( empty( $atts['auto_play'] ) ? 1 : 0 ) . '"';
$data .= ' data-autotime="' . ( ! empty( $atts['auto_time'] ) ? $atts['auto_time'] : 4000 ) . '"';
$data .= ' data-speed="' . ( ! empty( $atts['speed'] ) ? $atts['speed'] : 800 ) . '"';
$data .= ' data-loop="' . ( ! empty( $atts['disable_loop'] ) ? 1 : 0 ) . '"';
$data .= ' data-dots="' . ( ! empty( $atts['enable_dots'] ) ? 1 : 0 ) . '"';
$data .= ' data-nav="' . ( empty( $atts['dis_arrows'] ) ? 1 : 0 ) . '"';
$data .= ' data-magrin="' . ( ! empty( $atts['margin_right'] ) ? $atts['margin_right'] : 0 ) . '"';
$data .= ' data-center="' . ( ! empty( $atts['center_item'] ) ? 0 : 1 ) . '"';
?>
<div id="<?php echo esc_attr( $unique_id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<div class="penci-testimonail-inner penci-owl-carousel-slider penci-owl-featured-area" <?php echo $data; ?>>
		<?php
		foreach ( $testimonials as $testimonial ) {
			$testimonial_name    = isset( $testimonial['name'] ) ? $testimonial['name'] : '';
			$testimonial_company = isset( $testimonial['company'] ) ? $testimonial['company'] : '';
			$testimonial_desc    = isset( $testimonial['desc'] ) ? $testimonial['desc'] : '';
			$testimonial_link    = isset( $testimonial['link'] ) ? $testimonial['link'] : '';

			$url_img_item = PENCI_ADDONS_URL . 'assets/img/no-thumb.jpg';
			if ( isset( $testimonial['image'] ) ) {
				$url_img_item = wp_get_attachment_url( $testimonial['image'] );
			}

			if ( $testimonial_name || $testimonial_company || $testimonial_desc ) {
				$testi_output = '<div class="penci-testimonail">';

				$class_lazy = $data_src = '';
				if( function_exists( 'penci_check_lazyload_type' ) ) {
					$class_lazy = penci_check_lazyload_type( 'class', null, false );
					$data_src = penci_check_lazyload_type( 'src', $url_img_item, false );
				}

				if( 's2' == $atts['_design_style'] ){
					$testi_output .= '<div class="penci-testi-avatar' . $class_lazy . '"' . $data_src . '></div>';
				}

				$testi_output .= '<div class="penci-testi-blockquote"><div class="penci-testi-bq-inner"><span class="penci-testi-bq-icon"></span><span>' . $testimonial_desc . '</span></div></div>';

				if( 's1' == $atts['_design_style'] ){
					$testi_output .= '<div class="penci-testi-avatar'. $class_lazy .'"' . $data_src . '></div>';
				}

			
				 $testi_output .=  $testimonial_link ? '<a class="penci-testi-name" href="' . $testimonial_link . '">' : '<div class="penci-testi-name">';
				$testi_output .=  $testimonial_name;
				$testi_output .=  $testimonial_link ? '</a>' : '</div>'; 
		

				$testi_output .= '<div class="penci-testi-company">' . $testimonial_company . '</div>';
				$testi_output .= '</div>';
				echo $testi_output;
			}
		}
		?>
	</div>
	<?php
	$id_testimonial = '#' . $unique_id;
	$css_custom = '';

	$blockquote_css = '';
	if( $atts['bq_max_width'] ) {
		$blockquote_css .= 'max-width:' . $atts['bq_max_width'] . ';';
	}

	if( $atts['bq_padding_tb'] ) {
		$blockquote_css .= 'padding-top:' . $atts['bq_padding_tb'] . '; padding-bottom:' . $atts['bq_padding_tb'] . ';';
	}

	if( $atts['bq_padding_lr'] ) {
		$blockquote_css .= 'padding-left:' . $atts['bq_padding_lr'] . '; padding-right:' . $atts['bq_padding_lr'] . ';';
	}

	if( $atts['bq_mar_top'] ) {
		$blockquote_css .= 'margin-top:' . intval( $atts['bq_mar_top'] )  . 'px;';
	}

	if( $atts['bq_mar_bottom'] && 's1' == $atts['_design_style'] ) {
		$blockquote_css .= 'margin-bottom:' . ( intval( $atts['bq_mar_bottom'] ) + 14 )  . 'px;';
	}

	if( $atts['bq_mar_bottom'] && 's2' == $atts['_design_style'] ) {
		$blockquote_css .= 'margin-bottom:' . intval( $atts['bq_mar_bottom'] )  . 'px;';
	}

	if( $blockquote_css ) {
		$css_custom .= $id_testimonial . '.penci-testimonails .penci-testi-blockquote{ ' . $blockquote_css . ' }';
	}

	if( $atts['name_mar_bottom'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-name{ margin-bottom:' . $atts['name_mar_bottom'] . ' }';
	}

	if( $atts['pos_mar_bottom'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-company{ margin-bottom:' . $atts['pos_mar_bottom'] . ' }';
	}

	if( $atts['icon_bq_mar_b'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-blockquote .penci-testi-bq-icon{ ' . $blockquote_css . ' }';
	}

	$avatar_css = '';
	if( $atts['avatar_wh'] ) {
		$avatar_css .= 'width:' . esc_attr( $atts['avatar_wh'] ) . '; height:' . esc_attr( $atts['avatar_wh'] ) . ';';
	}

	if( $atts['avatar_mar_top'] ) {
		$avatar_css .= 'margin-top:' . esc_attr( $atts['avatar_mar_top'] ) . ';';
	}

	if( $atts['avatar_mar_bottom'] ) {
		$avatar_css .= 'margin-bottom:' . esc_attr( $atts['avatar_mar_bottom'] ) . ';';
	}

	if( $avatar_css ) {
		$css_custom .= $id_testimonial . ' .penci-testi-avatar{ ' . $avatar_css . ' }';
	}

	// Color
	if( $atts['bq_bg_color'] ) {

		if( 's1' == $atts['_design_style'] ){
			$css_custom .= $id_testimonial . ' .owl-item.active.center .penci-testimonail .penci-testi-blockquote { background-color: ' . $atts['bq_bg_color'] . '; }';
			$css_custom .= $id_testimonial . ' .owl-item.active.center .penci-testimonail .penci-testi-blockquote:after{ border-top-color: ' . $atts['bq_bg_color'] . '; }';
		}else{
			$css_custom .= $id_testimonial . ' .penci-testi-blockquote { background-color: ' . $atts['bq_bg_color'] . '; }';
		}
	}

	if( $atts['bq_bo_top_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-blockquote { border-color: ' . $atts['bq_bo_top_color'] . '; }';
	}

	if( $atts['bq_text_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-blockquote { color: ' . $atts['bq_text_color'] . '; }';
	}

	if( $atts['bg_icon_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-bq-icon { color: ' . $atts['bg_icon_color'] . '; }';
	}

	if( $atts['name_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-name { color: ' . $atts['name_color'] . '; }';
	}

	if( $atts['company_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-testi-company { color: ' . $atts['company_color'] . '; }';
	}

	if( $atts['dots_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-owl-carousel-slider .owl-dot:not( .active ) span{ background-color: ' . $atts['dots_color'] . '; }';
	}
	if( $atts['dots_active_color'] ) {
		$css_custom .= $id_testimonial . ' .penci-owl-carousel-slider .owl-dot.active span,';
		$css_custom .= $id_testimonial . ' .penci-owl-carousel-slider .owl-dot:hover span{ background-color: ' . $atts['dots_active_color'] . '; }';
	}

	$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom( array(
		'e_admin'      => 'blockquote',
		'font-size'    => '',
		'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'roboto' ),
		'template'     => $id_testimonial . ' .penci-testi-blockquote{ %s }',
	), $atts
	);
	$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom( array(
		'e_admin'      => 'name',
		'font-size'    => '',
		'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'roboto' ),
		'template'     => $id_testimonial . ' .penci-testi-name{ %s }',
	), $atts
	);

	$css_custom .= Penci_Helper_Shortcode::get_typo_css_custom( array(
		'e_admin'      => 'company',
		'font-size'    => '',
		'google_fonts' => Penci_Helper_Shortcode::get_font_family( 'roboto' ),
		'template'     => $id_testimonial . ' .penci-testi-company{ %s }',
	), $atts
	);

	if ( $css_custom ) {
		echo '<style>';
		echo $css_custom;
		echo '</style>';
	}
	?>
</div>


