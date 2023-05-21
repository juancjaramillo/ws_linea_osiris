<?php 
$conf = include 'wsconfig.php';
require_once('validations.php');
require_once('PHPMailer/class.phpmailer.php');
require_once('PHPExcel.php'); /** PHPExcel_Writer_Excel2007 */
require_once('logger.php'); /** System Log Register */


class WSMaster {
	
	var $log;
	
	public function __construct(){
		$this->log = new logger();
		$this->log->error_log_app = 'WS_CRMLXXXXXXX_OSIRIS';
	}
	
	
	function generateUuid() {
		try {
			return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
					mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
					mt_rand( 0, 0xffff ),
					mt_rand( 0, 0x0fff ) | 0x4000,
					mt_rand( 0, 0x3fff ) | 0x8000,
					mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
			);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function codificaJson($cadena){
		try {
			return utf8_decode(preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', json_encode($cadena)));
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function replace_unicode_escape_sequence($match) {
		try {
			return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function replaceSpaces($data){

		$data = array_map(function($field){
			return (!strlen($field)>0) ? 'NULL' : "'".$field."'";
		},$data);
		return $data;
	}

	
	function limpiarArray($array) {
		try {
			$str_result = '';
			$arr_result = array();
			foreach($array as $key=>$campo){
				foreach($campo as $error=>$descripcion){
					if($descripcion!='true'){
						if(!isset($arr_result[$key])){
							$str_result .= strtoupper($key).':\n';
							$arr_result[$key]=array();
						}
						array_push($arr_result[$key], $descripcion);
						$str_result .= '-- '.$descripcion.'\n';
					}
				}
			}
			return $str_result;			
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}


	function leerJson($array, $t = 1) {
		// No es una función de producción.
		// Esta función solo se utiliza para leer en modo de prueba el json enviado desde línea directa. 
		try {
			$string = "";
			foreach($array as $key=>$value){
				$string .= str_repeat("\t", ($t > 0? $t - 1 : 0)) . "'$key' : ";
				if (is_array($value)){
					$pad = str_repeat("\t", ($t > 0? $t - 1 : 0));
					$string .= $pad . "{\n";
					$string .= $this->leerJson($value, $t + 1);
					$string .= $pad . "},\n";
				} else {
					$string .= "'$value',\n";
				}
				}
			return $string;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
		
	
	function enviarEmail($adjunto){
		
		// ESTE MÉTODO ES DE PRUEBA. SOLO SE USARÁ EN DESARROLLO
		
		$mail = new PHPMailer();
		
		$mail->isSMTP();
		$mail->Host = '10.1.xx.xx';
		$mail->SMTPAuth = false;
		$mail->Username = 'crm_pruebas';
		//$mail->Password = 'xxx';
		
		$mail->From = 'juan.xx@xxx.com.co';
		$mail->FromName = 'WS Osiris - xxx';
		$mail->addAddress('juan.xx@xx.com.co');
		
		//$mail->addCC('cc@example.com');

		
		$mail->addAttachment('/var/www/html/xxoxx/ws_xx_xx/'.$adjunto);
		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Prueba Respuesta Servicio Web';
		$mail->Body    = 'Este es un mensaje confirmando que se ha recibido una petición desde Línea Directa. En el archivo adjunto podrán encontar en log con el resultado de la petición.';
		
		if(!$mail->send()) {
		    echo 'El mensaje no pudo ser enviado.';
		    echo 'Reporte de Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Mensaje Enviado...';
		}
	}
		
	
	function enviarEmail2($adjunto){
	
		// ESTE MÉTODO ES DE PRUEBA. SOLO SE USARÁ EN DESARROLLO
	
		$mail = new PHPMailer();
	
		$mail->isSMTP();
		$mail->Host = '10.1.xx.xx';
		$mail->SMTPAuth = false;
		$mail->Username = 'crm_pruebas';
		//$mail->Password = 'xxx';
	
		$mail->From = 'juan.xx@xx.com.co';
		$mail->FromName = 'WS Osiris - xx';
		$mail->addAddress('juan.xx@xx.com.co');
		$mail->addReplyTo('juan.xx@xxxxx.com.co');
		//$mail->addCC('cc@example.com');
	
	
		$mail->addAttachment('/var/www/html/JCJC/xxxxx/'.$adjunto);
		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Reporte de Errores Servicio Web Osiris - xxxx';
		$mail->Body    = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
							<html>
								<body style='font-family:calibri; font-size:small;'>
									<p>Cordial saludo,<br /> <br /> En el archivo adjunto podr&aacute;n encontrar los registros que fueron rechazados por presentar inconsitencias en algunos de campos.</p>
									<p>&nbsp;</p>
									<p>Atentamente,</p>
									<p><strong><span style='color: #0069b4;'>CRM L&Iacute;NEA xx</span></strong> (Carmel + Pac&iacute;fika + Loguin)<br><strong>xxxxx S.A.S.</strong></p>
									
									<br>
									<hr />
									<em>Este es un mensaje generado autom&aacute;ticamente desde SuiteCRM. Por favor no responder sobre este correo.</em>
									<hr />
								</body>
							</html>";
		if(!$mail->send()) {
			echo 'El mensaje no pudo ser enviado.<br>';
			echo 'Reporte de Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Mensaje Enviado...<br>';
		}
	}
		
	
	function enviarReporteErrores($tipo_reporte, $adjunto){
		try {
			global $conf;
			$mail = new PHPMailer();
			
			$mail->isSMTP();
			$mail->Host = $conf['Mail_config']['host'];
			$mail->SMTPAuth = true;
			$mail->Username = $conf['Mail_config']['user'];;
			$mail->Password = $conf['Mail_config']['pass'];;
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->From = 'notificaciones@xx.com.co';
			$mail->FromName = 'WS Osiris - xx';
			$mail->addReplyTo('notificaciones@xxxxx.com.co');			
			foreach($conf['Notify_to'] as $email_to){
				$mail->addAddress($email_to);
			}
			//$mail->addCC('cc@example.com');
			
			$mail->addAttachment($adjunto);
			$mail->Subject = 'Reporte de Errores '.$tipo_reporte.' Servicio Web Osiris - xxxxx';
			$mail->Body    = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
							<html>
								<body style='font-family:calibri; font-size:small;'>
									<p>Cordial saludo,<br /> <br /> En el archivo adjunto podr&aacute;n encontrar los registros que fueron rechazados por presentar inconsitencias en algunos de campos.</p>
									<p>&nbsp;</p>
									<p>Atentamente,</p>
									<p><strong><span style='color: #0069b4;'>CRM L&Iacute;NEA DIRECTA</span></strong> (Carmel + Pac&iacute;fika + Loguin)<br><strong>xxxxx S.A.S.</strong></p>
					
									<br>
									<hr />
									<em>Este es un mensaje generado autom&aacute;ticamente desde SuiteCRM. Por favor no responder sobre este correo.</em>
									<hr />
								</body>
							</html>";
			if(!$mail->send()) {
				$this->log->writeLog($mail->ErrorInfo);;
			}
				
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function txtLog($mensaje){
		$tmpJson = json_decode($mensaje, true);		
		$mensaje = json_encode($mensaje);		
		
		# leemos el json y construimos el string del documento
		$jsonPretty  = $this->leerJson($tmpJson);

		$nombreArchivo = 'ws_osiris_xxxxx.log';
		
		if(!file_exists($nombreArchivo)){
			$archivo = fopen($nombreArchivo, 'a+');
				fwrite($archivo, PHP_EOL);
				fwrite($archivo, '********************************************************************'.PHP_EOL);
				fwrite($archivo, '*                                                                  *'.PHP_EOL);
				fwrite($archivo, '*            LOG CONSUMO WEB SERVICE OSIRIS - xxxxx              *'.PHP_EOL);
				fwrite($archivo, '*                                                                  *'.PHP_EOL);
				fwrite($archivo, '********************************************************************'.PHP_EOL);
			fclose($archivo);
		}
		$archivo = fopen($nombreArchivo, 'a+');
			fwrite($archivo, PHP_EOL);		
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, '--------------------------------------------------------------------'.PHP_EOL);
			fwrite($archivo, 'Fecha Hora Transacción: '.date('Y-m-d h:i:s').PHP_EOL);
			fwrite($archivo, '--------------------------------------------------------------------'.PHP_EOL);				
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, 'Mensaje Enviado desde Osiris: '.PHP_EOL);
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, $jsonPretty);
			fwrite($archivo, PHP_EOL);
			fwrite($archivo, '<-- Fin Transacción -->'.PHP_EOL);
		fclose($archivo);
		
		$this->enviarEmail($nombreArchivo);
	}
			
	
	function obtenerIp(){
		try {
			if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != ''){
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != ''){
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != ''){
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function obtenerRequestId(){
		try {
			$ip=$this->obtenerIp();
			$ip=str_replace('.', '', $ip);
			return $ip.'-'.date('Ymd').'-'.date('His');
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
		
	function generarReporteErroresAsesoras($errores){
		try {
			global $conf;
			$objPHPExcel = new PHPExcel();
			$nombreArchivo = $conf['File_upload'].'Reporte Errores Asesoras WS-Osiris-xxxxx '.date('Ymdhis').'.xlsx';
			
			// Set Propiedades Archivo
			$objPHPExcel->getProperties()->setCreator("WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setLastModifiedBy("WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setTitle("Reporte Errores Asesoras WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setSubject("Reporte Errores Asesoras WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setDescription("...");
			$objPHPExcel->getProperties()->setKeywords("...");
			$objPHPExcel->getProperties()->setCategory("...");
			
			// Set Nombre Columnas
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CEDULA');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'TIPO DOCUMENTO');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'MARCA');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ZONA');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'SALDO A PAGAR');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'CUPO VALOR FACTURA');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'CUPO VALOR CATÁLOGO');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'NÚMERO DE ÚLTIMA FACTURA');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'VALOR ÚLTIMA FACTURA');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'CAMPAÑA ÚLTIMA FACTURA');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'FECHA DE VENCIMIENTO FACTURA');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'FECHA FACTURA');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'NÚMERO DOC ULTIMA NOTA CRÉDITO');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'VALOR ÚLTIMA NOTA CRÉDITO');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'FECHA ÚLTIMA NC');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'TIPO DE ÚLTIMA NC');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'NÚMERO ÚLTIMA REMISIÓN ');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'NÚMERO DOC DE ÚLTIMO PAGO');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'VALOR DE ÚLTIMO PAGO');
			$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'FECHA DEL ÚLTIMO PAGO');
			$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'NOMBRE DE LA DIRECTORA DE ZONA');
			$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'TELEFONO DE LA DIRECTORA DE ZONA');
			$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'EMAIL DE LA DIRECTORA DE ZONA');
			$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'CAMPAÑA ACTUAL');
			$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'PUNTOS  CAMPAÑA ACTUAL');
			$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'CAMPAÑA ANTERIOR');
			$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'PUNTOS CAMPAÑA ANTERIOR');
			$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'CAMPAÑA TRAS ANTERIOR');
			$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'PUNTOS CAMPAÑA TRAS ANTERIOR');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'ESTADO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'NÚMERO DE CRÉDITOS');
			$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'CLASIFICADO POR VALOR');
			$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'DIVISIÓN');
			$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'PRIMER NOMBRE');
			$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'SEGUNDO NOMBRE');
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'PRIMER APELLIDO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'SEGUNDO APELLIDO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'FECHA NACIMIENTO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'PERSONA QUE REFERENCIÓ');
			$objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'DEPARTAMENTO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'CIUDAD');
			$objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'DIRECCIÓN');
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'BARRIO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'TELEFONO 1');
			$objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'TELEFONO 2');
			$objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'TELEFONO 3');
			$objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'CELULAR');
			$objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'EMAIL');
			$objPHPExcel->getActiveSheet()->SetCellValue('AW1', 'ID PETICIÓN');
			$objPHPExcel->getActiveSheet()->SetCellValue('AX1', 'RESULTADO');
			$objPHPExcel->getActiveSheet()->SetCellValue('AY1', 'MENSAJE ERROR');
			
			$fila = 2;
			$campos = $errores->columnCount();

			foreach($errores as $row_errores){
				for($i = 0; $i<$campos; $i++){
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i, $fila, $row_errores[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				}
				$fila += 1;
			}

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($nombreArchivo);
			return $nombreArchivo;			
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}

	
	function generarReporteErroresRecordatorios($errores){
		try {
			global $conf;
			$objPHPExcel = new PHPExcel();
			$nombreArchivo = $conf['File_upload'].'Reporte Errores Recordatorios WS-Osiris-xxxxx '.date('Ymdhis').'.xlsx';
			
			// Set Propiedades Archivo
			$objPHPExcel->getProperties()->setCreator("WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setLastModifiedBy("WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setTitle("Reporte Errores Recordatorios WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setSubject("Reporte Errores Recordatorios WS-Osiris-xxxxx");
			$objPHPExcel->getProperties()->setDescription("...");
			$objPHPExcel->getProperties()->setKeywords("...");
			$objPHPExcel->getProperties()->setCategory("...");
			
			// Set Nombre Columnas
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MARCA');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CAMPAÑA');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ZONA');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'FECHA ENTREGA PEDIDO');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'FECHA FACTURACIÓN PEDIDO');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'FECHA LÍMITE INGRESO DE PEDIDO');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'FECHA DE CAMBIOS Y DEVOLUCIONES');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'LUGAR Y HORA DE CAMBIOS Y DEVOLUCIONES');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'FECHA LÍMITE DE PAGO DE PEDIDO');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'FECHA DE CONFERENCIA ');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'LUGAR Y HORA DE LA CONFERENCIA ');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'ID PETICIÓN');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'RESULTADO');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'MENSAJE ERROR');
			
			$fila = 2;
			$campos = $errores->columnCount();
			foreach($errores as $row_errores){
				for($i = 0; $i<$campos; $i++){
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i, $fila, $row_errores[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				}
				$fila += 1;
			}
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			
			$objWriter->save($nombreArchivo);
			return $nombreArchivo;
				
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
		
	
	function validarRegistroAsesora($asesora){
		
		$error='';
		
		try {
			$validar = array();
			if(isset($asesora['nro_documento'])) $validar['nro_documento'] = array(
					Validation::validate_required($asesora['nro_documento']),
					Validation::validate_maxlenght($asesora['nro_documento'], 12),
					Validation::validate_alphanumeric($asesora['nro_documento']),
			);
			if(isset($asesora['tipo_documento'])) $validar['tipo_documento'] = array(
					Validation::validate_required($asesora['tipo_documento']),
					Validation::validate_lenght($asesora['tipo_documento'], 2),
					Validation::validate_alphabetic($asesora['tipo_documento']),
			);
			if(isset($asesora['marca'])) $validar['marca'] = array(
					Validation::validate_required($asesora['marca']),
					Validation::validate_lenght($asesora['marca'], 4),
					Validation::validate_marca($asesora['marca']),
			);
			if(isset($asesora['zona'])) $validar['zona'] = array(
					Validation::validate_required($asesora['zona']),
					Validation::validate_minlenght($asesora['zona'], 1),
					Validation::validate_maxlenght($asesora['zona'], 5),
					Validation::validate_digits($asesora['zona']),
					Validation::validate_zona_exist($asesora['zona']),
			);
			if(isset($asesora['saldo_pagar'])) $validar['saldo_pagar'] = array(
					//Validation::validate_required($asesora['saldo_pagar']),
					Validation::validate_numerics($asesora['saldo_pagar']),
					Validation::validate_maxlenght($asesora['saldo_pagar'], 18),
			);
			if(isset($asesora['cupo_valor_factura'])) $validar['cupo_valor_factura'] = array(
					Validation::validate_required($asesora['cupo_valor_factura']),
					Validation::validate_digits($asesora['cupo_valor_factura']),
					Validation::validate_minlenght($asesora['cupo_valor_factura'], 1),
					Validation::validate_maxlenght($asesora['cupo_valor_factura'], 15),
			);
			if(isset($asesora['cupo_valor_catalogo'])) $validar['cupo_valor_catalogo'] = array(
					Validation::validate_required($asesora['cupo_valor_catalogo']),
					Validation::validate_digits($asesora['cupo_valor_catalogo']),
					Validation::validate_minlenght($asesora['cupo_valor_catalogo'], 1),
					Validation::validate_maxlenght($asesora['cupo_valor_catalogo'], 15),
			);
			if(isset($asesora['numero_ultima_factura'])) $validar['numero_ultima_factura'] = array(
					//Validation::validate_required($asesora['numero_ultima_factura']),
					Validation::validate_digits($asesora['numero_ultima_factura']),
					Validation::validate_maxlenght($asesora['cupo_valor_catalogo'], 20),
			);
			if(isset($asesora['valor_ultima_factura'])) $validar['valor_ultima_factura'] = array(
					//Validation::validate_required($asesora['valor_ultima_factura']),
					Validation::validate_digits($asesora['valor_ultima_factura']),
					Validation::validate_maxlenght($asesora['valor_ultima_factura'], 15),
			);
			if(isset($asesora['campana_ultima_factura'])) $validar['campana_ultima_factura'] = array(
					//Validation::validate_required($asesora['campana_ultima_factura']),
					Validation::validate_lenght($asesora['campana_ultima_factura'], 6),
					Validation::validate_digits($asesora['campana_ultima_factura']),
			);
			if(isset($asesora['fecha_vencimiento_factura'])) $validar['fecha_vencimiento_factura'] = array(
					//Validation::validate_required($asesora['fecha_vencimiento_factura']),
					Validation::validate_lenght($asesora['fecha_vencimiento_factura'], 8),
					Validation::validate_dateformat($asesora['fecha_vencimiento_factura']),
			);
			if(isset($asesora['fecha_factura'])) $validar['fecha_factura'] = array(
					//Validation::validate_required($asesora['fecha_factura']),
					Validation::validate_lenght($asesora['fecha_factura'], 8),
					Validation::validate_dateformat($asesora['fecha_factura']),
			);
			if(isset($asesora['numero_doc_ultima_nc'])) $validar['numero_doc_ultima_nc'] = array(
					//Validation::validate_required($asesora['numero_doc_ultima_nc']),
					Validation::validate_digits($asesora['numero_doc_ultima_nc']),
					Validation::validate_maxlenght($asesora['numero_doc_ultima_nc'], 18),
			);
			if(isset($asesora['valor_ultima_nc'])) $validar['valor_ultima_nc'] = array(
					//Validation::validate_required($asesora['valor_ultima_nc']),
					Validation::validate_digits($asesora['valor_ultima_nc']),
					Validation::validate_maxlenght($asesora['valor_ultima_nc'], 15),
			);
			if(isset($asesora['fecha_ultima_nc'])) $validar['fecha_ultima_nc'] = array(
					//Validation::validate_required($asesora['fecha_ultima_nc']),
					Validation::validate_lenght($asesora['fecha_ultima_nc'], 8),
					Validation::validate_dateformat($asesora['fecha_ultima_nc']),
			);
			if(isset($asesora['tipo_ultima_nc'])) $validar['tipo_ultima_nc'] = array(
					//Validation::validate_required($asesora['tipo_ultima_nc']),
					Validation::validate_lenght($asesora['tipo_ultima_nc'], 2),
					Validation::validate_alphabetic($asesora['tipo_ultima_nc']),
			);
			if(isset($asesora['numero_ultima_remision'])) $validar['numero_ultima_remision'] = array(
					//Validation::validate_required($asesora['numero_ultima_remision']),
					//Validation::validate_digits($asesora['numero_ultima_remision']),
					Validation::validate_maxlenght($asesora['numero_ultima_remision'], 20),
			);
			if(isset($asesora['numero_doc_ultimo_pago'])) $validar['numero_doc_ultimo_pago'] = array(
					//Validation::validate_required($asesora['numero_doc_ultimo_pago']),
					Validation::validate_digits($asesora['numero_doc_ultimo_pago']),
					Validation::validate_maxlenght($asesora['numero_doc_ultimo_pago'], 20),
			);
			if(isset($asesora['valor_ultimo_pago'])) $validar['valor_ultimo_pago'] = array(
					//Validation::validate_required($asesora['valor_ultimo_pago']),
					Validation::validate_digits($asesora['valor_ultimo_pago']),
					Validation::validate_maxlenght($asesora['valor_ultimo_pago'], 15),
			);
			if(isset($asesora['fecha_ultimo_pago'])) $validar['fecha_ultimo_pago'] = array(
					//Validation::validate_required($asesora['fecha_ultimo_pago']),
					Validation::validate_lenght($asesora['fecha_ultimo_pago'], 8),
					Validation::validate_dateformat($asesora['fecha_ultimo_pago']),
			);
			if(isset($asesora['nombre_directora_zona'])) $validar['nombre_directora_zona'] = array(
					Validation::validate_required($asesora['nombre_directora_zona']),
					//Validation::validate_alphabetic($asesora['nombre_directora_zona']),
			);
			if(isset($asesora['telefono_directora_zona'])) $validar['telefono_directora_zona'] = array(
					Validation::validate_required($asesora['telefono_directora_zona']),
					Validation::validate_minlenght($asesora['telefono_directora_zona'], 7),
					Validation::validate_maxlenght($asesora['telefono_directora_zona'], 10),
					Validation::validate_digits($asesora['telefono_directora_zona']),
			);
			if(isset($asesora['email_directora_zona'])) $validar['email_directora_zona'] = array(
					//Validation::validate_required($asesora['email_directora_zona']),
					Validation::validate_email($asesora['email_directora_zona']),
					Validation::validate_maxlenght($asesora['email_directora_zona'], 100),
			);
			if(isset($asesora['campana_actual'])) $validar['campana_actual'] = array(
					//Validation::validate_required($asesora['campana_actual']),
					Validation::validate_lenght($asesora['campana_actual'], 6),
					Validation::validate_digits($asesora['campana_actual']),
			);
			if(isset($asesora['puntos_campana_actual'])) $validar['puntos_campana_actual'] = array(
					//Validation::validate_required($asesora['puntos_campana_actual']),
					Validation::validate_numerics($asesora['puntos_campana_actual']),
					Validation::validate_maxlenght($asesora['puntos_campana_actual'], 50),
			);
			if(isset($asesora['campana_anterior'])) $validar['campana_anterior'] = array(
					//Validation::validate_required($asesora['campana_anterior']),
					Validation::validate_lenght($asesora['campana_anterior'], 6),
					Validation::validate_digits($asesora['campana_anterior']),
			);
			if(isset($asesora['puntos_campana_anterior'])) $validar['puntos_campana_anterior'] = array(
					//Validation::validate_required($asesora['puntos_campana_anterior']),
					Validation::validate_numerics($asesora['puntos_campana_anterior']),
					Validation::validate_maxlenght($asesora['puntos_campana_anterior'], 50),
			);
			if(isset($asesora['campana_trasanterior'])) $validar['campana_trasanterior'] = array(
					//Validation::validate_required($asesora['campana_trasanterior']),
					Validation::validate_lenght($asesora['campana_trasanterior'], 6),
					Validation::validate_digits($asesora['campana_trasanterior']),
			);
			if(isset($asesora['puntos_campana_trasanterior'])) $validar['puntos_campana_trasanterior'] = array(
					//Validation::validate_required($asesora['puntos_campana_trasanterior']),
					Validation::validate_numerics($asesora['puntos_campana_trasanterior']),
					Validation::validate_maxlenght($asesora['puntos_campana_trasanterior'], 50),
			);
			if(isset($asesora['estado'])) $validar['estado'] = array(
					//Validation::validate_required($asesora['estado']),
					Validation::validate_alphanumeric($asesora['estado']),
			);
			if(isset($asesora['numero_creditos'])) $validar['numero_creditos'] = array(
					//Validation::validate_required($asesora['numero_creditos']),
					Validation::validate_digits($asesora['numero_creditos']),
					Validation::validate_maxlenght($asesora['numero_creditos'], 4),
			);
			if(isset($asesora['clasificado_por_valor'])) $validar['clasificado_por_valor'] = array(
					//Validation::validate_required($asesora['clasificado_por_valor']),
					Validation::validate_alphanumeric($asesora['clasificado_por_valor']),
					Validation::validate_maxlenght($asesora['clasificado_por_valor'], 8),
			);
			if(isset($asesora['division'])) $validar['division'] = array(
					Validation::validate_required($asesora['division']),
					Validation::validate_lenght($asesora['division'], 11),
					Validation::validate_division($asesora['division']),
			);
			if(isset($asesora['primer_nombre'])) $validar['primer_nombre'] = array(
					Validation::validate_required($asesora['primer_nombre']),
					//Validation::validate_alphabetic($asesora['primer_nombre']),
			);
			if(isset($asesora['segundo_nombre'])) $validar['segundo_nombre'] = array(
					//Validation::validate_required($asesora['segundo_nombre']),
					//Validation::validate_alphabetic($asesora['segundo_nombre']),
			);
			if(isset($asesora['primer_apellido'])) $validar['primer_apellido'] = array(
					Validation::validate_required($asesora['primer_apellido']),
					//Validation::validate_alphabetic($asesora['primer_apellido']),
			);
			if(isset($asesora['segundo_apellido'])) $validar['segundo_apellido'] = array(
					//Validation::validate_required($asesora['segundo_apellido']),
					//Validation::validate_alphabetic($asesora['segundo_apellido']),
			);
			if(isset($asesora['fecha_nacimiento'])) $validar['fecha_nacimiento'] = array(
					Validation::validate_required($asesora['fecha_nacimiento']),
					Validation::validate_lenght($asesora['fecha_nacimiento'], 8),
					Validation::validate_dateformat($asesora['fecha_nacimiento']),
			);
			if(isset($asesora['persona_referencio'])) $validar['persona_referencio'] = array(
					//Validation::validate_required($asesora['persona_referencio']),
					Validation::validate_maxlenght($asesora['persona_referencio'], 12),
					Validation::validate_alphanumeric($asesora['persona_referencio']),
			);
			if(isset($asesora['departamento'])) $validar['departamento'] = array(
					Validation::validate_required($asesora['departamento']),
					Validation::validate_lenght($asesora['departamento'], 2),
					Validation::validate_digits($asesora['departamento']),
					Validation::validate_departamento_exist($asesora['departamento']),
			);
			if(isset($asesora['ciudad'])) $validar['ciudad'] = array(
					Validation::validate_required($asesora['ciudad']),
					Validation::validate_lenght($asesora['ciudad'], 5),
					Validation::validate_digits($asesora['ciudad']),
					Validation::validate_ciudad_exist($asesora['ciudad']),
			);
			if(isset($asesora['direccion'])) $validar['direccion'] = array(
					Validation::validate_required($asesora['direccion']),
			);
			if(isset($asesora['barrio'])) $validar['barrio'] = array(
					//Validation::validate_required($asesora['barrio']),
					//Validation::validate_alphanumeric($asesora['barrio']),
			);
			if(isset($asesora['telefono1'])) $validar['telefono1'] = array(
					//Validation::validate_required($asesora['telefono1']),
					Validation::validate_minlenght($asesora['telefono1'], 7),
					Validation::validate_maxlenght($asesora['telefono1'], 10),
					Validation::validate_digits($asesora['telefono1']),
			);
			if(isset($asesora['telefono2'])) $validar['telefono2'] = array(
					//Validation::validate_required($asesora['telefono2']),
					Validation::validate_minlenght($asesora['telefono2'], 7),
					Validation::validate_maxlenght($asesora['telefono2'], 10),
					Validation::validate_digits($asesora['telefono2']),
			);
			if(isset($asesora['telefono3'])) $validar['telefono3'] = array(
					//Validation::validate_required($asesora['telefono3']),
					Validation::validate_minlenght($asesora['telefono3'], 7),
					Validation::validate_maxlenght($asesora['telefono3'], 10),
					Validation::validate_digits($asesora['telefono3']),
			);
			if(isset($asesora['celular'])) $validar['celular'] = array(
					//Validation::validate_required($asesora['celular']),
					Validation::validate_lenght($asesora['celular'], 10),
					Validation::validate_digits($asesora['celular']),
			);
			if(isset($asesora['email'])) $validar['email'] = array(
					//Validation::validate_required($asesora['email']),
					Validation::validate_email($asesora['email']),
					Validation::validate_maxlenght($asesora['email'], 100),
					
			);
			$error = $this->limpiarArray($validar);
			return ($error=='') ? 'valido' : $error;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function validarRegistroRecordatorio($recordatorio){
	
		$error='';
	
		try {
			$validar = array();
			if(isset($recordatorio['marca'])) $validar['marca'] = array(
					Validation::validate_required($recordatorio['marca']),
					Validation::validate_lenght($recordatorio['marca'], 4),
					Validation::validate_marca($recordatorio['marca']),
			);
			if(isset($recordatorio['campana'])) $validar['campana'] = array(
					Validation::validate_required($recordatorio['campana']),
					Validation::validate_lenght($recordatorio['campana'], 6),
					Validation::validate_digits($recordatorio['campana']),
			);
			if(isset($recordatorio['zona'])) $validar['zona'] = array(
					Validation::validate_required($recordatorio['zona']),
					Validation::validate_minlenght($recordatorio['zona'], 1),
					Validation::validate_maxlenght($recordatorio['zona'], 5),
					Validation::validate_digits($recordatorio['zona']),
					Validation::validate_zona_exist($recordatorio['zona']),
			);
			if(isset($recordatorio['fecha_entrega_pedido'])) $validar['fecha_entrega_pedido'] = array(
					//Validation::validate_required($recordatorio['fecha_entrega_pedido']),
					Validation::validate_lenght($recordatorio['fecha_entrega_pedido'], 8),
					Validation::validate_dateformat($recordatorio['fecha_entrega_pedido']),
			);
			if(isset($recordatorio['fecha_facturacion_pedido'])) $validar['fecha_facturacion_pedido'] = array(
					//Validation::validate_required($recordatorio['fecha_facturacion_pedido']),
					Validation::validate_lenght($recordatorio['fecha_facturacion_pedido'], 8),
					Validation::validate_dateformat($recordatorio['fecha_facturacion_pedido']),
			);
			if(isset($recordatorio['fecha_limite_ingreso_pedido'])) $validar['fecha_limite_ingreso_pedido'] = array(
					//Validation::validate_required($recordatorio['fecha_limite_ingreso_pedido']),
					Validation::validate_lenght($recordatorio['fecha_limite_ingreso_pedido'], 8),
					Validation::validate_dateformat($recordatorio['fecha_limite_ingreso_pedido']),
			);
			if(isset($recordatorio['fecha_cambios_devoluciones'])) $validar['fecha_cambios_devoluciones'] = array(
					//Validation::validate_required($recordatorio['fecha_cambios_devoluciones']),
					Validation::validate_lenght($recordatorio['fecha_cambios_devoluciones'], 8),
					Validation::validate_dateformat($recordatorio['fecha_cambios_devoluciones']),
			);
			if(isset($recordatorio['lugar_hora_cambias'])) $validar['lugar_hora_cambias'] = array(
					//Validation::validate_required($recordatorio['lugar_hora_cambias']),
			);
			if(isset($recordatorio['fecha_limite_pago_pedido'])) $validar['fecha_limite_pago_pedido'] = array(
					//Validation::validate_required($recordatorio['fecha_limite_pago_pedido']),
					Validation::validate_lenght($recordatorio['fecha_limite_pago_pedido'], 8),
					Validation::validate_dateformat($recordatorio['fecha_limite_pago_pedido']),
			);
			if(isset($recordatorio['fecha_conferencia'])) $validar['fecha_conferencia'] = array(
					//Validation::validate_required($recordatorio['fecha_conferencia']),
					Validation::validate_lenght($recordatorio['fecha_conferencia'], 8),
					Validation::validate_dateformat($recordatorio['fecha_conferencia']),
			);
			if(isset($recordatorio['lugar_hora_conferencia'])) $validar['lugar_hora_conferencia'] = array(
					//Validation::validate_required($recordatorio['lugar_hora_conferencia']),
			);
			$error = $this->limpiarArray($validar);
			return ($error=='') ? 'valido' : $error;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}

	}
	
	
}

?>