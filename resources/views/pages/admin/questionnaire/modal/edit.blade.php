<!-- Edit -->
<div class="modal fade" id="edit_question{{ $question->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit.questionnaire', $question->id) }}" method="post" class="px-5">
                    @csrf
                    @method('PATCH')
                    <select class="form-select  " aria-label="Default select example" name="criteria">
                        <option value="Teacher's Personality"
                            {{ $question->criteria === "Teacher's Personality" ? 'selected' : '' }}>Teacher's
                            Personality
                        </option>
                        <option value="Classroom Management"
                            {{ $question->criteria === 'Classroom Management' ? 'selected' : '' }}>Classroom Management
                        </option>
                        <option value="Knowledge of the Subject Matter"
                            {{ $question->criteria === 'Knowledge of the Subject Matter' ? 'selected' : '' }}>Knowledge
                            of the Subject Matter
                        </option>
                        <option value="Teaching Skills"
                            {{ $question->criteria === 'Teaching Skills' ? 'selected' : '' }}>Teaching Skills
                        </option>
                        <option value="Skills in Evaluating the Students"
                            {{ $question->criteria === 'Skills in Evaluating the Students' ? 'selected' : '' }}>Skills
                            in Evaluating the Students
                        </option>
                        <option value="Attitude towards the Subject and the Students"
                            {{ $question->criteria === 'Attitude towards the Subject and the Students' ? 'selected' : '' }}>
                            Attitude towards the Subject and the Students
                        </option>
                    </select>
                    <textarea name="question" id="" class="form-control my-2" cols="30" rows="3"
                        placeholder="Question..." required>{{ $question->question }}</textarea>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit -->
