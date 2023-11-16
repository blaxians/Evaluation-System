<div class="modal fade modal-lg" id="topratedfacultys" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h3 class="modal-title">Faculty Information</h3>
                <button class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="pb-4 fs-5">Faculty Name: <span class="fw-semibold fs-5 text-capitalize"
                        id="naem_faculty_top_rateds"></span>
                </div>

                <div class="row my-2 px-2">
                    <div class="rounded-1 border p-2">
                        <h5>Ratings:</h5>
                        <div class="d-flex justify-content-evenly">
                            <p style="font-size:15px;">Outstanding (<span class="fw-bold">O</span>)</p>
                            <p style="font-size:15px;">Fairly Satisfactory (<span class="fw-bold">FS</span>)</p>
                            <p style="font-size:15px;">Satisfactory (<span class="fw-bold">S</span>)</p>
                            <p style="font-size:15px;">Very Satisfactory (<span class="fw-bold">VS</span>)</p>
                            <p style="font-size:15px;">Needs Improvement (<span class="fw-bold">NI</span>)</p>
                        </div>
                    </div>
                </div>

                <div id="view_faculty_score_table_top_rateds">
                    {{-- table here --}}

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>