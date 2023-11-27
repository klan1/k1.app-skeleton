<?php

namespace k1lib;

const K1LIB_INC_MODE = 0;

namespace k1app;

if (!defined("\k1app\IN_K1APP")) {
    die("hacking attemp '^_^ " . __FILE__);
}

date_default_timezone_set("America/Bogota");

/*
 *  NAME AND DESCRIPTION
 */

const K1APP_TITLE = "K1 APP SKELETON";
const K1APP_DESCRIPTION = "Demo app to start new projects";
const K1APP_KEYWORKS = "";
const K1APP_VERBOSE = 1;

const K1APP_SESSION_NAME = 'K1APP-DEMO-SESSION';


/**
 * SET a CUSTOM K1MAGIC for K1.lib
 */
// # md5 -s "k1 app demo"
//MD5 ("k1 app demo") = ffb07e0d73382f34ffdd99567c39921c
\k1lib\K1MAGIC::set_value("e8fccf89902acac95121563eJ9e99b197");

/**
 * URL REWRITE ENABLE
 */
\k1lib\urlrewrite\url::enable();

/**
 * TEMPLATE AND OUTPUT BUFFER SYSTEM ENABLE
 */
\k1lib\templates\temply::enable(\k1app\APP_MODE);

/*
 * SESSION CONFIG
 */
\k1lib\session\session_plain::enable();
\k1lib\session\session_plain::set_session_name(K1APP_SESSION_NAME);
\k1lib\session\session_plain::set_use_ip_in_userhash(FALSE);
\k1lib\session\session_plain::set_app_user_levels([
    'god',
    'admin',
    'admin-coordinador',
    'lider',
    'digitador',
    'estadisticas',
    'consulta',
    'guest'
]);

/**
 * SQL PROFILER ENABLE
 */
\k1lib\sql\profiler::enable();
/**
 * SQL LOCAL CACHE ENABLE
 */
\k1lib\sql\local_cache::enable();

/**
 * FILE UPLOADS ENABLE
 */
\k1lib\forms\file_uploads::enable(APP_UPLOADS_PATH, APP_UPLOADS_URL);
//\k1lib\forms\file_uploads::set_overwrite_existent(FALSE);
/**
 * TEMPLATE CONFIG
 */
\k1lib\html\template::enable(APP_TEMPLATE_PATH);

/*
 * OTHERS
 */
\k1lib\html\html::set_use_log(FALSE);

//ini_set('memory_limit', '100M');
//ROUND numbers on all html foundation tables
\k1lib\html\foundation\table_from_data::$float_round_default = 1;
