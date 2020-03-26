<?php
    
  function connect () {
    $host = "comp-1006.cq2sofwg3vlf.us-east-1.rds.amazonaws.com";
    $user = "everyone";
    $pass = "g0t0BJ4mmin";
    $db = "labs";
    
    // Create the connection
    $conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);

    return $conn;
  }