<script>
    $(document).ready(function(){
        showStudent();
        viewStudent();
        resetPassword();

    })

    //reset password 
    function resetPassword(){
        $(document).on('click','#btn_changepass_button',function(){
            let id = $(this).attr('data-id');
            Swal.fire({
            title: 'Are you sure?',
            text: "You wan to reset the password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('resetPassword.student') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id:id
                    },
                    success: function(res){
                        if(res == 'success'){
                            Swal.fire(
                                'Success!',
                                'Password has been reset.',
                                'success'
                                )
                        }
                    },
                    error: function(err){
                        console.log(err);
                    }
                })
            }
            })
        })
    }

    function showStudent() {
    $.ajax({
        url: "{{ route('show.student') }}",
        method: 'get',
        success: function(res) {
            $('#spinner_loader_stud').toggleClass('d-none');
            $('#student_table').toggleClass('d-none');
            var table = $('#student_table').DataTable({
                data: res.data,
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'username' },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                var statusText = row.status;
                                var statusClass = statusText === 'Done' ? 'text-success fw-semibold' : 'text-danger fw-semibold';
                                return '<span class="' + statusClass + '">' + statusText + '</span>';
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var buttons = '';

                            if (row.status === 'Done' || row.actions) {
                                buttons += '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#view_student_modal" id="btn_view_button" data-status="' + row.status + '" data-id="' + row.id + '"><i class="bi bi-eye-fill"></i></button>';
                                buttons += '<button class="btn btn-success btn-sm" id="btn_changepass_button" data-id="' + row.id + '"><i class="bi bi-unlock-fill"></i></button>';
                            }

                            return buttons;
                        }
                    },
                ],
                columnDefs: [
                    { targets: [4], className: 'center-align' }
                ]
            });
        }
    });
}



    //view student
    function viewStudent(){
        $(document).on('click', '#btn_view_button', function(){
            let view_id = $(this).data('id'); 
            let view_status = $(this).data('status'); 

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