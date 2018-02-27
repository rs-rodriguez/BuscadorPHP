<?php 
require_once("class_buscador.php");

if(!empty($_POST["case"])){
	$caseProcess = $_POST["case"];
}else{
	$caseProcess = 0;
}

switch ($caseProcess) {
	//Caso para mostrar todos los registros
	case 'mostrarTodo':
		$buscadorNextU = new buscadorNextU("../data-1.json");
		$rps = json_encode(array("rps" => 1, "result" => $buscadorNextU->datosJson()));

		echo $rps;
		
		break;

	//Caso para rellenar los select
	case 'DatosCiudad':

		$buscadorNextU 	= new buscadorNextU("../data-1.json");
		$datos 			= $buscadorNextU->datosJson();
		$tipos = $ciudad= array();
		
		//Recorremos los datos
		foreach($datos as $data){
			//Comprobamos que este dato no este vacio
			if(!empty($data["Ciudad"])){
				//verificamos si la variable $ciudad tiene ya un registro
				if(count($ciudad)>0){
					//miramos si en el array existe esta ciudad
					if(!in_array($data["Ciudad"], $ciudad)){
						//como no existe ingresamos el dato en la variable ciudad
						array_push($ciudad, $data["Ciudad"]);
					}
				}else{
					//Como no exisxten registro lo innaguramos con este dato
					array_push($ciudad, $data["Ciudad"]);
				}
			}

			//Comprobamos que este dato no este vacio
			if(!empty($data["Tipo"])){
				//verificamos si la variable $tipos tiene ya un registro
				if(count($tipos)>0){
					//miramos si en el array existe esta ciudad
					if(!in_array($data["Tipo"], $tipos)){
						array_push($tipos, $data["Tipo"]);
					}
				}else{
					array_push($tipos, $data["Tipo"]);
				}
			}
		}

		//enviamos lo siguiente como respuesta
		$rps = json_encode(array("rps" => 1, "result" => array($ciudad, $tipos)));

		echo $rps;

		break;

	//Caso para realizar la busqueda por filtros
	case 'DatosFiltro':

		$buscadorNextU 	= new buscadorNextU("../data-1.json");
		$datos 			= $buscadorNextU->datosJson();
		
		$ciudad 		= $_POST["ciudad"];
		$tipo 			= $_POST["tipo"];
		$precio 		= explode(";", $_POST["precio"]);

		$datos_mostrar 	= array();
				
		foreach($datos as $data){
			//banderas para evaluar
			$fag_ciudad = false;
			$fag_tipo 	= false;
			$fag_precio = false;

			//evaluamos si solicito filtrar por ciudad
			if(!empty($ciudad)){
				if($data["Ciudad"]==$ciudad){
					$fag_ciudad = true;
				}
			}else{
				$fag_ciudad = true;
			}

			//evaluamos si solicito filtrar por tipo
			if(!empty($tipo)){
				if($data["Tipo"]==$tipo){
					$fag_tipo = true;
				}
			}else{
				$fag_tipo = true;
			}

			//evaluamos si solicito filtrar por precio
			//Le damos un formato al precio
			$precio_limpio = str_replace(array("$",","), array("",""), $data["Precio"]);
			if($precio_limpio>=$precio[0] && $precio_limpio<=$precio[1]){
				$fag_precio = true;
			}

			//Si todas las banderas son verdaderas guardo los datos de este registro
			if($fag_ciudad && $fag_tipo && $fag_precio){
				array_push($datos_mostrar, $data);
			}

			//enviamos lo siguiente como respuesta
			$rps = json_encode(array("rps" => 1, "result" => $datos_mostrar));
		}	

		echo $rps;

		break;
	
	default:
		# code...
		break;
}


?>