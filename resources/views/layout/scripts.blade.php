{{-- Bootstrap Cdn --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Font Awesome --}}
<script src="https://kit.fontawesome.com/54bcf78a4d.js" crossorigin="anonymous"></script>
{{-- Jquery --}}
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- Datatables --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

{{-- chart js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

{{-- Sweet Alert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- Sweet Alert Header --}}
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-1",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    $(document).ready(function() {
        checkConfirmPassword();
        changePasswordUser();

        checkConfirmPasswordAdmin();
        changePasswordAdmin();

        //function to collapse sidebar
        $(document).on('click', '#menu-toggle', () => {
            $('#wrapper').toggleClass('toggled');
        });

        //function dropdown
        $(".dropdown-btn").click(function() {

            $(this).toggleClass("active");

            var dropdownContent = $(this).next();

            if (dropdownContent.css("display") === "block") {
            dropdownContent.css("display", "none");
            } else {
            dropdownContent.css("display", "block");
            }

        
        });
    });

    function checkConfirmPassword() {
        $(document).on('input', '#password_confirm_user', function () {
            var confirmPass = $(this).val();
            var newPass = $('#password_new_user').val();
            var confirmAlert = $('#confirm_alert_password');

            if (confirmPass !== newPass && confirmPass.length > 0) {
                updateAlert(confirmAlert, 'Passwords do not match. Please try again.', 'alert-danger');
            } else {
                if (newPass.length > 0 && confirmPass.length > 0) {
                    updateAlert(confirmAlert, 'Passwords match! You can proceed.', 'alert-success');
                } else {
                    confirmAlert.addClass('d-none'); // Hide the message when both fields are empty
                }
            }
            });
        }

        function updateAlert(element, message, alertClass) {
            element.text(message);
            element.removeClass('d-none alert-danger alert-success');
            element.addClass(alertClass);
        }


    //function send change password
    function changePasswordUser(){
        $(document).on('submit', '#change_password_form_user', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: "{{ route('changePassword') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res){
                    
                    if(res == 'success'){
                        Swal.fire(
                            'Success!',
                            'Password updated successfully.',
                            'success'
                        )
                        $('#change_password_user').modal('hide');
                        $('#change_password_form').trigger('reset');
                    } else {
                        const {password_confirm, password_new, password_old} = res.error;
                        
                        if (password_confirm){
                            Swal.fire('Error!',
                            `${password_confirm[0]}`,
                            'error'
                            )
                        } 
                        else if (password_new){
                            Swal.fire('Error!',
                            `${password_new[0]}`,
                            'error'
                            )
                        } else if(res.error){
                            
                            Swal.fire('Error!',
                            `Old ${res.error}`,
                            'error'
                            )
                        }
                    }
                },
                error: function(err){
                    console.log(err);
                }
            })
        })


        $(document).on('hidden.bs.modal', '#change_password_user',function(){
            $('#change_password_user').modal('hide');
            $('#change_password_form_user').trigger('reset');
            $('#confirm_alert_password').text('');
            $('#confirm_alert_password').addClass('d-none');    

        })
    }

    function checkConfirmPasswordAdmin() {
        $(document).on('input', '#password_confirm_admin', function () {
            var confirmPass = $(this).val();
            var newPass = $('#password_new_admin').val();
            var confirmAlert = $('#confirm_alert_password');

            if (confirmPass !== newPass && confirmPass.length > 0) {
                updateAlert(confirmAlert, 'Passwords do not match. Please try again.', 'alert-danger');
            } else {
                if (newPass.length > 0 && confirmPass.length > 0) {
                    updateAlert(confirmAlert, 'Passwords match! You can proceed.', 'alert-success');
                } else {
                    confirmAlert.addClass('d-none'); 
                }
            }
            });
        }

        function updateAlert(element, message, alertClass) {
            element.text(message);
            element.removeClass('d-none alert-danger alert-success');
            element.addClass(alertClass);
        }


    //function send change password
    function changePasswordAdmin(){
        $(document).on('submit', '#change_password_form_admin', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
                url: "{{ route('changePassword') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res){
                    
                    if(res == 'success'){
                        Swal.fire(
                            'Success!',
                            'Password updated successfully.',
                            'success'
                        )
                        $('#change_password_admin').modal('hide');
                        $('#change_password_form_admin').trigger('reset');
                    } else {
                        const {password_confirm, password_new, password_old} = res.error;
                        
                        if (password_confirm){
                            Swal.fire('Error!',
                            `${password_confirm[0]}`,
                            'error'
                            )
                        } 
                        else if (password_new){
                            Swal.fire('Error!',
                            `${password_new[0]}`,
                            'error'
                            )
                        } else if(res.error){
                            
                            Swal.fire('Error!',
                            `Old ${res.error}`,
                            'error'
                            )
                        }
                    }
                },
                error: function(err){
                    console.log(err);
                }
            })
        })


        $(document).on('hidden.bs.modal', '#change_password_admin',function(){
            $('#change_password_admin').modal('hide');
            $('#change_password_form_admin').trigger('reset');
            $('#confirm_alert_password_admin').text('');
            $('#confirm_alert_password_admin').addClass('d-none');    

        })
    }
</script>
