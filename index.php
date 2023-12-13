<?php

/**
 * Plugin Name:       IoT Catalogue Integration
 * Description:       Display in WordPress content from IoT Catalogue
 * Version:           1.10.0-0
 * Author:            UNPARALLEL Innovation, Lda
 * Author URI:        https://www.unparallel.pt
 */


 /*
 IoT Catalogue Integration is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.

 IoT Catalogue Integration is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with IoT Catalogue Integration. If not, see https://github.com/unparallel-innovation/IoT-Catalogue-Plugin-Wordpress/blob/main/LICENSE.
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
  require_once  __DIR__ . '/includes/iotcat_datasets.php';
  require_once  __DIR__ . '/includes/iotcat_data_concepts.php';
  require_once  __DIR__ . '/includes/iotcat_measurable_quantities.php';






$iotcat_field_data_update_interval =  get_option( 'iotcat_options' )["iotcat_field_data_update_interval"] ??$iotcat_default_data_update_interval;


$iotcat_components_singular_name =  get_option( 'iotcat_options' )["iotcat_field_components_singular"] ??$iotcat_default_components_singular_name;
$iotcat_components_plural_name =  get_option( 'iotcat_options' )["iotcat_field_components_plural"] ??$iotcat_default_components_plural_name;

$iotcat_validations_singular_name =  get_option( 'iotcat_options' )["iotcat_field_validations_singular"] ??$iotcat_default_validations_singular_name;
$iotcat_validations_plural_name =  get_option( 'iotcat_options' )["iotcat_field_validations_plural"] ??$iotcat_default_validations_plural_name;

$iotcat_datasets_singular_name =  get_option( 'iotcat_options' )["iotcat_field_datasets_singular"] ??$iotcat_default_datasets_singular_name;
$iotcat_datasets_plural_name =  get_option( 'iotcat_options' )["iotcat_field_datasets_plural"] ??$iotcat_default_datasets_plural_name;

$iotcat_data_concepts_singular_name =  get_option( 'iotcat_options' )["iotcat_field_data_concepts_singular"] ??$iotcat_default_data_concepts_singular_name;
$iotcat_data_concepts_plural_name =  get_option( 'iotcat_options' )["iotcat_field_data_concepts_plural"] ??$iotcat_default_data_concepts_plural_name;

$iotcat_measurable_quantities_singular_name =  get_option( 'iotcat_options' )["iotcat_field_measurable_quantities_singular"] ??$iotcat_default_measurable_quantities_singular_name;
$iotcat_measurable_quantities_plural_name =  get_option( 'iotcat_options' )["iotcat_field_measurable_quantities_plural"] ??$iotcat_default_measurable_quantities_plural_name;

$iotcat_validations_comment_status=  get_option( 'iotcat_options' )["iotcat_validations_comment_status"] ??$iotcat_default_validations_comment_status;
$iotcat_components_comment_status=  get_option( 'iotcat_options' )["iotcat_components_comment_status"] ??$iotcat_default_components_comment_status;
$iotcat_datasets_comment_status=  get_option( 'iotcat_options' )["iotcat_datasets_comment_status"] ??$iotcat_default_datasets_comment_status;
$iotcat_data_concepts_comment_status=  get_option( 'iotcat_options' )["iotcat_data_concepts_comment_status"] ??$iotcat_default_data_concepts_comment_status;
$iotcat_measurable_quantities_comment_status=  get_option( 'iotcat_options' )["iotcat_measurable_quantities_comment_status"] ??$iotcat_default_measurable_quantities_comment_status;

$iotcat_validations_um_content_restriction = get_option( 'iotcat_options' )["iotcat_validations_um_content_restriction"] ??$iotcat_default_validations_um_content_restriction;
$iotcat_components_um_content_restriction = get_option( 'iotcat_options' )["iotcat_components_um_content_restriction"] ??$iotcat_default_components_um_content_restriction;
$iotcat_datasets_um_content_restriction = get_option( 'iotcat_options' )["iotcat_datasets_um_content_restriction"] ??$iotcat_default_datasets_um_content_restriction;
$iotcat_data_concepts_um_content_restriction = get_option( 'iotcat_options' )["iotcat_datasets_um_content_restriction"] ??$iotcat_default_data_concepts_um_content_restriction;
$iotcat_measurable_quantities_um_content_restriction = get_option( 'iotcat_options' )["iotcat_measurable_quantities_um_content_restriction"] ??$iotcat_default_measurable_quantities_um_content_restriction;

$iotcat_components =  new IoTCat_components($iotcat_components_plural_name, $iotcat_components_singular_name,array("um_content_restriction"=>$iotcat_components_um_content_restriction ),$iotcat_components_comment_status );
$iotcat_validations = new IoTCat_validations($iotcat_validations_plural_name,$iotcat_validations_singular_name,array("um_content_restriction"=>$iotcat_validations_um_content_restriction ),$iotcat_validations_comment_status );
$iotcat_datasets = new IoTCat_datasets($iotcat_datasets_plural_name,$iotcat_datasets_singular_name,array("um_content_restriction"=>$iotcat_datasets_um_content_restriction ),$iotcat_datasets_comment_status );
$iotcat_data_concepts = new IoTCat_data_concepts($iotcat_data_concepts_plural_name,$iotcat_data_concepts_singular_name,array("um_content_restriction"=>$iotcat_data_concepts_um_content_restriction ),$iotcat_data_concepts_comment_status );
$iotcat_measurable_quantities = new IoTCat_measurable_quantities($iotcat_measurable_quantities_plural_name,$iotcat_measurable_quantities_singular_name,array("um_content_restriction"=>$iotcat_measurable_quantities_um_content_restriction ),$iotcat_measurable_quantities_comment_status );




function iotcat_get_element_instances(){
  global $iotcat_components,$iotcat_validations,$iotcat_datasets,$iotcat_data_concepts,$iotcat_measurable_quantities;
  $element_instances = array();
  $iotcat_components_enabled = get_option( 'iotcat_options' )["iotcat_field_components_enabled"]!=="-1" ;
  if($iotcat_components_enabled){
    array_push( $element_instances ,$iotcat_components);
  }
  $iotcat_validations_enabled = get_option( 'iotcat_options' )["iotcat_field_validations_enabled"]!=="-1" ;
  if($iotcat_validations_enabled){
    array_push(  $element_instances ,$iotcat_validations);
  }
  $iotcat_field_datasets_enabled = get_option( 'iotcat_options' )["iotcat_field_datasets_enabled"]!=="-1" ;
  if($iotcat_field_datasets_enabled){
    array_push(  $element_instances ,$iotcat_datasets);
  }
  $iotcat_field_data_concepts_enabled = get_option( 'iotcat_options' )["iotcat_field_data_concepts_enabled"]!=="-1" ;
  if($iotcat_field_data_concepts_enabled){
    array_push(  $element_instances ,$iotcat_data_concepts);
  }
  $iotcat_field_measurable_quantities_enabled = get_option( 'iotcat_options' )["iotcat_field_measurable_quantities_enabled"]!=="-1" ;
  if($iotcat_field_measurable_quantities_enabled){
    array_push(  $element_instances ,$iotcat_measurable_quantities);
  }
  return  $element_instances;
}
function iotcat_get_base_url(){
  global $iotcat_default_base_url;
  return get_option( 'iotcat_options' )["iotcat_field_base_url"] ??$iotcat_default_base_url;
}

function iotcat_added_option($option, $value){
  if($option === "iotcat_options"){
    global $iotcat_components,$iotcat_validations,$iotcat_datasets,$iotcat_data_concepts,$iotcat_measurable_quantities,$iotcat_default_base_url;
    if(array_key_exists("iotcat_field_token", $value)){
      $token = $value["iotcat_field_token"];
      if($token){
        $iotcat_subscription = new IoTCat_subscription($token,iotcat_get_element_instances(),iotcat_get_base_url());
        update_option( 'iotcat_subscription_instance', $iotcat_subscription);
        iotcat_sync_data($iotcat_subscription);
      }
    }

  }
}

function iotcat_sync_data($iotcat_subscription){
  $iotcat_subscription -> get_data();


}


function iotcat_destroy_current_subscription(){
  $current_subscription = get_option('iotcat_subscription_instance');
  if($current_subscription){
    $current_subscription->destroy();
    delete_option('iotcat_subscription_instance');
  }
}



function iotcat_updated_option($option, $old_value,$value){

  if($option === "iotcat_options"){
    iotcat_destroy_current_subscription();
    if(array_key_exists("iotcat_field_token", $value)){
      $token = $value["iotcat_field_token"];
      if($token){
        global $iotcat_components,$iotcat_validations,$iotcat_datasets,$iotcat_data_concepts,$iotcat_measurable_quantities;$iotcat_default_base_url;
        
        $iotcat_subscription = new IoTCat_subscription($token,iotcat_get_element_instances(),iotcat_get_base_url());
        update_option( 'iotcat_subscription_instance', $iotcat_subscription);
        iotcat_sync_data($iotcat_subscription);
      }
    }

  }

}

add_action( 'updated_option', 'iotcat_updated_option', 10, 3 );
add_action( 'added_option', 'iotcat_added_option', 10, 2 );

add_filter( 'cron_schedules', 'iotcat_add_update_interval' );
function iotcat_add_update_interval($schedules){
  global $iotcat_field_data_update_interval;
  $schedules['iotcat_update_interval'] = array(
        'interval' => intval($iotcat_field_data_update_interval)*60,
        'display'  => esc_html__( "Every .$iotcat_field_data_update_interval minutes" ), );
    return $schedules;

}


function iotcat_update_data_exec(){
  $user_id = get_option("iotcat_plugin_admin_user_id");
  if($user_id > 0){
    wp_set_current_user($user_id);
    $current_subscription = get_option('iotcat_subscription_instance');
    if($current_subscription){
      $current_subscription->get_data();
    }
  }

}

add_action( 'iotcat_update_data', 'iotcat_update_data_exec', 10, 0 );

if ( ! wp_next_scheduled( 'iotcat_update_data' ) ) {

  $current_time = time() + 10;
  wp_schedule_event($current_time, 'iotcat_update_interval', 'iotcat_update_data' , array(), true);
}


function iotcat_activate() {
  $user =wp_get_current_user();
  update_option( "iotcat_plugin_admin_user_id",$user->ID);
  $current_subscription = get_option('iotcat_subscription_instance');
  if($current_subscription){
    iotcat_sync_data($current_subscription);
  }

}
register_activation_hook( __FILE__, 'iotcat_activate' );


function iotcat_deactivate() {
  remove_filter( 'cron_schedules', 'iotcat_add_update_interval' );
  $timestamp = wp_next_scheduled( 'iotcat_update_data' );
    wp_unschedule_event( $timestamp, 'iotcat_update_data' );

}
register_deactivation_hook( __FILE__, 'iotcat_deactivate' );


 ?>
