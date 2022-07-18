<?php

// phpinfo();
// exit();

// $serverName = "REPORTING"; //serverName
// $connectionInfo = array( "Database"=>"TEST_DAWSON2", "UID"=>"sa", "PWD"=>"vyn.ccs");
// $conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( !$conn ) {
//     echo "Connection could not be established.<br />";
//     die( print_r( sqlsrv_errors(), true));
// }
use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
