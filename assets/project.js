import adige from './photos/colorsBigger/Adige.png';
import bianco from './photos/colorsBigger/Bianco.png';
import caraibi from './photos/colorsBigger/Caraibi.png';
import corsica from './photos/colorsBigger/Corsica.png';
import grecia from './photos/colorsBigger/Grecia.png';
import panama from './photos/colorsBigger/Panama.png';
import rosso from './photos/colorsBigger/Rosso.png';
import sardegna from './photos/colorsBigger/Sardegna.png';

import bali from './photos/shapesBigger/bali.png';
import benitiers from './photos/shapesBigger/benitiers.png';
import ibiza from './photos/shapesBigger/Ibiza.png';
import majorque from './photos/shapesBigger/Majorque.png';
import moorea from './photos/shapesBigger/Moorea.png';
import phuket from './photos/shapesBigger/Phuket.png';
import santorin from './photos/shapesBigger/Santorin.png';
import seychelles from './photos/shapesBigger/Seychelles.png';
import zanzibar from './photos/shapesBigger/Zanzibar.png';

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

    let colors = {
        'Adige': adige,
        'Bianco': bianco,
        'Caraibi': caraibi,
        'Corsica': corsica,
        'Grecia': grecia,
        'Panama': panama,
        'Rosso': rosso,
        'Sardegna': sardegna,
    };

    $('button[name="colorButton"]').click(function(event) {
        $("#content").empty();
        let colorName = $(this).attr('id');
        let colorImage = colors[colorName];
        document.getElementById('content').innerHTML = '<img src="'+colorImage+'" class="w-100">';
    })

    let shapes = {
        'Bali': bali,
        'Benitiers': benitiers,
        'Ibiza': ibiza,
        'Majorque': majorque,
        'Moorea': moorea,
        'Phuket': phuket,
        'Santorin': santorin,
        'Seychelles': seychelles,
        'Zanzibar': zanzibar,
    };

    $('button[name="shapeButton"]').click(function(event) {
        $("#content").empty();
        let shapeName = $(this).attr('id');
        let shapeImage = shapes[shapeName];
        document.getElementById('content').innerHTML = '<img src="'+shapeImage+'" class="w-100">';
    })
});


