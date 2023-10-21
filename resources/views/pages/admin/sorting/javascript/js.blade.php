<script>
     $(document).ready(function(){
        getCampus();
        setActiveWhenClicked();
        disabledButton();
        $('table').DataTable();
        viewStudentSorting();
        resetPasswordSorting();
        scrollUpSorting();


     })
     //scroll to top
     function scrollUpSorting(){
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
            $('#scroll-to-top-button_sorting').fadeIn();
            } else {
            $('#scroll-to-top-button_sorting').fadeOut();
            }
        });

        $('#scroll-to-top-button_sorting').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 100);
            return false;
        });
    }

     //reset password 
    function resetPasswordSorting(){
        $(document).on('click','#btn_changepass_button_sorting',function(){
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
                    url: "{{ route('sorting.resetPassword') }}",
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

     function viewStudentSorting(){
        $(document).on('click', '#btn_view_button_sorting', function(){
            let view_id = $(this).data('id'); 
            let view_status = $(this).data('status'); 

            $.ajax({
                url: "{{ route('get.view') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    id:view_id,
                    status:view_status
                },
                success: function(res){

                    $('#view_student_name_sorting').text(res.student['name']);
                    $('#view_student_name1_sorting').text(res.student['name']);
                    $('#view_student_username_sorting').text(res.student['username']);
                    $('#table_faculty_view_sorting').html(res.faculty_table);
                    if(res.status == 'Done'){
                        $('#view_student_status_sorting').text(res.status);
                        $('#view_student_status_sorting').removeClass('text-bg-warning');
                        $('#view_student_status_sorting').addClass('text-bg-success');
                    } else {
                        $('#view_student_status_sorting').text(res.status);
                        $('#view_student_status_sorting').removeClass('text-bg-success');
                        $('#view_student_status_sorting').addClass('text-bg-warning');
                    }
                    
                }
            })
        })
    }

     //get campuses 
     function getCampus(){
        $.ajax({
            url: "{{ route('get.campus') }}",
            method: 'get',
            success: function(res){
                $('#campus_select_main').text(res[0]).attr('data-id', res[0]);
                $('#campus_select_btvc').text(res[1]).attr('data-id', res[1]);
                $('#campus_select_drt').text(res[2]).attr('data-id', res[2]);
                $('#campus_select_ffhnas').text(res[3]).attr('data-id', res[3]);
                resetCampusData();

            }, error: function(err){
                console.log(err);
            }
        })
     }

     function disabledButton(){
            let institute_select_value = $('#institute_select').val();
            let course_select_value = $('#course_select').val();
            let year_select_value = $('#year_select').val();
            let section_select_value = $('#section_select').val();
                
            if(institute_select_value.length && 
            course_select_value.length && 
            year_select_value.length && 
            section_select_value.length){
                $('#btn_filter_sorting').prop('disabled', false);
            } else {
                $('#btn_filter_sorting').prop('disabled', true);
            }
     }

     function resetSelectOption(){
        $('#institute_select').prop('selectedIndex', 0);
        $('#course_select').prop('selectedIndex', 0);
        $('#year_select').prop('selectedIndex', 0);
        $('#section_select').prop('selectedIndex', 0);

     }

     function setActiveWhenClicked(){
        $(document).on('click', '#campus_select_main', function(){
            $('ul li a').removeClass('active');
            $(this).addClass('active');
            resetCampusData();
            disabledButton();
        })
        $(document).on('click', '#campus_select_btvc', function(){
            $('ul li a').removeClass('active');
            $(this).addClass('active');
            resetCampusData();
            disabledButton();
        })
        $(document).on('click', '#campus_select_drt', function(){
            $('ul li a').removeClass('active');
            $(this).addClass('active');
            resetCampusData();
            disabledButton();
        })
        $(document).on('click', '#campus_select_ffhnas', function(){
            $('ul li a').removeClass('active');
            $(this).addClass('active');
            resetCampusData();
            disabledButton();
        })
     }
     
     //reset all when campus clicked
     function resetCampusData(){
        if($('#campus_select_main').hasClass('active')){
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            mainCampus();
            resetSelectOption();
        } 
        if($('#campus_select_btvc').hasClass('active')){
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            btvcCampus();
            resetSelectOption();
        } 
        if($('#campus_select_drt').hasClass('active')){
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            drtCampus();
            resetSelectOption();
        } 
        if($('#campus_select_ffhnas').hasClass('active')){
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            ffhnasCampus();
            resetSelectOption();
        } 
     }

     //BASC - Main Campus
     function mainCampus(){
        let main_campus = $('#campus_select_main').attr('data-id');        
        $('#option_reset_institute').nextAll().remove();

        //format institute long name
        function formatInstiName(nameparams){
            if(nameparams == 'BASC - FFHNAS Campus'){
                return 'FFHNAS';
            } else if(nameparams == 'College of Agriculture'){
                return 'CA';
            } else if(nameparams == 'Institute of Arts & Sciences'){
                return 'IAS';
            } else if(nameparams == 'Institute of Education'){
                return 'IED'
            }  else if(nameparams == 'Institute of Engineering and Applied Technology'){
                return 'IEAT'
            } else if (nameparams == 'Institute of Management'){
                return 'IM';
            } else {
                return nameparams;
            }
        }

        //set value of institute
        $.ajax({
            url: "{{ route('get.institute') }}",
            method: 'get',
            data:{
                _token: "{{ csrf_token() }}",
                campus: main_campus
            },
            success: function(res){
                res.forEach((name) => {
                    $('#institute_select').append(`<option value="${name}">
                        ${formatInstiName(name)}</option>`);
                })
            }, error: function(err){
                console.log(err);
            }
        })

        //disable other  selection when institute is changed
        function disableWhenSelectInstitute(){
            $('#course_select').prop('selectedIndex', 0);
            $('#year_select').prop('selectedIndex', 0);
            $('#section_select').prop('selectedIndex', 0);

            $('#year_select').prop('disabled', true);
            $('#section_select').prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectCourse(){
            $('#year_select').prop('selectedIndex', 0);
            $('#section_select').prop('selectedIndex', 0);
            
            $('#section_select').prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectYear(){
            $('#section_select').prop('selectedIndex', 0);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectSection(){
          
            $('#btn_filter_sorting').prop('disabled', true);
        }

        //set value of course
        $(document).on('change', '#institute_select', function(){
            disableWhenSelectInstitute();
            $('#option_reset_course').nextAll().remove();
            $('#option_reset_course').nextAll().remove();
            $('#option_reset_course').nextAll().remove();
            let main_insti = $(this).val();
            disabledButton();
            
            //set value of course
            $.ajax({
                url: "{{ route('get.courses') }}",
                method: 'get',
                data: {
                    _token: "csrf_token()",
                    main_insti: main_insti,
                    main_campus: main_campus
                },
                success: function(res){
                    res.forEach((name) => {
                        $('#course_select').append(`<option value="${name}">${name}</option>`);
                        $('#course_select').prop('disabled', false);
                    })
                }, error: (err) => {
                    console.log(err)
                }
            })
        })

        //set value of year level
        $(document).on('change', '#course_select', function(){
            disableWhenSelectCourse();
            $('#option_reset_year').nextAll().remove();
            let main_insti = $('#institute_select').val();
            let main_course = $(this).val();
            disabledButton();

            //set value of year level
            $.ajax({
                url: "{{ route('get.year_level') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: main_campus,
                    main_insti: main_insti,
                    main_course: main_course
                },
                success: function(res){
                    res.forEach((name) => {
                        $('#year_select').append(`<option value="${name}">${name}</option>`);
                        $('#year_select').prop('disabled', false);
                    })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set value of section
        $(document).on('change', '#year_select', function(){
            disableWhenSelectYear();
            $('#option_reset_section').nextAll().remove();
            let main_insti = $('#institute_select').val();
            let main_course = $('#course_select').val();
            let main_year = $(this).val();
            disabledButton();

            //set value of section
            $.ajax({
                url: "{{ route('get.section') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: main_campus,
                    main_insti: main_insti,
                    main_course: main_course,
                    main_year: main_year
                },
                success: function(res){
                    res.forEach((name) => {
                        $('#section_select').append(`<option value="${name}">${name}</option>`);
                        $('#section_select').prop('disabled', false);
                     })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set disable of button
        $(document).on('change', '#section_select', function(){
            disabledButton();
        })

        $(document).on('click', '#btn_filter_sorting', function() {
            let main_campus = $('#campus_select_main').attr('data-id');
            let main_institute = $('#institute_select').val();
            let main_course = $('#course_select').val();
            let main_year = $('#year_select').val();
            let main_section = $('#section_select').val();

            $.ajax({
                url: "{{ route('get.search') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: main_campus,
                    main_institute: main_institute,
                    main_course: main_course,
                    main_year: main_year,
                    main_section: main_section
                },
                success: function(res) {
                    const table = $('#student_table_sorting').DataTable({
                        destroy: true,
                        data: res,
                        columns: [
                            { data: 'name' },
                            { data: 'username' },
                            { data: 'program_name' },
                            { data: 'year_level' },
                            { data: 'sex' },
                            { data: 'status' },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    var buttons = '';

                                    if (row.status === 'Done' || row.actions) {
                                        buttons += '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" id="btn_view_button_sorting" data-bs-target="#view_student_modal_sorting" data-status="' + row.status + '" data-id="' + row.id + '"><i class="bi bi-eye-fill"></i></button>';
                                        buttons += '<button class="btn btn-success btn-sm" id="btn_changepass_button_sorting" data-id="' + row.id + '"><i class="bi bi-unlock-fill"></i></button>';
                                    }

                                    return buttons;
                                }
                            }
                        ],
                        createdRow: function (row, data, dataIndex) {
                            const status = data.status;

                            if (status === 'Done') {
                                $('td:eq(5)', row).addClass('text-success fw-semibold');
                            } else if (status === 'Pending') {
                                $('td:eq(5)', row).addClass('text-danger fw-semibold');
                            }
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });





     }

     function btvcCampus(){
        $('#option_reset_institute').nextAll().remove();
        

        // set value of institute
        const institute_array = ['IEAT', 'IM', 'IED'];
        institute_array.forEach((name) => {
            $('#institute_select').append(`<option value="${name}">${name}</option>`);
        })

        //set value of course
        $(document).on('change', '#institute_select', function(){
            $('#option_reset_course').nextAll().remove();
            let main_insti = $(this).val();
            
            const main_course = ['BSIT', 'BSFT'];
            main_course.forEach((name) => {
                $('#course_select').append(`<option value="${name}">${name}</option>`);
                $('#course_select').prop('disabled', false);
            })
        })

        //set value of year level
        $(document).on('change', '#course_select', function(){
            $('#option_reset_year').nextAll().remove();
            let main_course = $(this).val();

            const main_year_level = ['1st Year', '2nd Year', '3rd Year'];
            main_year_level.forEach((name) => {
                $('#year_select').append(`<option value="${name}">${name}</option>`);
                $('#year_select').prop('disabled', false);
            })
        })

        //set value of section
        $(document).on('change', '#year_select', function(){
            $('#option_reset_section').nextAll().remove();
            let main_year = $(this).val();

            const main_section = ['A', 'B', 'C'];
            main_section.forEach((name) => {
                $('#section_select').append(`<option value="${name}">${name}</option>`);
                $('#section_select').prop('disabled', false);
            })
        })
     }

     function drtCampus(){
        $('#option_reset_institute').nextAll().remove();
        

        // set value of institute
        const institute_array = ['IEAT', 'IM', 'IED'];
        institute_array.forEach((name) => {
            $('#institute_select').append(`<option value="${name}">${name}</option>`);
        })

        //set value of course
        $(document).on('change', '#institute_select', function(){
            $('#option_reset_course').nextAll().remove();
            let main_insti = $(this).val();
            
            const main_course = ['BSIT', 'BSFT'];
            main_course.forEach((name) => {
                $('#course_select').append(`<option value="${name}">${name}</option>`);
                $('#course_select').prop('disabled', false);
            })
        })

        //set value of year level
        $(document).on('change', '#course_select', function(){
            $('#option_reset_year').nextAll().remove();
            let main_course = $(this).val();

            const main_year_level = ['1st Year', '2nd Year', '3rd Year'];
            main_year_level.forEach((name) => {
                $('#year_select').append(`<option value="${name}">${name}</option>`);
                $('#year_select').prop('disabled', false);
            })
        })

        //set value of section
        $(document).on('change', '#year_select', function(){
            $('#option_reset_section').nextAll().remove();
            let main_year = $(this).val();

            const main_section = ['A', 'B', 'C'];
            main_section.forEach((name) => {
                $('#section_select').append(`<option value="${name}">${name}</option>`);
                $('#section_select').prop('disabled', false);
            })
        })
     }

     function ffhnasCampus(){
        $('#option_reset_institute').nextAll().remove();
        

        // set value of institute
        const institute_array = ['IEAT', 'IM', 'IED'];
        institute_array.forEach((name) => {
            $('#institute_select').append(`<option value="${name}">${name}</option>`);
        })

        //set value of course
        $(document).on('change', '#institute_select', function(){
            $('#option_reset_course').nextAll().remove();
            let main_insti = $(this).val();
            
            const main_course = ['BSIT', 'BSFT'];
            main_course.forEach((name) => {
                $('#course_select').append(`<option value="${name}">${name}</option>`);
                $('#course_select').prop('disabled', false);
            })
        })

        //set value of year level
        $(document).on('change', '#course_select', function(){
            $('#option_reset_year').nextAll().remove();
            let main_course = $(this).val();

            const main_year_level = ['1st Year', '2nd Year', '3rd Year'];
            main_year_level.forEach((name) => {
                $('#year_select').append(`<option value="${name}">${name}</option>`);
                $('#year_select').prop('disabled', false);
            })
        })

        //set value of section
        $(document).on('change', '#year_select', function(){
            $('#option_reset_section').nextAll().remove();
            let main_year = $(this).val();

            const main_section = ['A', 'B', 'C'];
            main_section.forEach((name) => {
                $('#section_select').append(`<option value="${name}">${name}</option>`);
                $('#section_select').prop('disabled', false);
            })
        })
     }
    



</script>