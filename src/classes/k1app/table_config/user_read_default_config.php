<?php

namespace k1app\table_config;


class user_read_default_config extends default_config {

    const CONTROLLER_ALLOWED_LEVELS = ['god', 'admin', 'user', 'guest'];

    /**
     * ALLOWED LEVELS
     */
    const BOARD_CREATE_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_READ_ALLOWED_LEVELS = ['god', 'admin', 'user'];
    const BOARD_UPDATE_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_DELETE_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_EXPORT_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_LIST_ALLOWED_LEVELS = ['god', 'admin', 'user'];
}
