<?php

	require 'Slim/Slim.php';
	require_once('master.php');
	require_once('datos.php');
	require_once('logger.php'); /** System Log Register */

	
	/***************************************************************************************************
	 * Deficiones de Variables y Obejetos globales
	 ***************************************************************************************************/

	$log = new logger(); 	// Instanciamos el sistema de registro de Logs
	$log->error_log_app = 'WS_CRMLINXX_OSIRIS';

	$master = new WSMaster();	// Instanciamos la clase principal del sistema. Esta contiene todas las funciones utilitarias
	$datos = new Datos();	// Instanciamos la clase de datos del sistema. Esta contiene todas las funciones para manejo de la base de datos
	

	
	/***************************************************************************************************
	 * Definición del servicio web y sus métodos
	 ***************************************************************************************************/
	\Slim\Slim::registerAutoloader();
	$ws = new \Slim\Slim();

	
	// Cabeceras request
	$headers = $ws->request->headers;
		
	// Cabeceras response
	//$ws->response->headers->set("Content-type", "application/json;charset=ISO-8859-1");
	//$ws->response->headers->set('Access-Control-Allow-Origin', '*');
	//$ws->response->headers->set('Content-type', 'application/json');
	//$ws->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	//$ws->response->headers->set('Access-Control-Allow-Headers', 'Origin, Authorization, X-Requested-With');

	
	// Métodos
	$ws->post('/setAsesoras', 'postSetAsesoras');
	$ws->post('/setRecordatorios', 'postSetRecordatorios');
	$ws->get('/getStatus', 'getStatus');
	$ws->get('/getValidateCarga', 'getValidateCarga');
	$ws->run();
		
	
	function postSetAsesoras(){

		try {
		
			global $log, $master, $datos, $headers;

			$ws = \Slim\Slim::getInstance();
			
			/*if ($headers['X-Token-Auth'] != '123456789ABCDEFG' || $headers['Php-Auth-User'] != 'juan' || $headers['Php-Auth-Pw'] != '123'){
				$ws->response->setStatus(401);
				echo 'sorry';
				die();
			}*/

			$data = $ws->request()->getBody();
			//$data = utf8_encode($data);
			$asesoras = json_decode($data, true);
			
			$request_id = $master->obtenerRequestId();
			$id_cuenta = '';
			$valid = '';
			$error = '';
			$result = '';

			
			foreach($asesoras['rootAsesoras']['asesora'] as $asesora){

				$validacion = '';
				$validacion = $master->validarRegistroAsesora($asesora);
				
				if($validacion=='valido'){
					$valid = 'S';
					$error = null;
					$resultados = $datos->registrarAsesora($asesora);
																			
					$datos->registrarEstadoCuenta($asesora, $resultados['id_cuenta']);
					$datos->registrarPuntos($asesora, $resultados['id_cuenta']);
					$datos->registrarEmail($asesora['email'], $resultados['id_cuenta']);
					$result = $resultados['accion'];		
				}else{
					$valid = 'N';
					$error = $validacion;
					$result = 'Rechazado';
				}
				
				$datos->insertarRegistroAsesoraLog($request_id, $asesora, $valid, $error, $result, 'setAsesoras');
			}
			echo 'Conexión establecida con xxxxx...<br>';
			echo 'Resultado del proceso: Exitoso....<br>';
			$master->txtLog($data);
			$ws->response->setStatus(200);
			
		} catch (Exception $e) {
			$log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			echo 'Conexión establecida con xxxxx...<br>';
			echo 'Resultado del proceso: Error....<br>';
			$ws->response->setStatus(500);
		}
		
	}


	function postSetRecordatorios(){
		try {
				
			global $log, $master, $datos, $headers;

			$ws = \Slim\Slim::getInstance();
			
			/*if ($headers['X-Token-Auth'] != '123456789ABCDEFG' || $headers['Php-Auth-User'] != 'juan' || $headers['Php-Auth-Pw'] != '123'){
				$ws->response->setStatus(401);
				echo 'sorry';
				die();
			}*/
			
			$data = $ws->request()->getBody();
			//$data = utf8_encode($data);
			$recordatorios = json_decode($data, true);
			
			$request_id = $master->obtenerRequestId();
			$id_cuenta = '';

			foreach($recordatorios['rootRecordatorios']['recordatorio'] as $recordatorio){

				$validacion = '';
				$validacion = $master->validarRegistroRecordatorio($recordatorio);

				if($validacion=='valido'){
					$valid = 'S';
					$error = null;
					$result = $datos->registrarRecordatorio($recordatorio);
				}else{
					$valid = 'N';
					$error = $validacion;
					$result = 'Rechazado';
				}
				$datos->insertarRegistroRecordatorioLog($request_id, $recordatorio, $valid, $error, $result, 'setRecordatorios');
			}
			echo 'Conexión establecida con xxxxx...<br>';
			echo 'Resultado del proceso: Exitoso....<br>';
			$master->txtLog($data);
			$ws->response->setStatus(200);
				
		} catch (Exception $e) {
			$log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			echo 'Conexión establecida con xxxxx...<br>';
			echo 'Resultado del proceso: Error....<br>';
			$ws->response->setStatus(500);
		}
	}
	
	
	function getStatus(){
		try {
			$ws = \Slim\Slim::getInstance();
			echo 'Current Satus: Service UP...';
			$ws->response->setStatus(200);
		} catch (Exception $e) {
			$ws->response->setStatus(500);
			$log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}	
	
	
	function getValidateCarga(){
	set_time_limit(900);
		try {

			global $log, $master, $datos, $headers;
		
			$ws = \Slim\Slim::getInstance();
			
			$total_registros = $datos->contarRegistrosCarga();
			$fin_for = round(($total_registros['totalRegistros'] / 500), 0, PHP_ROUND_HALF_UP);
			
			echo 'Total Registros: '.$total_registros['totalRegistros'].'<br>';
			echo 'Total Rondas: '.$fin_for.'<br>';
			echo 'Hora Inicial: '.date('H:i:s').'<br><br>';
			$limit_ini = 1;
			$limit_fin = 500;
			
			for($i = 0; $i <= $fin_for; $i++){
				
				echo 'Ronda de ejecución: '.$i.' de '.$fin_for.'<br>';
				echo '-------------------------------------------------<br>';
				echo 'Consecutivo inicial: '.$limit_ini.'<br>'; 
				echo 'consecutivo final: '.$limit_fin.'<br><br>';
				$carga = $datos->seleccionarCarga($limit_ini, $limit_fin);
				$request_id = $master->obtenerRequestId();
				$id_cuenta = '';
				$valid = '';
				$error = '';
				$result = '';
				
				foreach($carga as $asesora){
				
					$validacion = '';
					$validacion = $master->validarRegistroAsesora($asesora);
						
					if($validacion=='valido'){
						$valid = 'S';
						$error = null;
						
						$resultados = $datos->registrarAsesora($asesora);
							
						$datos->registrarEstadoCuenta($asesora, $resultados['id_cuenta']);
						$datos->registrarPuntos($asesora, $resultados['id_cuenta']);
						$datos->registrarEmail($asesora['email'], $resultados['id_cuenta']);
						$result = $resultados['accion'];
						
					}else{
						$valid = 'N';
						$error = $validacion;
						$result = 'Rechazado';
					}
						
					$datos->insertarRegistroAsesoraLog($request_id, $asesora, $valid, $error, $result, 'getValidateCarga');

				}
				$limit_ini += 500;
				$limit_fin += 500;
				sleep(5);
			}
			echo 'Conexión establecida con xxxxx...<br>';
			echo 'Resultado del proceso: Exitoso....<br>';
			echo 'Hora Final: '.date('H:i:s');
			$ws->response->setStatus(200);
				
		} catch (Exception $e) {
			$log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			echo 'Conexión establecida con xxxxx...<br>';
			echo 'Resultado del proceso: Error....<br>';
			$ws->response->setStatus(500);
		}
	set_time_limit(30);
	}
	
	
?>