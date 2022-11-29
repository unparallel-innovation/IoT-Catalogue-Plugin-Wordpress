<?php


function iotcat_carousel_add_page_header() {
    ?>
    <style>
       /*.iotcat-bs-carousel .carousel-item{
            display:block;
        }*/

        .iotcat-bs-carousel .carousel-item:not(.active):not(.carousel-item-prev):not(.carousel-item-next){
        /*    opacity:0;
            pointer-events:none;*/
           /* display:block;*/
        }
        .iotcat-bs-carousel .carousel-inner {
           /* display:flex;*/
        }
        .iotcat-bs-carousel .carousel-item {
        /*    float:none;*/
        }
        </style>
<?php

}

class IoTCat_carousel {


    


	function __construct($slides, $options = array()) {

		$this->id = uniqid("bs_carousel_");
        $this->slides = $slides;
        $this->options = $options;

	}

  
    private function render_indicators(){
        $slide_count = count($this->slides);
        $html = "";
        for($i=0;$i<$slide_count;$i++){
            $class = $i===0?"active":"";
            $label = "Slide " + ($i + 1);
            $html = $html.'<button type="button" data-bs-target="#'.$this->id.'" data-bs-slide-to="'.$i.'" class="'.$class.'" aria-current="true" aria-label="'.$label.'"></button>';
        }
        return $html;
    }


    private function render_slides(){
        $slide_count = count($this->slides);
        $html = "";
        for($i=0;$i<$slide_count;$i++){
            $class = $i===0?"carousel-item active":"carousel-item";
            $content = $this->slides[$i];
            $html = $html.'
            <div class="'.$class.'">
                '.$content.'
            </div>
            ';
        }
        return $html;
    }

    private function render_buttons(){
        if(array_key_exists("hide_buttons",$this->options) && $this->options["hide_buttons"] === true){
            return "";
        }
        return '
            <button class="carousel-control-prev" type="button" data-bs-target="#'.$this->id.'" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#'.$this->id.'" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        ';
    }

    function render(){

        $style = "";
        if(array_key_exists("height",$this->options)){
            $style = 'min-height:'.$this->options["height"].'px';
        }
        return '
            <div id="'.$this->id.'" style="'.$style.'" class="iotcat-bs-carousel carousel carousel-dark slide pb-4" data-bs-ride="carousel">
                <div class="carousel-indicators" style="bottom:-5px">
                    '.$this->render_indicators().'
                </div>
                <div class="carousel-inner">
                    '.$this->render_slides().'   
                </div>
                    '.$this->render_buttons().'
            </div>       
        ';
    }
}
add_action('wp_head',"iotcat_carousel_add_page_header");
?>