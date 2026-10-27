<?php

namespace Syr\Account\Controller;

class Controller
{
    public function is_post_request() {
        if(isset($_SERVER['REQUEST_METHOD'])) {
            return (strtolower($_SERVER['REQUEST_METHOD']) == 'post');
        }
        else {
            return (isset($_POST) && !empty($_POST));
        }
    }
}