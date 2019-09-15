(function ($) {

    var $hamburger = $('.menu-toggle');

    // initialize Slideout.
    var slideout = new Slideout({
        'panel': $('.site-container').get(0),
        'menu': $('.side-menu').get(0),
        'padding': 256 // width of the slideout menu
        // 'side': 'right' // open the menu from right
    });

    // 959px and below, move `.nav-primary` from its default location to inside `.nav-menu` inside the side menu.
    // 960px and above, ensure that side menu is closed and that `.nav-primary` is in its default location.
    $(window).on('resize', function () {
        if (960 > $(window).width()) {
            $('.nav-primary').appendTo('.nav-menu');
        } else {
            slideout.close();
            $('.nav-primary').insertAfter('.menu-toggle');
        }
    }).resize(); // Invoke the resize event immediately

    // open and close the side menu by clicking on the hamburger button.
    $hamburger.on('click', function (e) {
        e.preventDefault();
        $hamburger.toggleClass('activated');

        slideout.toggle();
    });

    // Toggle Slideout when .close-icon is tapped.
    $('.close-icon').on('click', function () {
        slideout.close();
    });

    // add an overlay on the open panel to close the side menu on click.
    function close(e) {
        e.preventDefault();
        slideout.close();
    }

    slideout
        .on('beforeopen', function () {
            this.panel.classList.add('panel-open');
        })
        .on('open', function () {
            this.panel.addEventListener('click', close);
        })
        .on('beforeclose', function () {
            this.panel.classList.remove('panel-open');
            this.panel.removeEventListener('click', close);
            $hamburger.removeClass('is-active');
        });

})(jQuery);