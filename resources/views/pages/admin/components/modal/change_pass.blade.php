<div class="modal fade" id="change_password" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-success">Change Password</h3>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="post" id="change_password_form">
                @csrf
                <div class="modal-body">
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" name="password_old" id="password_old" placeholder="Old Password" required>
                        <label for="password_old">Old Password</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="password" class="form-control" name="password_new" id="password_new" placeholder="New Password" required>
                        <label for="password_new">New Password</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Confirm Password" required>
                        <label for="password_confirm">Confirm Password</label>
                    </div>
                    <div class="alert d-none" role="alert" id="confirm_alert">
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="btn_changed_pssword">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>