<?php

 /**
  * @internal never define functions inside callbacks.
  * these functions could be run multiple times; this would result in a fatal error.
  */

 /**
  * custom option and settings
  */
 function iotcat_settings_init() {

     // Register a new setting for "iotcat" page.
     register_setting( 'iotcat', 'iotcat_options' );



     // Register a new section in the "iotcat" page.
     add_settings_section(
         'iotcat_section_developers',
         __( 'IoT Catalogue Subscription', 'iotcat' ), 'iotcat_section_developers_callback',
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
  	<?php esc_html_e( 'Token to authenticate requests with.', 'iotcat' ); ?>
  	</p>

     <?php
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
             submit_button( 'Save Settings' );
             ?>
         </form>
     </div>
     <?php
 }
?>
