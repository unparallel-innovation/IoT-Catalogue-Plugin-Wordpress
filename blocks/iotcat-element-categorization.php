<?php




function iotcat_element_categorization_add_page_header() {

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

                    .iotcat-tags-container-new{
                        margin-bottom: 1rem;
                    }
                </style>
        <?php


}



function iotcat_element_categorization_render_callback( $block_attributes, $content, $block ) {
    if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	$post_ID = $block->context['postId'];
    $post_type = $block->context['postType'];
    $tags_path = get_post_meta( $post_ID ,"iotcat_tags_path");
    $website = get_post_meta( $post_ID ,"iotcat_website");
   

    if(count($tags_path) === 0 && count($website) === 0){
        return "";
    }
    $html = "";
    if(count($tags_path) > 0){
        $html = $html.iotcat_element_categorization_render_tags_path($tags_path);
    }
    if(count($website) > 0){
        $html = $html.iotcat_element_categorization_render_website($website[0]);
    }
    return $html;
    
}




function iotcat_element_categorization_render_tags_path($tags_path){

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

function iotcat_element_categorization_render_website($website){
    if(!$website){
        return "";
    }
    $parse = parse_url($website);
    $host = $parse['host'];
    return "
    <div class=\"iotcat-element-info-box\">
        <b class=\"label\">Website: </b><a href=\"".$website."\" target=\"_blank\">".$host."</a>
    </div>
    ";
}


  function iotcat_register_element_categorization_block() {

    add_action('wp_head', "iotcat_element_categorization_add_page_header");
    register_block_type(__DIR__ . '/build/iotcat-element-categorization' ,
    array(
        'render_callback' => 'iotcat_element_categorization_render_callback'
    )
);

  }
  add_action( 'init', 'iotcat_register_element_categorization_block' );


?>
