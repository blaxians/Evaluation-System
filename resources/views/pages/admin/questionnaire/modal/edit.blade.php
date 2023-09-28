<!-- Edit -->
<div class="modal fade" id="edit_question" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-5" id="update_question_form">
                    @csrf
                    <input type="hidden" name="id" id="question_id">
                    <select class="form-select " aria-label="Default select example" name="criteria" id="question_select">
                        <option value="Teacher's Personality">Teacher's Personality
                        </option>
                        <option value="Classroom Management">Classroom Management
                        </option>
                        <option value="Knowledge of the Subject Matter">Knowledge of the Subject Matter
                        </option>
                        <option value="Teaching Skills">Teaching Skills
                        </option>
                        <option value="Skills in Evaluating the Students">Skills in Evaluating the Students
                        </option>
                        <option value="Attitude towards the Subject and the Students">
                            Attitude towards the Subject and the Students
                        </option>
                    </select>
                    <textarea name="question" id="question_textarea" class="form-control my-2" cols="30" rows="3"
                        placeholder="Question..." required></textarea>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="btn_question_save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit -->
