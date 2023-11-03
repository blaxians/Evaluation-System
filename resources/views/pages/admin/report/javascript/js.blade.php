<script>
    $(document).ready(function() {
        showReportFaculty();
        showCardInstitute();
        viewFacultyScore();
        viewDeanScore();


    })
    // //generate report
    // function generateReport(){
    //     $(document).on('submit', '#generate_report_form', function(e){
    //         e.preventDefault();
    //         const fd = new FormData(this);
    //         $.ajax({
    //             url: "{{ route('generatePdfStudent') }}",
    //             method: 'post',
    //             data: fd,
    //             processData:false,
    //             contentType: false,
    //             cache: false,
    //             success: function(res){
    //                 console.log(res);
    //                 // if(res.status == 'success'){
    //                 //     window.location.href = "{{ route('reportPdfStudent') }}";
    //                 // }

    //             }
    //         })
    //     })
    // }

   
    //show card institute
    function showCardInstitute() {
        $.ajax({
            url: "{{ route('card') }}",
            method: 'get',
            success: function(res) {
                $('#institute_card_report').html(res);
                $('#evaluation_report_title').text('Evaluation Report');
            }
        })
    }

    //show faculty data 
    function showReportFaculty() {
        $(document).on('click', '#btn_ca_show', function() {
            let insti_view = $(this).prev().text();
            $.ajax({
                url: "{{ route('show.report') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    insti: insti_view
                },
                success: function(res) {
                    $('#evaluation_report_title').text(insti_view);
                    $('#institute_card_report').html(res);
                    $('#table').DataTable();
                }
            })
        })
        $(document).on('click', '#btn_ias_view', function() {
            let insti_view = $(this).prev().text();
            $.ajax({
                url: "{{ route('show.report') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    insti: insti_view
                },
                success: function(res) {
                    $('#evaluation_report_title').text(insti_view);
                    $('#institute_card_report').html(res);
                    $('#table').DataTable();
                }
            })
        })
        $(document).on('click', '#btn_ieat_view', function() {
            let insti_view = $(this).prev().text();
            $.ajax({
                url: "{{ route('show.report') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    insti: insti_view
                },
                success: function(res) {
                    $('#evaluation_report_title').text(insti_view);
                    $('#institute_card_report').html(res);
                    $('#table').DataTable();
                }
            })
        })
        $(document).on('click', '#btn_ied_view', function() {
            let insti_view = $(this).prev().text();
            $.ajax({
                url: "{{ route('show.report') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    insti: insti_view
                },
                success: function(res) {
                    $('#evaluation_report_title').text(insti_view);
                    $('#institute_card_report').html(res);
                    $('#table').DataTable();
                }
            })
        })
        $(document).on('click', '#btn_im_view', function() {
            let insti_view = $(this).prev().text();
            $.ajax({
                url: "{{ route('show.report') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    insti: insti_view
                },
                success: function(res) {
                    $('#evaluation_report_title').text(insti_view);
                    $('#institute_card_report').html(res);
                    $('#table').DataTable();
                }
            })
        })

        $(document).on('click', '#btn_back_view', function() {
            showCardInstitute();
        })
    }

    //view faculty score evaluation
    function viewFacultyScore() {
        $(document).on('click', '#btn_view_student_score', function() {
            $('#view_faculties_score').modal('show');
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('viewFromStudent') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    if (res.btn_gen == '0') {
                        $('#btn_generate_report').prop('disabled', true);
                    } else {
                        $('#btn_generate_report').prop('disabled', false);
                    }
                    $('#view_faculty_score_table').html(res.faculties);
                    $('#naem_faculty').text(res.name);
                    $('#title_evaluation_generate').text('Evaluation from Student');
                    $('#hidden_id').val(res.faculties_detail['id'] + ',student');
                }
            })
        });
    }
    //view faculty score evaluation
    function viewDeanScore() {
        $(document).on('click', '#btn_view_dean_score', function() {
            $('#view_faculties_score').modal('show');
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('viewFromDean') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    if (res.btn_gen == '0') {
                        $('#btn_generate_report').prop('disabled', true);
                    } else {
                        $('#btn_generate_report').prop('disabled', false);
                    }
                    $('#view_faculty_score_table').html(res.faculties);
                    $('#naem_faculty').text(res.name);
                    $('#title_evaluation_generate').text('Evaluation from Dean');
                    $('#hidden_id').val(res.faculties_detail['id'] + ',dean');
                }, error: function(err){
                    console.log(err);
                }
            })
        });
    }
</script>
