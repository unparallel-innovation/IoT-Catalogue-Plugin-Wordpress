<?php
	require_once  __DIR__ . '/log.php';
  	require_once  __DIR__ . '/iotcat_components.php';


	class IoTCat_subscription {
		function __construct($token, $iotcat_elements_instances,$base_url ){

			$this->token = $token;
			$this->base_url = $base_url;
			$this->iotcat_elements_instances = $iotcat_elements_instances;
			$this->id = uniqid();

		}


		private function get_tpi_elements_id($page_name){
			$response = wp_remote_get( $this->base_url.'/api/getTPIElementsId?access_token='.$this->token.'&pageName='.$page_name);
			if(
				array_key_exists("response", $response) &&
				array_key_exists("code", $response["response"]) &&
				$response["response"]["code"] === 200
			){
				return json_decode( wp_remote_retrieve_body( $response ), true );

			}
		}
		private function get_tpi_element($page_name, $id){

			$response = wp_remote_get( $this->base_url.'/api/getTPIElement?access_token='.$this->token.'&pageName='.$page_name.'&id='.$id);
			if(
				array_key_exists("response", $response) &&
				array_key_exists("code", $response["response"]) &&
				$response["response"]["code"] === 200
			){
				return json_decode( wp_remote_retrieve_body( $response ), true );

			}
		}



		private function get_page_data($instance){
			$ids_info = $this->get_tpi_elements_id($instance::$page_name);

			if(is_array($ids_info)){
				$ids = (array_map(
					function($id_info){
						return $id_info["_id"];
					}
					,$ids_info));

				$instance->delete_removed_elements($ids);


				foreach ($ids_info as $id_info) {

						$id = $id_info["_id"];
						$post = $instance->get_element_by_original_id($id);
						if($post!== null){
								iotcat_log_me("Element ".$id." exists");
								$metadata = get_post_meta($post->ID);
								$new_last_update_timestamp = array_key_exists("_lastUpdateTimestamp", $id_info)?round( ($id_info["_lastUpdateTimestamp"])/1000) :0;
								$last_update_timestamp = $metadata["last_update_timestamp"][0];
								if($new_last_update_timestamp  >$last_update_timestamp ){
									$element = $this->get_tpi_element($instance::$page_name,$id);
									$instance->update_element($post->ID,
										array_key_exists("name", $element) ?$element["name"]:"",
										array_key_exists("description", $element) ?$element["description"]:"",
										array_key_exists("_embeddedUrl", $element) ?$element["_embeddedUrl"]:"",
										array_key_exists("_imageUrl", $element) ?$element["_imageUrl"]:"",
										array_key_exists("_id", $element) ?$element["_id"]:"",
										array_key_exists("_lastUpdateTimestamp", $element) ? round( $element["_lastUpdateTimestamp"]/1000):0,
										$this->id
									);
								}

						}else{
							iotcat_log_me("Element ".$id." does not exists");
							$element = $this->get_tpi_element($instance::$page_name,$id);
							if(array_key_exists("name",$element)){

								$instance->add_new_element(
											array_key_exists("name", $element) ?$element["name"]:"",
											array_key_exists("description", $element) ?$element["description"]:"",
											array_key_exists("_embeddedUrl", $element) ?$element["_embeddedUrl"]:"",
											array_key_exists("_imageUrl", $element) ?$element["_imageUrl"]:"",
											array_key_exists("_id", $element) ?$element["_id"]:"",
											array_key_exists("_lastUpdateTimestamp", $element) ? round( $element["_lastUpdateTimestamp"]/1000):0,
											$this->id
										);
							}


						}
				}
			}
		}




		public function get_data(){
			foreach($this->iotcat_elements_instances as $iotcat_elements_instance){
				$this->get_page_data($iotcat_elements_instance);
			}

		}





		public function destroy(){
			foreach($this->iotcat_elements_instances as $iotcat_elements_instance){
				$iotcat_elements_instance->delete_subscription_elements($this->id);
			}

		}



	}

?>
