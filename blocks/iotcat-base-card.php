<?php
  function iotcat_base_card_render_callback( $block_attributes, $content, $block ) {
    $style = "";
    if(array_key_exists("borderColor", $block_attributes)){
      $style = "background-color: ".$block_attributes["borderColor"]."!important";
    }
    return '
    <div class="iotcat-base-card d-flex">
				<div class="iotcat-base-card-margin rounded-start bg-primary flex-shrink-0"  style="'.$style.'"></div>
				<div class="iotcat-base-card-body flex-grow-1 border rounded-end border-2 overflow-hidden">'. $content.'</div>
			</div>
    ';
    
  }

  function iotcat_register_base_card() {

      register_block_type(__DIR__ . '/build/iotcat-base-card',
      array(
          'render_callback' => 'iotcat_base_card_render_callback'
      )
    );
 
  }
  add_action( 'init', 'iotcat_register_base_card' );


?>