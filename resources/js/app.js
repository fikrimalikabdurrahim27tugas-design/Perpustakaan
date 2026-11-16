
import '../css/app.css';

// Mobile navigation
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.getElementById('navMenu');

if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });

    navMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('show');
        });
    });
}

// Book search
const searchForm = document.getElementById('searchForm');
const searchInput = document.getElementById('bookSearch');
const bookCards = document.querySelectorAll('.book-card');
const noResults = document.getElementById('noResults');

function filterBooks(keyword) {
    const search = keyword.toLowerCase().trim();
    let found = 0;

    bookCards.forEach(card => {
        const content = card.textContent.toLowerCase();
        const keywords = card.dataset.search || '';

        const matches =
            content.includes(search) ||
            keywords.toLowerCase().includes(search);

        card.hidden = !matches;

        if (matches) found++;
    });

    if (noResults) {
        noResults.hidden = found !== 0;
    }

    return found;
}

if (searchForm && searchInput) {
    searchForm.addEventListener('submit', event => {
        event.preventDefault();

        filterBooks(searchInput.value);

        document.getElementById('books')
            ?.scrollIntoView({ behavior: 'smooth' });
    });

    searchInput.addEventListener('input', () => {
        filterBooks(searchInput.value);
    });
}
