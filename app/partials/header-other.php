<section class="container d-flex justify-content-center" id="main-header">
    <div class="row align-self-center" id="header">
        <div class="col-12 text-center">
            <i class="fas fa-gavel fa-5x"></i>
        </div>
    </div>
</section>
<?php
    if($this->isNavEnabled()):
?>
<nav class="menu mt-4">
    <div class="container">
        <div class="row">
            <?php $this->getNav(); ?>
        </div>
    </div>
</nav>
<?php endif;