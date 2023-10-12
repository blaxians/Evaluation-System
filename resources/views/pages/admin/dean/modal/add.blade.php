<!-- Modal -->
<div class="modal fade" id="add_dean" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Dean</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-5" id="deans_form">
                    @csrf
                    <select class="form-select " aria-label="Default select example" name="institute" id="dean_institute">
                        <option value="College of Agriculture">College of Agriculture</option>
                        <option value="Institute of Arts and Sciences">Institute of Arts and Sciences</option>
                        <option value="Institute of Engineering and Applied Technology">Institute of Engineering and
                            Applied Technology</option>
                        <option value="Institute of Education">Institute of Education</option>
                        <option value="Institute of Management">Institute of Management</option>
                    </select>

                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="dean_name" name="name" placeholder="Name" required>
                        <label for="dean_name">Name</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" maxlength="25" class="form-control" id="dean_username" name="username" id="dean_username" placeholder="Username" required>
                        <label for="dean_username">Username</label>
                    </div>
                    
                    <p class="">Note: <span id="onchange_username"
                        class="text-success fw-semibold">username</span> is the default password</>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="dean_btn_submit">Add Dean</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
