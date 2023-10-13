<script>
    $(document).ready(function(){
        changePassword();
    })

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
                    }
                },
                error: function(err){
                    console.log(err);
                }
            })
        })

        $(document).on('click', '#btn_change_password', function(){
            $('#change_password').modal('hide');
            $('#change_password_form').trigger('reset');
        })
        $(document).on('hidden.bs.modal', '#change_password',function(){
            $('#change_password').modal('hide');
            $('#change_password_form').trigger('reset');
        })
    }
</script>