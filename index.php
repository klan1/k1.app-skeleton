<?php

/*
 * Easy and clean start, not bad, learned from WordPress :D
 */
namespace k1lib;

const K1LIB_INC_MODE = 0;
const K1LIB_LANG = 'en';

namespace k1app;

// Composer lines
require __DIR__ . '/vendor/autoload.php';

// k1.app start
const APP_MODE = "web";
include_once "./bootstrap.php";
