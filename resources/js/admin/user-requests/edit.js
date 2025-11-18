document.addEventListener('DOMContentLoaded', function () {
    const infraSelect = document.getElementById('infrastructure_object_id');
    const selectedInfraObjectId = infraSelect.value;

    function loadInfrastructureObjects(infraSelect) {
        fetch(`/dashboard/api/objects`)
            .then(response => response.json())
            .then(json => {
                if (!json.success || !Array.isArray(json.data)) {
                    throw new Error('Invalid data format');
                }

                infraSelect.innerHTML = '<option value="">Select an infrastructure object</option>';
                json.data.forEach(obj => {
                    const option = document.createElement('option');
                    option.value = obj.id;
                    option.textContent = obj.name + (obj.public_address ? ` (${obj.public_address})` : '');
                    infraSelect.appendChild(option);
                });

                if (selectedInfraObjectId) {
                    infraSelect.value = selectedInfraObjectId;
                }
                infraSelect.disabled = false;
            })
            .catch(() => {
                infraSelect.innerHTML = '<option value="">Failed to load</option>';
            });
    }

    loadInfrastructureObjects(infraSelect);
});
