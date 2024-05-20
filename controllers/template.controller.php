<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class TemplateController{

	/*=============================================
	Ruta del sistema administrativo
	=============================================*/

	static public function path(){

		return "http://panelaranda.com/";

	}

	
	/*=============================================
	Traemos la Vista Principal de la plantilla
	=============================================*/

	public function index(){

		include "views/template.php";

	}	

	/*=============================================
	Ruta para las imágenes del sistema
	=============================================*/

	static public function srcImg(){
		//cambie la ruta para que apunte directamente a la carpeta del dominio y no a otro domunio
		//return "http://marketplace.com/";
		return "http://archivosaranda.com/";

	}

	/*=============================================
	Devolver la imagen del MP
	=============================================*/

	static public function returnImg($id,$picture,$method){

		if($method == "direct"){

			if($picture != null){

				return TemplateController::srcImg()."views/img/users/".$id."/".$picture;
			
			}else{

				return TemplateController::srcImg()."views/img/users/default/default.png";
			}

		}else{

			return $picture;

		}

	}

	/*=============================================
	Función para mayúscula inicial
	=============================================*/

	static public function capitalize($value){

		$value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
		return $value;
	}

	/*=============================================
	Función para quitar tildes
	=============================================*/

	static public function tildes($cadena){

	$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
	$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
}
	/*=============================================
	Función para las rutas de las imagenes 
	=============================================*/
	static public function rutasimg($cadena) {
       // Convertir la cadena a minúsculas
        $cadena = strtolower($cadena);

        // Array asociativo con caracteres a reemplazar
        $acentos = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ñ' => 'n'
        );

        // Reemplazar tildes
        $cadena = strtr($cadena, $acentos);

        // Reemplazar espacios adicionales por un solo espacio
        $cadena = preg_replace('/\s+/', ' ', $cadena);

        // Reemplazar espacios por raya media
        $cadena = str_replace(' ', '-', $cadena);

        // Eliminar caracteres no permitidos (excepto letras, números, espacios y guiones)
        $cadena = preg_replace('/[^a-z0-9-]/', '', $cadena);

        return $cadena;
    }

	/*=============================================
	Función Limpiar HTML
	=============================================*/	

	static public function htmlClean($code){

		$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');

		$replace = array('>','<','\\1');

		$code = preg_replace($search, $replace, $code);

		$code = str_replace("> <", "><", $code);

		return $code;	
	}

	/*=============================================
	Promediar reseñas
	=============================================*/

	static public function averageReviews($reviews){
		

		$totalReviews = 0;

		if($reviews != null){

			foreach ($reviews as $key => $value) {
			
				$totalReviews += $value["review"];
			}

			return round($totalReviews/count($reviews));

		}else{

			return 0;
		}

	}

	/*=============================================
	funciona para validad sintaxis json
	=============================================*/

	static public function corregirJson($json) {
    $datos = json_decode($json, true);

    if ($datos !== null || json_last_error() === JSON_ERROR_NONE) {
        return $json;
    }

    $errorMensaje = json_last_error_msg();
    $errorPosicion = json_last_error();

    $error = 'Error en el JSON: ' . $errorMensaje . ' en la posición ' . $errorPosicion;

    if ($errorPosicion < strlen($json)) {
        $caracterErroneo = $json[$errorPosicion];

        $caracteresPermitidos = ['{', '}', '[', ']', '"', ':', ',', 'true', 'false', 'null', '-'];

        $jsonCorregido = $json;
        $caracterValidoEncontrado = false;

        foreach ($caracteresPermitidos as $caracterPermitido) {
            $jsonCorregido[$errorPosicion] = $caracterPermitido;
            $datosCorregidos = json_decode($jsonCorregido, true);

            if ($datosCorregidos !== null || json_last_error() === JSON_ERROR_NONE) {
                $caracterValidoEncontrado = true;
                break;
            }
        }

        if (!$caracterValidoEncontrado) {
            // Si no se encuentra un carácter válido, se elimina el carácter erróneo
            $jsonCorregido = substr_replace($json, '', $errorPosicion, 1);
        }

        // Intentar decodificar el JSON corregido nuevamente
        $datosCorregidos = json_decode($jsonCorregido, true);

        if ($datosCorregidos !== null || json_last_error() === JSON_ERROR_NONE) {
            return $jsonCorregido;
        }
    }

    return $error;
}

	/*=============================================
	Función para enviar correos electrónicos
	=============================================*/

	static public function sendEmail($name, $subject, $email, $message, $url){

		date_default_timezone_set("America/Bogota");

		$mail = new PHPMailer;

		$mail->Charset = "UTF-8";

		$mail->isMail();

		$mail->setFrom("support@marketplace.com", "Marketplace Support");

		$mail->Subject = "Hi ".$name." - ".$subject;

		$mail->addAddress($email);

		$mail->msgHTML(' 

			<div>

				Hi, '.$name.':

				<p>'.$message.'</p>

				<a href="'.$url.'">Click this link for more information</a>

				If you didn’t ask to verify this address, you can ignore this email.

				Thanks,

				Your Marketplace Team

			</div>

		');

		$send = $mail->Send();

		if(!$send){

			return $mail->ErrorInfo;	

		}else{

			return "ok";

		}

	}

}