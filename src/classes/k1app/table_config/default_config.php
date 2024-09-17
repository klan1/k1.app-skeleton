<?php

namespace k1app\table_config;

/**
 * TABLE CONFIG DEFAULT
 */
class default_config {

    const CONTROLLER_ALLOWED_LEVELS = ['god', 'admin', 'user'];

    /**
     * URLS
     */
    const ROOT_URL = "app/controlername";
    const BOARD_CREATE_URL = "crear";
    const BOARD_READ_URL = "leer";
    const BOARD_UPDATE_URL = "actualizar";
    const BOARD_DELETE_URL = "borrar";
    const BOARD_EXPORT_URL = "exportar";
    const BOARD_LIST_URL = "listar";

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
    const BOARD_CREATE_ALLOWED_LEVELS = ['god', 'admin', 'user'];
    const BOARD_READ_ALLOWED_LEVELS = ['god', 'admin', 'user'];
    const BOARD_UPDATE_ALLOWED_LEVELS = ['god', 'admin', 'user'];
    const BOARD_DELETE_ALLOWED_LEVELS = ['god', 'admin', 'user'];
    const BOARD_EXPORT_ALLOWED_LEVELS = ['god', 'admin'];
    const BOARD_LIST_ALLOWED_LEVELS = ['god', 'admin', 'user'];
}