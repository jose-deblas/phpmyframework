<?php
// framework/index.php
$name = $_GET['name'] ?? 'World';

printf('Hello %s', $name);