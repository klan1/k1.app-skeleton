<?php

namespace k1app\table_config;

/**
 * APP USER CONFIG CLASESS FROM HERE, UP CODE PLEASE LET IT BE.
 */
class k1app_users extends defaults\admin_rol {

    const BOARD_CREATE_URL = "registro";
    const BOARD_READ_URL = "perfil";
    const BOARD_UPDATE_URL = "actualizar";
    const BOARD_DELETE_URL = "borrar";
    const BOARD_EXPORT_URL = "exportar";
    const BOARD_LIST_URL = "listar";

    /**
     * NAMES
     */
    const BOARD_CREATE_NAME = "Registro de nueva persona";
    const BOARD_READ_NAME = NULL;
    const BOARD_UPDATE_NAME = "Actualizar datos del registro";
    const BOARD_DELETE_NAME = "Borrar registro";
    const BOARD_EXPORT_NAME = "Exportar tabla";
    const BOARD_LIST_NAME = NULL;

    /**
     * 
     */
    const ENUM_CUSTOM_VALUES_BY_ROL = [
        'guest' => [
            'level' => [
                'person',
            ],
        ],
        'person' => [
            'level' => [
                'person',
            ],
        ],
        'veterinarian' => [
            'level' => [
                'veterinarian',
            ],
        ],
        'visitors' => [
            'level' => [
                'visitors',
            ],
        ],
        'selesman' => [
            'level' => [
                'selesman',
            ],
        ],
        'accountant' => [
            'level' => [
                'accountant',
            ],
        ],
        'admin-pos' => [
            'level' => [
                'admin-pos',
            ],
        ],
        'admin-zone' => [
            'level' => [
                'admin-zone',
                'admin-pos',
                'accountant',
                'selesman',
                'visitors',
                'veterinarian',
                'person',
            ],
        ],
        'admin-distribuitor' => [
            'level' => [
                'admin-pos',
                'selesman',
            ],
        ],
        'admin-producer' => [
            'level' => [
                'admin-zone',
                'accountant',
                'visitors',
                'veterinarian',
                'person',
            ],
        ],
        'businsess-admin' => [
            'level' => [
                'admin-producer',
                'admin-distribuitor',
                'admin-zone',
                'admin-pos',
                'accountant',
                'selesman',
                'visitors',
                'veterinarian',
                'person',
            ],
        ],
//        'god' => [
//            'level' => [
//                'admin-producer',
//                'admin-distribuitor',
//                'admin-zone',
//                'admin-pos',
//                'accountant',
//                'selesman',
//                'visitors',
//                'veterinarian',
//                'person',
//                'guest'
//            ],
//        ],
    ];

    /**
     * 
     */
    const HIDE_FIELDS_BY_ROL = [
        'admin-zone' => [
            'producer_id',
            'zone_id',
            'distributor_id',
            'level'
        ],
        'admin-distribuitor' => [
            'producer_id',
            'zone_id',
            'distributor_id',
            'level'
        ],
        'admin-producer' => [
            'producer_id',
        ],
        'god' => [
//            'producer_id',
        ],
    ];
}
