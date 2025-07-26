<?php

namespace k1app\core\config;

use k1lib\app\config;
use k1lib\sql\local_cache;
use k1lib\sql\profiler;

class general
        extends config
{

    public function __construct()
    {
        /*
         *  NAME AND DESCRIPTION
         */
        $this->add_option('app_version', 'v2.0 RC1');
        $this->add_option('app_name', 'K1 APP SKELETON');
        $this->add_option('app_description', 'Demo app to start new projects');
        $this->add_option('app_keywords', 'framework, php, web, develpment');
        $this->add_option('app_copyright',
                '© 2013-2024 Dev by <a href="https://github.com/j0hnd03" class="klan1-site-link" target="_blank">J0hnD03</a>');
        $this->add_option('app_verbose', true);
        $this->add_option('app_verbose_level', 5);
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

        $this->add_option('timezone', 'America/Bogota');

        $this->add_option('google_tag', null);

        //MD5 ("k1 app demo") = ffb07e0d73382f34ffdd99567c39921c
        $this->add_option('magic_value', 'e8fccf89902acac95121563eJ9e99b197');

        /**
         * SQL PROFILER ENABLE
         */
        profiler::enable();
        /**
         * SQL LOCAL CACHE ENABLE
         */
        local_cache::enable();

        /*
         * SESSION CONFIG
         */
        $this->add_option('app_session_name', 'K1APP_SESSION_DEMO');
        $this->add_option('app_session_use_ip_in_userhash', false);
        $this->add_option('app_session_levels',
                [
            'god',
            'admin',
            'user',
            'guest',
        ]);
        /**
         * URL REWRITING ALLOW CALLS
         */
        $this->add_option('app_controllers_allowed_paths',
                [
            '/controllers/',
            '/core/tools/',
        ]);

        \k1lib\html\html_document::set_use_log(TRUE);

        /*
         * DB OBJECT SETTINGS
         */
        $this->add_option('db_name', 'k1appdemo');
        $this->add_option('db_user', 'k1appdemo');
        $this->add_option('db_password', 'k1appdemo');
        $this->add_option('db_host', 'localhost');
        $this->add_option('db_port', '3306');
        $this->add_option('db_type', 'mysql');
    }
}
