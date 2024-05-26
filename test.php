
<?php
 echo("ciao".$_SERVER['PHP_AUTH_USER']);

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
} else {
	$user = $_SERVER['PHP_AUTH_USER'];
	$pwd = $_SERVER['PHP_AUTH_PW'];
	
	var_dump($user);
	var_dump($pwd);
}

?>