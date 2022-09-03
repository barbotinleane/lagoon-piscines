const datepicker = require('js-datepicker');

$(function() {
	const showInput = (id) => {
		$('#formation_asks_'+id).val('');
		$('#'+id).show();
	}

	const hideInput = (id) => {
		$('#formation_asks_'+id).val('null');
		$('#'+id).hide();
	}

	$('input[name^="formation_asks[isStagiaireMultiple]"]').click(function() {
		let value = parseInt($("input[name^=\"formation_asks[isStagiaireMultiple]\"]:checked").val());

		if (value === 0) {
			$('#cost-when-alone').show();
		} else {
			$('#cost-when-alone').hide();
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

	$('input[name^="formation_asks[activityCategory]"]').change(() => {
		let activityCategory = $("input[name='formation_asks[activityCategory]']:checked").val();

		if(activityCategory === "Autre") {
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

	$('#formation_asks_knowsUs_5').on("click", () => {
		if($('#formation_asks_knowsUs_5').prop('checked')){
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
		container.classList.add("text-center");

		const removeFormButton = document.createElement('button');
		removeFormButton.classList.add("btn");
		removeFormButton.classList.add("btn-danger");
		removeFormButton.innerHTML = '<i class="fas fa-user-minus"></i>&nbsp;Supprimer ce stagiaire';

		container.appendChild(removeFormButton);
		item.append(container);

		removeFormButton.addEventListener('click', (e) => {
			e.preventDefault();
			item.remove();
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
		item.classList.add("bg-blue");
		item.classList.add("col-12");
		item.classList.add("col-sm-6");
		item.classList.add("shadow-lg");
		item.classList.add("p-4");

		item.innerHTML = '<h4>STAGIAIRE</h4>';

		item.insertAdjacentHTML('beforeend', collectionHolder
			.dataset
			.prototype
			.replace(
				/__name__/g,
				collectionHolder.dataset.index
			));

		/*container.appendChild(item);*/
		collectionHolder.appendChild(item);
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
				$('#formation_asks_save').prop('disabled', false);
			} else {
				$('#formation_asks_save').prop('disabled', true);
			}
		})
	});

	const picker = datepicker('.js-datepicker', {
		startDay: 1,
		customDays: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
		customMonths: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
		customOverlayMonths: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Jui', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
		minDate: new Date(),
		overlayPlaceholder: 'Entrez une année',
		formatter: (input, date, instance) => {
			input.value = date.toLocaleDateString("fr");
		},
	});
});

