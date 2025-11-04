document.addEventListener('DOMContentLoaded', () => {
    let currentPage = 1;
    let lastPage = 1;
    let totalRequests = 0;

    const container = document.getElementById('requests-container');
    const paginationInfo = document.getElementById('pagination-info');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    const getStatusColor = (status) => {
        switch (status.toLowerCase()) {
            case 'new': return 'bg-blue-100 text-blue-800';
            case 'in_progress': return 'bg-yellow-100 text-yellow-800';
            case 'resolved': return 'bg-green-100 text-green-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    };

    const renderRequest = (req) => {
        const div = document.createElement('div');
        div.className = 'bg-white shadow p-4 rounded border';
        const statusClass = getStatusColor(req.status);

        div.innerHTML = `
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">${req.title}</h3>
                <span class="px-2 py-1 rounded text-xs font-medium ${statusClass}">
                    ${req.status.replace('_', ' ')}
                </span>
            </div>
            <p class="text-gray-600 mt-2">${req.description ?? ''}</p>
            <p class="text-sm text-gray-500 mt-2">
                ${req.city?.name ?? ''} • ${req.district?.name ?? ''} •
                ${new Date(req.created_at).toLocaleDateString()}
            </p>
        `;
        container.appendChild(div);
    };

    const loadRequests = (page = 1) => {
        fetch(`/profile/api/requests?page=${page}`)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = '';
                data.data.forEach(renderRequest);

                currentPage = data.current_page;
                lastPage = data.last_page;
                totalRequests = data.total;

                paginationInfo.textContent = `Page ${currentPage} of ${lastPage} — Total: ${totalRequests} requests`;

                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === lastPage;
            })
            .catch(err => console.error('Error loading requests:', err));
    };

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) loadRequests(currentPage - 1);
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < lastPage) loadRequests(currentPage + 1);
    });

    loadRequests();
});
