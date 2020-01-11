<?php
session_start();
if(!isset($_SESSION["user"]) && ($_SESSION["user_id"] > 0)) header("Location: login.php");