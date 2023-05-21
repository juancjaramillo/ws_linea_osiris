<?php 

require_once('master.php');
require_once('datos.php');
require_once('logger.php'); /** System Log Register */
set_time_limit(900);
ini_set("memory_limit","512M");
try {
	$log = new logger(); 	// Instanciamos el sistema de registro de Logs
	$log->error_log_app = 'WS_CRMLINXX_OSIRIS';
	$datos = new Datos();
	$master = new WSMaster();
	
		
	// GENERAR REPORTE DE ASESORAS
	$reporte = '';
	$errores = $datos->seleccionarErroresLogAsesoras();
	if($errores->rowCount()>0){
		$reporte = $master->generarReporteErroresAsesoras($errores);
		$master->enviarReporteErrores('Asesoras', $reporte);
		//$datos->actualizarErroresLog('setAsesoras');
		echo 'Reporte de errores Asesoras enviado<br>';
	}else{
		echo 'No hay reporte de errores de asesoras para enviar<br>';
	}

	
	// GENERAR REPORTE DE RECORDATORIOS
	$reporte = '';
	$errores = $datos->seleccionarErroresLogrecordatorios();
	if($errores->rowCount()>0){
		$reporte = $master->generarReporteErroresRecordatorios($errores);
		//$master->enviarReporteErrores('Recordatorios', $reporte);
		//$datos->actualizarErroresLog('setRecordatorios');
		echo 'Reporte de errores Recordatorios enviado<br>';
	}else{
		echo 'No hay reporte de errores de recordatorios para enviar<br>';
	}

} catch (Exception $e) {
	echo 'Error al enviar el reporte de errores';
	$this->log->writeLog('Error al enviar el reporte de errores');
	$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
}



?>