<?php
/**
 *  Install Add-ons
 *  
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *  
 *  All fields must be included during the 'acf/register_fields' action.
 *  Other types of Add-ons (like the options page) can be included outside of this action.
 *  
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme as outlined in the terms and conditions.
 *  However, they are NOT to be included in a premium / free plugin.
 *  For more information, please read http://www.advancedcustomfields.com/terms-conditions/
 */ 

// Fields 
//add_action('acf/register_fields', 'my_register_fields');

//function my_register_fields()
//{
//	include_once('add-ons/acf-repeater/repeater.php');
	//include_once('add-ons/acf-gallery/gallery.php');
	//include_once('add-ons/acf-flexible-content/flexible-content.php');
//}

// Options Page 
//include_once( 'add-ons/acf-options-page/acf-options-page.php' );


/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id'     => 'acf_zone-maps',
		'title'  => 'Zone Maps',
		'fields' => array (
			array (
				'key'          => 'field_5313cd997327f',
				'label'        => 'Background Image',
				'name'         => 'background_image',
				'type'         => 'image',
				'required'     => 1,
				'save_format'  => 'url',
				'preview_size' => 'large',
			),
			array (
				'key'        => 'field_5313ce8873280',
				'label'      => 'Zone',
				'name'       => 'zone',
				'type'       => 'repeater',
				'sub_fields' => array (
					array (
						'key'           => 'field_5313ce9b73281',
						'label'         => 'Zone Title',
						'name'          => 'zone_title',
						'type'          => 'text',
						'column_width'  => '',
						'default_value' => '',
						'formatting'    => 'html',
					),
					array (
						'key'           => 'field_5313cead73282',
						'label'         => 'Zone Vector Coordinates',
						'name'          => 'zone_vector_coordinates',
						'type'          => 'textarea',
						'instructions'  => 'This is the vector code for drawing the zone shape',
						'column_width'  => '',
						'default_value' => '',
						'formatting'    => 'none',
					),
					array (
						'key'           => 'field_5313cef873283',
						'label'         => 'Zone X Coordinate',
						'name'          => 'zone_x_coordinate',
						'type'          => 'text',
						'instructions'  => 'The position of the zone from the left of the photo',
						'column_width'  => '',
						'default_value' => '',
						'formatting'    => 'none',
					),
					array (
						'key'           => 'field_5313cf1f73284',
						'label'         => 'Zone Y Coordinate',
						'name'          => 'zone_y_coordinate',
						'type'          => 'text',
						'instructions'  => 'The position of the zone from the top of the photo',
						'column_width'  => '',
						'default_value' => '',
						'formatting'    => 'none',
					),/*
					array (
						'key'           => 'field_5313cf7973285',
						'label'         => 'Zone Overlay Colour',
						'name'          => 'zone_overlay_colour',
						'type'          => 'color_picker',
						'instructions'  => 'The fill colour of the zone overlay.',
						'column_width'  => '',
						'default_value' => '',
					),
					array (
						'key'           => 'field_5313d02973286',
						'label'         => 'Zone Overlay Rollover Colour',
						'name'          => 'zone_overlay_rollover_colour',
						'type'          => 'color_picker',
						'instructions'  => 'The fill colour of the zone overlay when the mouse rolls over it.',
						'column_width'  => '',
						'default_value' => '',
					),*/
					array (
						'key'           => 'field_5313d02973287',
						'label'         => 'Content',
						'name'          => 'content',
						'type'          => 'wp_wysiwyg',
						'instructions'  => 'The content to display when a zone is linked',
						'default_value' => '',
						'teeny'         => 0,
						'media_buttons' => 1,
						'dfw'           => 1,
					),
				),
				'row_min'      => '',
				'row_limit'    => '',
				'layout'       => 'table',
				'button_label' => '',
			),
		),
		'location' => array (
			'rules' => array (
				array (
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'zone-map',
					'order_no' => 0,
				),
			),
			'allorany' => 'all',
		),
		'options'            => array (
			'position'       => 'normal',
			'layout'         => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}