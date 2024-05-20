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
            
            $url = "relations?rel=tramites,categoriatramites&type=tramite,categoriatramite&select=id_tramite&linkTo=fecha_creacion_tramite&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

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

            $select = "id_tramite,nombre_tramite,contenido_tramite,descripcion_tramite,imagen_tramite,visitas_tramite,fecha_creacion_tramite,fecha_actualizacion_tramite,nombre_categoriatramite";

            if(!empty($_POST['search']['value'])){

                if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

                    $linkTo = ["id_tramite,nombre_tramite,imagen_tramite"];

                    $search = str_replace(" ","_",$_POST['search']['value']);

                    foreach ($linkTo as $key => $value) {
                        
                        $url = "relations?rel=tramites,categoriatramites&type=tramite,categoriatramite&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

                $url = "relations?rel=tramites,categoriatramites&type=tramite,categoriatramite&select=".$select."&linkTo=fecha_creacion_tramite&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

                    $logo = $value->imagen_curso;
                    
                    $actions = "";

                    
                    
                }else{


                    $nomruta=TemplateController::rutasimg($value->nombre_tramite);
                    
                    $logo = "<img src='".TemplateController::srcImg()."views/img/tramites/".$nomruta."/".$value->imagen_tramite."'style='width:90px'>";

                        $actions = "<a href='/tramites/edit/".base64_encode($value->id_tramite."~".$_GET["token"])."'class='btn btn-warning btn-sm mr-1 rounded-circle'>

                                <i class='fas fa-pencil-alt'></i>

                                </a>

                                <a class='btn btn-danger btn-sm rounded-circle eliminar' idItem='".base64_encode($value->id_tramite."~".$_GET["token"])."' table='tramites' suffix='tramite' deleteFile='tramites/".$nomruta."/".$value->imagen_tramite."'page='tramites'>

                                <i class='fas fa-trash'></i>

                                </a>";



                    $actions = TemplateController::htmlClean($actions);


                }  

                $contenido_tramite =  TemplateController::htmlClean($value->contenido_tramite);
                $contenido_tramite =  preg_replace("/\"/","'",$contenido_tramite);  
                $categoria_tramite=$value->nombre_categoriatramite;
                $nombre_tramite = $value->nombre_tramite;
                $descripcion_tramite = $value->descripcion_tramite;
                $visitas_tramite = $value->visitas_tramite; 
                $fecha = $value->fecha_creacion_tramite;
                $fechaactu = $value->fecha_actualizacion_tramite;

                $dataJson.='{ 

                    "id_tramite":"'.($start+$key+1).'",
                    "actions":"'.$actions.'", 
                    "categoria_tramite":"'.$categoria_tramite.'",  
                    "nombre_tramite":"'.$nombre_tramite.'",
                    "logo":"'.$logo.'",
                    "descripcion_tramite":"'.$descripcion_tramite.'",
                    "visitas_tramite":"'.$visitas_tramite.'",
                    "contenido_tramite":"'.$contenido_tramite.'",
                    "fecha_creacion_tramite":"'.$fecha.'",
                    "fecha_actualizacion_tramite":"'.$fechaactu.'"                   

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

