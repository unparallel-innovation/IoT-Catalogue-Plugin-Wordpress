<?php



 /**
  * @internal never define functions inside callbacks.
  * these functions could be run multiple times; this would result in a fatal error.
  */

 /**
  * custom option and settings
  */

  function iotcat_options_handler($options)
  {
    global $iotcat_default_base_url,
    $iotcat_default_components_singular_name, 
    $iotcat_default_components_plural_name,

    $iotcat_default_validations_plural_name,
    $iotcat_default_validations_singular_name,

    $iotcat_default_datasets_singular_name,
    $iotcat_default_datasets_plural_name,

    $iotcat_default_data_concepts_singular_name,
    $iotcat_default_data_concepts_plural_name,


    $iotcat_default_measurable_quantities_singular_name,
    $iotcat_default_measurable_quantities_plural_name,

    $iotcat_default_data_update_interval;


    if($_POST["submit"] === "Delete Subscription"){
      unset($options["iotcat_field_token"]);
    }

    $data_update_interval = $iotcat_default_data_update_interval;

    if(
            array_key_exists("iotcat_field_data_update_interval", $options) &&
            $options["iotcat_field_data_update_interval"] &&
            (string)(int)$options["iotcat_field_data_update_interval"] == $options["iotcat_field_data_update_interval"]
    ){
      $data_update_interval = $options["iotcat_field_data_update_interval"];
    }

    $base_url = $iotcat_default_base_url;
    $component_singular = $iotcat_default_components_singular_name;
    $component_plural = $iotcat_default_components_plural_name;


    if(array_key_exists("iotcat_field_base_url", $options) &&  $options["iotcat_field_base_url"]){
      $base_url = $options["iotcat_field_base_url"];
    }

    if(array_key_exists("iotcat_field_components_singular", $options) &&  $options["iotcat_field_components_singular"]){
      $component_singular = $options["iotcat_field_components_singular"];
    }

    if(array_key_exists("iotcat_field_components_plural", $options) &&  $options["iotcat_field_components_plural"]){
      $component_plural = $options["iotcat_field_components_plural"];
    }

    $validation_singular = $iotcat_default_validations_singular_name;
    $validation_plural = $iotcat_default_validations_plural_name;

    if(array_key_exists("iotcat_field_validations_singular", $options) &&  $options["iotcat_field_validations_singular"]){
      $validation_singular = $options["iotcat_field_validations_singular"];
    }

    if(array_key_exists("iotcat_field_validations_plural", $options) &&  $options["iotcat_field_validations_plural"]){
      $validation_plural = $options["iotcat_field_validations_plural"];
    }

    $dataset_singular = $iotcat_default_datasets_singular_name;
    $dataset_plural = $iotcat_default_datasets_plural_name;

    if(array_key_exists("iotcat_field_datasets_singular", $options) &&  $options["iotcat_field_datasets_singular"]){
      $dataset_singular = $options["iotcat_field_datasets_singular"];
    }

    if(array_key_exists("iotcat_field_datasets_plural", $options) &&  $options["iotcat_field_datasets_plural"]){
      $dataset_plural = $options["iotcat_field_datasets_plural"];
    }


    $data_concept_singular = $iotcat_default_data_concepts_singular_name;
    $data_concept_plural = $iotcat_default_data_concepts_plural_name;

    if(array_key_exists("iotcat_field_data_concepts_singular", $options) &&  $options["iotcat_field_data_concepts_singular"]){
      $data_concept_singular = $options["iotcat_field_data_concepts_singular"];
    }

    if(array_key_exists("iotcat_field_data_concepts_plural", $options) &&  $options["iotcat_field_data_concepts_plural"]){
      $data_concept_plural = $options["iotcat_field_data_concepts_plural"];
    }


    $measurable_quantity_singular = $iotcat_default_measurable_quantities_singular_name;
    $measurable_quantity_plural = $iotcat_default_measurable_quantities_plural_name;

    if(array_key_exists("iotcat_field_measurable_quantities_singular", $options) &&  $options["iotcat_field_measurable_quantities_singular"]){
      $measurable_quantity_singular = $options["iotcat_field_measurable_quantities_singular"];
    }

    if(array_key_exists("iotcat_field_measurable_quantities_plural", $options) &&  $options["iotcat_field_measurable_quantities_plural"]){
      $measurable_quantity_plural = $options["iotcat_field_measurable_quantities_plural"];
    }


    

    $oldlevel = error_reporting(E_ALL & ~E_WARNING);
    $iotcat_field_components_enabled =$options["iotcat_field_components_enabled"]==="1"?$options["iotcat_field_components_enabled"]:"-1";
    $iotcat_field_validations_enabled = $options["iotcat_field_validations_enabled"]==="1"?$options["iotcat_field_validations_enabled"]:"-1";

    $iotcat_field_datasets_enabled = $options["iotcat_field_datasets_enabled"]==="1"?$options["iotcat_field_datasets_enabled"]:"-1";
    $iotcat_field_data_concepts_enabled = $options["iotcat_field_data_concepts_enabled"]==="1"?$options["iotcat_field_data_concepts_enabled"]:"-1";
    $iotcat_field_measurable_quantities_enabled = $options["iotcat_field_measurable_quantities_enabled"]==="1"?$options["iotcat_field_measurable_quantities_enabled"]:"-1";

    error_reporting($oldlevel);


    return array_merge(
        $options
        ,array(
          "iotcat_field_data_update_interval"=>$data_update_interval,
          "iotcat_field_components_enabled"=>$iotcat_field_components_enabled ,

          "iotcat_field_components_singular"=>$component_singular ,
          "iotcat_field_components_plural"=>$component_plural,
          "iotcat_field_validations_enabled"=>$iotcat_field_validations_enabled ,
          "iotcat_field_validations_singular"=>$validation_singular ,
          "iotcat_field_validations_plural"=>$validation_plural,
          "iotcat_field_datasets_enabled"=>$iotcat_field_datasets_enabled ,
          "iotcat_field_datasets_singular"=>$dataset_singular ,
          "iotcat_field_datasets_plural"=>$dataset_plural,
          "iotcat_field_data_concepts_enabled"=>$iotcat_field_data_concepts_enabled ,
          "iotcat_field_data_concepts_singular"=>$data_concept_singular ,
          "iotcat_field_data_concepts_plural"=>$data_concept_plural,
          "iotcat_field_measurable_quantities_enabled"=>$iotcat_field_measurable_quantities_enabled ,
          "iotcat_field_measurable_quantities_singular"=>$measurable_quantity_singular ,
          "iotcat_field_measurable_quantities_plural"=>$measurable_quantity_plural,
          "iotcat_field_base_url"=>$base_url
        )
      );

   }

 function iotcat_settings_init() {
    global $iotcat_default_base_url;
     // Register a new setting for "iotcat" page.
     register_setting( 'iotcat', 'iotcat_options','iotcat_options_handler' );



     // Register a new section in the "iotcat" page.
     add_settings_section(
         'iotcat_section_developers',
         __( 'IoT Catalogue Subscription ', 'iotcat' ), 'iotcat_section_developers_callback',
         'iotcat'
     );



     // Register a new field in the "iotcat_section_developers" section, inside the "iotcat" page.
     add_settings_field(
         'iotcat_field_token', // As of WP 4.6 this value is used only internally.
                                 // Use $args' label_for to populate the id inside the callback.
             __( 'Token', 'iotcat' ),
         'iotcat_field_token_cb',
         'iotcat',
         'iotcat_section_developers',
         array(
             'label_for'         => 'iotcat_field_token',
             'class'             => 'iotcat_row',
             'iotcat_custom_data' => 'custom',
         )
     );


     add_settings_field(
         'iotcat_field_data_update_interval', // As of WP 4.6 this value is used only internally.
                                 // Use $args' label_for to populate the id inside the callback.
             __( 'Data update interval (min)', 'iotcat' ),
         'iotcat_field_data_update_interval_cb',
         'iotcat',
         'iotcat_section_developers',
         array(
             'label_for'         => 'iotcat_field_data_update_interval',
             'class'             => 'iotcat_row',
             'iotcat_custom_data' => 'custom',
         )
     );

     function iotcat_add_element_enable_field($element_name,$label){
      add_settings_field(
        'iotcat_field_'.$element_name.'_enabled', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Enable '.$label.' subscription', 'iotcat' ),
        'iotcat_field_'.$element_name.'_enabled_cb',
        'iotcat',
        'iotcat_section_developers',
        array(
            'label_for'         => 'iotcat_field_'.$element_name.'_enabled',
            'class'             => 'iotcat_row',
            'iotcat_custom_data' => 'custom',
          )
      );
     }

     function iotcat_add_element_singular_field($element_name,$label){
        add_settings_field(
          'iotcat_field_'.$element_name.'_singular', // As of WP 4.6 this value is used only internally.
                                  // Use $args' label_for to populate the id inside the callback.
              __( $label.' singular name', 'iotcat' ),
          'iotcat_field_'.$element_name.'_singular_cb',
          'iotcat',
          'iotcat_section_developers',
          array(
              'label_for'         => 'iotcat_field_'.$element_name.'_singular',
              'class'             => 'iotcat_row',
              'iotcat_custom_data' => 'custom',
          )
      );
     }

     function iotcat_add_element_plural_field($element_name,$label){
        add_settings_field(
          'iotcat_field_'.$element_name.'_plural', // As of WP 4.6 this value is used only internally.
                                  // Use $args' label_for to populate the id inside the callback.
              __( $label.' plural name', 'iotcat' ),
          'iotcat_field_'.$element_name.'_plural_cb',
          'iotcat',
          'iotcat_section_developers',
          array(
              'label_for'         => 'iotcat_field_'.$element_name.'_plural',
              'class'             => 'iotcat_row',
              'iotcat_custom_data' => 'custom',
          )
      );
     }




    $show_advanced_settings = false;
    $options = get_option( 'iotcat_options' );


      if(array_key_exists("iotcat_field_base_url", $options) &&  $options["iotcat_field_base_url"]!==$iotcat_default_base_url ||  array_key_exists("advanced_settings",$_GET) ){
        add_settings_field(
          'iotcat_field_base_url',
          __( 'Base url of IoT Catalogue instance', 'iotcat' ),
          'iotcat_field_base_url_cb',
          'iotcat',
          'iotcat_section_developers',
          array(
            'label_for'         => 'iotcat_field_base_url',
            'class'             => 'iotcat_row',
            'iotcat_custom_data' => 'custom',
          )
        );
      }
      iotcat_add_element_enable_field("components","components");
      iotcat_add_element_singular_field("components","Component");
      iotcat_add_element_plural_field("components","Component");


      iotcat_add_element_enable_field("validations","validations");    
      iotcat_add_element_singular_field("validations","Validation"); 
      iotcat_add_element_plural_field("validations","Validation"); 

      iotcat_add_element_enable_field("datasets","datasets");  
      iotcat_add_element_singular_field("datasets","Dataset"); 
      iotcat_add_element_plural_field("datasets","Dataset"); 

      iotcat_add_element_enable_field("data_concepts","data concepts");  
      iotcat_add_element_singular_field("data_concepts", "Data concept"); 
      iotcat_add_element_plural_field("data_concepts", "Data concept"); 

      iotcat_add_element_enable_field("measurable_quantities","measurable quantities");  
      iotcat_add_element_singular_field("measurable_quantities","Measurable quantity"); 
      iotcat_add_element_plural_field("measurable_quantities","Measurable quantity"); 



 }

 /**
  * Register our iotcat_settings_init to the admin_init action hook.
  */
 add_action( 'admin_init', 'iotcat_settings_init' );


 /**
  * Custom option and settings:
  *  - callback functions
  */


 /**
  * Developers section callback function.
  *
  * @param array $args  The settings array, defining title, id, callback.
  */
 function iotcat_section_developers_callback( $args ) {
     ?>
     <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'IoT Catalogue Subscription', 'iotcat' ); ?></p>
     <?php
 }

 /**
  * Pill field callbakc function.
  *
  * WordPress has magic interaction with the following keys: label_for, class.
  * - the "label_for" key value is used for the "for" attribute of the <label>.
  * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
  * Note: you can add custom key value pairs to be used inside your callbacks.
  *
  * @param array $args
  */
 function iotcat_field_token_cb( $args ) {
     // Get the value of the setting we've registered with register_setting()
     $options = get_option( 'iotcat_options' );
     ?>
     <input
  		name="iotcat_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
  		value="<?php echo $options[ $args['label_for'] ] ?? ""; ?>"
  	/>
  	<p class="description">
  	<?php esc_html_e( 'Token used to authenticate requests with.', 'iotcat' ); ?>
  	</p>

     <?php
 }

 function iotcat_field_data_update_interval_cb( $args ) {
     // Get the value of the setting we've registered with register_setting()
     global $iotcat_default_data_update_interval;
     $options = get_option( 'iotcat_options' );
     ?>
     <input
  		name="iotcat_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
  		value="<?php echo $options[ $args['label_for'] ] ?? $iotcat_default_data_update_interval; ?>"
  	/>
  	<p class="description">
  	<?php esc_html_e( 'Period in minutes between data updates.', 'iotcat' ); ?>
  	</p>

     <?php
 }
 function iotcat_field_base_url_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
  global $iotcat_default_base_url;
  $options = get_option( 'iotcat_options' );
  ?>
  <input
   name="iotcat_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
   value="<?php echo $options[ $args['label_for'] ] ?? $iotcat_default_base_url; ?>"
 />
 <p class="description">
 <?php esc_html_e( 'IoT Catalogue URL', 'iotcat' ); ?>
 </p>

  <?php
}
  function iotcat_field_elements_enable_cb($args,$plural_element_name){
     //global $iotcat_default_components_singular_name;
    // Get the value of the setting we've registered with register_setting()
    

    $options = get_option( 'iotcat_options' );

    ?>
      <input type="checkbox" name="iotcat_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="1"
      <?php checked(  $options[ $args['label_for'] ] ??  "1", 1 ); ?> />
      <p class="description">
        <?php esc_html_e( 'Enable subscriptions for '.$plural_element_name, 'iotcat' ); ?>
      </p>

    <?php   
  }



  function iotcat_field_elements_singular_cb( $args,$element_singular_name,$singular_name ) {
      // Get the value of the setting we've registered with register_setting()
      $options = get_option( 'iotcat_options' );
      ?>
      <input
       name="iotcat_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
       value="<?php echo $options[ $args['label_for'] ] ?? $singular_name ; ?>"
     />
     <p class="description">
        <?php esc_html_e( 'Singular name for '.$element_singular_name.' post type.', 'iotcat' ); ?>
     </p>
 
      <?php
  }

  function iotcat_field_elements_plural_cb( $args,$element_singular_name,$singular_name ) {
      // Get the value of the setting we've registered with register_setting()
      $options = get_option( 'iotcat_options' );
      ?>
      <input
      name="iotcat_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
      value="<?php echo $options[ $args['label_for'] ] ?? $singular_name; ?>"
    />
    <p class="description">
      <?php esc_html_e( 'Plural name for '.$element_singular_name.' post type.', 'iotcat' ); ?>
    </p>
 
      <?php
  }

  function iotcat_field_components_enabled_cb( $args ) {
    iotcat_field_elements_enable_cb( $args ,'components');
  }

 function iotcat_field_components_singular_cb( $args ) {
   global $iotcat_default_components_singular_name;
   iotcat_field_elements_singular_cb($args,"component",$iotcat_default_components_singular_name);
 }


 function iotcat_field_components_plural_cb( $args ) {
   global $iotcat_default_components_plural_name;
   iotcat_field_elements_plural_cb($args,"component",$iotcat_default_components_plural_name);

 }

  function iotcat_field_validations_enabled_cb( $args ) {
    iotcat_field_elements_enable_cb( $args ,'validations');
  }
 function iotcat_field_validations_singular_cb( $args ) {
   global $iotcat_default_validations_singular_name;
   iotcat_field_elements_singular_cb($args,"validation",$iotcat_default_validations_singular_name);

 }


 function iotcat_field_validations_plural_cb( $args ) {
   global $iotcat_default_validations_plural_name;
   iotcat_field_elements_plural_cb($args,"validation",$iotcat_default_validations_plural_name);
 }

 function iotcat_field_datasets_enabled_cb( $args ) {
  iotcat_field_elements_enable_cb( $args ,'datasets');
}
 function iotcat_field_datasets_singular_cb( $args ) {
  global $iotcat_default_datasets_singular_name;
  iotcat_field_elements_singular_cb($args,"dataset",$iotcat_default_datasets_singular_name);

}


function iotcat_field_datasets_plural_cb( $args ) {
  global $iotcat_default_datasets_plural_name;
  iotcat_field_elements_plural_cb($args,"dataset",$iotcat_default_datasets_plural_name);
}

function iotcat_field_data_concepts_enabled_cb( $args ) {
  iotcat_field_elements_enable_cb( $args ,'data concepts');
}
function iotcat_field_data_concepts_singular_cb( $args ) {
  global $iotcat_default_data_concepts_singular_name;
  iotcat_field_elements_singular_cb($args,"data concept",$iotcat_default_data_concepts_singular_name);

}


function iotcat_field_data_concepts_plural_cb( $args ) {
  global $iotcat_default_data_concepts_plural_name;
  iotcat_field_elements_plural_cb($args,"data concepts",$iotcat_default_data_concepts_plural_name);

}

function iotcat_field_measurable_quantities_enabled_cb( $args ) {
  iotcat_field_elements_enable_cb( $args ,'measurable quantities');
}

function iotcat_field_measurable_quantities_singular_cb( $args ) {
  global $iotcat_default_measurable_quantities_singular_name;
  iotcat_field_elements_singular_cb($args,"measurable quantity",$iotcat_default_measurable_quantities_singular_name);

}


function iotcat_field_measurable_quantities_plural_cb( $args ) {
  global $iotcat_default_measurable_quantities_plural_name;
  iotcat_field_elements_plural_cb($args,"measurable quantity",$iotcat_default_measurable_quantities_plural_name);

}
 /**
  * Add the top level menu page.
  */
 function iotcat_options_page() {
     add_menu_page(
         'IoT Catalogue Integration',
         'IoT Catalogue',
         'manage_options',
         'iotcat',
         'iotcat_options_page_html'
     );
 }


 /**
  * Register our iotcat_options_page to the admin_menu action hook.
  */
 add_action( 'admin_menu', 'iotcat_options_page' );


 /**
  * Top level menu callback function
  */
 function iotcat_options_page_html() {
     // check user capabilities
     if ( ! current_user_can( 'manage_options' ) ) {
         return;
     }

     // add error/update messages

     // check if the user have submitted the settings
     // WordPress will add the "settings-updated" $_GET parameter to the url
     if ( isset( $_GET['settings-updated'] ) ) {
         // add settings saved message with the class of "updated"
         add_settings_error( 'iotcat_messages', 'iotcat_message', __( 'Settings Saved', 'iotcat' ), 'updated' );
     }

     // show error/update messages
     settings_errors( 'iotcat_messages' );
     ?>
     <div class="wrap">
         <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
         <form action="options.php" method="post">
             <?php
             // output security fields for the registered setting "iotcat"
             settings_fields( 'iotcat' );
             // output setting sections and their fields
             // (sections are registered for "iotcat", each field is registered to a specific section)
             do_settings_sections( 'iotcat' );
             // output save settings button
             submit_button( 'Save Settings','primary iotcat-save-button','submit',false );
              submit_button( 'Delete Subscription', 'secondary');
             ?>

         </form>

     </div>
     <?php
 }
 function load_resources() {


   wp_register_style( 'styles.css', plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), "1.0" );
   wp_enqueue_style( 'styles.css');

   wp_register_script( 'main.js', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery'), "1.0" );
   wp_enqueue_script( 'main.js' );

 }
add_action( 'admin_enqueue_scripts', 'load_resources' );



?>
