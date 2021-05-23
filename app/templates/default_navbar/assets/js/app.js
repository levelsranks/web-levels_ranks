$(document).on("click", "[data-sidebar-open]", (e) => {
    console.log($(e.target).data("sidebar-open"));
    if( $(e.target).data("sidebar-open") == true || typeof $(e.target).data("sidebar-open") == "undefined" )
    {
        $(e.target).data("sidebar-open", false);
        $(".navbar-chlen").addClass("navbar-content-open"),
        $(".navbar-content").addClass("navbar-content-open");
    }
    else
    {
        $(e.target).data("sidebar-open", true);
        $(".navbar-chlen").removeClass("navbar-content-open"),
        $(".navbar-content").removeClass("navbar-content-open");
    }
});