<?php  
/* 
Plugin Name: Zone Maps
Plugin URI: http://
Version: 0.1
Author: Jaap Nieuwland
Description: Allows you to overlay vector-based hotspots over the top of images.
*/  

/*  Copyright 2014  Jaap Nieuwland  (email : jaap@xmarketing.com.au)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include( dirname(__FILE__) . '/scripts/custom-post-type.php' );
include( dirname(__FILE__) . '/scripts/custom_fields.php' );




/*

*/
function zone_map_activation()
{
		
}
register_activation_hook(__FILE__, 'zone_map_activation');
/*

*/
function zone_map_deactivation() 
{
	
}
register_deactivation_hook(__FILE__, 'zone_map_deactivation');





/*

*/
function display_zone_map( $atts ) {
	extract( shortcode_atts( array(
		'map_id'    => 0,
		'map_width' => 800,
		'map_height'=> 533
	), $atts ) );

	return build_map_zone_code($map_id, $map_width, $map_height);	
}
add_shortcode( 'display_zone_map', 'display_zone_map' );



/*

*/
function load_scripts_styles() 
{
	//
	wp_enqueue_script( 'zone-maps', plugins_url( '/scripts/zone-maps.js' , __FILE__ ), array( 'jquery' ) );
	//
	wp_enqueue_script('raphael', plugins_url( '/scripts/raphael.js' , __FILE__ ) );
	//
	wp_enqueue_style( 'styles', plugins_url( '/css/styles.css' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' );



/*

*/
function build_map_zone_code($map_id, $map_width, $map_height)
{
	/*
		Build the map data
	*/
	$map        = get_post( $map_id, 'OBJECT' );
	$raw_data   = array(
		'map_id'          => $map_id,
		'map_name'        => get_the_title( $map_id ),
		'map_image_url'   => ( get_field( 'background_image', $map_id ) ) ? get_field( 'background_image', $map_id ) : '',
		'map_zones'       => array()
	);
	
	/*
		Take data from the repeater fields attached to this custom post
	*/
	while( have_rows( 'zone', $map_id ) ): the_row(); 
		$zone_data   = array(
			'zone_title'                   => get_sub_field('zone_title'), 
			'zone_vector_coordinates'      => get_sub_field('zone_vector_coordinates'),
			'zone_x_coordinate'            => get_sub_field('zone_x_coordinate'),
			'zone_y_coordinate'            => get_sub_field('zone_y_coordinate'),
			//'zone_overlay_colour'          => get_sub_field('zone_overlay_colour'),
			//'zone_overlay_rollover_colour' => get_sub_field('zone_overlay_rollover_colour'),
			'content'                      => get_sub_field('content')
		);
		// 
		array_push( $raw_data['map_zones'], $zone_data );	
	endwhile;
	
	echo '<div class="map_zones_container" id="map_zones_' . $map_id . '"></div>';
	
	$output  = "<script>";
	$output .= "try{
					map_zones = new MapZones({'map_data': ". json_encode( $raw_data ) .", 'map_height': ".$map_height." , 'map_width': ".$map_width.",'container': '#map_zones_".$map_id."' });
				}
				catch(e)
				{
					throw new Error('Failed to initialise MapZones. ' + e);
				}";
	$output .= "</script>";
	$output .= "";
	
	return $output;
}









