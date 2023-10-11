<div class="modal fade modal-lg" id="view_faculties_score" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h3 class="modal-title fw-semibold text-success" id="title_evaluation_generate">Generate Evaluation</h3>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="pb-4 border-bottom fs-5">Faculty Name: <span class="fw-semibold fs-5" id="naem_faculty">Gelo Mark Inducil</span></div>
                <div id="view_faculty_score_table"> 
                    {{-- table here --}}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                <button class="btn btn-success" id="btn_generate_report">Generate Report</button>
            </div>
        </div>
    </div>
</div>