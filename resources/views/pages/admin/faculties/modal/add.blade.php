<!-- Modal -->
<div class="modal fade" id="add_faculties" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Faculties</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-5" id="faculties_form">
                    @csrf
                    <select class="form-select  " aria-label="Default select example" name="institute">
                        <option value="College of Agriculture">College of Agriculture</option>
                        <option value="Institute of Arts and Sciences">Institute of Arts and Sciences</option>
                        <option value="Institute of Engineering and Applied Technology">Institute of Engineering and
                            Applied Technology</option>
                        <option value="Institute of Education">Institute of Education</option>
                        <option value="Institute of Management">Institute of Management</option>
                    </select>
                    <input type="text" class="form-control my-1" name="employee_id" placeholder="Employee ID">
                    <input type="text" class="form-control my-1" name="first_name" placeholder="First Name" required>
                    <input type="text" class="form-control my-1" name="middle_name" placeholder="Middle Name"
                        required>
                    <input type="text" class="form-control my-1" name="last_name" placeholder="Last Name" required>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="faculties_btn_submit">Add Faculty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
