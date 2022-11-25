import '../styles/css/darkTheme.scss';
import '../styles/css/webpages/formationAsk.scss';

$('.btn-save-formation-ask').prop('disabled', true);

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

    const showInput = (id) => {
        $('#formation_asks_'+id).val('');
    }

    const hideInput = (id) => {
        $('#formation_asks_'+id).val('null');
    }

    $('input[name^="formation_asks[isStagiaireMultiple]"]').click(function() {
        let value = parseInt($("input[name^=\"formation_asks[isStagiaireMultiple]\"]:checked").val());

        if (value === 0) {
            $('#cost-when-alone').show();
            $('#costs').hide();
        } else {
            $('#cost-when-alone').hide();
            $('#costs').show();
        }
    })

    $('input[name^="formation_asks[status]"]').change(() => {
        let status = parseInt($("input[name='formation_asks[status]']:checked").val());

        if(status === 6) {
            $('#autre_statut_champ').show();
        } else {
            $('#autre_statut_champ').hide();
        }
    })

    $('input[name^="formation_asks[activityCategory][]"]').change(() => {
        let activityCategory = [];
        $("input:checkbox[name='formation_asks[activityCategory][]']:checked").each(function(){
            activityCategory.push($(this).val());
        });

        if(activityCategory.indexOf("Autre") > -1) {
            $('#autre_activite_champ').show();
        } else {
            $('#autre_activite_champ').hide();
        }
    })

    $('input[name^="formation_asks[goal]"]').change(() => {
        let goal = $("input[name='formation_asks[goal]']:checked").val();

        if(goal === "Autre") {
            $('#autre_obj_champ').show();
        } else {
            $('#autre_obj_champ').hide();
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

    const calculatePriceWhenStagiaireAdded = (numberOfPeople) => {
        let pricesList = document.querySelector('#cost-when-multiple').getAttribute('data');
        pricesList = JSON.parse(pricesList);
        let price = numberOfPeople*pricesList[0];

        for(let i = 1; i < pricesList.length; i++) {
            if(i === numberOfPeople) {
                price = pricesList[i];
            }
        }

        document.querySelector('#cost-calculated').innerHTML = price+' €';
    }

    const addStagiaireFormDeleteLink = (item) => {
        const container = document.createElement('div');
        container.classList.add("text-end");
        container.classList.add("remove-students-button");
        container.classList.add("order-1");
        container.classList.add("order-lg-3");

        const removeFormButton = document.createElement('button');
        removeFormButton.classList.add("btn");
        removeFormButton.classList.add("btn-danger");
        removeFormButton.classList.add("rounded-corners");
        removeFormButton.innerHTML = '<i class="fas fa-minus"></i>';

        container.appendChild(removeFormButton);
        item.append(container);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            $(item).fadeOut(400, function() { $(this).remove(); });
            let numberOfPeople = parseInt(document.querySelector('#asks_stagiaires').getAttribute("data")) - 1;

            document.querySelector('#asks_stagiaires').setAttribute("data", ""+numberOfPeople+"");
            calculatePriceWhenStagiaireAdded(numberOfPeople);
        });
    }

    const addStagiaireToCollection = (e) => {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
        collectionHolder.classList.add("decoration-none");
        collectionHolder.classList.add("px-1");

        const item = document.createElement('li');
        item.classList.add("bg-grey", "d-flex", "flex-column", "flex-lg-row", "justify-content-center");
        item.classList.add("rounded-corners", "p-4", "mb-3");

        item.innerHTML = '<div class="pe-2 pb-2 order-2 order-lg-1 text-center">\n' +
            '                <i class="fas fa-user form-icon"></i>\n' +
            '            </div>';

        item.insertAdjacentHTML('beforeend', collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            ));

        /*container.appendChild(item);*/
        collectionHolder.appendChild(item);
        $(item).hide().fadeIn();
        collectionHolder.dataset.index++;

        addStagiaireFormDeleteLink(item);
        let numberOfPeople = parseInt(document.querySelector('#asks_stagiaires').getAttribute("data")) + 1;

        document.querySelector('#asks_stagiaires').setAttribute("data", ""+numberOfPeople+"");
        calculatePriceWhenStagiaireAdded(numberOfPeople);
    };

    document
        .querySelectorAll('.add_stagiaire_link')
        .forEach(btn => {
            btn.addEventListener("click", addStagiaireToCollection)
        })

    document
        .querySelectorAll('#formation_asks_stagiaires > div')
        .forEach((stagiaire) => {
            addStagiaireFormDeleteLink(stagiaire)
        })


    var $consents = [$('#formation_asks_consents_0'), $('#formation_asks_consents_1'), $('#formation_asks_consents_2')];

    $.each($consents, function( index, value ) {
        value.change(function() {
            //if all checked
            if($consents[0].is(':checked') && $consents[1].is(':checked') && $consents[2].is(':checked')) {
                $('.btn-save-formation-ask').prop('disabled', false);
            } else {
                $('.btn-save-formation-ask').prop('disabled', true);
            }
        })
    });
})