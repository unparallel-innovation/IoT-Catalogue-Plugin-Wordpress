<?php
require_once  __DIR__ . '/log.php';
class IoTCat_components {

	function __construct($name = "Components", $singular_name = "Component", $post_type = "iotcat_component") {
		add_action('init',array($this,'create_post_type'));
		add_action('init',array($this,'create_taxonomies'));

		add_action('manage_iotcat_component_posts_columns',array($this,'columns'),10,2);
		add_action('manage_iotcat_component_posts_custom_column',array($this,'column_data'),11,2);
		add_action('wp_head', array($this,'hook_javascript'));
		//sanitize_title("fdsdf sDGF DFgdf g-sdfg sdfg sdfg~dfsg sdf");
		$this->name = $name;
		$this->singular_name = $singular_name;
		$this->post_type = $post_type;
	//	add_filter('posts_join',array($this,'join'),10,1);
		//add_filter('posts_orderby',array($this,'set_default_sort'),20,2);
	}

	function hook_javascript() {

		if(get_post_type() === $this->post_type){

			?>
					<style>
							#iotcat-iframe{
								border: 0px;
							}
							.iotcat-component-img {
								height: 200px;

							}

							.iotcat-component-img-container {
								display: flex;
						    justify-content: center;
						    margin-bottom: 10px;

							}
	        </style>
					<script>
							const maxRetries = 500;
							const waitTime = 10;
							function getIframeRecursive(resolve, reject, retryCount = 0 ){
								const iframe = document.getElementById("iotcat-iframe");
								console.log("getIframeRecursive",iframe)
								if(retryCount > maxRetries){
									reject("Max retries exceeded");
								}else if(!iframe){
									setTimeout(()=>{getIframeRecursive(resolve,reject,retryCount + 1)},waitTime)
								}else{
									resolve(iframe)
								}

							}
							function getIframe(){
								return new Promise((resolve,reject)=>(getIframeRecursive(resolve,reject)))
							}
							getIframe().then(iframe=>{
								function receiveMessage(event) {
									const data = event.data
									console.log("data",data)
									if (data.action == "resize") {

										console.log(iframe)
										console.log("Set height " + data.height)
										iframe.style.height = data.height + 'px';
									}
								}
								window.addEventListener("message", receiveMessage, false)
							})


					</script>
			<?php
		}


	}

	function create_post_type() {
		$labels = array(
			'name'               => $this->name,
			'singular_name'      => $this->singular_name,
			'menu_name'          => $this->name,
			'name_admin_bar'     => $this->singular_name,
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New '.$this->singular_name,
			'new_item'           => 'New '.$this->singular_name,
			'edit_item'          => 'Edit '.$this->singular_name,
			'view_item'          => 'View '.$this->singular_name,
			'all_items'          => 'All '.$this->name,
			'search_items'       => 'Search '.$this->name,
			'parent_item_colon'  => 'Parent '.$this->singular_name,
			'not_found'          => 'No '.$this->name.' Found',
			'not_found_in_trash' => 'No '.$this->name.' Found in Trash'
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-list-view',
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'         => true,
			'rewrite'             => array( 'slug' => sanitize_title($this->name) ),
			'query_var'           => true
		);

		register_post_type( $this->post_type, $args );
	}

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
		register_taxonomy('iotcat_component_type',array($this->post_type),$args);
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
		register_taxonomy('iotcat_component_attribute',$this->post_type,$args);
	}

	function columns($columns) {
		unset($columns['date']);
		unset($columns['taxonomy-iotcat_component_attribute']);
		unset($columns['comments']);
		unset($columns['author']);
		return array_merge(
			$columns,
			array(
				'iotcat_component_original_id' => 'Original Id',
				'iotcat_subscription_id' => 'Subscription Id',
				'iotcat_timeframe' => 'Timeframe'
			));
	}

	function column_data($column,$post_id) {
		switch($column) {
			case 'iotcat_component_original_id' :
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


	private function get_img_html($image_url){
		if(isset($image_url)){
			return "
			<div class=\"iotcat-component-img-container\">
				<img class=\"iotcat-component-img\" src=\"$image_url\" >
			</div>
			";
		}
		return "";
	}

	private function get_page_content($name,$description,$embedded_url, $image_url){

			return
			$this -> get_img_html($image_url).
			"<p>$description</p>
			<iframe id=\"iotcat-iframe\" style=\"height: 0px;width: 100%\" src=\"$embedded_url\" />
			";


	}

	public function has_component($original_id){
		$args = array(
				'meta_key' => 'original_id',
				'meta_value' => $original_id,
				'post_type' => $this->post_type
		);
		$posts = get_posts($args);
		if(count($posts) > 0){
			return true;
		}
		return false;

	}

	private function get_subscription_components($subscription_id){
		$args = array(
				'meta_key' => 'subscription_id',
				'meta_value' => $subscription_id,
				'post_type' => $this->post_type,
				'numberposts' => -1
		);
		return get_posts($args);
	}

	public function delete_subscription_components($subscription_id){
		$posts = $this-> get_subscription_components($subscription_id);
		foreach ($posts as $post) {
			$id = $post->ID;
			log_me("Deleting post with id ".$id);
			wp_delete_post($id);
		}
	}

	public function add_new($name,$description,  $embedded_url,$image_url,$original_id,$subscription_id, $insert_repeated = false){

		if($insert_repeated || !$this->has_component($original_id)){
			$component = array(
						'post_title'    => $name,
						'post_status'   => 'publish',
						'post_content' => $this->get_page_content($name,$description,$embedded_url, $image_url),
						'post_type'     => $this->post_type,
						'meta_input' => array(
									"description" => $description,
									"image_url" => $image_url,
									"original_id" => $original_id,
									"subscription_id" => $subscription_id
							)
						);
				return wp_insert_post( $component );
		}



	}
}

?>
