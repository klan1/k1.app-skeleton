<?php

namespace k1app\core\template;

use const k1app\K1APP_URL;
use k1app\template\mazer\components\app\sidebar\wrapper\sidebar_menu\menu;
use k1lib\app\controller;
use k1lib\session\app_session;

class my_menu extends menu {

    public function __construct($menu_title = null) {
        if (isset(app_session::get_user_data()['user_id'])) {
            $db = controller::app()->db();
            $user_id = app_session::get_user_data()['user_id'];
            $user_auth_code = $db->generate_auth_code($user_id);
            $person_profile_url = K1APP_URL . 'app/public/personas/perfil/' . $user_id . '/?auth-code=' . $user_auth_code;
            $user_profile_url = K1APP_URL . 'app/persons/perfil/' . $user_id . '/?auth-code=' . $user_auth_code;
        }
        parent::__construct($menu_title);
        if (app_session::check_user_level(['guest'])) {
            $this->add_item('Iniciar sesión', K1APP_URL . 'auth/login/', 'bi bi-person-badge-fill', 'nav-login');
            $this->add_item('Registro', K1APP_URL . 'app/public/personas/registro/', 'bi bi-person-badge-fill', 'nav-my-profile');
        } else if (app_session::check_user_level(['person'])) {

            $this->add_item('Mi perfil', $person_profile_url, 'bi bi-person-badge-fill', 'nav-my-profile');
            $this->add_item('Cerrar sesión', K1APP_URL . 'auth/logout/', 'bi bi-door-open', 'nav-login');
        } else {

            $this->add_item('Inicio', K1APP_URL, 'bi bi-file-earmark-bar-graph', 'nav-index');
            if (app_session::is_logged()) {
                $submenu_profile = $this->add_item('Mi perfil', '#', 'bi bi-person-badge-fill', 'nav-user-profile')->nav_is_sub();
                $submenu_profile->add_subitem('Ver perfíl', $user_profile_url, 'nav-my-profile');
                $submenu_profile->add_subitem('Cerrar sesión', K1APP_URL . 'auth/logout/');
            } else {
                $this->add_item('Iniciar sesión', K1APP_URL . 'auth/login/', 'bi bi-person-badge-fill', 'nav-login');
            }
            /**
             * 
             */
            if (app_session::check_user_level([
                        'god',
                        'businsess-admin',
                        'admin-producer',
                        'admin-zone',
                    ])) {
                $submenu_producer = $productores_item = $this->add_item('Produccion', '#', 'bi bi-box-seam', 'nav-producer-top')->nav_is_sub();
                $submenu_producer->add_subitem('Productores', K1APP_URL . 'app/producers/', 'nav-producers');
                $submenu_producer->add_subitem('Zonas', K1APP_URL . 'app/sales_zones/', 'nav-sales_zones');
//                $submenu_producer->add_subitem('POS en Zonas', K1APP_URL . 'app/zone_pos/', 'nav-producer-distributor-pos');
                $submenu_producer->add_subitem('Visitadores', K1APP_URL . 'app/visitors/', 'nav-visitors');
//                $submenu_producer->add_subitem('Importar datos', K1APP_URL . 'app/product_imports/', 'nav-product-imports');
                $submenu_producer->add_subitem('Productos', K1APP_URL . 'app/products/', 'nav-products');
            }

            /**
             * 
             */
            if (app_session::check_user_level([
                        'god',
                        'businsess-admin',
                        'admin-producer',
                        'admin-distribuitor',
                    ])) {
                $submenu_distribution = $this->add_item('Distribución', '#', 'bi bi-shop', 'nav-distribution')->nav_is_sub();
                $submenu_distribution->add_subitem('Empresas', K1APP_URL . 'app/distributors/', 'nav-distributors');
                $submenu_distribution->add_subitem('Puntos de venta', K1APP_URL . 'app/pos/', 'nav-pos');
                $submenu_distribution->add_subitem('Vendedores', K1APP_URL . 'app/salesmen/', 'nav-salesmen');
//                $submenu_distribution->add_subitem('Ventas', "javascript:alert('En desarrollo.')", 'nav-sales');
            }
            /**
             * 
             */
            if (app_session::check_user_level([
                        'god',
                        'businsess-admin',
                        'admin-producer',
                        'admin-distribuitor',
                        'admin-zone',
                    ])) {
                $submenu_visitors = $this->add_item('Visitadores', '#', 'bi bi-briefcase', 'nav-distributors')->nav_is_sub();
                $submenu_visitors->add_subitem('Veterinarios', K1APP_URL . 'app/vets/', 'nav-vets');
                $submenu_visitors->add_subitem('Visitas', "javascript:alert('En desarrollo.')", 'nav-distributors');
            }
            /**
             * 
             */
            if (app_session::check_user_level([
                        'god',
                        'businsess-admin',
                        'admin-producer',
                        'admin-zone',
                        'veterinarian',
                    ])) {
                $submenu_vets = $this->add_item('Veterinarios', K1APP_URL . 'app/vets/', 'bi bi-heart-pulse', 'nav-vets')->nav_is_sub();
                $submenu_vets->add_subitem('Compradores', K1APP_URL . 'app/owners/', 'nav-owners');
                $submenu_vets->add_subitem('Mascotas', "javascript:alert('En desarrollo.')", 'nav-pets');
            }
            /**
             *
             */
            if (app_session::check_user_level([
                        'god',
                        'businsess-admin',
                        'admin-producer',
                        'admin-distribuitor',
                        'admin-zone',
                        'admin-pos',
                    ])) {
                $this->add_menu_title('PANEL DE CONTROL');
                $this->add_item('Personas', K1APP_URL . 'app/persons/', 'bi bi-person-workspace', 'nav-admin-users');

                if (app_session::check_user_level(['god'])) {

                    $submenu_admin = $this->add_item('DB Configurator', '#', 'bi bi-database', 'nav-db-configurator')->nav_is_sub();
                    $submenu_admin->add_subitem('Config a table', K1APP_URL . 'core/admin/select_table/', 'nav-config-table');
                    $submenu_admin->add_subitem(
                            'Export configuration', K1APP_URL . 'core/admin/export_db_configuration/',
                            'nav-export-configuration'
                    );
                    $submenu_admin->q('#a-nav-export-configuration')->set_attrib('target', '_export');
                    $submenu_admin->add_subitem(
                            'Import configuration', K1APP_URL . 'core/admin/import_db_configuration/',
                            'nav-export-configuration'
                    );
                }
            }
        }
    }
}
