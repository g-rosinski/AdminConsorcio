<?php 
session_start();

if(isset($_SESSION['user']) && ($_SESSION['expire'] > time())){
     $_SESSION['expire'] = time() + (60 * 10);
} else {
    session_destroy();
}

set_error_handler(function($error) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo json_encode($error);
});

spl_autoload_register(function ($class) {

   $className = strtolower($class);
   $rootPath = $_SERVER["DOCUMENT_ROOT"]."server/api/";
   $rootPath = str_replace("/","\\",$rootPath);   
   $searchIn = array("config","utils","entities");
   $found=false;

   foreach ($searchIn as $folder) {
   		$path=$rootPath.$folder.'\\'.$className.'.php';
   		if (file_exists($path)) {
            if($folder=="entities"){
               include_once($path);
            }else{
   			   require_once($path);
            }
   			$found=true;
   		}
   }
   if(!$found){throw new Exception("No se encuentra la clase ".$class." que estas buscando");}
});
?>

