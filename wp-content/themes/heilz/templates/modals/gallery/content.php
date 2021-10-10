<div class="ulz-modal ulz-modal-gallery ulz-no-select" data-id="gallery">
    <?php Ucore()->the_template('modals/close'); ?>
    <div class="ulz-modal-heading">
        <h4 class="ulz--title">&nbsp;</h4>
    </div>
    <div class="ulz-modal-content">
        <div class="ulz-modal-image">
            <!-- append immage here -->
        </div>
        <a href="#" class="ulz-gallery-nav" data-action="prev">
            <span><i class="fas fa-arrow-left"></i></span>
        </a>
        <a href="#" class="ulz-gallery-nav" data-action="next">
            <span><i class="fas fa-arrow-right"></i></span>
        </a>
        <?php Ucore()->preloader(); ?>
    </div>
    <div class="ulz-gallery-counter">
        <span class="ulz--current"></span>&nbsp;&sol;&nbsp;<span class="ulz--total"></span>
    </div>
</div>
