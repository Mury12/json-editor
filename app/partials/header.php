<section class="container d-flex justify-content-center bg-parallax" id="main-header" style="<?=$this->getHeaderImage()?>">
    <div class="row align-self-center" id="header">
        <div class="col-12 text-center">
            <h1 class="t-shadow parallax-right" data-speed="3">
                <?= $this->getHeaderTitle() ?>
            </h1>
            <div class="t-shadow hideOnScroll" data-speed="3">
                <?= $this->getHeadersubTitle() ?>
            </div>

            <?php if($this->isBodyButtonEnabled()): ?>
            <div class="fixed-bottom mb-2 f-center d-flex justify-content-center hideOnScroll">
                <p class="pointer d-flex align-items-end">
                    <i class="fas fa-chevron-down scroll fa-2x oscilator" data-scroll-to="main"></i>
                </p>
            </div>
            <?php endif; ?>

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