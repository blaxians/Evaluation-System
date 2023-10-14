<script>
    $(document).ready(function(){
        changePasswordUser();
    })

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
                    } else {
                        const {password_confirm, password_new, password_old} = res.error;
                        
                        if(res.error || password_old){
                            var err_msg = (res.error) ? 'Old ' + res.error : password_old;
                            Swal.fire('Error',
                            `${err_msg}`,
                            'error'
                            )
                        } else if (password_confirm){
                            Swal.fire('Error',
                            `${password_confirm}`,
                            'error'
                            )
                        } 
                        else if (password_new){
                            Swal.fire('Error',
                            `${password_new}`,
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

        $(document).on('click', '#btn_change_password_user', function(){
            $('#change_password_user').modal('hide');
            $('#change_password_form').trigger('reset');
        })
        $(document).on('hidden.bs.modal', '#change_password_user',function(){
            $('#change_password_user').modal('hide');
            $('#change_password_form_user').trigger('reset');
        })
    }
</script>