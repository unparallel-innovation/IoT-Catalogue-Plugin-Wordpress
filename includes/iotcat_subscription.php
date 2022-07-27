<?php
	require_once  __DIR__ . '/log.php';
  require_once  __DIR__ . '/iotcat_components.php';
	class IoTCat_subscription {
		function __construct($token, $iotcat_components ,$base_url = "http://10.0.199.155:3000"){
			$this->token = $token;
			$this->base_url = $base_url;
			$this->iotcat_components = $iotcat_components;
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


		private function sync_page_data($pageName){
			$ids = $this->get_tpi_ids($pageName);
			if($ids){
				foreach ($ids as $id) {
						if($this->iotcat_components->has_component($id)){
								log_me("Element ".$id." exists");
						}else{
							log_me("Element ".$id." does not exists");
							$component = $this->get_tpi_element($pageName,$id);
							if(array_key_exists("name",$component)){
								$this->iotcat_components->add_new(
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
			$this->sync_page_data("components");

		}
		public function destroy(){
			log_me("destroying subscription");
			$this->iotcat_components->delete_subscription_components($this->id);
		}

	}

?>
