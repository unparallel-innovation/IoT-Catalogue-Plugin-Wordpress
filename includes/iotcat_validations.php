<?php
require_once  __DIR__ . '/log.php';
require_once  __DIR__ . '/iotcat_elements.php';
class IoTCat_validations  extends IoTCat_elements {

	function __construct($name = "Validations", $singular_name = "validation",$default_metadata,$comment_type, $post_type = "iotcat_validation") {
		parent::__construct($name, $singular_name, $post_type,$default_metadata,$comment_type );


		$this->icon = "dashicons-lightbulb";

	}

	public static $page_name = "validations";





}

?>
