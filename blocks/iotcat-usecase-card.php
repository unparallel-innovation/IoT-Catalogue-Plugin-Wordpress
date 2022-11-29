<?php



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


function iotcat_usecase_card_render_callback( $block_attributes, $content, $block ) {

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
    $boxes = $block_attributes["boxes"];
    $style = "";
    $color = null;
    if(array_key_exists("color", $block_attributes)){
     $color = $block_attributes["color"];
      $style ='{"borderColor":"'.$color.'"}';
    }
    return do_blocks( 
        '
        <!-- wp:unparallel/base-card '.$style.' -->
            <div >
                <h5 class="mt-0 pt-3 mb-3 fw-bold text-center text-truncate border-top border-white">
                    '.$block_attributes["title"].'
                </h5>
                <div class="d-flex flex-wrap ">
                    '.iotcat_usecase_card_render_boxes($boxes,$color).'
                </div>
            </div>
        <!-- /wp:unparallel/base-card -->
    '

    ) ;


}
  function iotcat_register_usecase_card_block() {

    register_block_type(__DIR__ . '/build/iotcat-usecase-card' ,
    array(
        'render_callback' => 'iotcat_usecase_card_render_callback'
    )
);

  }
  add_action( 'init', 'iotcat_register_usecase_card_block' );


?>