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


		function getTPIIds($pageName){
			$response = wp_remote_get( $this->base_url.'/api/getTPIIds?access_token='.$this->token.'&pageName='.$pageName);
			$response_code = $response["response"]["code"];
			if($response_code === 200){
				return json_decode( wp_remote_retrieve_body( $response ), true );

			}
		}
		function getTPIElement($pageName, $id){
			$response = wp_remote_get( $this->base_url.'/api/getTPIElement?access_token='.$this->token.'&pageName='.$pageName.'&id='.$id);
			$response_code = $response["response"]["code"];
			if($response_code === 200){
				return json_decode( wp_remote_retrieve_body( $response ), true );

			}
		}


		function syncData($pageName){
			$ids = $this->getTPIIds($pageName);
			if($ids){
				foreach ($ids as $id) {
						if($this->iotcat_components->has_component($id)){
								log_me("Element ".$id." exists");
						}else{
							log_me("Element ".$id." does not exists");
							$component = $this->getTPIElement($pageName,$id);
							if(array_key_exists("name",$component)){
								$this->iotcat_components->add_new(
									    $component["name"],
											$component["description"],
									    $component["_imageUrl"],
									    $component["_id"],
											$this->id
										);
							}


						}
				}
			}
		}

		function subscribe(){
			$this->syncData("components");

		}
		function destroy(){
			log_me("destroying subscription");
			$this->iotcat_components->delete_subscription_components($this->id);
		}

	}

?>
