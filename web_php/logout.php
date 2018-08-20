<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['share']);
header("refresh:0;url=login.html");
