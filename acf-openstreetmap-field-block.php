<?php
/**
 * Plugin Name: ACF OpenStreetMap Field into a Block
 * Plugin URI: https://framagit.org/julianoe/acf-openstreetmap-field-block
 * Description: This plugin creates a block editor block from the "ACF OpenStreetMap Field" plugin by Jörn Lund.
 * Version: 1.0
 * Author: Julianoe
 * Author URI: http://julien.gasbayet.fr
 * License: GPLv2
 * Textdomain: acf-osm-block
 * Domain Path: lang/
*/

add_action('acf/init', 'acf_osm_block_init_block_type');
function acf_osm_block_init_block_type() {

    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'acf-osm-block',
            'title'             => __('ACF OpenStreetMap Block'),
            'description'       => __('This block is designed to make a block using the plugin "ACF OpenStreetMap Field" by Jörn Lund.'),
			'render_callback'	=> 'acf_osm_block_callback',
            'category'          => 'formatting',
            'icon'              => 'location',
            'keywords'          => array( 'OSM', 'ACF', 'maps', 'OpenStreetMap' ),
        ));
    }
}

/**
 * ACF OpenStreetMap Block Callback Function
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
function acf_osm_block_callback( $block, $content = '', $is_preview = false, $post_id = 0 ){

	// Create id attribute allowing for custom "anchor" value.
	$id = 'acf-osm-block' . $block['id'];
	if( !empty($block['anchor']) ) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if( !empty($block['className']) ) {
		$className .= ' ' . $block['className'];
	}
	if( !empty($block['align']) ) {
		$className .= ' align' . $block['align'];
	}
	?>

	<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
		<?= get_field('acf_osm_block'); ?>
	</div>
	<?php
}

/**
 * Add a basic ACF group with basic settings
 */
add_action('acf/init', 'acf_osm_block_add_field_group');
function acf_osm_block_add_field_group() {
	$exists = false;
	$value = 'ACF OSM BLOCK';
	$type = 'post_title';
	if ($field_groups = get_posts(array('post_type'=>'acf-field-group'))) {
		foreach ($field_groups as $field_group) {			
			if ($field_group->$type == $value) {
				$exists = true;
			}
		}
	}

	if( function_exists('acf_add_local_field_group') && !$exists ) {
	
		acf_add_local_field_group(array(
			'key' => 'group_60956674a8d58',
			'title' => 'ACF OSM BLOCK',
			'fields' => array(
				array(
					'center_lat' => 27.98819,
					'center_lng' => 86.92495,
					'zoom' => 13,
					'key' => 'field_6095667b3ce95',
					'label' => __('Map', 'acf-osm-block'),
					'name' => 'acf_osm_block',
					'type' => 'open_street_map',
					'instructions' => __('Default field group provided to use in the OSM block with default settings.', 'acf-osm-block'),
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'leaflet',
					'layers' => array(
						0 => 'OpenStreetMap.Mapnik',
					),
					'allow_map_layers' => 1,
					'height' => 400,
					'max_markers' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'block',
						'operator' => '==',
						'value' => 'acf/acf-osm-block',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));

	}
}


?>