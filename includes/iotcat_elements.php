<?php
require_once  __DIR__ . '/log.php';
class IoTCat_elements {

	function __construct($name, $singular_name, $post_type) {

		$this->name = $name;
		$this->singular_name = $singular_name;
		$this->post_type = $post_type;
		add_action('init',array($this,'create_post_type'));
		add_action('wp_head', array($this,'add_page_header'));
		add_action('template_redirect', array($this,'process_redirect'),10,0);
		add_action('pre_get_posts', array($this,'sort_posts'),10,1);
		$this->icon = 'dashicons-list-view';
	}

	public function sort_posts($query){
		if(
			array_key_exists("post_type",$query->query) &&
			$query->query["post_type"] === $this->post_type
		){
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'title' );
		}
	}

	public function process_redirect(){
		global $wp;

		$query_vars = $wp->query_vars;


		if(
			array_key_exists("page_id",$query_vars) &&
			array_key_exists("post_type",$query_vars) &&
			$query_vars["post_type"] === $this->post_type
		){

					$element = $this->get_element_by_original_id($query_vars["page_id"]);
					if($element !==null){
						$permalink = get_permalink($element);
						wp_redirect($permalink);
					}
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
			'taxonomies' 					=> array('post_tag'),
			'public'              => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => $this->icon,
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'         => true,
			'rewrite'             => array( 'slug' => sanitize_title($this->name) ),
			'query_var'           => true
		);

		register_post_type( $this->post_type, $args );
	}

	private function get_img_html($image_url){

		if(isset($image_url) && $image_url !== ""){
			return "
			<div class=\"iotcat-element-img-container\">
				<img class=\"iotcat-element-img\" src=\"$image_url\" >
			</div>
			";
		}
		return "";
	}

	private function get_website_link($website){

		if(isset($website) && $website !== ""){

			$parse = parse_url($website);
			$host = $parse['host'];
			return "
			<div class=\"iotcat-element-info-box\">
				<b class=\"label\">Website</b><a href=\"$website\" target=\"_blank\">$host</a>
			</div>
			";
		}
		return "";
	}


	private function get_tags_input($tags_path){
		$tag_input = array();
		if(isset($tags_path) && $tags_path !== null){
			foreach($tags_path as $tag_path){
				if(count($tag_path)>0){
					$tag_name = $tag_path[0]["name"];
					array_push($tag_input,$tag_name);
				}
			}
		}
		return $tag_input;
	}

	private function get_tags_elements($tags_path){
		$html = "";
		if(isset($tags_path) && $tags_path !== null){
			$tag_elements = array();
			foreach($tags_path as $tag_path){
				if(count($tag_path)>0){
					$tag_name = $tag_path[0]["name"];
					$tag_type_name = $tag_path[0]["typeName"];
					if(!array_key_exists($tag_type_name,$tag_elements)){
						$tag_elements[$tag_type_name] = array();
					}
					array_push($tag_elements[$tag_type_name],$tag_name);

				}

			}
			$tag_type_names = array_keys($tag_elements);
			asort($tag_type_names);
			foreach($tag_type_names as $tag_type_name){
				$tags_html = "";
				$tag_names = $tag_elements[$tag_type_name];
				asort($tag_names);
				foreach($tag_names as $tag_name){
					$tags_html = $tags_html."<span class=\"iotcat-element-tag\">$tag_name</span>";
				}
				if($tags_html !== ""){
					$html = $html."
					<div class=\"iotcat-element-info-box\">
						<b class=\"label\">$tag_type_name</b>$tags_html
					</div>
					";
				}
			}
		}
		return $html;
	}


	protected function get_page_content($name,$description,$website,$embedded_url, $image_url,$tags_path){

			return
			$this->get_img_html($image_url).
			"<p>$description</p>".
			$this->get_tags_elements($tags_path).
			$this->get_website_link($website).
			"<iframe id=\"iotcat-iframe\" style=\"height: 0px;width: 100%\" src=\"$embedded_url\" />
			";


	}

	public function add_page_header() {
		if(get_post_type() === $this->post_type){



					?>
							<style>
									#iotcat-iframe{
										border: 0px;
									}
									.iotcat-element-img {
										height: 200px;

									}

									.iotcat-element-img-container {
										display: flex;
										justify-content: center;
										margin-bottom: 10px;

									}
									.iotcat-element-info-box {
									    background-color: #f1f2f2;
									    padding: 8px;
									    border-radius: 4px;
											margin-bottom: 8px;
									}
									.iotcat-element-info-box .label {
										margin-right:5px;
									}

									.iotcat-element-tag {
								    border: 1px solid #cdced0;
								    color: #494949;
								    padding: 2px 5px;
								    margin-right: 5px;
								    border-radius: 2px;
									}
							</style>
							<script>
									const maxRetries = 500;
									const waitTime = 10;
									function getIframeRecursive(resolve, reject, retryCount = 0 ){
										const iframe = document.getElementById("iotcat-iframe");
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
											if (data.action == "resize") {
												iframe.style.height = data.height + 'px';
											}
										}
										window.addEventListener("message", receiveMessage, false)
										window.onbeforeunload = function(){
											window.removeEventListener("message", receiveMessage);
										};
									})


							</script>
					<?php


			}
	}



	public function get_element_by_original_id($original_id){
		$args = array(
				'meta_key' => 'original_id',
				'meta_value' => $original_id,
				'post_type' => $this->post_type
		);
		$posts = get_posts($args);
		if(count($posts) > 0){
			return $posts[0];
		}

	}


    public function delete_removed_elements($ids){

        $meta_query = array(
            'key'=>'original_id',
            'value'=>$ids,
            'compare'=>'NOT IN'

        );

        $args = array(
            'meta_query' =>array($meta_query),
            'post_type' => $this->post_type,
            'numberposts' => -1,
            'fields' => 'ids'
        );
        $posts = get_posts($args);
        foreach ($posts as $id_to_delete){
            iotcat_log_me("Deleting $this->post_type with id $id_to_delete");
            wp_delete_post($id_to_delete);
        }
    }


	public function has_element($original_id){
		return $this->get_element_by_original_id($original_id)!==null?true:false;
	}

	private function get_subscription_elements($subscription_id){
		$args = array(
				'meta_key' => 'subscription_id',
				'meta_value' => $subscription_id,
				'post_type' => $this->post_type,
				'numberposts' => -1
		);
		return get_posts($args);
	}

	public function delete_subscription_elements($subscription_id){
		$posts = $this-> get_subscription_elements($subscription_id);
		foreach ($posts as $post) {
			$id = $post->ID;
			iotcat_log_me("Deleting post with id ".$id);
			wp_delete_post($id);
		}
	}


	private function create_post_element($id,	$name, $description,$website, $embedded_url, $image_url,$tags_path,$original_id,$subscription_id,$last_update_timestamp){


		$element = array(
					'post_title'    => $name,
					'post_status'   => 'publish',
					'post_content' => $this->get_page_content($name,$description,$website,$embedded_url, $image_url,$tags_path),
					'tags_input' => $this->get_tags_input($tags_path),
					'post_type'     => $this->post_type,
					'meta_input' => array(
								"description" => $description,
								"image_url" => $image_url,
								"original_id" => $original_id,
								"subscription_id" => $subscription_id,
								"last_update_timestamp" => $last_update_timestamp

						)
					);
			if($id){
				$element["ID"] = $id;
			}
			return $element;
	}
	public function add_new_element($name,$description, $website, $embedded_url,$image_url,$tags_path,$original_id,$last_update_timestamp,$subscription_id, $insert_repeated = false){

		if($insert_repeated || !$this->has_element($original_id)){
            iotcat_log_me("Add new $this->post_type $name");
            return wp_insert_post( $this->create_post_element(null, $name,$description,$website,$embedded_url,$image_url,$tags_path,$original_id,$subscription_id,  $last_update_timestamp ) );
		}
	}

	public function update_element($id,$name,$description,$website,  $embedded_url,$image_url,$tags_path,$original_id,$last_update_timestamp,$subscription_id){

    iotcat_log_me("update $this->post_type $name");
		return wp_update_post( $this->create_post_element($id, $name,$description,$website,$embedded_url,$image_url,$tags_path,$original_id,$subscription_id,  $last_update_timestamp ) );
	}

}
?>
