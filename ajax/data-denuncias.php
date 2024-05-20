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
            
            $url = "relations?rel=denuncias,categoriadenuncias&type=denuncia,categoriadenuncia&select=id_denuncia&linkTo=fecha_creacion_denuncia&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

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

            $select = "id_denuncia,nombre_denuncia,contenido_denuncia,descripcion_denuncia,imagen_denuncia,visitas_denuncia,fecha_creacion_denuncia,fecha_actualizacion_denuncia,nombre_categoriadenuncia";

            if(!empty($_POST['search']['value'])){

                if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

                    $linkTo = ["id_denuncia,nombre_denuncia,imagen_denuncia"];

                    $search = str_replace(" ","_",$_POST['search']['value']);

                    foreach ($linkTo as $key => $value) {
                        
                        $url = "relations?rel=denuncias,categoriadenuncias&type=denuncia,categoriadenuncia&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

                        $data = CurlController::request($url,$method,$fields)->results;
                                
                        //echo'<pre>'; print_r($data);echo'</pre>'; 

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

                $url = "relations?rel=denuncias,categoriadenuncias&type=denuncia,categoriadenuncia&select=".$select."&linkTo=fecha_creacion_denuncia&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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
                    

                   // $nomruta=strtr($value->nombre_curso," ","-");
                    
                    $tilde=TemplateController::tildes($value->nombre_denuncia);
                    $nomruta=strtolower(strtr($tilde," ","-"));
                    
                    $logo = "<img src='".TemplateController::srcImg()."views/img/denuncias/".$nomruta."/".$value->imagen_denuncia."'style='width:90px'>";

                        $actions = "<a href='/denuncias/edit/".base64_encode($value->id_denuncia."~".$_GET["token"])."'class='btn btn-warning btn-sm mr-1 rounded-circle'>

                                <i class='fas fa-pencil-alt'></i>

                                </a>

                                <a class='btn btn-danger btn-sm rounded-circle removeCur' idItem='".base64_encode($value->id_denuncia."~".$_GET["token"])."' table='tramites' suffix='tramite' deleteFile='tramites/".$nomruta."/".$value->imagen_denuncia."'page='tramites'>

                                <i class='fas fa-trash'></i>

                                </a>";



                    $actions = TemplateController::htmlClean($actions);


                }  

                $contenido_denuncia =  TemplateController::htmlClean($value->contenido_denuncia);
                $contenido_denuncia =  preg_replace("/\"/","'",$contenido_denuncia);  

                $categoria_denuncia=$value->nombre_categoriadenuncia;
                $nombre_denuncia = $value->nombre_denuncia;
                $descripcion_denuncia = $value->descripcion_denuncia;
                $visitas_denuncia = $value->visitas_denuncia; 
                $fecha = $value->fecha_creacion_denuncia;
                $fechaactu = $value->fecha_actualizacion_denuncia;

                $dataJson.='{ 

                    "id_denuncia":"'.($start+$key+1).'",
                    "actions":"'.$actions.'", 
                    "categoria_denuncia":"'.$categoria_denuncia.'",  
                    "nombre_denuncia":"'.$nombre_denuncia.'",
                    "logo":"'.$logo.'",
                    "descripcion_denuncia":"'.$descripcion_denuncia.'",
                    "visitas_denuncia":"'.$visitas_denuncia.'",
                    "contenido_denuncia":"'.$contenido_denuncia.'",
                    "fecha_creacion_denuncia":"'.$fecha.'",
                    "fecha_actualizacion_denuncia":"'.$fechaactu.'"                   

                },';

            }//agrego cesAER

            //prueba para validad el json antes de enviarlo a la base de datos 

            //printf("aca inicia los datos--".$dataJson); 

          /*$jsonCorregido = TemplateController::corregirJson($dataJson);

                if ($jsonCorregido) {
                    echo "El JSON corregido es: " . $jsonCorregido;
                } else {
                    echo "No se pudo corregir el JSON.";
                }*/
           
            //termina la prueba 

            

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

