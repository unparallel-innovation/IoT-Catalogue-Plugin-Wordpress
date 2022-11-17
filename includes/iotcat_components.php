<?php
require_once  __DIR__ . '/log.php';
require_once  __DIR__ . '/iotcat_elements.php';
class IoTCat_components  extends IoTCat_elements{

	function __construct($name = "Components", $singular_name = "Component",$default_metadata,$comment_type, $post_type = "iotcat_component") {
		parent::__construct($name, $singular_name, $post_type,$default_metadata,$comment_type );


	}

	public static $page_name = "components";





}

?>
