import './bootstrap';
import './chat';

document.getElementById('toggleSearch').addEventListener('click', function() {
    const searchContainer = document.getElementById('searchContainer');
    searchContainer.classList.toggle('open');
});

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});
