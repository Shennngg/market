<?php

  $host = 'localhost';
  $user = 'root';
  $password  = '';
  $db  = 'supermarket';

  $conn = new mysqli($host, $user, $password, $db);

  if (!$db){
    die("Connection Failed: ".mysqli_connect_error());
  }

?>                                                              