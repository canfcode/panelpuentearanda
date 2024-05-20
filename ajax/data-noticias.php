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
            
            $url = "relations?rel=noticias,categorianoticias&type=noticia,categorianoticia&select=id_noticia&linkTo=fecha_creacion_noticia&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

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

            $select = "id_noticia,titulo_noticia,cuerpo_noticia,resumen_noticia,imagen_noticia,visitas_noticia,fecha_creacion_noticia,fecha_actualizacion_noticia,nombre_categorianoticia";

            if(!empty($_POST['search']['value'])){

                if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

                    $linkTo = ["id_noticia,titulo_noticia,imagen_noticia"];

                    $search = str_replace(" ","_",$_POST['search']['value']);

                    foreach ($linkTo as $key => $value) {
                        
                        $url = "relations?rel=noticias,categorianoticias&type=noticia,categorianoticia&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

                        $data = CurlController::request($url,$method,$fields)->results;
                                
                        echo'<pre>'; print_r($data);echo'</pre>'; 

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

                $url = "relations?rel=noticias,categorianoticias&type=noticia,categorianoticia&select=".$select."&linkTo=fecha_creacion_noticia&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
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

                    $logo = $value->imagen_noticia;
                    
                    $actions = "";
  
                }else{
                    //$nomruta=strtr($value->titulo_noticia," ","-");
                     $tilde=TemplateController::tildes($value->titulo_noticia);
                    $nomruta=strtolower(strtr($tilde," ","-"));                                      
                    $logo = "<img src='".TemplateController::srcImg()."views/img/noticias/".$nomruta."/".$value->imagen_noticia."' style='width:70px'>";
                        $actions = "<a href='/noticias/edit/".base64_encode($value->id_noticia."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>
                                <i class='fas fa-pencil-alt'></i>
                                </a>
                                <a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_noticia."~".$_GET["token"])."' table='noticias' suffix='noticia' deleteFile='noticias/".$nomruta."/".$value->imagen_noticia."'page='noticias'>
                                <i class='fas fa-trash'></i>
                                </a>";
                    $actions = TemplateController::htmlClean($actions);
                }  
                $cuerpo_noticia =  TemplateController::htmlClean($value->cuerpo_noticia);
                
                //$cuerpo_noticia = preg_replace('"',"/\"/","'",$cuerpo_noticia);  //parece bien en el servidor
                //$cuerpo_noticia = str_replace('"', '/"', $cuerpo_noticia);

                $categoria_noticia=$value->nombre_categorianoticia;
                $titulo_noticia = $value->titulo_noticia;
                $resumen_noticia = $value->resumen_noticia;
                $visitas_noticia = $value->visitas_noticia; 
                $fecha = $value->fecha_creacion_noticia;
                $fechaactu = $value->fecha_actualizacion_noticia;

                $dataJson.='{ 

                    "id_noticia":"'.($start+$key+1).'",
                    "actions":"'.$actions.'", 
                    "categoria_noticia":"'.$categoria_noticia.'",  
                    "titulo_noticia":"'.$titulo_noticia.'",
                    "logo":"'.$logo.'",
                    "resumen_noticia":"'.$resumen_noticia.'",
                    "visitas_noticia":"'.$visitas_noticia.'",
                    "cuerpo_noticia":"'.$cuerpo_noticia.'",
                    "fecha_creacion_noticia":"'.$fecha.'",
                    "fecha_actualizacion_noticia":"'.$fechaactu.'"                   

                },';

                //$dataJson["data"][] = $row;

            }//agrego cesAER
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

