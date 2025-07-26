<?php

namespace k1app\table_config\defaults;

/**
 * TABLE CONFIG DEFAULT
 */
class base_all_roles {

    const CONTROLLER_ALLOWED_LEVELS = ['god', 'admin', 'user', 'guest'];

    /**
     * URLS
     */
    const BOARD_CREATE_URL = "create";
    const BOARD_READ_URL = "open";
    const BOARD_UPDATE_URL = "update";
    const BOARD_DELETE_URL = "delete";
    const BOARD_EXPORT_URL = "export";
    const BOARD_LIST_URL = "browse";

    /**
     * AVAILABILITY
     */
    const BOARD_CREATE_ENABLED = TRUE;
    const BOARD_READ_ENABLED = TRUE;
    const BOARD_UPDATE_ENABLED = TRUE;
    const BOARD_DELETE_ENABLED = TRUE;
    const BOARD_EXPORT_ENABLED = TRUE;
    const BOARD_LIST_ENABLED = TRUE;

    /**
     * NAMES
     */
    const BOARD_CREATE_NAME = "Crear registro";
    const BOARD_READ_NAME = "Leer registro";
    const BOARD_UPDATE_NAME = "Actualizar datos del registro";
    const BOARD_DELETE_NAME = "Borrar registro";
    const BOARD_EXPORT_NAME = "Exportar tabla";
    const BOARD_LIST_NAME = "Listar datos";

    /**
     * ALLOWED LEVELS
     */
    const BOARD_CREATE_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
    const BOARD_READ_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
    const BOARD_UPDATE_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
    const BOARD_DELETE_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
    const BOARD_EXPORT_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;
    const BOARD_LIST_ALLOWED_LEVELS = self::CONTROLLER_ALLOWED_LEVELS;

    /**
     * 
     */
    const ENUM_CUSTOM_VALUES_BY_ROL = [];

    /**
     * 
     */
    const HIDE_FIELDS_BY_ROL = [];
}
