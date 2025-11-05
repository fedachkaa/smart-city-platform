document.addEventListener('DOMContentLoaded', function () {
    const districtSelect = document.getElementById('district_id');
    const infraSelect = document.getElementById('infrastructure_object_id');

    districtSelect.addEventListener('change', function () {
        const districtId = this.value;
        if (!districtId) return;

        fetch(`/profile/api/objects?district_id=${districtId}`)
            .then(res => res.json())
            .then(response => {
                const objects = response.data || [];

                infraSelect.innerHTML = '<option value="">Select Object (optional)</option>';
                objects.forEach(obj => {
                    const opt = document.createElement('option');
                    opt.value = obj.id;
                    opt.textContent = `${obj.name} ${obj.public_address.length ? ('(' + obj.public_address.length + ')') : ''}`;
                    infraSelect.appendChild(opt);
                });
            })
            .catch(err => console.error('Error loading objects:', err));
    });
});