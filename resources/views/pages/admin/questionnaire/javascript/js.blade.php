<script>
    $(document).ready(function() {
        addQuestion();
        showQuestion();
        viewQuestion();
        updateQuestion();
        removeQuestion();
        
    })

    //function add question
    function addQuestion() {
        $(document).on('submit', '#add_questionnaire', function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $('#btn_submit').text('Submitting..');

            $.ajax({
                url: "{{ route('post.questionnaire') }}",
                method: "post",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire(
                            'Added!',
                            'Question added successfully.',
                            'success'
                        );

                        $('#add_question_modal').modal('hide');
                        $('#btn_submit').text('Submit');
                        $('#add_questionnaire').trigger('reset');
                        showQuestion();
                    }
                }
            })

        })
    }

    //show questionnaire table
    function showQuestion() {
        $.ajax({
            url: "{{ route('show.questionnaire') }}",
            method: 'get',
            success: function(res) {
                $('#questionnaire_table').html(res);
                $('#table').DataTable();

            }
        })
    }

    //view question
    function viewQuestion() {
        $(document).on('click', '#questionnaire_btn_edit', function() {
            let id = $(this).attr('data-id');
            $('#edit_question').modal('show');

            $.ajax({
                url: "{{ route('view.questionnaire') }}",
                method: 'get',
                data: {id:id,
                _token: "{{ csrf_token() }}"},
                success: function(res){
                   const {id, question, criteria} = res;
                   
                    var $select = $('#question_select');
                    var optionExists = $select.find('option[value="' + criteria + '"]').length > 0;

                    if (optionExists) {
                        $select.val(criteria);
                    }

                    $('#question_textarea').val(question);
                    $('#question_id').val(id);

                }
            })
        })
    }

    //update question
    function updateQuestion(){
        $(document).on('submit', '#update_question_form', function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $('#btn_question_save').text('Saving...');

            $.ajax({
                url: "{{ route('edit.questionnaire') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res){
                   if(res == 'success'){
                    Swal.fire(
                        'Updated!',
                        'Question updated successfully.',
                        'success'
                    );
                    showQuestion();
                    $('#update_question_form').trigger('reset');
                    $('#btn_question_save').text('Save Changes');
                    $('#edit_question').modal('hide');
                    
                   } 
                }
            })
        })
    }

    //remove question
    function removeQuestion(){
        $(document).on('click', '#question_btn_delete', function(){
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete.questionnaire') }}",
                        method: 'post',
                        data: {id:id,
                        _token: "{{ csrf_token() }}"},
                        success: function(res){
                            if(res == 'success'){
                                Swal.fire(
                                    'Deleted!',
                                    'Question has been deleted.',
                                    'success'
                                )
                                showQuestion();
                            }
                        }
                    })
                  
                }
              })
        })
    }


</script>
