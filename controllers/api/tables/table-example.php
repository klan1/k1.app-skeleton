<?php

namespace k1app;

require 'db-connection-1.php';

$crud_api_obj = new api\auth\api_crud(TRUE,TRUE);
$crud_api_obj->set_db($db);
$crud_api_obj->set_db_table_name('table_example');
$crud_api_obj->set_db_table_keys_fields(['id','user_login']);
$crud_api_obj->exec();
