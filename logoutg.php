<?php
session_start();
include("config/google_config.php");
unset($_SESSION['token']);
unset($_SESSION['userData']);

// Reset OAuth access token
$gClient->revokeToken();

// Destroy entire session data
session_destroy();

// Redirect to homepage
header('Location: index.php');
