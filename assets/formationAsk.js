import './styles/css/darkTheme.scss';

$(function() {
    $("nav.navbar").addClass("navbar-dark");
    $("nav.navbar").removeClass("navbar-light");
    $("nav.navbar").addClass("bg-dark");
    $("nav.navbar").removeClass("bg-white");

    $("#start-form").click(function() {
        $("#intro").hide();
        $("#step1").fadeIn();
    })

    $("#formation_asks_stagiaires > div > label").addClass("d-block pe-2 pb-2 order-2 order-lg-1 text-center");
    $("#formation_asks_stagiaires > div > label").append("<i class='fas fa-user form-icon'></i>");
})