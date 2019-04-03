<?php

session_start();

foreach ($_SESSION['nodes'] as $key => $value) {
    if ($value['id'] === $_GET['id']) {
        unset($_SESSION['nodes'][$key]);
    }
}

header('Location: /');

