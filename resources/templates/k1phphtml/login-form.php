<?php

namespace k1app;

use k1lib\html\template as template;
use k1app\k1app_template as DOM;

$body = DOM::html()->body();

// Form behaivor values
$form_magic_value = \k1lib\common\set_magic_value("login_form");
$form_action = \k1lib\urlrewrite\url::do_url("../in/");

$form_values = \k1lib\common\unserialize_var("login");

$body->set_id("login-form-body");

$form = new \k1lib\html\form("login-form-object");
$form->append_to($body->content());
$form->set_attrib("action", $form_action);
$form->append_child(new \k1lib\html\input("hidden", "magic_value", $form_magic_value));

$centered_grid = new \k1lib\html\foundation\grid(1, 1, $form);
$centered_grid->row(1)->align_center();
$centered_grid->row(1)->cell(1)->small(10)->medium(6)->large(4);

$main_grid = new \k1lib\html\foundation\grid(4, 1, $centered_grid->row(1)->cell(1));
$main_grid->row(1)->cell(1)->set_class("text-center")->set_id("k1lib-login-logo")->append_child(new \k1lib\html\img(K1APP_TEMPLATE_URL . "img/klan1.png"));
$main_grid->row(2)->cell(1)->set_id("k1lib-login-title")->set_class("text-left")->append_h1(K1APP_TITLE);

$login_grid = $main_grid->row(3)->cell(1)->append_grid(5, 1)->set_id("k1app-login-content");

(new \k1lib\html\input("text", "login", NULL))->set_attrib("placeholder", "Login")->append_to($login_grid->row(2)->cell(1));
(new \k1lib\html\input("password", "pass", NULL))->set_attrib("placeholder", "Password")->append_to($login_grid->row(3)->cell(1));

$login_grid->row(4)->cell(1)->append_child((new \k1lib\html\label("Remember me", "remember-me", "float-left")));
$login_grid->row(4)->cell(1)->append_child((new \k1lib\html\input("checkbox", "remember-me", NULL, ""))->set_style("margin-left:1em;"));

$button_grid = $login_grid->row(5)->cell(1)->append_row(2);
$button_grid->cell(1)->small(6)->append_a("javascript:alert('Sorry to hear that!, Please contact an administrator.')", "Forgot your password?");
$button_grid->cell(2)->small(6)->set_class("text-right")->append_child(new \k1lib\html\input("submit", NULL, "Login", "button"));

$main_grid->row(4)->cell(1)->append_h6(K1APP_COPYRIGHT)->set_id("k1lib-login-copyright");