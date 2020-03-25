<?php

session_start(); // Start the session

session_unset(); //unset the session

session_destroy(); //destroy th esession

header('location:login.php');

exit();






?>