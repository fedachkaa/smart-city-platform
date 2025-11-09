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
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 rounded text-xs font-medium ${statusClass}">
                        ${req.status.replace('_', ' ')}
                    </span>
                    <button class="js-view-request text-gray-500 hover:text-cyan-600 transition" 
                        title="View Request" data-requestid="${req.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
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

    function loadRequestView(userRequestId) {
        fetch(`/profile/requests/${userRequestId}`)
            .then(res => res.text())
            .then(html => {
                const viewPane = document.getElementById('request-view');
                viewPane.innerHTML = html;
                document.getElementById('my-requests').classList.add('hidden');
                viewPane.classList.remove('hidden');

                viewPane.querySelector('#back-to-list').addEventListener('click', () => {
                    viewPane.classList.add('hidden');
                    document.getElementById('my-requests').classList.remove('hidden');
                });
            });
    }

    function initViewRequest() {
        document.addEventListener('click', (e) => {
            const viewBtn = e.target.closest('.js-view-request');
            if (!viewBtn) return;

            loadRequestView(viewBtn.dataset.requestid);
        });
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) loadRequests(currentPage - 1);
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < lastPage) loadRequests(currentPage + 1);
    });

    loadRequests();
    initViewRequest();

    const params = new URLSearchParams(window.location.search);
    const requestId = params.get('userRequestId');
    if (requestId) {
        loadRequestView(requestId);
        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, '', newUrl);
    }
});
