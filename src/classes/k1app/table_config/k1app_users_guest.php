<?php

namespace k1app\table_config;

/**
 * APP USER CONFIG CLASESS FROM HERE, UP CODE PLEASE LET IT BE.
 */
class k1app_users_guest extends defaults\admin_rol {

    const CONTROLLER_ALLOWED_LEVELS = ['person', 'guest'];

    /**
     * URLS
     */
    const BOARD_CREATE_URL = "new";
    const BOARD_READ_URL = "profile";
    const BOARD_UPDATE_URL = "update";
    const BOARD_DELETE_URL = "delete";
    const BOARD_EXPORT_URL = "export";
    const BOARD_LIST_URL = "list";

    /**
     * AVAILABILITY
     */
    const BOARD_CREATE_ENABLED = TRUE;
    const BOARD_READ_ENABLED = TRUE;
    const BOARD_UPDATE_ENABLED = TRUE;
    const BOARD_DELETE_ENABLED = FALSE;
    const BOARD_EXPORT_ENABLED = FALSE;
    const BOARD_LIST_ENABLED = FALSE;

    /**
     * NAMES
     */
    const BOARD_CREATE_NAME = "Registro de nueva persona";
    const BOARD_READ_NAME = "Perfil de usuario";
    const BOARD_UPDATE_NAME = "Actualizar datos del perfil";
    const BOARD_DELETE_NAME = "Borrar persona";
    const BOARD_EXPORT_NAME = "Exportar personas";
    const BOARD_LIST_NAME = "Listar datos";

    /**
     * ALLOWED LEVELS
     */
    const BOARD_CREATE_ALLOWED_LEVELS = ['person', 'guest'];
    const BOARD_READ_ALLOWED_LEVELS = ['person', 'guest'];
    const BOARD_UPDATE_ALLOWED_LEVELS = ['person', 'guest'];
    const BOARD_DELETE_ALLOWED_LEVELS = ['person', 'guest'];
    const BOARD_EXPORT_ALLOWED_LEVELS = ['person', 'guest'];
    const BOARD_LIST_ALLOWED_LEVELS = ['person', 'guest'];
}
