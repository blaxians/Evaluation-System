<script>
    $(document).ready(function(){
        addDean();
        showDean();
        viewDean();
        updateDean();
        eventEditDean();
        confirmPassword();
        eventAddDean();
    })

    //add dean
    function addDean(){
        $(document).on('submit', '#deans_form', function(e){
            e.preventDefault();
            $('#dean_btn_submit').text('Adding..');
            const fd = new FormData(this);
            $.ajax({
                url: "{{ route('post.dean') }}",
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res == 'success'){
                        Swal.fire('Added!',
                        'Dean added successfully.',
                        'success');
                        $('#dean_btn_submit').text('Add Dean');
                        $('#add_dean').modal('hide');
                        $('#deans_form').trigger('reset');
                        showDean();
                    }
                }
            })
        })
    }

    //add dean event 
    function eventAddDean(){
        $(document).on('input', '#dean_username', function(){
            var username = $(this).val();
            if(username.length > 0){
                $('#onchange_username').text(username);
            } else {
                $('#onchange_username').text('username');
            }
        })

        $(document).on('hidden.bs.modal', '#add_dean', function(){
            $('#deans_form').trigger('reset');
            $('#onchange_username').text('username');
        })
    }



    //show dean
    function showDean(){
        $.ajax({
            url: "{{ route('show.dean') }}",
            method: 'get',
            success: function(res){
                $('#deans_table').html(res);
                $('#table').DataTable();
            }
        })
    }

    //view dean for update
    function viewDean(){
        $(document).on('click', '#edit_dean_btn', function(){
            $('#edit_dean').modal('show');
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('view.dean') }}",
                method: 'get',
                data: {id:id,
                _token: "{{ csrf_token() }}"},
                success: function(res){
                    const {id, name, username} = res;
                    $('#dean_id').val(id);
                    $('#username').val(username);
                    $('#name').val(name);
                }
                
            })
        })
    }

    //event form
    function eventEditDean(){
        $(document).on('hidden.bs.modal', '#edit_dean', function(){
            $('#deans_form_update').trigger('reset')
            $('#dean_btn_update').text('Update Dean');
            $('#password_note_container').addClass('d-none');
            $('#confirmed').removeClass('is-invalid');
        })
    }

    //confirm password
    function confirmPassword(){
        $(document).on('input', '#confirmed', function(){
            var value = $(this).val();
            var password = $('#password').val();
            if(value.length > 0){
                if(value == password){
                    $('#password_note_container').removeClass('d-none');
                    $('#password_note_container').removeClass('alert-danger');
                    $('#password_note_container').addClass('alert-success');
                    $('#password_note').text('Password matched!');
                    $('#confirmed').removeClass('is-invalid');
                    $('#confirmed').tooltip('dispose');
                } else if(value.length > 0){
                    $('#password_note_container').removeClass('d-none');
                    $('#password_note_container').removeClass('alert-success');
                    $('#password_note_container').addClass('alert-danger');
                    $('#password_note').text("Password doesn't matched!");
                    
                }
            } else {
                $('#password_note_container').addClass('d-none');
            }
        })
    }

    //update dean 
    function updateDean(){
        $(document).on('submit', '#deans_form_update', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $('#dean_btn_update').text('Updating..');
            $.ajax({
                url: "{{ route('edit.dean') }}",
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res){
                   if(res == 'success'){
                    Swal.fire('Updated!',
                    'Dean update successfully.',
                    'success');
                    $('#edit_dean').modal('hide');
                   } else {
                    $('#dean_btn_update').text('Update Dean');
                    $('#confirmed').tooltip('dispose');
                    $('#confirmed').attr('data-bs-title', res.error);
                    $('#confirmed').addClass('is-invalid');
                    $('#confirmed').focus();
                    $('#confirmed').tooltip('show');
                   }
                   showDean();
                }
            })

        })

        
    }

</script>