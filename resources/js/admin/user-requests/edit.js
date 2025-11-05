document.addEventListener('DOMContentLoaded', function () {
    const districtSelect = document.getElementById('district_id');
    const infraSelect = document.getElementById('infrastructure_object_id');
    const selectedInfraObjectId = infraSelect.value;

    districtSelect.addEventListener('change', function () {
        const districtId = this.value;

        infraSelect.innerHTML = '<option>Loading...</option>';
        infraSelect.disabled = true;

        if (!districtId) {
            infraSelect.innerHTML = '<option value="">Select a district first</option>';
            return;
        }

        loadInfrastructureObjects(districtId, infraSelect)
    });

    function loadInfrastructureObjects(districtId, infraSelect) {
        fetch(`/dashboard/api/objects?district_id=` + districtId)
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

    loadInfrastructureObjects(districtSelect.value, infraSelect);
});
