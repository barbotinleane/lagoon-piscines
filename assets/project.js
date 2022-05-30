$(function() {
    $('input[name^="project_ask[shape]"]').change(function() {
        let model = $("input[name='project_ask[shape]']:checked").val();

        if (model === "Modèle pré-dessiné") {
            $("#choose_forme").show();
        } else {
            $("#choose_forme").hide();
        }
    });

    $('input[name^="project_ask[beach]"]').change(function() {
        let beach = $("input[name='project_ask[beach]']:checked").val();

        if (beach === "Oui") {
            $("#choose_plage").show();
        } else {
            $("#choose_plage").hide();
        }
    });

    $('#consentement_donnees').change(function() {
        let submit = $("#valider");

        if ($('#consentement_donnees').is(':checked')) {
            submit.prop('disabled', false);
        } else {
            submit.prop('disabled', true);
        }
    });
});