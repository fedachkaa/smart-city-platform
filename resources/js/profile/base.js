document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.tab-button');
    const panes = document.querySelectorAll('.tab-pane');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            panes.forEach(pane => pane.classList.add('hidden'));
            document.getElementById(targetId)?.classList.remove('hidden');
            buttons.forEach(b => b.classList.remove('bg-cyan-200'));
            btn.classList.add('bg-cyan-200');
        });
    });

    if (panes.length > 0) {
        panes[0].classList.remove('hidden');
        buttons[0].classList.add('bg-cyan-200');
    }
});