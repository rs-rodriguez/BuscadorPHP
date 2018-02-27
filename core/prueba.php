<?php 
require_once("class_buscador.php");

$buscadorNextU 	= new buscadorNextU("../data-1.json");
$datos 			= $buscadorNextU->datosJson();
$ciudad 		= array();
		
foreach($datos as $data){
	if(!empty($data["Tipo"])){
		if(count($ciudad)>0){
			if(!in_array($data["Tipo"], $ciudad)){
				array_push($ciudad, $data["Tipo"]);
			}
		}else{
			array_push($ciudad, $data["Tipo"]);
		}
	}

	echo '<pre>';
    print_r($data);
    echo '</pre>';

    echo str_replace(array("$",","), array("",""), $data["Precio"]);


}




?>