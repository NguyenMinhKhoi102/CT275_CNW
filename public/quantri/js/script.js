$(document).ready(function () {
    $('#DataTable').DataTable();
    $(".dropdown-select").click(function () {
        $(this).children(".fa").toggleClass("fa-caret-up");
        $(this).siblings(".dropdown-list").toggleClass("drop");
    });
    $("#control-bars").click(function () {
        $("main").toggleClass("col-12");
        if ($("nav").css("display") == "block") {
            $("nav").css("display", "none");
        } else {
            $("nav").css("display", "block");
        }
    });

});
