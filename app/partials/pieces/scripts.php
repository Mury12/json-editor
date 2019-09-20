<?php

foreach ($layout->getJs() as $s) {
    echo '<script defer src="' . $s . '" type="text/javascript"></script>';
}