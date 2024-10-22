<?php

namespace k1app\table_config;

class god_default_config extends default_config {

    const CONTROLLER_ALLOWED_LEVELS = ['god'];

    /**
     * ALLOWED LEVELS
     */
    const BOARD_CREATE_ALLOWED_LEVELS = ['god'];
    const BOARD_READ_ALLOWED_LEVELS = ['god'];
    const BOARD_UPDATE_ALLOWED_LEVELS = ['god'];
    const BOARD_DELETE_ALLOWED_LEVELS = ['god'];
    const BOARD_EXPORT_ALLOWED_LEVELS = ['god'];
    const BOARD_LIST_ALLOWED_LEVELS = ['god'];
}
