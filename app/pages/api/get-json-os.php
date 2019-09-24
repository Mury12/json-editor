<?php

$content = file_get_contents('assets/js/vue.components/util/items.json');

    sendJsonResponse(json_decode($content));