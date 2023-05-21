<?php 

include 'logger.php';

$log= new logguer();

$log->error_log_directory = 'Logs/';
$log->error_log_name = 'error.log';
$log->error_log_size = 1; // Valor en Mb
$log->error_log_count = '5';
$log->error_log_app = 'ws-osiris-EMXX';

echo $log->writeLog('prueba');


?>