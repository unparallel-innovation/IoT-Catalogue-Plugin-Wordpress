<?php



/**
 * Plugin Name:       IoT Catalogue Integration
 * Description:       Display in wordpress content from IoT Catalogue
 * Version:           1.0.0
 * Author:            UNPARALLEL Innovation, Lda
 * Author URI:        https://www.unparallel.pt
 */
 require_once  __DIR__ . '/includes/log.php';
 if ( is_admin() ) {
     // we are in admin mode
     require_once __DIR__ . '/admin/settings.php';
 }
  require_once  __DIR__ . '/includes/iotcat_subscription.php';
  require_once  __DIR__ . '/includes/iotcat_components.php';
  $iotcat_components =  new IoTCat_components();








function add_data(){
  global $iotcat_components;
  $iotcat_components->add_new(
    "A&D Medical Deluxe Upper Arm Blood Pressure Monitor with Bluetooth (UA-651BLE)x",
    "A wireless blood pressure monitor that automatically records and tracks measurements via mobile app to enable trending and sharing",
    "https://iot-catalogue.s3.amazonaws.com/images/xfSizLbvpJtWJ44ud/UA-651BLE.jpg",
    "5a82d2c836acc6d2aa8c50d6x");

}

function added_option($option, $value){
  if($option === "iotcat_options"){
    global $iotcat_components;
    $token = $value["iotcat_field_token"];
    if($token){
      $iotcat_subscription = new IoTCat_subscription($token, $iotcat_components );
      update_option( 'iotcat_subscription_instance', $iotcat_subscription);
    }
  }
}


function updated_option($option, $old_value,$value){
  if($option === "iotcat_options"){
    $current_subscription = get_option('iotcat_subscription_instance');


    if($current_subscription){
      $current_subscription->destroy();
      delete_option('iotcat_subscription_instance');

    }
    $token = $value["iotcat_field_token"];
    if($token){
      global $iotcat_components;
      $iotcat_subscription = new IoTCat_subscription($token,$iotcat_components);
      update_option( 'iotcat_subscription_instance', $iotcat_subscription);
      $iotcat_subscription -> subscribe();
    }
  }

}

//https://developer.wordpress.org/reference/hooks/update_option/
add_action( 'updated_option', 'updated_option', 10, 3 );
add_action( 'added_option', 'added_option', 10, 2 );




 ?>
