jQuery(document).ready(function() {

    // show the main nav when clicked
    jQuery('#nav-toggle').click(function() {
        jQuery('body').toggleClass('nav-expanded');
    });

    // add classes when download is added to cart
    jQuery('body').on('click.eddAddToCart', '.edd-add-to-cart', function (e) {
        jQuery(this).parent().parent().parent().parent().not('.variable-priced').addClass('in-cart');
        jQuery(this).next().find('i').addClass('animated');
    });

});

// add loaded class
jQuery(window).load(function() {
    jQuery('body').addClass('loaded');
});