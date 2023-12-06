<?php

namespace k1app;

date_default_timezone_set("America/Bogota");

/*
 *  NAME AND DESCRIPTION
 */

const K1APP_TITLE = "K1 APP SKELETON";
const K1APP_DESCRIPTION = "Demo app to start new projects";
const K1APP_KEYWORKS = "";
const K1APP_COPYRIGHT = '© 2013-2023 DEV BY <a href="https://github.com/j0hnd03" class="klan1-site-link" target="_blank">J0hnD03</a>';
const K1APP_VERBOSE = 1;
const K1APP_SESSION_NAME = 'K1APP-DEMO-SESSION';
const GOOGLE_TAG = NULL;
const K1APP_TEMPLATE_PATH = APP_TEMPLATES_PATH . '/k1phphtml/';
const K1APP_TEMPLATE_URL = APP_TEMPLATES_URL . '/k1phphtml/';

/**
 * SET a CUSTOM K1MAGIC for K1.lib
 */
// # md5 -s "k1 app demo"
//MD5 ("k1 app demo") = ffb07e0d73382f34ffdd99567c39921c
\k1lib\K1MAGIC::set_value("e8fccf89902acac95121563eJ9e99b197");

/**
 * SQL PROFILER ENABLE
 */
\k1lib\sql\profiler::enable();
/**
 * SQL LOCAL CACHE ENABLE
 */
\k1lib\sql\local_cache::enable();

if (K1APP_MODE == K1APP_MODE_WEB || K1APP_MODE == K1APP_MODE_API) {
    /**
     * URL REWRITE ENABLE
     */
    \k1lib\urlrewrite\url::enable();

    /*
     * SESSION CONFIG
     */
    \k1lib\session\session_plain::enable();
    \k1lib\session\session_plain::set_session_name(K1APP_SESSION_NAME);
    \k1lib\session\session_plain::set_use_ip_in_userhash(FALSE);
    \k1lib\session\session_plain::set_app_user_levels([
        'god',
        'admin',
        'user',
        'guest'
    ]);

    /**
     * FILE UPLOADS ENABLE
     */
    \k1lib\forms\file_uploads::enable(APP_UPLOADS_PATH, APP_UPLOADS_URL);
//\k1lib\forms\file_uploads::set_overwrite_existent(FALSE);
    /**
     * TEMPLATE CONFIG
     */
    \k1lib\html\template::enable(K1APP_TEMPLATE_PATH);

    //ROUND numbers on all html foundation tables
    \k1lib\html\foundation\table_from_data::$float_round_default = 1;
    /*
     * OTHERS
     */
    \k1lib\html\html::set_use_log(FALSE);

//ini_set('memory_limit', '100M');
//ROUND numbers on all html foundation tables
    \k1lib\html\foundation\table_from_data::$float_round_default = 1;
}

//ini_set('memory_limit', '100M');
