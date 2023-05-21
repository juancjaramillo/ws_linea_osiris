<?php

require_once('datos.php');

class Validation {

	function validate_digits($value){
		if(strlen($value)>0){
			return(preg_match("/^\d*$/", $value) ? 'true' : 'El campo solo puede contener números mayores a cero');
		}else{
			return 'true';
		}
	}
	
	function validate_numerics($value){
		if(strlen($value)>0){
			return(preg_match("/^-?\d*$/", $value) ? 'true' : 'El campo solo puede contener números positivos o negativos');
		}else{
			return 'true';
		}
	}
	
	function validate_alphanumeric($value){
		if(strlen($value)>0){
			return(preg_match("/^[a-zA-Z0-9 ñÑáÁéÉíÍóÓúÚ]+$/", $value) ? 'true' : 'El campo solo puede contener números mayores a cero y letras');
		}else{
			return 'true';
		}
	}
	
	function validate_alphabetic($value){
		if(strlen($value)>0){
			return(preg_match("/^[A-Za-z ñÑáÁéÉíÍóÓúÚ]*$/", $value) ? 'true' : 'El campo solo puede contener letras');
		}else{
			return 'true';
		}
	}

	function validate_decimal($value, $intLenght, $decLenght){
		if(strlen($value)>0){
			return(preg_match("/^\d{1,10}(\.\d{1,2})?$/", $value) ? 'true' : 'El campo solo puede contener números mayores a cero, con un máximo de '.$intLenght.' enteros y '.$decLenght.' decimales');
		}else{
			return 'true';
		}
	}
	
	function validate_maxlenght($value, $lenght){
		if (strlen($value)>0){
			return((strlen($value) <= $lenght) ? 'true' : 'El campo no puede ser mayor a '.$lenght.' caracteres');
		}else{
			return 'true';
		}
	}
	
	function validate_minlenght($value, $lenght){
		if (strlen($value)>0){
			return((strlen($value) >= $lenght) ? 'true' : 'El campo no puede ser menor a '.$lenght.' caracteres');
		}else{
			return 'true';
		}
	}
	
	function validate_lenght($value, $lenght){
		if (strlen($value)>0){
			return((strlen($value) == $lenght) ? 'true' : 'El campo debe contener '.$lenght.' caracteres');
		}else{
			return 'true';
		}
	}
	
	function validate_initial($value){
		if (strlen($value)>0){
					return($value[0] == '0' ? 'El valor del campo no puede iniciar por cero' : 'true');
		}else{
			return 'true';
		}
	}
	
	function validate_email($value){
		if(strlen($value)>0){
			return(preg_match("/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})\.?([A-Za-z]{2})?$/", $value) ? 'true' : 'Dirección de correo electrónico inválida');
			//return(preg_match("/^([\\w-]+(?:\\.[\\w-]+)*)@((?:[\\w-]+\\.)*\\w[\\w-]{0,66})\\.([A-Za-z]{2,6}(?:\\.[A-Za-z]{2})?)$/", $value) ? 'true' : 'Dirección de correo electrónico inválida');
		}else{
			return 'true';	
		}
	}
	
	function validate_required($value){
		return($value != '' ? 'true' : 'Este campo es requerido');
	}
	
	function validate_uuid($value){
		if (strlen($value)>0){
			return(preg_match("/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/", $value) ? 'true' : 'uuid de registro inválido');
		}else{
			return 'true';
		}
	}
	
	function validate_dateformat($value){
		if(strlen($value)>0){
			return(preg_match("/^((((19|[2-9]\d)\d{2})(0[13578]|1[02])(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})(0[13456789]|1[012])(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})02(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))0229))$/", $value) ? 'true' : 'El formato de la fecha no es correcto');
		}else{
			return 'true';
		}
	}
	
	function validate_attached($value){
		$file = '/var/www/html/MLT/metro/upload/'.$value;
		if(file_exists($file)){
			if(filesize($file) <= '1000000') {
				return 'true';
			} else{
				unlink($file);
				return 'Tamaño de archivo invalido';
			}	
		} else{
			return 'Referencia de archivo no valida';
		}
	}
	
	function validate_attached_ext($value){
		$ext = array(
			'doc','docx','xls','xlsx','xlm','xlt','ppt','pptx','jpg','png','ico','zip','rar','msg','pdf','mp4','mkv','avi','mov','wmv','flv','mpeg','3gp','odt'
		);
		return (in_array($value, $ext) ? 'true' : 'Extensión de archivo inválida');
	}

	function validate_division($value){
		if(strlen($value)>0){
			return(preg_match("/(DIVISION)\s(01|02|03|04|05|06|07|08|09)$/", $value) ? 'true' : 'El formato de la división es incorrecto');
		}else{
			return 'true';
		}
	}
	
	function validate_marca($value){
		if(strlen($value)>0){
			return(preg_match("/(CO|co)(11|12|14)$/", $value) ? 'true' : 'El formato de la marca es incorrecto');
		}else{
			return 'true';
		}
	}
	
	function validate_zona_exist($value){
		if(strlen($value)>0){
			$datos = new datos();
			$result = $datos->obtenerZona($value);
			return ($result != '' || $result != null)? 'true' : 'El código de la zona no existe en el CRM';
		}else{
			return 'true';
		}
	}	
	
	function validate_departamento_exist($value){
		if(strlen($value)>0){
			$datos = new datos();
			$result = $datos->obtenerDepartamento($value);
			return ($result != '' || $result != null)? 'true' : 'El código del departamento no existe en el CRM';
		}else{
			return 'true';
		}
	}
	
	function validate_ciudad_exist($value){
		if(strlen($value)>0){
			$datos = new datos();
			$result = $datos->obtenerCiudad($value);
			return ($result != '' || $result != null)? 'true' : 'El código de la ciudad no existe en el CRM';
		}else{
			return 'true';
		}
	}
	
	function validate_campana($value){
		if(strlen($value)>0){
			return(preg_match("/^(\d{4})((0[1-9])|(1[0-2]))$/", $value) ? 'true' : 'El formato de la campana es incorrecto');
		}else{
			return 'true';
		}
	}
}

?>