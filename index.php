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

  log_me("********************************************************************************************************");
/*
if(isset(get_option( 'iotcat_options' )) && get_option( 'iotcat_options' )["iotcat_field_token"]){
  $iotcat_components =  new IoTCat_components();
}





*/


$iotcat_components_singular_name =  get_option( 'iotcat_options' )["iotcat_field_components_singular"] ??$iotcat_default_components_singular_name;
$iotcat_components_plural_name =  get_option( 'iotcat_options' )["iotcat_field_components_plural"] ??$iotcat_default_components_plural_name;

$iotcat_components =  new IoTCat_components($iotcat_components_plural_name, $iotcat_components_singular_name );

function added_option($option, $value){
  if($option === "iotcat_options"){
    global $iotcat_components;
    if(array_key_exists("iotcat_field_token", $value)){
      $token = $value["iotcat_field_token"];
      if($token){
        $iotcat_subscription = new IoTCat_subscription($token, $iotcat_components );
        update_option( 'iotcat_subscription_instance', $iotcat_subscription);
        $iotcat_subscription -> sync_data();
      }
    }

  }
}

function destroy_current_subscription(){
  $current_subscription = get_option('iotcat_subscription_instance');
  if($current_subscription){
    $current_subscription->destroy();
    delete_option('iotcat_subscription_instance');
  }
}


function updated_option($option, $old_value,$value){
  log_me("update option");
  if($option === "iotcat_options"){
    destroy_current_subscription();
    if(array_key_exists("iotcat_field_token", $value)){
      $token = $value["iotcat_field_token"];
      if($token){
        global $iotcat_components;
        $iotcat_subscription = new IoTCat_subscription($token,$iotcat_components);
        update_option( 'iotcat_subscription_instance', $iotcat_subscription);
        $iotcat_subscription -> sync_data();
      }
    }

  }

}

//https://developer.wordpress.org/reference/hooks/update_option/
add_action( 'updated_option', 'updated_option', 10, 3 );
add_action( 'added_option', 'added_option', 10, 2 );

function my_plugin_activate() {

  log_me("activate");
  $current_subscription = get_option('iotcat_subscription_instance');
  if($current_subscription){
    $current_subscription -> sync_data();
  }
  log_me(get_option('iotcat_subscription_instance'));
  /* activation code here */
}
register_activation_hook( __FILE__, 'my_plugin_activate' );
function my_plugin_deactivate() {

  log_me("deactivate");
  log_me(get_option('iotcat_subscription_instance'));
  //destroy_current_subscription();
  /* activation code here */
}
register_deactivation_hook( __FILE__, 'my_plugin_deactivate' );


 ?>
