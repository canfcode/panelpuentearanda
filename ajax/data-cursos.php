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
            
            $url = "relations?rel=cursos,categoriacursos&type=curso,categoriacurso&select=id_curso&linkTo=fecha_creacion_curso&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

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

            $select = "id_curso,nombre_curso,contenido_curso,descripcion_curso,imagen_curso,visitas_curso,fecha_creacion_curso,fecha_actualizacion_curso,nombre_categoriacurso";

            if(!empty($_POST['search']['value'])){

                if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

                    $linkTo = ["id_curso,nombre_curso,imagen_curso"];

                    $search = str_replace(" ","_",$_POST['search']['value']);

                    foreach ($linkTo as $key => $value) {
                        
                        $url = "relations?rel=cursos,categoriacursos&type=curso,categoriacurso&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

                $url = "relations?rel=cursos,categoriacursos&type=curso,categoriacurso&select=".$select."&linkTo=fecha_creacion_curso&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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
                    
                    $tilde=TemplateController::tildes($value->nombre_curso);
                    $nomruta=strtolower(strtr($tilde," ","-"));
                    
                    $logo = "<img src='".TemplateController::srcImg()."views/img/cursos/".$nomruta."/".$value->imagen_curso."' style='width:90px'>";

                        $actions = "<a href='/cursos/edit/".base64_encode($value->id_curso."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>

                                <i class='fas fa-pencil-alt'></i>

                                </a>

                                <a class='btn btn-danger btn-sm rounded-circle removeCur' idItem='".base64_encode($value->id_curso."~".$_GET["token"])."' table='cursos' suffix='curso' deleteFile='cursos/".$nomruta."/".$value->imagen_curso."'page='cursos'>

                                <i class='fas fa-trash'></i>

                                </a>";



                    $actions = TemplateController::htmlClean($actions);


                }  

                $contenido_curso =  TemplateController::htmlClean($value->contenido_curso);
                $contenido_curso =  preg_replace("/\"/","'",$contenido_curso);  

                $categoria_curso=$value->nombre_categoriacurso;
                $nombre_curso = $value->nombre_curso;
                $descripcion_curso = $value->descripcion_curso;
                $visitas_curso = $value->visitas_curso; 
                $fecha = $value->fecha_creacion_curso;
                $fechaactu = $value->fecha_actualizacion_curso;

                $dataJson.='{ 

                    "id_curso":"'.($start+$key+1).'",
                    "actions":"'.$actions.'", 
                    "categoria_curso":"'.$categoria_curso.'",  
                    "nombre_curso":"'.$nombre_curso.'",
                    "logo":"'.$logo.'",
                    "descripcion_curso":"'.$descripcion_curso.'",
                    "visitas_curso":"'.$visitas_curso.'",
                    "contenido_curso":"'.$contenido_curso.'",
                    "fecha_creacion_curso":"'.$fecha.'",
                    "fecha_actualizacion_curso":"'.$fechaactu.'"                   

                },';

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

