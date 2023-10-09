<!-- Modal -->
<div class="modal fade" id="view_dean_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <h2 class="modal-title fw-semibold text-center my-3" id="view_dean_name"></h3>
            <div class="border-bottom"></div>
          <div class="my-2">
            <div class="mt-4">
                <p class="m-0 p-0 fw-semibold">Username: <span class="fw-medium" id="view_dean_username"></span></p>
                <p class="m-0 p-0 fw-semibold">Name: <span class="fw-medium" id="view_dean_name1"></span></p>
                <p class="m-0 p-0 fw-semibold">Status: <span class="badge" id="view_dean_status"></span></p>
            </div>
          </div>
          <div class="my-3">
            <div id="table_dean_view">
              {{-- faculty table here --}}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>