<?php

	$iotcat_default_data_update_interval = "24";

	$iotcat_default_components_singular_name = "Component";
	$iotcat_default_components_plural_name = "Components";

	$iotcat_default_validations_singular_name = "Validation";
	$iotcat_default_validations_plural_name = "Validations";

	$iotcat_default_validations_comment_status = "closed";
	$iotcat_default_components_comment_status = "closed";

	$um_content_restriction_public = array(
		"_um_custom_access_settings" => null,
    "_um_accessible" => 0,
    "_um_access_hide_from_queries" => null,
    "_um_noaccess_action" => 0,
    "_um_restrict_by_custom_message" => 0,
    "_um_restrict_custom_message" => null,
    "_um_access_redirect" => 0,
    "_um_access_redirect_url" => null
	);
	$um_content_restriction_private = array(
		"_um_custom_access_settings" => 1,
		"_um_accessible" => 2,
		"_um_access_hide_from_queries" => null,
		"_um_noaccess_action" => 1,
		"_um_restrict_by_custom_message" => 0,
		"_um_restrict_custom_message" => null,
		"_um_access_redirect" => 0,
		"_um_access_redirect_url" => null
	);

	$iotcat_default_validations_um_content_restriction = $um_content_restriction_private;
	$iotcat_default_components_um_content_restriction = $um_content_restriction_private;


 ?>
