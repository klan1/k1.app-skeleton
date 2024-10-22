<?php

namespace k1app;

use k1lib\html\template as template;
use k1app\k1app_template as DOM;

DOM::start_template_plain();

$body = DOM::html_document()->body();

template::load_template('header');
template::load_template('login-form');
