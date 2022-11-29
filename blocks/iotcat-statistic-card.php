<?php

function iotcat_statistic_card_render_callback( $block_attributes, $content, $block ) {
    $color = null;
    if(array_key_exists("color", $block_attributes)){
        $color = $block_attributes["color"];
    }

    $count = "";
    if(array_key_exists("endpoint", $block_attributes)){
        $count = file_get_contents($block_attributes["endpoint"]);
    }   

    $image = "";
    if(array_key_exists("image", $block_attributes)){
        $image = $block_attributes["image"];
    }

    return '
        <div class="iotcat-statistic-card d-flex flex-column align-items-center p-4">   
            <div style="width: 50px; height: 50px">
                <img src='.$image.' />
            </div>
            <h2 style="color:'.$color.'; margin-bottom: 4px; font-weight: bold">
                '.$count.'
            </h2>
            <h6 class="text-uppercase" style="color:'.$color.'">
                '.$block_attributes["type"].'
            </h6>
        </div>
    ';

}
  
function iotcat_register_statistic_card_block() {

    register_block_type(__DIR__ . '/build/iotcat-statistic-card' ,
    array(
        'render_callback' => 'iotcat_statistic_card_render_callback'
    ));
}
  
add_action( 'init', 'iotcat_register_statistic_card_block' );

?>