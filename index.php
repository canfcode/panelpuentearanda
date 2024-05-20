<?php

/*=============================================
Mostrar errores
=============================================*/

/*ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log",  "D:/xampp/htdocs/sistema-php/admin/php_error_log");*/

// Ruta deseada para el archivo de registro de errores
$custom_error_log_path = '/home/yz5yrjca8ckq/public_html/panel.puentearandaapp.com/php_error_log';

// Establecer la configuración para el registro de errores
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', $custom_error_log_path);



/*=============================================
CORS
=============================================*/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');

/*=============================================
Requerimientos
=============================================*/

require_once "controllers/template.controller.php";
require_once "controllers/curl.controller.php";

require "extensions/vendor/autoload.php";

$index = new TemplateController();
$index -> index();