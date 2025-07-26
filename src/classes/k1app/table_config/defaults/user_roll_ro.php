<?php

namespace k1app\table_config\defaults;

class user_roll_ro extends base_all_roles {

    const CONTROLLER_ALLOWED_LEVELS = ['god', 'admin', 'user'];

    /**
     * ALLOWED LEVELS
     */
    const BOARD_CREATE_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_READ_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
    const BOARD_UPDATE_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_DELETE_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_EXPORT_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_LIST_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
}
