export default function initFilter(selectId, queryParam = 'sub') {
    const filterSelect = document.getElementById(selectId);

    if (!filterSelect) return;

    const baseUrl = filterSelect.dataset.baseUrl || window.location.href; // fallback

    filterSelect.addEventListener('change', () => {
        applyFilter(filterSelect, baseUrl, queryParam);
    });
}

function applyFilter(selectElement, baseUrl, queryParam) {
    const currentUrl = new URL(window.location.href);
    const selectedValue = selectElement.value.trim();

    if (baseUrl !== window.location.href) {
        currentUrl.pathname = new URL(baseUrl, window.location.origin).pathname;
    }

    if (selectedValue) {
        currentUrl.searchParams.set(queryParam, selectedValue);
    } else {
        currentUrl.searchParams.delete(queryParam);
    }

    window.location.href = currentUrl.toString();
}
