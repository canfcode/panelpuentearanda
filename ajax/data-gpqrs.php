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
            
            //$url = "users?select=id_user&linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=rol_user&inTo='admin'";

            $url = "barrios?select=id_barrio&linkTo=fecha_creacion_barrio&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

            

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
			
            $select = "id_barrio,nombre_barrio,fecha_creacion_barrio,fecha_actualizacion_barrio";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["nombre_barrio"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);
					
	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "barrios?select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
						
	            		$data = CurlController::request($url,$method,$fields)->results;

	            		print_r($url);
						
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

	            $url = "barrios?select=".$select."&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;				
	           
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
            	//gregado cesar
				//$actions = "";
				if($_GET["text"] == "flat"){

	            	$actions = "";
	            	
            	}else{

            		$actions = "<a href='/barrios/edit/".base64_encode($value->id_barrio."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>

	            		<i class='fas fa-pencil-alt'></i>

	            		</a>

	            		<a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_barrio."~".$_GET["token"])."' table='barrios' suffix='barrio' deleteFile='no' page='barrios'>

	            		<i class='fas fa-trash'></i>

            		</a>";

			        $actions = TemplateController::htmlClean($actions);
					
            	}

            	//finaliza codigo agregado cesar
            	//$actions = "";
            	$nombre_barrio = $value->nombre_barrio;	
            	$fecha_creacion_barrio = $value->fecha_creacion_barrio;
            	$fecha_actualizacion_barrio = $value->fecha_actualizacion_barrio;	

            	$dataJson.='{ 

            		"id_barrio":"'.($start+$key+1).'",
            		"nombre_barrio":"'.$nombre_barrio.'",
            		"fecha_creacion_barrio":"'.$fecha_creacion_barrio.'",
            		"fecha_actualizacion_barrio":"'.$fecha_actualizacion_barrio.'",
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


