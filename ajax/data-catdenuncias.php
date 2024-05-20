<?php

require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";

class DatatableController{	

	public function data(){

		if(!empty($_POST)){

			/*=============================================
            Capturando y organizando las variables POST de DT
            =============================================*/
			
			$draw = $_POST["draw"];//Contador utilizado por DataTables para garantizar que los retornos de Ajax de las solicitudes de procesamiento del lado del servidor sean dibujados en secuencia por DataTables 

			$orderByColumnIndex = $_POST['order'][0]['column']; //Índice de la columna de clasificación (0 basado en el índice, es decir, 0 es el primer registro)

			$orderBy = $_POST['columns'][$orderByColumnIndex]["data"];//Obtener el nombre de la columna de clasificación de su índice

			$orderType = $_POST['order'][0]['dir'];// Obtener el orden ASC o DESC

			$start  = $_POST["start"];//Indicador de primer registro de paginación.

            $length = $_POST['length'];//Indicador de la longitud de la paginación.

            /*=============================================
            El total de registros de la data
            =============================================*/                    

            $url = "categoriadenuncias?select=id_categoriadenuncia&linkTo=fecha_creacion_categoriadenuncia&between1=".$_GET["between1"]."&between2=".$_GET["between2"];	          
			
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields); 

			
			
			if($response->status == 200){	

				$totalData = $response->total;

			}else{

				echo '{"data": []}';

                return;

			}	

			/*=============================================
           	Búsqueda de datos
            =============================================*/	
	
            $select = "id_categoriadenuncia,nombre_categoriadenuncia,descripcion_categoriadenuncia,fecha_creacion_categoriadenuncia";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["id_categoriadenuncia","nombre_categoriadenuncia"];
	            	
	            	$search = str_replace(" ","_",$_POST['search']['value']);
					
	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "categoriadenuncias?select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
						
	            		$data = CurlController::request($url,$method,$fields)->results;
												
	            		if($data  == "Not Found"){

	            			$data = array();
	            			$recordsFiltered = count($data);

	            		}else{

	            			$data = $data;
	            			$recordsFiltered = count($data);
	            			
	            			break;

	            		}

	            	}

            	}else{

        			echo '{"data": []}';

                	return;

            	}

            }else{
				
	            /*=============================================
	            Seleccionar datos
	            =============================================*/	           

	            $url = "categoriadenuncias?select=".$select."&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
				
	           
	            $data = CurlController::request($url,$method,$fields)->results;
				
	            $recordsFiltered = $totalData;

	            

            }  


            /*=============================================
            Cuando la data viene vacía
            =============================================*/

            if(empty($data)){

            	echo '{"data": []}';

            	return;

            }

            /*=============================================
            Construimos el dato JSON a regresar
            =============================================*/

            $dataJson = '{

            	"Draw": '.intval($draw).',
            	"recordsTotal": '.$totalData.',
            	"recordsFiltered": '.$recordsFiltered.',
            	"data": [';

            /*=============================================
            Recorremos la data
            =============================================*/	
			
            foreach ($data as $key => $value) {            									
				
            	// agregado cesar 

            	if($_GET["text"] == "flat"){

            		//$icono_categorianoticia = $icono_categorianoticia;

            		$actions = "";

            		//echo '<pre>'; printf($icono_categorianegocio); echo '</pre>'; 
 

            		}else{
                    
                    
        $nomruta=strtolower(strtr($value->nombre_categoriadenuncia," ","-"));
                        
                     /*$icono_categorianoticia = "<img src='".TemplateController::srcImg()."views/img/categorianoticia/".$nomruta."/".$value->icono_categorianoticia."' class='img-circle' style='width:70px'>";*/

            		 	$actions = "<a href='/catdenuncias/edit/".base64_encode($value->id_categoriadenuncia."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>

			            		<i class='fas fa-pencil-alt'></i>

			            		</a>

			            		<a class='btn btn-danger btn-sm rounded-circle removeNoti' idItem='".base64_encode($value->id_categoriadenuncia."~".$_GET["token"])."' table='categoriadenuncias' suffix='categoriadenuncia' deleteFile='no'page='catdenuncias'>

			            		<i class='fas fa-trash'></i>

			            		</a>";

			        $actions = TemplateController::htmlClean($actions);

			        		
            	}

            	//termina

				//$actions = "";
				
            	$id_categoriadenuncia = $value->id_categoriadenuncia;	
            	$nombre_categoriadenuncia = $value->nombre_categoriadenuncia;	
            	$descripcion_categoriadenuncia = $value->descripcion_categoriadenuncia;
				$fecha_creacion_categoriadenuncia = $value->fecha_creacion_categoriadenuncia;		

            	$dataJson.='{ 

            		"id_categoriadenuncia":"'.($start+$key+1).'",
            		"nombre_categoriadenuncia":"'.$nombre_categoriadenuncia.'",
            		"descripcion_categoriadenuncia":"'.$descripcion_categoriadenuncia.'",	
					"fecha_creacion_categoriadenuncia":"'.$fecha_creacion_categoriadenuncia.'",
            		
            		"actions":"'.$actions.'"            		
            	},';

            }
		

            $dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

            $dataJson .= ']}';

            echo $dataJson;
		}

	}

}

/*=============================================
Activar función DataTable
=============================================*/ 

$data = new DatatableController();
$data -> data();


