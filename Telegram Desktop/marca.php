<?php
require "../modelos/Marca.php";


$marca = new Marca();

//Declaracion de Variables
//Ajax permite obtener los datos de los usuarios y pasarlos al modelo: Es el intermediario/ Ajax es el controlador
 
$idmarca = isset($_POST["idmarca"]) ? limpiarCadena($_POST["idmarca"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$condicion = isset($_POST["condicion"]) ? limpiarCadena($_POST["condicion"]) : "";

//Switch
switch ($_GET['op']) {
	case 'guardaryeditar':
		if(empty($idmarca)){//insertar
			//Mandamos a llamara la funcion de insertar de nuestro modelo y pasamos las dos variables para insertar
			$rspta = $marca-> insertar($nombre, $descripcion);
			// tambien puede ser: echo $rspta == true?
			echo $rspta?"Marca Insertada":"Marca no se pudo Insertar";
		}
		else{//editar
			$rspta = $marca-> editar($idmarca, $nombre, $descripcion);
			echo $rspta?"Marca Editada":"Marca No se puedo Editar";
		}
		break;
	
	case'activar':
		$rspta = $marca-> activar($idmarca);
		echo $rspta?"Marca Activada":"Marca no se pudo Activar";

		break;

	case'desactivar':
		$rspta = $marca-> desactivar($idmarca);
		echo $rspta?"Marca Desactivada":"Marca no se puedo activar";
		break;

		case'mostrar':
		$rspta = $marca-> mostrarform($idmarca);
		//Convertir en json
		echo json_encode($rspta);
		break;

	case'mostrarform':
		$rspta = $marca-> mostrarform($idmarca);
		//Convertir en json
		echo json_encode($rspta);
		break;

	case'listar':
		$rspta=$marca->listar();
		$data=Array();

		while($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0"=>  ($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idmarca.')"><i class= "fa fa-pencil"></i></button>'.
        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idmarca.')"><i class= "fa fa-close"></i></button>'
        :
        '<button class="btn btn-warning" onclick="mostrar('.$reg->idmarca.')"><i class= "fa fa-pencil"></i></button>'.
        ' <button class="btn btn-success" onclick="activar('.$reg->idmarca.')"><i class= "fa fa-check"></i></button>',				
        		"1" => $reg->nombre,        
				"2" => $reg->descripcion,
				"3" => ($reg->condicion)? '<span class="label bg-green">Activado</span>':
				'<span class="label bg-red">Desactivado</span>'
			);
		}
		$result =array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data
		);
		echo json_encode($result);

		break;
}
?>