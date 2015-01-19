<?php

foreach (['api', 'user', 'app'] as $route_key) {
    require_once(__DIR__ . "/routes/$route_key.php");
}
