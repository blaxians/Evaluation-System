<!-- Modal -->
<div class="modal fade" id="edit_dean" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Dean</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-5" id="deans_form_update">
                    @csrf
                    <input type="hidden" name="id" id="dean_id">
                    <div class="my-2">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" disabled>
                    </div>
                    <div class="my-2">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                    </div>
                    <div class="my-2">
                        <label for="name">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required
                        autocomplete="off">
                    </div>
                    <div class="my-2">
                        <label for="confirmed">Confirm Password:</label>
                        <input type="password" class="form-control" name="confirmed" id="confirmed" placeholder="Confirm Password"
                        autocomplete="off" data-bs-placement="right">
                    </div>

                      <div class="alert d-flex d-none align-items-center" role="alert" id="password_note_container">
                        <div id="password_note"></div>
                      </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="dean_btn_update">Update Dean</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
