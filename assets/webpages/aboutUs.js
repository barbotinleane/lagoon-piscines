import '../styles/css/webpages/aboutUs.scss';

document.addEventListener('DOMContentLoaded', function() {
    $('#subject-of-ask').on("change", function() {
        if(this.value == "formation") {
            $('#placeholder-contact').hide();
            $('#formation-contact').show();
            $('#build-contact').hide();
        } else if (this.value == "build") {
            $('#placeholder-contact').hide();
            $('#build-contact').show();
            $('#formation-contact').hide();
        } else {
            $('#build-contact').hide();
            $('#formation-contact').hide();
            $('#placeholder-contact').show();
        }
    })
})