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
            
            $url = "relations?rel=negocios,categorianegocios&type=negocio,categorianegocio&select=id_negocio&linkTo=fecha_creacion_negocio&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

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

            $select = "nombre_negocio,id_negocio,nombre_categorianegocio,url_negocio,logo_negocio,banner_negocio,dirmapa_negocio,direccion_negocio,correo_negocio,descripcion_negocio,telefono_negocio,dirmapa_negocio,paginaweb_negocio,fecha_creacion_negocio,nombre_barrio,redes_negocio,fecha_creacion_negocio";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["nombre_negocio"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "relations?rel=negocios,categorianegocios,barrios&type=negocio,categorianegocio,barrio&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "relations?rel=negocios,categorianegocios,barrios&type=negocio,categorianegocio,barrio&select=".$select."&linkTo=fecha_creacion_negocio&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

            	if($_GET["text"] == "flat"){

            		$logo = "";
            		
	            	$actions = "";

	            	
	            	
            	}else{

            		$filesDelete = array();

                		$filesDelete = array(  
                			"negocios/".$value->url_negocio."/".$value->logo_negocio,

                		);

                		foreach (json_decode($value->banner_negocio, true) as $index => $item) {
                			
                			array_push($filesDelete, "negocios/".$value->nombre_negocio."/galeria/".$item);
                		
                		}

                			$actions = "<div class='btn-group'>

                                <a href='/negocios/edit/".base64_encode($value->id_negocio."~".$_GET["token"])."' class='btn btn-warning btn-sm rounded-circle mr-2'>

                                    <i class='fas fa-pencil-alt'></i>

                                </a>

                                <a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_negocio."~".$_GET["token"])."' table='negocios' suffix='negocio' deleteFile='".base64_encode(json_encode($filesDelete))."' page='negocios'>

			            		<i class='fas fa-trash'></i>

			            		</a>

                        </div>";


                        $actions =  TemplateController::htmlClean($actions);
            
            	}	

           		$logo = "<img src='".TemplateController::srcImg()."views/img/negocios/".$value->url_negocio."/".$value->logo_negocio."' style='width:70px'>";

            	$nombre_negocio = $value->nombre_negocio;
            	$mapa = $value->dirmapa_negocio;
            	$direccion = $value->direccion_negocio;	
            	$correo = $value->correo_negocio;
            	$descripcion = $value->descripcion_negocio;            	
            	$telefono = $value->telefono_negocio;
            	$fecha = $value->fecha_creacion_negocio;
            	$categoria=$value->nombre_categorianegocio;
            	$zona=$value->nombre_barrio;
            	$pagina=$value->paginaweb_negocio;

            	$socialnetwork_store = "";
            		if($value->redes_negocio != null){

	            	foreach(json_decode($value->redes_negocio, true) as $index => $item) {

	            		$socialnetwork_store .= $item[array_keys($item)[0]]."<br>";
	            		
	            	}

	            	$socialnetwork_store = substr($socialnetwork_store,0,-2);

	            }

	            	/*=============================================
	                Gallery Product
	                =============================================*/ 

	                $gallery_product = "<div class='row'>";

	                foreach (json_decode($value->banner_negocio, true) as $item) {

	                    $gallery_product .= "<figure class='col-3'><img src='".TemplateController::srcImg()."views/img/negocios/".$value->url_negocio."/galeria/".$item."' style='width:100px'></figure>";
	                    
	                }   

	                $gallery_product .= "</div>";

            	$dataJson.='{ 

            		"id_negocio":"'.($start+$key+1).'",
            		"actions":"'.$actions.'",	
            		"nombre_negocio":"'.$nombre_negocio.'",
            		"logo_negocio":"'.$logo.'",
            		"direccion_negocio":"'.$direccion.'",
            		"telefono_negocio":"'.$telefono.'",
            		"mapa_negocio":"'.$mapa.'",
            		"correo_negocio":"'.$correo.'",
            		"descripcion_negocio":"'.$descripcion.'",
            		"categoria_negocio":"'.$categoria.'",
            		"nombre_barrio":"'.$zona.'",
            		"gallery_product":"'.$gallery_product.'",
            		"paginaweb_negocio":"'.$pagina.'",
            		"socialnetwork_store":"'.$socialnetwork_store.'",
            		"fecha_creacion_negocio":"'.$fecha.'"           		

            	},';

            }

            $dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

            $dataJson .= ']}';

            echo $dataJson;



		}// cierra 1 if

	}// cierra metodo

}//cierra clase

/*=============================================
Activar función DataTable
=============================================*/ 

$data = new DatatableController();
$data -> data();
