//import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.addEventListener('DOMContentLoaded', () => {
    // Gestion de la navbar-burger
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    $navbarBurgers.forEach(el => {
        el.addEventListener('click', () => {
            const target = el.dataset.target;
            const $target = document.getElementById(target);
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
        });
    });

    // Gestion des modals
    const openModalButtons = document.querySelectorAll('[data-target]');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    openModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetModalId = button.getAttribute('data-target');
            const modal = document.getElementById(targetModalId);

            // S'assurer que l'élément est bien un modal
            if (modal && modal.classList.contains('modal')) {
                modal.classList.add('is-active');
            }
        });
    });

    closeModalButtons.forEach($close => {
        $close.addEventListener('click', () => {
            const modal = $close.closest('.modal');
            if (modal) {
                modal.classList.remove('is-active');
            }
        });
    });
});





/*
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("collection-input");
    const dataList = document.getElementById("collections-list");

    input.addEventListener("input", function () {
        const query = input.value.trim();
        if (query.length < 2) return;

        fetch(`/collection/search?q=${query}`)
            .then(response => response.json())
            .then(data => {
                dataList.innerHTML = "";
                data.items.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.text; // Affichage du nom de la collection
                    option.dataset.id = item.id; // ID stocké pour le back
                    dataList.appendChild(option);
                });
            })
            .catch(error => console.error("Erreur de chargement des collections :", error));
   });
});
 */
