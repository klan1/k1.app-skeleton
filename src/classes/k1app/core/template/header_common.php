<?php

namespace k1app\core\template;

use k1app\core\config\general;
use k1app\template\mazer\redefinitions\head;
use const k1lib\VERSION;

trait header_common {

    protected general $app_settings;

    public function load_app_config() {
        $this->app_settings = new general();
    }

    public function append_header_common(head $header_tag) {
        if (empty($this->app_settings)) {
            $this->load_app_config();
        }
        /**
         * HEAD TAGS
         */
        $header_tag->set_title($this->app_settings->get_option('app_name'));
        $header_tag->append_meta("description", $this->app_settings->get_option('app_description'));
        $header_tag->append_meta("keywords", $this->app_settings->get_option('app_keywords'));
        $header_tag->append_meta("generator", "K1.lib v" . VERSION);
        $header_tag->append_meta("developer", "Alejandro Trujillo J. - alejo@klan1.com");
        $header_tag->append_meta("dev_contact", "httsp://github.com/j0hnd03, +57 318 398-8800");
    }
}
