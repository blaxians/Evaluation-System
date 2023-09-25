<!-- Modal -->
<div class="modal fade" id="add_question" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('index.questionnaire') }}" method="post" class="px-5">
                    @csrf
                    <select class="form-select  " aria-label="Default select example" name="criteria">
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <textarea name="question" id="" class="form-control my-2" cols="30" rows="3"
                        placeholder="Question..." required></textarea>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
