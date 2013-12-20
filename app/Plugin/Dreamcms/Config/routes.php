<?php

require_once "core.php";

Router::connect("/secret/:action/*", array("plugin" => "Dreamcms", "controller" => "Admins"));

?>