<?php

function iotcat_embed_add_page_header() {
        iotcat_log_me("iotcat_embed_add_page_header");
        ?>

                <script>
                    	window.onload = function() {

                            const elements = document.getElementsByClassName("iotcat-iframe");

                            function receiveMessage(event) {
                                const data = event.data
                                if (data.action == "resize") {

                                    for (let i = 0; i < elements.length; i++) {
                                        const element = elements.item(i);
                                        element.style.height = data.height + 'px';
                                    }
                                    
                                }
                            }
                            window.addEventListener("message", receiveMessage, false)
                            window.onbeforeunload = function(){
                                window.removeEventListener("message", receiveMessage);
                            };
                         
                        }
                </script>
        <?php


}



function iotcat_embed_render_callback( $block_attributes, $content, $block ) {
    if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	$post_ID = $block->context['postId'];
    $post_type = $block->context['postType'];
    $embedded_url = get_post_meta( $post_ID ,"iotcat_embedded_url");
    $tags_path = get_post_meta( $post_ID ,"iotcat_tags_path");

    if(count($embedded_url) === 0){
        return "";
    }
    
    return "<iframe class=\"iotcat-iframe\" style=\"height: 0px;width: 100%\" src=\"".$embedded_url[0]."\" ></iframe>";

}
  function iotcat_register_embed_block() {

    add_action('wp_head', "iotcat_embed_add_page_header");
    register_block_type(__DIR__ . '/build/iotcat-embed' ,
    array(
        'render_callback' => 'iotcat_embed_render_callback'
    )
);

  }
  add_action( 'init', 'iotcat_register_embed_block' );


?>