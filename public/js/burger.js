$(document).ready(function () {
    console.log('Global Burger Menu Fix Loaded');

    // Manual Toggle for Burger Menu (Sidebar)
    // This script applies to ALL pages to ensure the burger menu works everywhere
    $(document).on('click', '[data-widget="pushmenu"]', function (e) {
        e.preventDefault();
        var body = $('body');

        // Toggle class for sidebar visibility
        if (body.hasClass('sidebar-collapse')) {
            body.removeClass('sidebar-collapse').addClass('sidebar-open');
        } else {
            body.addClass('sidebar-collapse').removeClass('sidebar-open');
        }
    });
});
