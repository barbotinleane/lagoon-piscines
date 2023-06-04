import '../styles/css/darkTheme.scss';

$(function() {
    $("nav.navbar").addClass("navbar-dark")
        .removeClass("navbar-light")
        .addClass("bg-dark")
        .removeClass("bg-white");

    const addFormDeleteLink = (item) => {
        const container = document.createElement('div');
        container.classList.add("text-center");

        const removeFormButton = document.createElement('button');
        removeFormButton.classList.add("btn");
        removeFormButton.classList.add("btn-danger");
        removeFormButton.classList.add("rounded-corners");
        removeFormButton.innerHTML = '<i class="fas fa-minus"></i>&nbsp;Supprimer';

        container.appendChild(removeFormButton);
        item.append(container);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            // remove the li for the tag form
            item.remove();
        });
    }

    const addGoalFormToCollection = (e) => {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

        const item = document.createElement('li');

        item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            );

        collectionHolder.appendChild(item);

        collectionHolder.dataset.index++;
        addFormDeleteLink(item);
    };

    document
        .querySelectorAll('.add_goal_link')
        .forEach(btn => {
            btn.addEventListener("click", addGoalFormToCollection)
        });

    document
        .querySelectorAll('ul.goals li')
        .forEach((goal) => {
            addFormDeleteLink(goal)
        });

    const addImageFormToCollection = (e) => {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

        const item = document.createElement('li');

        item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            );

        collectionHolder.appendChild(item);

        collectionHolder.dataset.index++;
        addFormDeleteLink(item);
    };

    document
        .querySelectorAll('.add_image_link')
        .forEach(btn => {
            btn.addEventListener("click", addImageFormToCollection)
        });

    document
        .querySelectorAll('ul.images li')
        .forEach((image) => {
            addFormDeleteLink(image)
        })

    const generateFaqCategoryForm = (e) => {
        fetch('/dashboard/foire-aux-questions/creer-categorie')
            .then(response => response.text())
            .then(html => {
                const modal = document.getElementById('form_category');
                modal.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

    document
        .querySelectorAll('.add_faq_category_link')
        .forEach(btn => {
            btn.addEventListener("click", generateFaqCategoryForm)
        });

    document.querySelectorAll('.remove_category').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            var name = e.currentTarget.getAttribute("name");
            var jsondata = new FormData();
            jsondata.append("id", document.getElementById(name).getAttribute("value"));
            $.ajax({
                method: 'POST',
                url: '/dashboard/foire-aux-questions/supprimer-categorie',
                data: jsondata,
                processData: false,
                contentType: false,
                success: function (data) {
                    window.location.reload()
                }
            });
        });
    })

});