<script>
    $(document).ready(function() {
        addFaculties();
        showFaculties();
        viewFaculties();
        updateFaculties();
    })

    //add faculties
    function addFaculties(){
        $(document).on('submit', '#faculties_form', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $('#faculties_btn_submit').text('Adding..');

            $.ajax({
                url: "{{ route('post.faculties') }}",
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res == 'success'){
                        Swal.fire('Added!', 
                        'Faculty added successfully.',
                        'success');
                        $('#faculties_btn_submit').text('Add Faculty');
                        $('#faculties_form').trigger('reset');
                        $('#add_faculties').modal('hide');
                        showFaculties();
                    }
                }
            })
        })
    }

    //show faculties
    function showFaculties(){
        $.ajax({
            url: "{{ route('show.faculties') }}",
            method: 'get',
            success: function(res){
                $('#faculties_table').html(res);
                $('#table').DataTable();
            }
        })
    }

    //function view faculties for update
    function viewFaculties(){
        $(document).on('click', '#faculties_btn_edit', function(){
            let id = $(this).attr('data-id');
            $('#edit_faculties').modal('show');
            $.ajax({
                url: "{{ route('view.faculties') }}",
                method: 'get',
                data: {id:id,
                _token: "{{ csrf_token() }}"},
                success: function(res){
                    const {id, employee_id, first_name, middle_name, last_name, institute} = res;
                    var $select = $('#faculties_institute');
                    var optionExists = $select.find('option[value="' + institute + '"]').length > 0;
                    if (optionExists) {
                        $select.val(institute);
                    }
                    $('#faculties_id').val(id);
                    $('#employee_id').val(employee_id);
                    $('#first_name').val(first_name);
                    $('#middle_name').val(middle_name);
                    $('#last_name').val(last_name);

                }
            })
        })
    }

    //update faculties
    function updateFaculties(){
        $(document).on('submit', '#faculties_edit_form', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $('#faculties_btn_update').text('Updating..');
            $.ajax({
                url: "{{ route('edit.faculties') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res){
                    if(res == 'success'){
                        Swal.fire('Updated!',
                        'Faculties updated successfully.',
                        'success');
                        $('#edit_faculties').modal('hide');
                        $('#faculties_btn_update').text('Update Faculty');
                        showFaculties();
                    } else {
                        $('#faculties_btn_update').text('Update Faculty');
                        const {employee_id, first_name, middle_name, last_name} = res;
                        if(employee_id){
                            $('#employee_id').tooltip('dispose');
                            $('#employee_id').focus();
                            $('#employee_id').addClass('is-invalid');
                            $('#employee_id').attr('data-bs-title', employee_id);
                            $('#employee_id').tooltip('show');
                        } else if (first_name){
                            $('#first_name').tooltip('dispose');
                            $('#first_name').focus();
                            $('#first_name').addClass('is-invalid');
                            $('#first_name').attr('data-bs-title', first_name);
                            $('#first_name').tooltip('show');
                        }   else if (middle_name){
                            $('#middle_name').tooltip('dispose');
                            $('#middle_name').focus();
                            $('#middle_name').addClass('is-invalid');
                            $('#middle_name').attr('data-bs-title', middle_name);
                            $('#middle_name').tooltip('show');
                        }else if (last_name){
                            $('#last_name').tooltip('dispose');
                            $('#last_name').focus();
                            $('#last_name').addClass('is-invalid');
                            $('#last_name').attr('data-bs-title', last_name);
                            $('#last_name').tooltip('show');
                        }
                    }
                   

                }
            })
        })

        $(document).on('hidden.bs.modal', '#edit_faculties', function(){
            $('#employee_id').tooltip('dispose');
            $('#employee_id').removeClass('is-invalid');
            $('#first_name').tooltip('dispose');
            $('#first_name').removeClass('is-invalid');
            $('#middle_name').tooltip('dispose');
            $('#middle_name').removeClass('is-invalid');
            $('#last_name').tooltip('dispose');
            $('#last_name').removeClass('is-invalid');
            $('#faculties_edit_form').trigger('reset');
        })
    }

    
    

</script>