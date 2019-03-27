<?php

//need to start the session to END it
session_start();

//deletes values inside all the session variables
session_unset();

//destroy sessions running
session_destroy();

header("Location: ../index.php");