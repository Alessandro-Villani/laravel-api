<div id="delete-modal" class="d-flex align-items-center justify-content-center d-none"></div>

<script>
    const deleteModal = document.getElementById('delete-modal')
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const projectName = form.dataset.projectName;
            deleteModal.innerHTML = 
            `<div class="card p-5">
                <h5 class="mb-5">Are you sure you want to delete <strong>'${projectName.toUpperCase()}'</strong>?</h5>
                <div class="buttons d-flex justify-content-center">
                    <button id="delete-yes" class="btn btn-small btn-success me-2">Yes</button>
                    <button id="delete-no" class="btn btn-small btn-danger">No</button>
                </div>
            </div>`
        const deleteNo = document.getElementById('delete-no')
        deleteNo.addEventListener('click', () => {
            deleteModal.classList.add('d-none');
        })
        const deleteYes = document.getElementById('delete-yes')
        deleteYes.addEventListener('click', () => {
            form.submit();
            deleteModal.classList.add('d-none');
        })
            deleteModal.classList.remove('d-none');
        })
    }) 
</script>