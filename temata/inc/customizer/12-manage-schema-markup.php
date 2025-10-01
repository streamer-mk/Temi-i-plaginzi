<?php
$wp_customize->add_section( 'penci_section_manage_schema_markup', array(
	'title'       => esc_html__( 'Manage Schema Markup', 'pennews' ),
	'priority'    => 30,
) );

$list_schema_positions = array(
	'organization' => esc_html__( 'Remove Organization Schema', 'pennews' ),
	'website'      => esc_html__( 'Remove Website Schema Data', 'pennews' ),
	'page'         => esc_html__( 'Remove Schema Data for Single Pages', 'pennews' ),
	'post'         => esc_html__( 'Remove Schema Data for Single Posts', 'pennews' ),
	'product'      => esc_html__( 'Remove Schema Data for Single Products', 'pennews' ),
	'sidebar'      => esc_html__( 'Remove Sidebar Schema', 'pennews' ),
);

foreach ( $list_schema_positions as $id => $position ) {


	$setting_id = 'penci_hide_schema_' . $id;
	$wp_customize->add_setting( $setting_id, array(
		'sanitize_callback' => array( $sanitizer, 'checkbox' ),
		'default'           => ''
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		$setting_id,
		array(
			'label'    => $position,
			'section'  => 'penci_section_manage_schema_markup',
			'type'     => 'checkbox',
			'settings' => $setting_id,
		)
	) );
}