	<?php

require_once "../controllers/curl.controller.php";

class DeleteController{

	public $idItem;
	public $table;
	public $suffix;
	public $token;
	public $deleteFile;

	public function dataDelete(){

		//echo'<pre>';print_r($this->idItem);echo'</pre>';
		//echo'<pre>';print_r($this->table);echo'</pre>';

		$security = explode("~",base64_decode($this->idItem));
		

		if($security[1] == $this->token){

			/*=============================================
			Validar primero que la categoría no tenga negocios
			=============================================*/
				
			if($this->table == "categorianoticias" || $this->table == "noticias"){

				$url = "noticias?select=id_noticia&linkTo=id_".$this->suffix."_noticia&equalTo=".$security[0];
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url, $method, $fields);
				
				if($response->status == 200){

					echo "no-delete";

					return;

				}
			
			}
			
			/*=============================================
			Validar que si vengan archivos para borrar
			=============================================*/

			if($this->deleteFile != "no"){

				if($this->table == "noticias"){

					$count = 0;

					foreach (json_decode(base64_decode($this->deleteFile),true) as $key => $value) {

						$count++;
						
						$fields = array(
									
						 "deleteFile"=>$value

						);

						CurlController::requestFile($fields);

						if($count == count(json_decode(base64_decode($this->deleteFile),true))){

							$picture = "ok";
						}
					}

				}else{

					$fields = array(
									
					 "deleteFile"=>$this->deleteFile,
					 "deleteDir"=>$this->suffix

					);

					$picture = CurlController::requestFile($fields);

				}

			}else{

				$picture = "ok";
				
			}

			/*=============================================
			Eliminar registro
			=============================================*/

			if($picture == "ok"){

				$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=usuarios&suffix=user";
				$method = "DELETE";
				$fields = array();

				$response = CurlController::request($url, $method, $fields);
				
				echo $response->status;

			}

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idItem"])){

	$validate = new DeleteController();
	$validate -> idItem = $_POST["idItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> deleteFile = $_POST["deleteFile"];
	$validate -> dataDelete();

}