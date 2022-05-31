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

	$('input[name^="formation_asks[status]"]').change(function() {
		let status = parseInt($("input[name='formation_asks[status]']:checked").val());

		if (status === 1) {
			let fieldsToShow = [
				'companyName',
				'sirenOrRm',
			];

			let fieldsToHide = [
				'siret',
				'idPoleEmploi',
			];

			fieldsToShow.forEach((value) => {
				showInput(value);
			})

			fieldsToHide.forEach((value) => {
				hideInput(value);
			})

			$('#activite').show();
			$('#stagiaires').show();

			$('#prerequis_autre').hide();
			$('#handicap').hide();
		}    
		else if (status === 2) {
			let fieldsToShow = [
				'idPoleEmploi',
			];

			let fieldsToHide = [
				'siret',
				'companyName',
				'sirenOrRm',
			];

			fieldsToShow.forEach((value) => {
				showInput(value);
			})

			fieldsToHide.forEach((value) => {
				hideInput(value);
			})

			$('#handicap').show();

			$('#stagiaires').hide();
			$('#prerequis_autre').show();

			$('#activite').show();
		}
		else if (status === 3) {
			let fieldsToShow = [
				'sirenOrRm',
			];

			let fieldsToHide = [
				'siret',
				'companyName',
				'idPoleEmploi',
			];

			fieldsToShow.forEach((value) => {
				showInput(value);
			})

			fieldsToHide.forEach((value) => {
				hideInput(value);
			})

			$('#handicap').show();

			$('#stagiaires').hide();
			$('#prerequis_autre').show();

			$('#activite').show();
		}
		else if (status === 4) {
			let fieldsToShow = [
				'siret',
			];

			let fieldsToHide = [
				'sirenOrRm',
				'companyName',
				'idPoleEmploi',
			];

			fieldsToShow.forEach((value) => {
				showInput(value);
			})

			fieldsToHide.forEach((value) => {
				hideInput(value);
			})

			$('#handicap').show();

			$('#stagiaires').hide();
			$('#prerequis_autre').show();

			$('#activite').hide();
		}
		else {
			let fieldsToHide = [
				'siret',
				'companyName',
				'idPoleEmploi',
				'sirenOrRm',
			];

			fieldsToHide.forEach((value) => {
				hideInput(value);
			})

			$('#handicap').show();

			$('#stagiaires').hide();
			$('#prerequis_autre').show();
		}
	});

	$('input[name^="formation_asks[status]"]').change(() => {
		let status = parseInt($("input[name='formation_asks[status]']:checked").val());

		if(status === 5) {
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
		});
	}

	const addStagiaireToCollection = (e) => {
		const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
		collectionHolder.classList.add("decoration-none");
		collectionHolder.classList.add("px-1");

		const item = document.createElement('li');
		item.classList.add("bg-blue");
		item.classList.add("shadow-lg");
		item.classList.add("p-4");
		item.classList.add("m-2");

		item.innerHTML = '<h4 class="text-center">STAGIAIRE</h4>';

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
	};

	document
		.querySelectorAll('.add_stagiaire_link')
		.forEach(btn => {
			btn.addEventListener("click", addStagiaireToCollection)
		})

	document
		.querySelectorAll('div.stagiaires div')
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

