<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'jonathan123');
define('DBNAME', 'locaparking2');

$conexao = mysqli_connect(HOST, USER, PASS, DBNAME) or die('Não foi possível conectar');

?>