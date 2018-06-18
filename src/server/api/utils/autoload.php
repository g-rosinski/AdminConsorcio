<?php 
spl_autoload_register(function ($class) {

   $className = strtolower($class);
   $rootPath = $_SERVER["DOCUMENT_ROOT"]."server/api/";
   $rootPath = str_replace("/","\\",$rootPath);   
   $searchIn = array("config","utils");
   $found=false;

   foreach ($searchIn as $folder) {
   		$path=$rootPath.$folder.'\\'.$className.'.php';
   		if (file_exists($path)) {
   			require_once($path);
   			$found=true;
   		}
   }
   if(!$found){throw new Exception("No se encuentra la clase que estas buscando");}
});
?>

