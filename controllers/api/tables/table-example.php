<?php

namespace k1app;

require 'db-connection-1.php';

$crud_obj = new \k1lib\api\crud(TRUE,TRUE);
$crud_obj->set_db($db);
$crud_obj->set_db_table_name('table_example');
$crud_obj->set_db_table_keys_fields(['id','user_login']);
$crud_obj->exec();
