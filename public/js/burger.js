$(document).ready(function () {
    console.log('Global Burger Menu Fix Loaded');

    // Manual Toggle for Burger Menu (Sidebar)
    // FIXED: Only target specific pushmenu elements, don't block other buttons
    $('[data-widget="pushmenu"]').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent event bubbling

        var body = $('body');

        // Toggle class for sidebar visibility
        if (body.hasClass('sidebar-collapse')) {
            body.removeClass('sidebar-collapse').addClass('sidebar-open');
        } else {
            body.addClass('sidebar-collapse').removeClass('sidebar-open');
        }
    });
});
