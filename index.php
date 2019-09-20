<?php
require_once 'app/config.php';
$permit = require_once('app/partials/classes/middleware/authenticated.php');

if(!$layout->isApi() && $permit):
?>
<html>
    <head>
        <?php require_once "app/partials/head.php" ?>
    </head>
    <body>
        <header id="home">
            <?php $layout->getHeader(); ?>
        </header>

        <?php if($layout->isBodyEnabled()):?>
        <div id="main">
            <?php $layout->render(); ?>
        </div>
        <?php endif; ?>

        <footer class="bg-brand">
            <?php $layout->getFooter(); ?>
        </footer>
        <?php require_once('app/partials/pieces/modals.php'); ?>

        
        <?php if($layout->isToTopButtonEnabled()): ?>
            <button type="button" class="btn btn-toTop bg-info t-white scroll" 
            data-scroll-to="<?= $layout->getToTopButtonAnchor() ?>">
                <i class="fas fa-chevron-up"></i>
            </button>
        <?php endif; ?>

        <?php
            require_once 'app/partials/pieces/scripts.php';
        ?>

    </body>
</html>
<?php 
    else: if($permit) $layout->render();
endif; ?>