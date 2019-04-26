<?php
/**
 * Purpose: Removable insert to insert phpCAS header's into files.
 */
// Load the settings from the central config file
// header('Content-Type: application/json');
require_once 'config.example.php';
require_once $phpcas_path . '/CAS.php';
require_once 'facultyConfigs.php';
if (! phpCAS::isAuthenticated ()) {
	phpCAS::setDebug ();
	phpCAS::setVerbose ( true );
	phpCAS::client ( CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context );
	phpCAS::setCasServerCACert ( $cas_server_ca_cert_path );
	
	phpCAS::forceAuthentication ();
}
?>