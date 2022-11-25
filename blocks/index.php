<?php
add_filter( 'block_categories_all' , function( $categories ) {

    // Adding a new category.
	$categories[] = array(
		'slug'  => 'iot-catalogue',
		'title' => 'IoT Catalogue'
	);

	return $categories;
} );


  require_once  __DIR__ . '/iotcat-embed.php';
  require_once  __DIR__ . '/iotcat-usecases.php';
  require_once  __DIR__ . '/iotcat-element-categorization.php';
  require_once  __DIR__ . '/iotcat-base-card.php';
  require_once  __DIR__ . '/iotcat-usecase-card.php';
?>