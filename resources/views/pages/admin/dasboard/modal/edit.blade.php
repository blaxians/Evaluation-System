<div class="modal" id="edit_sem" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Semester</h3>
            </div>
            <form action="#" method="post" id="update_sem">
                @csrf
                <div class="modal-body bg-light">
                    <div class="mx-5">
                        <input type="hidden" id="semester_id" name="id">
                        <label for="year" class="fw-semibold">Semester:</label>
                        <select class="form-select" aria-label="Default select example" name="semester">
                            <option value="1" selected id="first_sem">1st Semester</option>
                            <option value="2" id="second_sem">2nd Semester</option>
                          </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="btn_update_sem">Update Sem</button>
                </div>
            </form>
        </div>
    </div>
</div>