<?php

    require __DIR__ . '/../vendor/autoload.php';

    $item = item(
        "string value",
        "name",
        "string",
        "desc",
        []
    );

    var_dump($item);
    var_dump($item->resolve());
?>