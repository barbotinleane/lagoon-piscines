import '../styles/css/darkTheme.scss';
import '../styles/css/webpages/formationAsk.scss';

$('.btn-save-formation-ask').prop('disabled', true);

$(function() {
    $("nav.navbar").addClass("navbar-dark");
    $("nav.navbar").removeClass("navbar-light");
    $("nav.navbar").addClass("bg-dark");
    $("nav.navbar").removeClass("bg-white");

    $('input[name^="formation_asks[status]"]').change(() => {
        let status = parseInt($("input[name='formation_asks[status]']:checked").val());

        if(status === 1) {
            $('#companyInformations').show();
            $('#numberLearners').show();
            $('#formation_asks_companyName').prop('required',true);
            $('#formation_asks_companyPostalCode').prop('required',true);
            $('#formation_asks_numberOfWorkersInCompany').prop('required',true);
            $('#formation_asks_numberOfLearners').prop('required',true);
        } else {
            $('#companyInformations').hide();
            $('#numberLearners').hide();
            $('#formation_asks_companyName').prop('required',false);
            $('#formation_asks_companyPostalCode').prop('required',false);
            $('#formation_asks_numberOfWorkersInCompany').prop('required',false);
            $('#formation_asks_numberOfLearners').prop('required',false);
        }

        if(status === 3) {
            $('#autre_statut_champ').show();
        } else {
            $('#autre_statut_champ').hide();
        }
    })

    $('input[name^="formation_asks[knowsUs][]"]').click(() => {
        let knowsUs = [];
        $("input:checkbox[name='formation_asks[knowsUs][]']:checked").each(function(){
            knowsUs.push($(this).val());
        });

        if(knowsUs.indexOf("Autre") > -1) {
            $('#autre_cnn_champ').show();
        } else {
            $('#autre_cnn_champ').hide();
        }
    })

    var $consents = [$('#formation_asks_consents_0'), $('#formation_asks_consents_1'), $('#formation_asks_consents_2')];

    $.each($consents, function( index, value ) {
        value.change(function() {
            //if all checked
            if($consents[0].is(':checked') && $consents[1].is(':checked') && $consents[2].is(':checked')) {
                $('#validate').prop('disabled', false);
            } else {
                $('#validate').prop('disabled', true);
            }
        })
    });
})