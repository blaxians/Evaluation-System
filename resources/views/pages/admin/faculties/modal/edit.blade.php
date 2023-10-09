<!-- Modal -->
<div class="modal fade" id="edit_faculties" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Faculties</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-5" id="faculties_edit_form">
                    @csrf
                    <input type="hidden" name="id" id="faculties_id1">
                    <select class="form-select  " aria-label="Default select example" name="institute" id="faculties_institute">
                        <option value="College of Agriculture">College of Agriculture</option>
                        <option value="Institute of Arts and Sciences">Institute of Arts and Sciences</option>
                        <option value="Institute of Engineering and Applied Technology">Institute of Engineering and
                            Applied Technology</option>
                        <option value="Institute of Education">Institute of Education</option>
                        <option value="Institute of Management">Institute of Management</option>
                    </select>
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="employee_id1" name="employee_id" data-bs-placement="right">
                        <label for="floatingInput">Employee id</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="first_name1" name="first_name" data-bs-placement="right">
                        <label for="floatingInput">First name</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="middle_name1" name="middle_name" data-bs-placement="right">
                        <label for="floatingInput">Middle name</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="last_name1" name="last_name" data-bs-placement="right">
                        <label for="floatingInput">Last name</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="faculties_btn_update">Update Faculty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
