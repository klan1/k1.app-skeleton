<?php

namespace k1app\core\template;

use k1app\template\mazer\layouts\blank;

class base extends blank {

    use header_common;

    public function __construct($lang = 'en') {
        parent::__construct($lang);
        $this->append_header_common($this->head());
    }
}
