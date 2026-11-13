<?php
/**
 * k1.app-skeleton asset boot
 *
 * [Klan1-Developer IA] Added asset namespace registration and early boot.
 *
 * @license Apache-2.0
 */

\k1lib\html\asset_manager::register_namespace('app', dirname(__DIR__) . '/resources/');
\k1lib\html\asset_manager::boot();
