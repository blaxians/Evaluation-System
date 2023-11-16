{{-- <div class="modal fade mt-2" id="add_professor" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Finalize your selection!</h3>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light" id="selected-items">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" id="btn_prof_confirm">Evaluate Now</button>
            </div>  
        </div>
    </div>
</div> --}}

<div class="modal fade" id="add_professor" data-bs-keyboard="false" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Finalize your selection!</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-light" id="selected-items">
            {{-- names and data here--}}
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" data-bs-target="#exampleModalToggle22" data-bs-toggle="modal" id="btn_prof_confirm">Evaluate Now</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModalToggle22" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-4" id="exampleModalToggleLabel2">Data Privacy</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3">
          <p class="font-monospace fw-semibold">This evaluation form is covered by the provisions of the Data Privacy and Protection regarding the collection, use, disclosure, and disposal of personal data collected from those who will participate in this online form. This is made in compliance with the Data Privacy Act of 2012 and its implementing rules and regulations. By accomplishing this form, you agree to share your personal data to the Office of Student Affairs & Services, and give consent to its processing which will be used in pursuit of its legitimate interests. After official use, the data will be expunged from our files or archived.</p>

          <div class="mt-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="data_privacy_radiobutton">
                <label class="form-check-label" for="data_privacy_radiobutton">
                  Agree
                </label>
              </div>
              
              
          </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" disabled id="btn_prof_confirm2">Accept</button>
        </div>
      </div>
    </div>
  </div>    