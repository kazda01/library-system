<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=' . env("DB_HOST") . ';dbname=' . env("DB_TEST_NAME");

return $db;
