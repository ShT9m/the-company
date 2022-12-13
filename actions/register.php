<?php
include "../classes/User.php";

// create or instantiate User object
$user = new User;

// Call store method of object user
$user->store($_POST);

?>