<?php

if ($layout->getCss() !== null){
    foreach ($layout->getCss() as $style){
        echo '<link href="'.$style.'" rel="stylesheet" type="text/css"/>';
    }
}
