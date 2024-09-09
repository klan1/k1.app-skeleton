<?php

namespace k1app;

use k1app\k1app_template as DOM;

if (!isset($_GET['just-controller'])) {

    if (DOM::off_canvas()) {
        $container = DOM::off_canvas()->left();
        $footer_class = 'left-footer';
        $footer_id = 'k1lib-footer-message';
    } else {
        $container = DOM::html_document()->body()->footer();
        $footer_class = 'callout secondary medium';
        $footer_id = 'k1lib-footer-message';
    }

    $container->append_div("clearfix", 'k1app-footer');
    if (!(isset($_GET['no-footer']) && ($_GET['no-footer'] == "1"))) {
        $div = $container->append_child_tail(new \k1lib\html\div($footer_class, $footer_id));
        $footer_text = $div->append_h6(K1APP_COPYRIGHT);
        $footer_text->append_span(null, "k1lib-run-info");
    }
}