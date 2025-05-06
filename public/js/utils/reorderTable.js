export default function initTableSequenceReorder(elementId, routeUrl) {
    const tableBody = document.getElementById(elementId);
    if (!tableBody || !routeUrl) return;

    let dragSrcRow = null;

    tableBody.addEventListener('dragstart', (e) => {
        dragSrcRow = e.target;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', e.target.innerHTML);
        e.target.classList.add('opacity-50');
    });

    tableBody.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });

    tableBody.addEventListener('drop', (e) => {
        e.preventDefault();
        const targetRow = e.target.closest('tr');
        if (targetRow && dragSrcRow !== targetRow) {
            tableBody.insertBefore(dragSrcRow, targetRow.nextSibling || targetRow);
            dragSrcRow.classList.remove('opacity-50');
            updateOrderOnServer();
        }
    });

    tableBody.addEventListener('dragend', (e) => {
        e.target.classList.remove('opacity-50');
    });

    async function updateOrderOnServer() {
        const rows = document.querySelectorAll(`#${elementId} tr`);
        const orderedIds = [];

        rows.forEach((row, index) => {
            orderedIds.push(row.dataset.id);
            row.children[0].textContent = index + 1;
            row.children[2].textContent = index + 1;
        });

        const res = await fetch(routeUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ orderedIds })
        });

        const data = await res.json();
        if (data.success) {
            console.log("Order updated successfully!");
        } else {
            console.error("Order update failed:", data.message);
        }
    }
}
