<script>
    $(document).ready(function(){
        showStudent();
        viewStudent();

    })

    //show student
    function showStudent(){
        $.ajax({
            url: "{{ route('show.student') }}",
            method: 'get',
            success: function(res){
                $('#student_table').html(res);
                $('#table').DataTable();
            }

        })
    }

    //view student
    function viewStudent(){
        $(document).on('click', '#btn_view_button', function(){
            let view_id = $(this).attr('data-id');
            let view_status = $(this).attr('data-status');

            $.ajax({
                url: "{{ route('view.student') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    id:view_id,
                    status:view_status
                },
                success: function(res){

                    $('#view_student_name').text(res.student['name']);
                    $('#view_student_name1').text(res.student['name']);
                    $('#view_student_username').text(res.student['username']);
                    $('#table_faculty_view').html(res.faculty_table);
                    if(res.status == 'Done'){
                        $('#view_student_status').text(res.status);
                        $('#view_student_status').removeClass('text-bg-warning');
                        $('#view_student_status').addClass('text-bg-success');
                    } else {
                        $('#view_student_status').text(res.status);
                        $('#view_student_status').removeClass('text-bg-success');
                        $('#view_student_status').addClass('text-bg-warning');
                    }
                    
                }
            })
        })
    }



</script>