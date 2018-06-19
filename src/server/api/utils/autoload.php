<?php 
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
   if(!$found){throw new Exception("No se encuentra la clase que estas buscando");}
});
?>

