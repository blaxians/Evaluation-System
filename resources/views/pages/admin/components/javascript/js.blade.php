<script>
    $(document).ready(function(){
        changePassword();
        checkConfirmPassword();
    })

    function checkConfirmPassword() {
        $(document).on('input', '#password_confirm', function () {
            var confirmPass = $(this).val();
            var newPass = $('#password_new').val();
            var confirmAlert = $('#confirm_alert');

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
    function changePassword(){
        $(document).on('submit', '#change_password_form', function(e){
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
                    $('#change_password').modal('hide');
                    $('#change_password_form').trigger('reset');

                    } else {
                        const {password_confirm, password_new, password_old} = res.error;
                        
                        if (password_confirm){
                            Swal.fire('passconfirm',
                            `${password_confirm[0]}`,
                            'error'
                            )
                        } 
                        else if (password_new){
                            Swal.fire('passnew',
                            `${password_new[0]}`,
                            'error'
                            )
                        } else if(res.error){
                            
                            Swal.fire('error',
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

        $(document).on('hidden.bs.modal', '#change_password',function(){
            $('#change_password').modal('hide');
            $('#change_password_form').trigger('reset');
            $('#confirm_alert').text('');
            $('#confirm_alert').addClass('d-none');    
        })
    }
</script>