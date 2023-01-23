<?php


/*
function iotcat_usecase_card_render_box($label, $value, $color,$last_square = false){

    $border_class = $last_square?'':'border-end';
    $color_style = $color?"color: ".$color."!important":"";
    return '
    <div class="bg-light flex-grow-1 text-center pe-3 ps-3  border-white border-top '.$border_class.'">
        <h6 class="text-primary mt-2 mb-0 " style="'.$color_style.'">
            <small>'.$value.'</small>
        </h6>
        <h6 class="mb-2 mt-0">
           <small>'.$label.'</small>
        </h6>
    </div>
    ';
}

function iotcat_usecase_card_render_boxes($boxes,$color){
    $html ='';

    if(is_array($boxes)){
        foreach($boxes as $key=>$box){
            $last_square = $key === count($boxes) -1;
            $html = $html.iotcat_usecase_card_render_box($box["label"],$box["value"],$color,$last_square);
        }
    }
    return $html;
}

*/
function iotcat_component_card_render_callback( $block_attributes, $content, $block ) {

  /*  if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	$post_ID = $block->context['postId'];
    $post_type = $block->context['postType'];
    $embedded_url = get_post_meta( $post_ID ,"iotcat_embedded_url");
    $tags_path = get_post_meta( $post_ID ,"iotcat_tags_path");

    if(count($embedded_url) === 0){
        return "";
    }*/
   // $boxes = $block_attributes["boxes"];
    $base_card_props = "";
    $style = "";
    $color = null;
    if(array_key_exists("color", $block_attributes)){
        $color = $block_attributes["color"];
        $base_card_props ='{"borderColor":"'.$color.'"}';
    }

    if(array_key_exists("image", $block_attributes)){
        $image = $block_attributes["image"];
        $style = 'background:url("'.$image.'")';
    }
//background:url("https://iot-catalogue.s3.amazonaws.com/images/7XxZHP6E3E3ukgxiL/csm_sshot_software_01_917e8f387e.jpg")

    return do_blocks( 
        '
        <!-- wp:unparallel/base-card '.$base_card_props.' -->
            <div class="iotcat-component-card" style="'.$style.'">
                <div style="height:36px"></div>
                <div class="bg-light bg-opacity-75 d-flex">
                    <h6 class="text-center text-truncate flex-grow-1 fw-bold mt-2">
                        '.$block_attributes["title"].'
                    </h5>
                </div>
            </div>
        <!-- /wp:unparallel/base-card -->
    '

    ) ;


}
  function iotcat_register_component_card_block() {

    register_block_type(__DIR__ . '/build/iotcat-component-card' ,
    array(
        'render_callback' => 'iotcat_component_card_render_callback'
    )
);

  }
  add_action( 'init', 'iotcat_register_component_card_block' );


?>