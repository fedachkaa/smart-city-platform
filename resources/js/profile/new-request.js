document.addEventListener('DOMContentLoaded', function () {
    const infraSelect = document.getElementById('infrastructure_object_id');

    function uploadObjects () {
        fetch(`/profile/api/objects`)
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
    }

    uploadObjects();
});