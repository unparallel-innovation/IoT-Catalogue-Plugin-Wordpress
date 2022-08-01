<?php
	require_once  __DIR__ . '/log.php';
  require_once  __DIR__ . '/iotcat_components.php';
	class IoTCat_subscription {
		function __construct($token, $iotcat_components ,$iotcat_validations,$base_url ){

			$this->token = $token;
			$this->base_url = $base_url;
			$this->iotcat_components = $iotcat_components;
			$this->iotcat_validations = $iotcat_validations;
			$this->id = uniqid();
		}


		private function get_tpi_ids($pageName){
			$response = wp_remote_get( $this->base_url.'/api/getTPIIds?access_token='.$this->token.'&pageName='.$pageName);
			$response_code = $response["response"]["code"];
			if($response_code === 200){
				return json_decode( wp_remote_retrieve_body( $response ), true );

			}
		}
		private function get_tpi_element($pageName, $id){

			$response = wp_remote_get( $this->base_url.'/api/getTPIElement?access_token='.$this->token.'&pageName='.$pageName.'&id='.$id);
			$response_code = $response["response"]["code"];
			if($response_code === 200){
				return json_decode( wp_remote_retrieve_body( $response ), true );

			}
		}


		private function sync_page_data($instance){
			$ids = $this->get_tpi_ids($instance::$pageName);
			if($ids){
				foreach ($ids as $id) {
						if($instance->has_element($id)){
								log_me("Element ".$id." exists");
						}else{
							log_me("Element ".$id." does not exists");
							$component = $this->get_tpi_element($instance::$pageName,$id);
							if(array_key_exists("name",$component)){
								$instance->add_new(
									    array_key_exists("name", $component) ?$component["name"]:"",
											array_key_exists("description", $component) ?$component["description"]:"",
											array_key_exists("_embeddedUrl", $component) ?$component["_embeddedUrl"]:"",
									    array_key_exists("_imageUrl", $component) ?$component["_imageUrl"]:"",
									    array_key_exists("_id", $component) ?$component["_id"]:"",
											$this->id
										);
							}


						}
				}
			}
		}

		public function sync_data(){
			$this->sync_page_data($this->iotcat_components);
			$this->sync_page_data($this->iotcat_validations);

		}
		public function destroy(){
			$this->iotcat_components->delete_subscription_elements($this->id);
			$this->iotcat_validations->delete_subscription_elements($this->id);
		}

	}

?>
