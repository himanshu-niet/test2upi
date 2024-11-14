<?php
require_once("components/session.components.php");
session_destroy();	
header("location: index");
exit();
?>