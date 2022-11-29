<?php

function iotcat_usecases_add_page_header() {

    ?>  
            <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.theme.min.css">
            
            <script>
                    window.onload = function() {
                        if(document.getElementsByClassName("glide").length === 0){
                            return;
                        }

                        new Glide('.glide').mount()
                     
                    }
            </script>
    <?php


}

//<!-- wp:unparallel/iotcat-usecase-card {"title":"Title","boxes":[{"label":"m","value":"d"}],"color":"#f78da7"} /-->
//json_encode
function iotcat_get_usecase_block($usecase){
    //return '<div style="width:100%;height:200px;background-color:green">AAA</div>';
    global $iotcat_base_url ;
    $title = $usecase["name"];
    $href = $iotcat_base_url.'/validations/'.$usecase["_id"];
    $boxes = array(
        array("label"=>"Validations","value"=>$usecase["validationCount"]),
        array("label"=>"Places","value"=>$usecase["placeCount"]),
        array("label"=>"Components","value"=>$usecase["componentCount"]),
        array("label"=>"Value Propositions","value"=>$usecase["valuePropositionCount"]),
        array("label"=>"ICT Problems","value"=>$usecase["ictProblemCount"])
    );
    return do_blocks('<div class="mb-3"><a target="_blank" href="'.$href.'" class="text-decoration-none"><!-- wp:unparallel/iotcat-usecase-card {"title":"'.$title.'","boxes":'.json_encode($boxes).'} /--></a></div>');
}


function iotcat_usecases_render_buttons($count){
    $html = "";
    for($i=0;$i<$count;$i++){
        $html = $html.'<button class="glide__bullet" data-glide-dir="='.$i.'"></button>';
    }
    return $html;
}


function iotcat_usecases_render_callback_old( $block_attributes, $content, $block ) {
    global $iotcat_base_url ;
    
    if( !array_key_exists("iotcat_field_token",get_option( 'iotcat_options' ))){
        return "<div>Token not defined</div>";
    }
    $token = get_option( 'iotcat_options' )["iotcat_field_token"];
    $response = wp_remote_get( $iotcat_base_url."/api/useCaseWithStats?access_token=".$token );
    $usecases = json_decode( wp_remote_retrieve_body( $response ), true );



    $items_per_slide = 6;
    $open_slider = '<li class="glide__slide"><div class="row">';
    $close_slider = '</div></li>';
    $html = '
    <div class="glide">
        <div data-glide-el="track" class="glide__track">
            <ul class="glide__slides">'.$open_slider;
    foreach($usecases as $key=>$usecase){
        $rem = $key%$items_per_slide ;
        if($rem === 0 && $key < count($usecases) - 1 && $key > 0){
            $html = $html.$close_slider.$open_slider;
        }
        $html = $html.'<div class="col-12 col-md-6 col-lg-4">'.iotcat_get_usecase_block($usecase).'</div>';
    }
    $html=$html.$close_slider.'

            </ul>
        </div>
        <div class="iotcat-usecases-bullets">

            <div class="glide__bullets" data-glide-el="controls[nav]">
               '.iotcat_usecases_render_buttons(ceil(count($usecases)/$items_per_slide )).'
            </div>
        </div>
    </div>

    ';
    return $html;
    
    


}

function iotcat_usecases_render_callback( $block_attributes, $content, $block ) {
    global $iotcat_base_url ;
    if( !array_key_exists("iotcat_field_token",get_option( 'iotcat_options' ))){
        return "<div>Token not defined</div>";
    }
    $token = get_option( 'iotcat_options' )["iotcat_field_token"];
    $response = wp_remote_get( $iotcat_base_url."/api/useCaseWithStats?access_token=".$token );
    $usecases = json_decode( wp_remote_retrieve_body( $response ), true );
    $items_per_slide = 6;
    $slides = array();
    $html = '<div class="row">';
    foreach($usecases as $key=>$usecase){
        $rem = $key%$items_per_slide ;
        if($rem === 0 && $key < count($usecases) - 1 && $key > 0){
            $html = $html.'</div>';
            array_push($slides,$html);
            $html ='<div class="row">';
        }
        
        $html = $html.'<div class="col-12 col-md-6">'.iotcat_get_usecase_block($usecase).'</div>';

    }

    $html = $html.'</div>';
    array_push($slides,$html);
    $carousel = new IoTCat_carousel($slides,array("hide_buttons"=>true));
    return  $carousel->render();





    
    


}
  function iotcat_register_usecases_block() {
    add_action('wp_head', "iotcat_usecases_add_page_header");
    register_block_type(__DIR__ . '/build/iotcat-usecases' ,
    array(
        'render_callback' => 'iotcat_usecases_render_callback'
    )
);

  }
  add_action( 'init', 'iotcat_register_usecases_block' );


?>