<?php

/**
 * Plugin Name:       IoT Catalogue Integration
 * Description:       Display in wordpress content from IoT Catalogue
 * Version:           1.0.0
 * Author:            UNPARALLEL Innovation, Lda
 * Author URI:        https://www.unparallel.pt
 */
 require_once  __DIR__ . '/includes/log.php';
 require_once  __DIR__ . '/includes/variables.php';
 if ( is_admin() ) {
     // we are in admin mode
     require_once __DIR__ . '/admin/settings.php';
 }
  require_once  __DIR__ . '/includes/iotcat_subscription.php';
  require_once  __DIR__ . '/includes/iotcat_components.php';
  require_once  __DIR__ . '/includes/iotcat_validations.php';

$iotcat_base_url = "https://www.iot-catalogue.com";


$iotcat_components_singular_name =  get_option( 'iotcat_options' )["iotcat_field_components_singular"] ??$iotcat_default_components_singular_name;
$iotcat_components_plural_name =  get_option( 'iotcat_options' )["iotcat_field_components_plural"] ??$iotcat_default_components_plural_name;

$iotcat_validations_singular_name =  get_option( 'iotcat_options' )["iotcat_field_validations_singular"] ??$iotcat_default_validations_singular_name;
$iotcat_validations_plural_name =  get_option( 'iotcat_options' )["iotcat_field_validations_plural"] ??$iotcat_default_validations_plural_name;

$iotcat_components =  new IoTCat_components($iotcat_components_plural_name, $iotcat_components_singular_name );
$iotcat_validations = new IoTCat_validations($iotcat_validations_plural_name,$iotcat_validations_singular_name );
function iotcat_added_option($option, $value){
  global $iotcat_base_url;
  if($option === "iotcat_options"){
    global $iotcat_components,$iotcat_validations;
    if(array_key_exists("iotcat_field_token", $value)){
      $token = $value["iotcat_field_token"];
      if($token){
        $iotcat_subscription = new IoTCat_subscription($token,$iotcat_components,$iotcat_validations,$iotcat_base_url);
        update_option( 'iotcat_subscription_instance', $iotcat_subscription);
        iotcat_sync_data($iotcat_subscription);
      }
    }

  }
}

function iotcat_sync_data($iotcat_subscription){
  $iotcat_subscription -> sync_data();


}


function iotcat_destroy_current_subscription(){
  $current_subscription = get_option('iotcat_subscription_instance');
  if($current_subscription){
    $current_subscription->destroy();
    delete_option('iotcat_subscription_instance');
  }
}


function iotcat_updated_option($option, $old_value,$value){

  global $iotcat_base_url;
  if($option === "iotcat_options"){
    iotcat_destroy_current_subscription();
    if(array_key_exists("iotcat_field_token", $value)){
      $token = $value["iotcat_field_token"];
      if($token){
        global $iotcat_components,$iotcat_validations;
        $iotcat_subscription = new IoTCat_subscription($token,$iotcat_components,$iotcat_validations,$iotcat_base_url);
        update_option( 'iotcat_subscription_instance', $iotcat_subscription);
        iotcat_sync_data($iotcat_subscription);
      }
    }

  }

}


//https://developer.wordpress.org/reference/hooks/update_option/
add_action( 'updated_option', 'iotcat_updated_option', 10, 3 );
add_action( 'added_option', 'iotcat_added_option', 10, 2 );

function iotcat_activate() {

  $current_subscription = get_option('iotcat_subscription_instance');
  if($current_subscription){
    iotcat_sync_data($current_subscription);
  }
  /* activation code here */
}
register_activation_hook( __FILE__, 'iotcat_activate' );
function iotcat_deactivate() {

  //iotcat_destroy_current_subscription();
  /* activation code here */
}
register_deactivation_hook( __FILE__, 'iotcat_deactivate' );


 ?>