<?php

namespace k1app;

/*
 * DB OBJECT CONNECTION
 */
try {
    /**
     * @var \k1lib\db\PDO_k1 
     */
    $db = new \k1lib\db\PDO_k1("k1app-demo", 'k1appdemo', '=K1.app.changeme', "70.38.14.6", "3306", "mysql", TRUE);
    $db->set_verbose_level(APP_VERBOSE);
} catch (\PDOException $e) {
    trigger_error($e->getMessage(), E_USER_ERROR);
}
$db->exec("set names utf8");
