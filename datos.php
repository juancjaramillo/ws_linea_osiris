<?php
$conf = include 'wsconfig.php';
require_once('wsconfig.php');
require_once('master.php');
require_once('wsconfig.php');
require_once('logger.php'); /** System Log Register */

class Datos{

	var $log;
	var $master;
	var $db;
	
	public function __construct(){
		try {
			$this->log = new logger();
			$this->log->error_log_app = 'WS_CRMLINXX_OSIRIS';
			$this->master = new WSMaster();
			$this->db = $this->getConnection();
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function getConnection(){
		try {
			global $conf;
			$dbhost = $conf['DB_config']['host'];
			$dbname = $conf['DB_config']['data_base'];
			$dbuser = $conf['DB_config']['user'];
			$dbpass = $conf['DB_config']['pass'];
			$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			return $dbh;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}			
	}
	
	
	
	
	//------- REGIÓN LOGS --------
	
	function insertarRegistroAsesoraLog($request_id, $asesora, $valid, $error, $result, $metodo){
		try {
			
			$id = $this->master->generateUuid();
			$date_entered = date('Y-m-d H:i:s');
			$ip = $this->master->obtenerIp();
			$asesora = $this->master->replaceSpaces($asesora);

			$sql="INSERT INTO `emt_ws_EMXX_osiris_log`(
				`id`,
				`method`,
				`request_id`,
				`date_entered`,
				`request_from`,
				`valid`,
				`error`,
				`result`,
				`send`,
				`date_send`,
				`nro_documento`,
				`tipo_documento`,
				`marca`,
				`zona`,
				`saldo_pagar`,
				`cupo_valor_factura`,
				`cupo_valor_catalogo`,
				`numero_ultima_factura`,
				`valor_ultima_factura`,
				`campana_ultima_factura`,
				`fecha_vencimiento_factura`,
				`fecha_factura`,
				`numero_doc_ultima_nc`,
				`valor_ultima_nc`,
				`fecha_ultima_nc`,
				`tipo_ultima_nc`,
				`numero_ultima_remision`,
				`numero_doc_ultimo_pago`,
				`valor_ultimo_pago`,
				`fecha_ultimo_pago`,
				`nombre_directora_zona`,
				`telefono_directora_zona`,
				`email_directora_zona`,
				`campana_actual`,
				`puntos_campana_actual`,
				`campana_anterior`,
				`puntos_campana_anterior`,
				`campana_trasanterior`,
				`puntos_campana_trasanterior`,
				`estado`,
				`numero_creditos`,
				`clasificado_por_valor`,
				`division`,
				`primer_nombre`,
				`segundo_nombre`,
				`primer_apellido`,
				`segundo_apellido`,
				`fecha_nacimiento`,
				`persona_referencio`,
				`departamento`,
				`ciudad`,
				`direccion`,
				`barrio`,
				`telefono1`,
				`telefono2`,
				`telefono3`,
				`celular`,
				`email`
				)
				VALUES
				('{$id}',
				'{$metodo}',
				'{$request_id}',
				'{$date_entered}',
				'{$ip}',
				'{$valid}',
				'{$error}',
				'{$result}',
				'N',
				NULL,
				{$asesora['nro_documento']},
				{$asesora['tipo_documento']},
				{$asesora['marca']},
				{$asesora['zona']},
				{$asesora['saldo_pagar']},
				{$asesora['cupo_valor_factura']},
				{$asesora['cupo_valor_catalogo']},
				{$asesora['numero_ultima_factura']},
				{$asesora['valor_ultima_factura']},
				{$asesora['campana_ultima_factura']},
				{$asesora['fecha_vencimiento_factura']},
				{$asesora['fecha_factura']},
				{$asesora['numero_doc_ultima_nc']},
				{$asesora['valor_ultima_nc']},
				{$asesora['fecha_ultima_nc']},
				{$asesora['tipo_ultima_nc']},
				{$asesora['numero_ultima_remision']},
				{$asesora['numero_doc_ultimo_pago']},
				{$asesora['valor_ultimo_pago']},
				{$asesora['fecha_ultimo_pago']},
				{$asesora['nombre_directora_zona']},
				{$asesora['telefono_directora_zona']},
				{$asesora['email_directora_zona']},
				{$asesora['campana_actual']},
				{$asesora['puntos_campana_actual']},
				{$asesora['campana_anterior']},
				{$asesora['puntos_campana_anterior']},
				{$asesora['campana_trasanterior']},
				{$asesora['puntos_campana_trasanterior']},
				{$asesora['estado']},
				{$asesora['numero_creditos']},
				{$asesora['clasificado_por_valor']},
				{$asesora['division']},
				{$asesora['primer_nombre']},
				{$asesora['segundo_nombre']},
				{$asesora['primer_apellido']},
				{$asesora['segundo_apellido']},
				{$asesora['fecha_nacimiento']},
				{$asesora['persona_referencio']},
				{$asesora['departamento']},
				{$asesora['ciudad']},
				{$asesora['direccion']},
				{$asesora['barrio']},
				{$asesora['telefono1']},
				{$asesora['telefono2']},
				{$asesora['telefono3']},
				{$asesora['celular']},
				{$asesora['email']}
				);";
			
			$this->db->query($sql);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}		
	}
	
	
	function insertarRegistroRecordatorioLog($request_id, $recordatorio, $valid, $error, $result, $metodo){
		try {
			
			$id = $this->master->generateUuid();
			$date_entered = date('Y-m-d H:i:s');
			$ip = $this->master->obtenerIp();
			$recordatorio = $this->master->replaceSpaces($recordatorio);
			
			$sql="INSERT INTO `emt_ws_EMXX_osiris_log`(
				`id`,
				`method`,
				`request_id`,
				`date_entered`,
				`request_from`,
				`valid`,
				`error`,
				`result`,
				`send`,
				`date_send`,
				`rec_marca`,
				`rec_campana`, 
				`rec_zona`, 
				`rec_fecha_entrega_pedido`,
				`rec_fecha_facturacion_pedido`,
				`rec_fecha_limite_ingreso_pedido`,
				`rec_fecha_cambios_devoluciones`,
				`rec_lugar_hora_cambios`,
				`rec_fecha_limite_pago_pedido`,
				`rec_fecha_conferencia`,
				`rec_lugar_hora_conferencia`
				)
				VALUES
				('{$id}',
				'{$metodo}',
				'{$request_id}',
				'{$date_entered}',
				'{$ip}',
				'{$valid}',
				'{$error}',
				'{$result}',
				'N',
				NULL,
				{$recordatorio['marca']},
				{$recordatorio['campana']},
				{$recordatorio['zona']},
				{$recordatorio['fecha_entrega_pedido']},
				{$recordatorio['fecha_facturacion_pedido']},
				{$recordatorio['fecha_limite_ingreso_pedido']},
				{$recordatorio['fecha_cambios_devoluciones']},
				{$recordatorio['lugar_hora_cambios']},
				{$recordatorio['fecha_limite_pago_pedido']},
				{$recordatorio['fecha_conferencia']},
				{$recordatorio['lugar_hora_conferencia']}
				);";
			$this->db->query($sql);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());			
		}
	}	

	
	function seleccionarErroresLogAsesoras(){
		try {
			$sql="SELECT
					`nro_documento`,
					`tipo_documento`,
					`marca`,
					`zona`,
					`saldo_pagar`,
					`cupo_valor_factura`,
					`cupo_valor_catalogo`,
					`numero_ultima_factura`,
					`valor_ultima_factura`,
					`campana_ultima_factura`,
					`fecha_vencimiento_factura`,
					`fecha_factura`,
					`numero_doc_ultima_nc`,
					`valor_ultima_nc`,
					`fecha_ultima_nc`,
					`tipo_ultima_nc`,
					`numero_ultima_remision`,
					`numero_doc_ultimo_pago`,
					`valor_ultimo_pago`,
					`fecha_ultimo_pago`,
					`nombre_directora_zona`,
					`telefono_directora_zona`,
					`email_directora_zona`,
					`campana_actual`,
					`puntos_campana_actual`,
					`campana_anterior`,
					`puntos_campana_anterior`,
					`campana_trasanterior`,
					`puntos_campana_trasanterior`,
					`estado`,
					`numero_creditos`,
					`clasificado_por_valor`,
					`division`,
					`primer_nombre`,
					`segundo_nombre`,
					`primer_apellido`,
					`segundo_apellido`,
					`fecha_nacimiento`,
					`persona_referencio`,
					`departamento`,
					`ciudad`,
					`direccion`,
					`barrio`,
					`telefono1`,
					`telefono2`,
					`telefono3`,
					`celular`,
					`email`,
					`request_id`,
					`result`,
					`error`
				FROM
					`emt_ws_EMXX_osiris_log`
				WHERE 
					`valid` = 'N'
					AND send = 'N';";

			$resultado  = $this->db->query($sql);
			return $resultado;
			
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}	
	
	
	function seleccionarErroresLogRecordatorios(){
		try {
				
			$sql="SELECT
					`rec_marca`,
					`rec_campana`,
					`rec_zona`,
					`rec_fecha_entrega_pedido`,
					`rec_fecha_facturacion_pedido`,
					`rec_fecha_limite_ingreso_pedido`,
					`rec_fecha_cambios_devoluciones`,
					`rec_lugar_hora_cambios`,
					`rec_fecha_limite_pago_pedido`,
					`rec_fecha_conferencia`,
					`rec_lugar_hora_conferencia`,
					`request_id`,
					`result`,
					`error`
				FROM
					`emt_ws_EMXX_osiris_log`
				WHERE 
					`valid` = 'N'
					AND send = 'N'
					AND method = 'setRecordatorios';";

			$resultado  = $this->db->query($sql);
			return $resultado;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function actualizarErroresLog($metodo){
		try {
			$sql="UPDATE `emt_ws_EMXX_osiris_log` 
					SET
						`send` = 'S', 
						`date_send` = CURRENT_TIMESTAMP() 
					WHERE
						`method` = '$metodo'
						AND `valid` = 'N'
						AND send = 'N';";
			$resultado  = $this->db->query($sql);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	//------- FIN LOGS --------
	
	
	
	
	
	
	
	//------- REGIÓN CUENTAS --------
	
	
	function validarCuentaExistente($marca, $nro_documento){
		try {
			
			$sql="SELECT id as id_cuenta
				FROM `accounts_cstm`
				JOIN `accounts` ON id = id_c
				WHERE `emt_maestro_marcas_id_c` = '{$marca}'
				AND `numero_documento_c` = '{$nro_documento}'
				AND `deleted` = 0;";
			
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id_cuenta'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();
		}
	}
	
	
	function obtenerMarca($marca){
		try {
		
			$sql = "SELECT id_c, name
			FROM emt_maestro_marcas JOIN emt_maestro_marcas_cstm ON id = id_c
			WHERE codigo_linea_directa_c = '{$marca}'
			AND deleted = 0;";
			
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();			
		}
	}

	
	function obtenerZona($zona){
		try {
	
			$sql = "SELECT id, name
			FROM emt_maestro_zonas
			WHERE codigo_zona = '{$zona}'
			AND deleted = 0;";
				
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function obtenerDepartamento($depto){
		try {
	
			$sql = "SELECT id, name
			FROM ing_departamento
			WHERE emt_dane = '{$depto}'
			AND deleted = 0;";

			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function obtenerCiudad($ciudad){
		try {
	
			$sql = "SELECT id, name
			FROM ing_municipio
			WHERE emt_dane = '{$ciudad}'
			AND deleted = 0;";

			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function obtenerPersonaReferencio($persona_referencio){
		try {
		
			$sql = "SELECT id_c 
					FROM `accounts`
					JOIN `accounts_cstm` on id = id_c
					WHERE `numero_documento_c` = '{$persona_referencio}'
					AND deleted = 0;";
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id_c'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();			
		}
	}
		
	
	function registrarAsesora($asesora){
		try {
			$marca = $this->obtenerMarca($asesora['marca']);
			$nro_documento = $asesora['nro_documento'];
			$id_cuenta = $this->validarCuentaExistente($marca['id_c'], $nro_documento);
			$resultados = array();
			
			if($id_cuenta != '' && $id_cuenta != NULL){
				$this->actualizarCuenta($asesora, $id_cuenta);
				$resultados['accion']='Actualizado';
				$resultados['id_cuenta']=$id_cuenta;
			}else{
				$resultados['accion']='Insertado';
				$resultados['id_cuenta'] = $this->insertarCuenta($asesora);
			}
			return $resultados;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}

	
	function insertarCuenta($asesora){
		try {

			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			
			$name = '';
			if (!$asesora['primer_nombre']=='') $name .= $asesora['primer_nombre'];
			if (!$asesora['segundo_nombre']=='') $name .= ' '.$asesora['segundo_nombre'];
			if (!$asesora['primer_apellido']=='') $name .= ' '.$asesora['primer_apellido'];
			if (!$asesora['segundo_apellido']=='') $name .= ' '.$asesora['segundo_apellido'];
			
			$division = substr($asesora['division'], -1);
			$marca = $this->obtenerMarca($asesora['marca']);
			$id_marca = $marca['id_c'];			
			$persona_referencio = $this->obtenerPersonaReferencio($asesora['persona_referencio']);
			$zona = $this->obtenerZona($asesora['zona']);
			//$id_cuenta = $marca['name'].'_'.$asesora['nro_documento'];
			$id_cuenta = $this->master->generateUuid();
			
			$asesora = $this->master->replaceSpaces($asesora);
			
			$sql="INSERT INTO `accounts`(
				`id`,
				`name`,
				`date_entered`,
				`date_modified`,
				`modified_user_id`,
				`created_by`,
				`deleted`
				)
				VALUES(
				'{$id_cuenta}',
				'{$name}',
				'{$date_entered}',
				'{$date_entered}',
				'1',
				'1',
				'0');";
			$this->db->query($sql);
			
			$sql="INSERT INTO `accounts_cstm`(
				`id_c`,
				`jjwg_maps_address_c`,
				`origen_cuenta_c`,
				`barrio_c`,
				`numero_documento_c`,
				`tipo_documento_c`,
				`emt_maestro_marcas_id_c`,
				`emt_maestro_zonas_id_c`,
				`directora_zona_c`,
				`telefono_directora_zona_c`,
				`email_directora_zona_c`,
				`estado_c`,
				`numero_creditos_c`,
				`clasificacion_valor_c`,
				`division_c`,
				`primer_nombre_c`,
				`segundo_nombre_c`,
				`primer_apellido_c`,
				`segundo_apellido_c`,
				`fecha_nacimiento_c`,
				`account_id_c`,
				`ing_departamento_id_c`,
				`ing_municipio_id_c`,
				`telefono1_c`,
				`telefono2_c`,
				`telefono3_c`,
				`celular_c`
				)VALUES(
				'{$id_cuenta}',
				{$asesora['direccion']},
				'Línea Directa',
				{$asesora['barrio']},
				{$asesora['nro_documento']},
				{$asesora['tipo_documento']},
				'{$id_marca}',
				'{$zona}',
				{$asesora['nombre_directora_zona']},
				{$asesora['telefono_directora_zona']},
				{$asesora['email_directora_zona']},
				{$asesora['estado']},
				{$asesora['numero_creditos']},
				{$asesora['clasificado_por_valor']},
				'{$division}',
				{$asesora['primer_nombre']},
				{$asesora['segundo_nombre']},
				{$asesora['primer_apellido']},
				{$asesora['segundo_apellido']},
				{$asesora['fecha_nacimiento']},
				'{$persona_referencio}',
				{$asesora['departamento']},
				{$asesora['ciudad']},
				{$asesora['telefono1']},
				{$asesora['telefono2']},
				{$asesora['telefono3']},
				{$asesora['celular']});";
			
			$this->db->query($sql);
			return $id_cuenta;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function actualizarCuenta($asesora, $id_cuenta){
		try {

			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
		
			$name = '';
			if (!$asesora['primer_nombre']=='') $name .= $asesora['primer_nombre'];
			if (!$asesora['segundo_nombre']=='') $name .= ' '.$asesora['segundo_nombre'];
			if (!$asesora['primer_apellido']=='') $name .= ' '.$asesora['primer_apellido'];
			if (!$asesora['segundo_apellido']=='') $name .= ' '.$asesora['segundo_apellido'];
			
			$division = substr($asesora['division'], -1);
			$marca = $this->obtenerMarca($asesora['marca']);
			$id_marca = $marca['id_c'];
			$persona_referencio = $this->obtenerPersonaReferencio($asesora['persona_referencio']);
			$zona = $this->obtenerZona($asesora['zona']);
			//$id_cuenta = $marca['name'].'_'.$asesora['nro_documento'];

			$asesora = $this->master->replaceSpaces($asesora);
			
			$sql="UPDATE accounts a
				JOIN accounts_cstm ac ON a.id = ac.id_c
				SET
					a.`name` = '{$name}',
					a.`date_modified` = '{$date_entered}',
					a.`modified_user_id` = '1',
					ac.`jjwg_maps_address_c` = {$asesora['direccion']},
					ac.`origen_cuenta_c` = 'Línea Directa',
					ac.`barrio_c` = {$asesora['barrio']},
					ac.`numero_documento_c` = {$asesora['nro_documento']},
					ac.`tipo_documento_c` = {$asesora['tipo_documento']},
					ac.`emt_maestro_marcas_id_c` = '{$id_marca}',
					ac.`emt_maestro_zonas_id_c` = '{$zona}',
					ac.`directora_zona_c` = {$asesora['nombre_directora_zona']},
					ac.`telefono_directora_zona_c` = {$asesora['telefono_directora_zona']},
					ac.`email_directora_zona_c` = {$asesora['email_directora_zona']},
					ac.`estado_c` = {$asesora['estado']},
					ac.`numero_creditos_c` = {$asesora['numero_creditos']},
					ac.`clasificacion_valor_c` = {$asesora['clasificado_por_valor']},
					ac.`division_c` = '{$division}',
					ac.`primer_nombre_c` = {$asesora['primer_nombre']},
					ac.`segundo_nombre_c` = {$asesora['segundo_nombre']},
					ac.`primer_apellido_c` = {$asesora['primer_apellido']},
					ac.`segundo_apellido_c` = {$asesora['segundo_apellido']},
					ac.`fecha_nacimiento_c` = {$asesora['fecha_nacimiento']},
					ac.`account_id_c` = '{$persona_referencio}',
					ac.`ing_departamento_id_c` = {$asesora['departamento']},
					ac.`ing_municipio_id_c` = {$asesora['ciudad']},
					ac.`telefono1_c` = {$asesora['telefono1']},
					ac.`telefono2_c` = {$asesora['telefono2']},
					ac.`telefono3_c` = {$asesora['telefono3']},
					ac.`celular_c` = {$asesora['celular']}
				WHERE a.id = '{$id_cuenta}';";
			$this->db->query($sql);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}

	
	}
	

	//------- FIN CUENTAS --------	
	
	
	
	
		

	
	
	
	


	//------- REGIÓN EMAILS --------
	
	
	function validarEmailExistente($id_cuenta){
		try {
				
			$sql="SELECT ea.id as id_email
			FROM `email_addresses` ea JOIN email_addr_bean_rel ear on ea.id = ear.email_address_id 
			WHERE ear.bean_id = '{$id_cuenta}'
			AND ea.deleted = 0
			AND ea.invalid_email = 0;";
				
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id_email'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();
		}
	}
	

	function registrarEmail($email, $id_cuenta){
		try {
	
			$id_email = $this->validarEmailExistente($id_cuenta);
	
			if($id_email != '' && $id_email != NULL){
				$this->actualizarEmail($email, $id_email);
			}else{
				$this->insertarEmail($email, $id_cuenta);
			}
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function insertarEmail($email, $id_cuenta){
		try {
	
			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$id_email = $this->master->generateUuid();
			$id_relacion = $this->master->generateUuid();
			$email_caps = strtoupper($email);
							
			$sql="INSERT INTO `email_addresses` 
			(`id`,
			`email_address`, 
			`email_address_caps`, 
			`invalid_email`, 
			`opt_out`, 
			`date_created`, 
			`date_modified`, 
			`deleted`
			)
			VALUES
			('{$id_email}', 
			'{$email}', 
			'{$email_caps}', 
			0, 
			0, 
			'{$date_entered}', 
			'{$date_entered}', 
			0
			);";
			$this->db->query($sql);
	
			$sql="INSERT INTO `email_addr_bean_rel` 
			(`id`, 
			`email_address_id`, 
			`bean_id`, 
			`bean_module`, 
			`primary_address`, 
			`reply_to_address`, 
			`date_created`, 
			`date_modified`, 
			`deleted`
			)
			VALUES
			('$id_relacion', 
			'$id_email', 
			'$id_cuenta', 
			'Accounts', 
			1, 
			0, 
			'{$date_entered}', 
			'{$date_entered}', 
			0
			);";
			$this->db->query($sql);
		} catch (Exception $e) {
		$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
		}
	
	
	function actualizarEmail($email, $id_email){
		try {
			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$email_caps = strtoupper($email);
			$sql = "UPDATE `email_addresses`
					SET
						`email_address` = '{$email}',
						`email_address_caps` = '{$email_caps}',
						`date_modified` = '{$date_entered}'
					WHERE
					`id` = '{$id_email}';";
		
			$this->db->query($sql);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}


		//------- FIN EMAILS --------




	
	
	
	
	
	
	
	
	
	
	//------- REGIÓN ESTADO CUENTAS --------	
	
	
	function validarEstadoCuentaExistente($id_cuenta){
		try {
				
			$sql="SELECT ec.id AS id_estado_cuentas
					FROM `emt_estado_cuenta` ec 
					JOIN `accounts_emt_estado_cuenta_1_c` aec ON ec.id = aec.`accounts_emt_estado_cuenta_1emt_estado_cuenta_idb`
					JOIN accounts_cstm ac ON aec.`accounts_emt_estado_cuenta_1accounts_ida` = ac.id_c
					JOIN accounts a ON ac.id_c = a.id
					WHERE ac.`id_c` = '{$id_cuenta}'
					AND ec.deleted = 0
					AND a.deleted = 0;";

			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id_estado_cuentas'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();
		}
	}
	
	
	function registrarEstadoCuenta($asesora, $id_cuenta){
		try {

			$estado_cuenta = $this->validarEstadoCuentaExistente($id_cuenta);
				
			if($estado_cuenta != '' && $estado_cuenta != NULL){
				$this->actualizarEstadoCuenta($asesora, $estado_cuenta);
			}else{
				$this->insertarEstadoCuenta($asesora, $id_cuenta);
			}
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function insertarEstadoCuenta($asesora, $id_cuenta){
		try {

			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$id_estado_cuenta = $this->master->generateUuid();
			$id_relacion = $this->master->generateUuid();
			$asesora = $this->master->replaceSpaces($asesora);
			
			$sql="INSERT INTO `emt_estado_cuenta` 
				(`id`,
				`name`, 
				`date_entered`, 
				`date_modified`, 
				`modified_user_id`, 
				`created_by`,
				`description`, 
				`deleted`,
				`assigned_user_id`, 
				`saldo_pagar`,
				`currency_id`, 
				`cupo_valor_factura`, 
				`cupo_valor_catalogo`, 
				`numero_ultima_factura`, 
				`valor_ultima_factura`,
				`fecha_vencimiento_factura`, 
				`fecha_factura`,
				`numero_doc_ultima_nc`, 
				`valor_ultima_nc`,
				`fecha_ultima_nc`, 
				`tipo_ultima_nc`,
				`numero_ultima_remision`, 
				`numero_doc_ultimo_pago`, 
				`valor_ultimo_pago`,
				`fecha_ultimo_pago`, 
				`campana_ultima_factura`
				)
				VALUES(
				'{$id_estado_cuenta}',
				NULL,
				'{$date_entered}',
				'{$date_entered}',
				'1',
				'1',
				NULL,
				'0',
				NULL,
				{$asesora['saldo_pagar']},
				NULL,
				{$asesora['cupo_valor_factura']},
				{$asesora['cupo_valor_catalogo']},
				{$asesora['numero_ultima_factura']},
				{$asesora['valor_ultima_factura']},
				{$asesora['fecha_vencimiento_factura']},
				{$asesora['fecha_factura']},
				{$asesora['numero_doc_ultima_nc']},
				{$asesora['valor_ultima_nc']},
				{$asesora['fecha_ultima_nc']},
				{$asesora['tipo_ultima_nc']},
				{$asesora['numero_ultima_remision']}, 
				{$asesora['numero_doc_ultimo_pago']}, 
				{$asesora['valor_ultimo_pago']},
				{$asesora['fecha_ultimo_pago']},
				{$asesora['campana_ultima_factura']}
				);";
			$this->db->query($sql);

			
			$sql="INSERT INTO `accounts_emt_estado_cuenta_1_c`
					(`id`,
					`date_modified`,
					`deleted`,
					`accounts_emt_estado_cuenta_1accounts_ida`,
					`accounts_emt_estado_cuenta_1emt_estado_cuenta_idb`
					)
					VALUES
					('{$id_relacion}',
					'{$date_entered}',
					'0',
					'{$id_cuenta}',
					'{$id_estado_cuenta}'
					);";
			$this->db->query($sql);				
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	} 
	
	
	function actualizarEstadoCuenta($asesora, $id_estado_cuenta){
		try {

			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$asesora = $this->master->replaceSpaces($asesora);
			
			$sql = "UPDATE `emt_estado_cuenta`
					SET
						`date_modified` = '{$date_entered}',
						`saldo_pagar` = {$asesora['saldo_pagar']},
						`cupo_valor_factura` = {$asesora['cupo_valor_factura']},
						`cupo_valor_catalogo` = {$asesora['cupo_valor_catalogo']},
						`numero_ultima_factura` = {$asesora['numero_ultima_factura']},
						`valor_ultima_factura` = {$asesora['valor_ultima_factura']},
						`fecha_vencimiento_factura` = {$asesora['fecha_vencimiento_factura']}, 
						`fecha_factura` = {$asesora['fecha_factura']}, 
						`numero_doc_ultima_nc` = {$asesora['numero_doc_ultima_nc']},
						`valor_ultima_nc` = {$asesora['valor_ultima_nc']},
						`fecha_ultima_nc` = {$asesora['fecha_ultima_nc']}, 
						`tipo_ultima_nc` = {$asesora['tipo_ultima_nc']},
						`numero_ultima_remision` = {$asesora['numero_ultima_remision']},
						`numero_doc_ultimo_pago` = {$asesora['numero_doc_ultimo_pago']},
						`valor_ultimo_pago` = {$asesora['valor_ultimo_pago']},
						`fecha_ultimo_pago` = {$asesora['fecha_ultimo_pago']}, 
						`campana_ultima_factura` = {$asesora['campana_ultima_factura']}
					WHERE
						`id` = '{$id_estado_cuenta}';";
			
			$this->db->query($sql);
			
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}


	//------- FIN ESTADO CUENTAS --------
	
	
	
	
		
	
	
	
	
	
	
	//------- REGIÓN PUNTOS --------
	

	function validarPuntosExistente($id_cuenta){
		try {
	
			$sql="SELECT p.id AS id_puntos
					FROM  `emt_puntos` p
					JOIN `accounts_emt_puntos_1_c` ap ON p.id = ap.`accounts_emt_puntos_1emt_puntos_idb`
					JOIN accounts_cstm ac ON ap.`accounts_emt_puntos_1accounts_ida` = ac.id_c
					JOIN accounts a ON ac.id_c = a.id
					WHERE ac.`id_c` = '{$id_cuenta}'
					AND p.deleted = 0
					AND a.deleted = 0;";
	
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id_puntos'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();
		}
	}
	
	
	function registrarPuntos($asesora, $id_cuenta){
		try {
	
			$puntos = $this->validarPuntosExistente($id_cuenta);
	
			if($puntos != '' && $puntos != NULL){
				$this->actualizarPuntos($asesora, $puntos);
			}else{
				$this->insertarPuntos($asesora, $id_cuenta);
			}
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function insertarPuntos($asesora, $id_cuenta){
		try {
	
			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$id_puntos = $this->master->generateUuid();
			$id_relacion = $this->master->generateUuid();
			$asesora = $this->master->replaceSpaces($asesora);
			
			$sql="INSERT INTO `emt_puntos` 
				(`id`, 
				`name`, 
				`date_entered`, 
				`date_modified`, 
				`modified_user_id`, 
				`created_by`, 
				`description`, 
				`deleted`, 
				`assigned_user_id`, 
				`campana_actual`, 
				`puntos_campana_actual`, 
				`campana_anterior`, 
				`puntos_campana_anterior`, 
				`campana_tras_anterior`, 
				`puntos_campana_tras_anterior`
				)
				VALUES
				('{$id_puntos}', 
				NULL, 
				'{$date_entered}', 
				'{$date_entered}', 
				'1', 
				'1', 
				NULL, 
				'0', 
				NULL, 
				{$asesora['campana_actual']}, 
				{$asesora['puntos_campana_actual']}, 
				{$asesora['campana_anterior']}, 
				{$asesora['puntos_campana_anterior']}, 
				{$asesora['campana_trasanterior']}, 
				{$asesora['puntos_campana_trasanterior']}
				);";
			$this->db->query($sql);

			
			$sql="INSERT INTO `accounts_emt_puntos_1_c`
			(`id`,
			`date_modified`,
			`deleted`,
			`accounts_emt_puntos_1accounts_ida`,
			`accounts_emt_puntos_1emt_puntos_idb`
			)
			VALUES
			('{$id_relacion}',
			'{$date_entered}',
			'0',
			'{$id_cuenta}',
			'{$id_puntos}'
			);";
			
			$this->db->query($sql);
			
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function actualizarPuntos($asesora, $id_puntos){
		try {
			
			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$asesora = $this->master->replaceSpaces($asesora);
			
			$sql = "UPDATE `emt_puntos` 
					SET
						`date_modified` = '{$date_entered}', 
						`campana_actual` = {$asesora['campana_actual']}, 
						`puntos_campana_actual` = {$asesora['puntos_campana_actual']}, 
						`campana_anterior` = {$asesora['campana_anterior']}, 
						`puntos_campana_anterior` = {$asesora['puntos_campana_anterior']}, 
						`campana_tras_anterior` = {$asesora['campana_trasanterior']}, 
						`puntos_campana_tras_anterior` = {$asesora['puntos_campana_trasanterior']}
					WHERE
					`id` = '{$id_puntos}';";
		
			$this->db->query($sql);
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	
	//------- FIN PUNTOS --------
	
	
	
	
	
	
	
	
	
	
	
	//------- REGIÓN RECORDATORIOS --------
	
	
	
	function validarRecordatorioExistente($campana, $marca, $zona){
		try {
			$sql="SELECT r.id AS id_recordatorio
					FROM `emt_recordatorios` as r
					WHERE`campana` = '{$campana}'
					AND `emt_maestro_marcas_id_c` = '{$marca}'
					AND `emt_maestro_zonas_id_c` = '{$zona}'
					AND `deleted` = 0;";
			$exec = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado['id_recordatorio'];
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			exit();
		}
	}
	
	
	function registrarRecordatorio($recordatorio){
		try {
			$marca = $this->obtenerMarca($recordatorio['marca']);
			$id_marca = $marca['id_c'];
			$zona = $this->obtenerZona($recordatorio['zona']);
			$id_recordatorio = $this->validarRecordatorioExistente($recordatorio['campana'], $id_marca, $zona);
 
			if($id_recordatorio != '' && $id_recordatorio != NULL){
				$this->actualizarRecordatorio($recordatorio, $id_recordatorio, $id_marca, $zona);
				return 'Actualizado';
			}else{
				$this->insertarRecordatorio($recordatorio, $id_marca, $zona);
				return 'Insertado';
			}
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function insertarRecordatorio($recordatorio, $marca, $zona){
		try {
	
			$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
			$id_recordatorio = $this->master->generateUuid();
			$recordatorio = $this->master->replaceSpaces($recordatorio);
			
			$sql="INSERT INTO `emt_recordatorios`
				(`id`, 
				`name`, 
				`date_entered`, 
				`date_modified`, 
				`modified_user_id`, 
				`created_by`, 
				`description`, 
				`deleted`, 
				`assigned_user_id`, 
				`campana`, 
				`emt_maestro_marcas_id_c`, 
				`fecha_entrega_pedido`, 
				`fecha_facturacion_pedido`, 
				`fecha_cambios_devoluciones`, 
				`lugar_hora_cambios`, 
				`fecha_limite_ingreso_pedido`, 
				`fecha_limite_pago_pedido`, 
				`fecha_conferencia`, 
				`lugar_hora_conferencia`,
				`emt_maestro_zonas_id_c`
				)
				VALUES
				('{$id_recordatorio}', 
				NULL, 
				'{$date_entered}', 
				'{$date_entered}', 
				'1', 
				'1', 
				NULL, 
				'0', 
				NULL, 
				{$recordatorio['campana']}, 
				'{$marca}', 
				{$recordatorio['fecha_entrega_pedido']},
 				{$recordatorio['fecha_facturacion_pedido']},
 				{$recordatorio['fecha_cambios_devoluciones']}, 
				{$recordatorio['lugar_hora_cambios']},
 				{$recordatorio['fecha_limite_ingreso_pedido']},
 				{$recordatorio['fecha_limite_pago_pedido']}, 								 
 				{$recordatorio['fecha_conferencia']}, 
				{$recordatorio['lugar_hora_conferencia']},
				'{$zona}'
				);";

			$this->db->query($sql);
			} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function actualizarRecordatorio($recordatorio, $id_recordatorio, $marca, $zona){
		try {
				$date_entered = date('Y-m-d H:i:s', (strtotime ("+5 Hours")));
				$recordatorio = $this->master->replaceSpaces($recordatorio);
				$sql = "UPDATE `emt_recordatorios`
						SET
							`date_modified` = '{$date_entered}', 
							`campana` = {$recordatorio['campana']}, 
							`emt_maestro_marcas_id_c` = '{$marca}', 
							`emt_maestro_zonas_id_c` = '{$zona}', 
							`fecha_entrega_pedido` = {$recordatorio['fecha_entrega_pedido']}, 
							`fecha_facturacion_pedido` = {$recordatorio['fecha_facturacion_pedido']}, 
							`fecha_cambios_devoluciones` = {$recordatorio['fecha_cambios_devoluciones']}, 
							`lugar_hora_cambios` = {$recordatorio['lugar_hora_cambios']}, 
							`fecha_limite_ingreso_pedido` = {$recordatorio['fecha_limite_ingreso_pedido']}, 
							`fecha_limite_pago_pedido` = {$recordatorio['fecha_limite_pago_pedido']}, 
							`fecha_conferencia` = {$recordatorio['fecha_conferencia']}, 
							`lugar_hora_conferencia` = {$recordatorio['lugar_hora_conferencia']}
						WHERE
						`id` = '{$id_recordatorio}';";

				$this->db->query($sql);
			} catch (Exception $e) {
				$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
			}
	}
	

	
	//------- FIN RECORDATORIOS --------
	
	
	
	
	
	
		
	
	
	
	//------- REGIÓN PRECARGA --------	
	
	
	function seleccionarCarga($limit_ini, $limit_fin){
		try {
			$sql="SELECT *
				FROM
					`emt_ws_EMXX_osiris_carga_carmel`
				WHERE
					consecutivo BETWEEN {$limit_ini} AND {$limit_fin}";
			$exec  = $this->db->query($sql);
			$resultado = $exec->fetchAll();
			return $resultado;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}
	
	
	function contarRegistrosCarga(){
		try {
			$sql="SELECT COUNT(1) totalRegistros
				FROM
				emt_ws_EMXX_osiris_carga_carmel";
			$exec  = $this->db->query($sql);
			$resultado = $exec->fetch();
			return $resultado;
		} catch (Exception $e) {
			$this->log->writeLog($e->getMessage().' in '.$e->getFile().':'.$e->getLine());
		}
	}


}// Fin Class
	

?>