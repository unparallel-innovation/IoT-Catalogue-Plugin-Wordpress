<?php
require_once  __DIR__ . '/log.php';
require_once  __DIR__ . '/iotcat_elements.php';
class IoTCat_validations  extends IoTCat_elements {

	function __construct($name = "Validations", $singular_name = "validation", $post_type = "iotcat_validation") {
		parent::__construct($name, $singular_name, $post_type );

		add_action('init',array($this,'create_taxonomies'));

		add_action('manage_iotcat_validation_posts_columns',array($this,'columns'),10,2);
		add_action('manage_iotcat_validation_posts_custom_column',array($this,'column_data'),11,2);
		$this->icon = "dashicons-lightbulb";

	}


	public static $page_name = "validations";

	function create_taxonomies() {
		// Add a taxonomy like categories
		$labels = array(
			'name'              => 'Types',
			'singular_name'     => 'Type',
			'search_items'      => 'Search Types',
			'all_items'         => 'All Types',
			'parent_item'       => 'Parent Type',
			'parent_item_colon' => 'Parent Type:',
			'edit_item'         => 'Edit Type',
			'update_item'       => 'Update Type',
			'add_new_item'      => 'Add New Type',
			'new_item_name'     => 'New Type Name',
			'menu_name'         => 'Types',
		);
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'type' ),
		);
		register_taxonomy('iotcat_validation_type',array($this->post_type),$args);
		// Add a taxonomy like tags
		$labels = array(
			'name'                       => 'Attributes',
			'singular_name'              => 'Attribute',
			'search_items'               => 'Attributes',
			'popular_items'              => 'Popular Attributes',
			'all_items'                  => 'All Attributes',
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Edit Attribute',
			'update_item'                => 'Update Attribute',
			'add_new_item'               => 'Add New Attribute',
			'new_item_name'              => 'New Attribute Name',
			'separate_items_with_commas' => 'Separate Attributes with commas',
			'add_or_remove_items'        => 'Add or remove Attributes',
			'choose_from_most_used'      => 'Choose from most used Attributes',
			'not_found'                  => 'No Attributes found',
			'menu_name'                  => 'Attributes',
		);
		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'attribute' ),
		);
		register_taxonomy('iotcat_validation_attribute',$this->post_type,$args);
	}

	function columns($columns) {
		unset($columns['date']);
		unset($columns['taxonomy-iotcat_validation_attribute']);
		unset($columns['comments']);
		unset($columns['author']);
		return array_merge(
			$columns,
			array(
				'iotcat_validation_original_id' => 'Original Id',
				'iotcat_subscription_id' => 'Subscription Id',
				'iotcat_timeframe' => 'Timeframe'
			));
	}

	function column_data($column,$post_id) {
		switch($column) {
			case 'iotcat_validation_original_id' :
				echo get_post_meta($post_id,'original_id',1);
				break;
			case 'iotcat_subscription_id' :
				echo get_post_meta($post_id,'subscription_id',1);
				break;
			case 'iotcat_timeframe' :
				echo get_post_meta($post_id,'timeframe',1);
				break;
		}
	}

	function join($wp_join) {
		global $wpdb;
		if(get_query_var('post_type') == $this->post_type) {
			$wp_join .= " LEFT JOIN (
				SELECT post_id, meta_value as awards
				FROM $wpdb->postmeta
				WHERE meta_key =  'awards' ) AS meta
				ON $wpdb->posts.ID = meta.post_id ";
		}
		return ($wp_join);
	}

	function set_default_sort($orderby,&$query) {
		global $wpdb;
		if(get_query_var('post_type') == $this->post_type) {
			return "meta.awards DESC";
		}
		return $orderby;
	}



}

?>
