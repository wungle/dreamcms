<?php

require_once "core.php";

Router::connect("/secret/:action/*", array("plugin" => "DreamCms", "controller" => "Admins"));

?>