<script>
     $(document).ready(function(){
        getCampus();
        setActiveWhenClicked();
        disabledButton();
        disableSelection();
        $('table').DataTable();
        viewStudentSorting();
        resetPasswordSorting();
        scrollUpSorting();


     })
    //default functions
        //change coolor intitute
        function changeColor(){
            const campuses = $('#sorting_campuses ul li').children();
            $.each(campuses, (index, data) => {
                if($(`#${data.id}`).hasClass('active')){
                    $(`#${data.id}`).addClass('text-dark fw-semibold')
                    $(`#${data.id}`).removeClass('text-muted')
                } else {
                    $(`#${data.id}`).removeClass('text-dark fw-semibold')
                    $(`#${data.id}`).addClass('text-muted')
                }
            })
        } 


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

        //reset password student
        function resetPasswordSorting(){
            $('#student_table_sorting').on('click','#btn_changepass_button_sorting',function(){
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

        //view student status if done or not modal
        function viewStudentSorting(){
            $('#student_table_sorting').on('click', '#btn_view_button_sorting', function(){
                
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
                        
                    }, error: function(err){
                        console.log(err)
                    }
                })
            })
        }
    //default functions end

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

            }, error: function(err){
                console.log(err);
            }
        })
     }
     function disableSelection(){
        //disable selection button when none of campuses are clicked
        const sorting_campuses_children = $('#sorting_campuses ul li.nav-item').children().hasClass('active');
        if(!sorting_campuses_children){
            const selection_student_filter = $('#sorting_filter_student div.col').children().get();
            selection_student_filter.map((data) => {
                $(`#${data.id}`).prop('disabled', true); 
            }) 
        } else {
            const selection_student_filter = $('#sorting_filter_student div.col').children().get();
            selection_student_filter.map((data) => {
                $(`#${data.id}`).prop('disabled', false); 
            }) 
            
        }
     }

     //disable filter sorting button
     function disabledButton(){
            //disable filter button 
            let institute_select_value = $(`#${insti_id}`).val();
            let course_select_value = $(`#${course_id}`).val();
            let year_select_value = $(`#${year_id}`).val();
            let section_select_value = $(`#${section_id}`).val();
                
            if(institute_select_value.length && 
            course_select_value.length && 
            year_select_value.length && 
            section_select_value.length){
                $('#btn_filter_sorting').prop('disabled', false);
            } else {
                $('#btn_filter_sorting').prop('disabled', true);
            }
     }

    //reset selection button to default 
     function resetSelectOption(){

        $(`#${insti_id}`).prop('selectedIndex', 0);
        $(`#${course_id}`).prop('selectedIndex', 0);
        $(`#${year_id}`).prop('selectedIndex', 0);
        $(`#${section_id}`).prop('selectedIndex', 0);
     }

     //campuses on click functions
     function setActiveWhenClicked(){
        
        $('#sorting_campuses').on('click', '#campus_select_main', function(){
            

            const sorting_student_id = $('#sorting_filter_student div.col').children().get();
            sorting_student_id.map((data, index) => {
                var value = data;
                var $value = $(value);
                var Attr = $value.attr('data-id');
                $(`[data-id='${Attr}']`).attr('id', `${index}_main`);
            })
            insti_id = $(`[data-id='institute']`).attr('id');
            course_id = $(`[data-id='course']`).attr('id');
            year_id = $(`[data-id='year']`).attr('id');
            section_id = $(`[data-id='section']`).attr('id');
            
            $('ul li a').removeClass('active');
            $(this).addClass('active');
            disableSelection();
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            mainCampus();
            resetSelectOption();
            disabledButton();
            changeColor();
        })
        $('#sorting_campuses').on('click', '#campus_select_btvc', function(){
            const sorting_student_id = $('#sorting_filter_student div.col').children().get();
            sorting_student_id.map((data, index) => {
                const index_10 = index + 10;
                var value = data;
                var $value = $(value);
                var Attr = $value.attr('data-id');
                $(`[data-id='${Attr}']`).attr('id', `${index_10}_btvc`);
            })
            insti_id = $(`[data-id='institute']`).attr('id');
            course_id = $(`[data-id='course']`).attr('id');
            year_id = $(`[data-id='year']`).attr('id');
            section_id = $(`[data-id='section']`).attr('id');

            $('ul li a').removeClass('active');
            $(this).addClass('active');
            disableSelection();
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            btvcCampus();
            resetSelectOption();
            disabledButton();
            changeColor();
        })
        $('#sorting_campuses').on('click', '#campus_select_drt', function(){
            const sorting_student_id = $('#sorting_filter_student div.col').children().get();
            sorting_student_id.map((data, index) => {
                const index_20 = index + 20;
                var value = data;
                var $value = $(value);
                var Attr = $value.attr('data-id');
                $(`[data-id='${Attr}']`).attr('id', `${index_20}_drt`);
            })
            insti_id = $(`[data-id='institute']`).attr('id');
            course_id = $(`[data-id='course']`).attr('id');
            year_id = $(`[data-id='year']`).attr('id');
            section_id = $(`[data-id='section']`).attr('id');

            $('ul li a').removeClass('active');
            $(this).addClass('active');
            disableSelection();
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            drtCampus();
            resetSelectOption();
            disabledButton();
            changeColor();

        })
        $('#sorting_campuses').on('click', '#campus_select_ffhnas', function(){
            const sorting_student_id = $('#sorting_filter_student div.col').children().get();
            sorting_student_id.map((data, index) => {
                const index_30 = index + 30;
                var value = data;
                var $value = $(value);
                var Attr = $value.attr('data-id');
                $(`[data-id='${Attr}']`).attr('id', `${index_30}_ffhnas`);
            })
            insti_id = $(`[data-id='institute']`).attr('id');
            course_id = $(`[data-id='course']`).attr('id');
            year_id = $(`[data-id='year']`).attr('id');
            section_id = $(`[data-id='section']`).attr('id');

            $('ul li a').removeClass('active');
            $(this).addClass('active');
            disableSelection();
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            ffhnasCampus();
            resetSelectOption();
            disabledButton();
            changeColor();

        })
     }

     //global variable
     var insti_id = $(`[data-id='institute']`).attr('id');
     var course_id = $(`[data-id='course']`).attr('id');
     var year_id = $(`[data-id='year']`).attr('id');
     var section_id = $(`[data-id='section']`).attr('id');

     //BASC - Main Campus start
     function mainCampus(){
        
        let main_campus = $('#campus_select_main').attr('data-id');        
        
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
                $('#option_reset_institute').nextAll().remove();
                res.forEach((name) => {

                    $(`#${insti_id}`).append(`<option value="${name}">
                        ${formatInstiName(name)}</option>`);
                })
            }, error: function(err){
                console.log(err);
            }
        })

        setValueMainFilter();

        
     }

     function setValueMainFilter(){
        //set value of main course

        $('#sorting_filter_student').off('change', `#${insti_id}`).on('change',`#${insti_id}`, function(){
                disableWhenSelectInstitute();
                let main_campus = $('#campus_select_main').attr('data-id');
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
                        $('#option_reset_course').nextAll().remove();
                        
                        res.forEach((name) => {
                            $(`#${course_id}`).append(`<option value="${name}">${name}</option>`);
                            $(`#${course_id}`).prop('disabled', false);
                        })
                    }, error: (err) => {
                        console.log(err)
                    }
                })
        })

        //set value of main year level
        $('#sorting_filter_student').off('change', `#${course_id}`).on('change', `#${course_id}`, function(){
            disableWhenSelectCourse();
            let main_campus = $('#campus_select_main').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
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
                    $('#option_reset_year').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${year_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${year_id}`).prop('disabled', false);
                    })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set value of main section
        $('#sorting_filter_student').off('change', `#${year_id}`).on('change', `#${year_id}`, function(){
            disableWhenSelectYear();
            let main_campus = $('#campus_select_main').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
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
                    $('#option_reset_section').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${section_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${section_id}`).prop('disabled', false);
                        })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set disable of button
        $('#sorting_filter_student').off('change', `#${section_id}`).on('change',`#${section_id}`, function(){
            disabledButton();
        })

        //button sorting
        $(document).off('click', '#btn_filter_sorting').on('click', '#btn_filter_sorting', function() {
            changeColor();
            let main_campus = $('#campus_select_main').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(`#${year_id}`).val();
            let main_section = $(`#${section_id}`).val();

            $.ajax({
                url: "{{ route('get.search') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: main_campus,
                    main_institute: main_insti,
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

        //disable other  selection when institute is changed
        function disableWhenSelectInstitute(){
            $(`#${course_id}`).prop('selectedIndex', 0);
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);

            $(`#${year_id}`).prop('disabled', true);
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectCourse(){
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);
            
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectYear(){
            $(`#${section_id}`).prop('selectedIndex', 0);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectSection(){
            
            $('#btn_filter_sorting').prop('disabled', true);
        }
     }
     
     //btvcCampus
     function btvcCampus(){
        
        let btvc_campus = $('#campus_select_btvc').attr('data-id');        
        
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
                campus: btvc_campus
            },
            success: function(res){
                $('#option_reset_institute').nextAll().remove();
                res.forEach((name) => {

                    $(`#${insti_id}`).append(`<option value="${name}">
                        ${formatInstiName(name)}</option>`);
                })
            }, error: function(err){
                console.log(err);
            }
        })

        setValueMainFilterBtvc();
   
     }

     function setValueMainFilterBtvc(){
        //set value of main course
       

        $('#sorting_filter_student').off('change', `#${insti_id}`).on('change',`#${insti_id}`, function(){
                disableWhenSelectInstitute();
                let btvc_campus = $('#campus_select_btvc').attr('data-id');
                let main_insti = $(this).val();
                
                
                disabledButton();
                
                //set value of course
                $.ajax({
                    url: "{{ route('get.courses') }}",
                    method: 'get',
                    data: {
                        _token: "csrf_token()",
                        main_insti: main_insti,
                        main_campus: btvc_campus
                    },
                    success: function(res){
                        $('#option_reset_course').nextAll().remove();
                        
                        res.forEach((name) => {
                            $(`#${course_id}`).append(`<option value="${name}">${name}</option>`);
                            $(`#${course_id}`).prop('disabled', false);
                        })
                    }, error: (err) => {
                        console.log(err)
                    }
                })
        })


        //set value of main year level
        $('#sorting_filter_student').off('change', `#${course_id}`).on('change', `#${course_id}`, function(){
            disableWhenSelectCourse();
            let btvc_campus = $('#campus_select_btvc').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(this).val();
            
            disabledButton();

            //set value of year level
            $.ajax({
                url: "{{ route('get.year_level') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: btvc_campus,
                    main_insti: main_insti,
                    main_course: main_course
                },
                success: function(res){
                    $('#option_reset_year').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${year_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${year_id}`).prop('disabled', false);
                    })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set value of main section
        $('#sorting_filter_student').off('change', `#${year_id}`).on('change', `#${year_id}`, function(){
            disableWhenSelectYear();
            let btvc_campus = $('#campus_select_btvc').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(this).val();
           
            disabledButton();

            //set value of section
            $.ajax({
                url: "{{ route('get.section') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: btvc_campus,
                    main_insti: main_insti,
                    main_course: main_course,
                    main_year: main_year
                },
                success: function(res){
                    $('#option_reset_section').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${section_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${section_id}`).prop('disabled', false);
                        })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set disable of button
        $('#sorting_filter_student').off('change', `#${section_id}`).on('change',`#${section_id}`, function(){
            disabledButton();
        })

        //button sorting
        $(document).off('click', '#btn_filter_sorting').on('click', '#btn_filter_sorting', function() {
            let btvc_campus = $('#campus_select_btvc').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(`#${year_id}`).val();
            let main_section = $(`#${section_id}`).val();

            $.ajax({
                url: "{{ route('get.search') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: btvc_campus,
                    main_institute: main_insti,
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

        //disable other  selection when institute is changed
        function disableWhenSelectInstitute(){
            $(`#${course_id}`).prop('selectedIndex', 0);
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);

            $(`#${year_id}`).prop('disabled', true);
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectCourse(){
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);
            
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectYear(){
            $(`#${section_id}`).prop('selectedIndex', 0);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectSection(){
            
            $('#btn_filter_sorting').prop('disabled', true);
        }
     }

     //drtCampus
     function drtCampus(){
        
        let drt_campus = $('#campus_select_drt').attr('data-id');        
        
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
                campus: drt_campus
            },
            success: function(res){
                $('#option_reset_institute').nextAll().remove();
                res.forEach((name) => {

                    $(`#${insti_id}`).append(`<option value="${name}">
                        ${formatInstiName(name)}</option>`);
                })
            }, error: function(err){
                console.log(err);
            }
        })

        setValueMainFilterDrt();
   
     }

     function setValueMainFilterDrt(){
        //set value of main course
    

        $('#sorting_filter_student').off('change', `#${insti_id}`).on('change',`#${insti_id}`, function(){
                disableWhenSelectInstitute();
                let drt_campus = $('#campus_select_drt').attr('data-id');
                let main_insti = $(this).val();
                
                disabledButton();
                
                //set value of course
                $.ajax({
                    url: "{{ route('get.courses') }}",
                    method: 'get',
                    data: {
                        _token: "csrf_token()",
                        main_insti: main_insti,
                        main_campus: drt_campus
                    },
                    success: function(res){
                        $('#option_reset_course').nextAll().remove();
                        
                        res.forEach((name) => {
                            $(`#${course_id}`).append(`<option value="${name}">${name}</option>`);
                            $(`#${course_id}`).prop('disabled', false);
                        })
                    }, error: (err) => {
                        console.log(err)
                    }
                })
        })


        //set value of main year level
        $('#sorting_filter_student').off('change', `#${course_id}`).on('change', `#${course_id}`, function(){
            disableWhenSelectCourse();
            let drt_campus = $('#campus_select_drt').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(this).val();
            
            disabledButton();

            //set value of year level
            $.ajax({
                url: "{{ route('get.year_level') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: drt_campus,
                    main_insti: main_insti,
                    main_course: main_course
                },
                success: function(res){
                    $('#option_reset_year').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${year_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${year_id}`).prop('disabled', false);
                    })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set value of main section
        $('#sorting_filter_student').off('change', `#${year_id}`).on('change', `#${year_id}`, function(){
            disableWhenSelectYear();
            let drt_campus = $('#campus_select_drt').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(this).val();
           
            disabledButton();

            //set value of section
            $.ajax({
                url: "{{ route('get.section') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: drt_campus,
                    main_insti: main_insti,
                    main_course: main_course,
                    main_year: main_year
                },
                success: function(res){
                    $('#option_reset_section').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${section_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${section_id}`).prop('disabled', false);
                        })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set disable of button
        $('#sorting_filter_student').off('change', `#${section_id}`).on('change',`#${section_id}`, function(){
            disabledButton();
        })

        //button sorting
        $(document).off('click', '#btn_filter_sorting').on('click', '#btn_filter_sorting', function() {
            let drt_campus = $('#campus_select_drt').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(`#${year_id}`).val();
            let main_section = $(`#${section_id}`).val();

            $.ajax({
                url: "{{ route('get.search') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: drt_campus,
                    main_institute: main_insti,
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

        //disable other  selection when institute is changed
        function disableWhenSelectInstitute(){
            $(`#${course_id}`).prop('selectedIndex', 0);
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);

            $(`#${year_id}`).prop('disabled', true);
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectCourse(){
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);
            
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectYear(){
            $(`#${section_id}`).prop('selectedIndex', 0);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectSection(){
            
            $('#btn_filter_sorting').prop('disabled', true);
        }
     }

     //ffhnasCampus
     function ffhnasCampus(){
        
        let ffhnas_campus = $('#campus_select_ffhnas').attr('data-id');        
        
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
                campus: ffhnas_campus
            },
            success: function(res){
                $('#option_reset_institute').nextAll().remove();
                res.forEach((name) => {

                    $(`#${insti_id}`).append(`<option value="${name}">
                        ${formatInstiName(name)}</option>`);
                })
            }, error: function(err){
                console.log(err);
            }
        })

        setValueMainFilterFfhnas();
   
     }

     function setValueMainFilterFfhnas(){
        //set value of main course


        $('#sorting_filter_student').off('change', `#${insti_id}`).on('change',`#${insti_id}`, function(){
                disableWhenSelectInstitute();
                let ffhnas_campus = $('#campus_select_ffhnas').attr('data-id');
                let main_insti = $(this).val();
                
                
                disabledButton();
                
                //set value of course
                $.ajax({
                    url: "{{ route('get.courses') }}",
                    method: 'get',
                    data: {
                        _token: "csrf_token()",
                        main_insti: main_insti,
                        main_campus: ffhnas_campus
                    },
                    success: function(res){
                        $('#option_reset_course').nextAll().remove();
                        
                        res.forEach((name) => {
                            $(`#${course_id}`).append(`<option value="${name}">${name}</option>`);
                            $(`#${course_id}`).prop('disabled', false);
                        })
                    }, error: (err) => {
                        console.log(err)
                    }
                })
        })


        //set value of main year level
        $('#sorting_filter_student').off('change', `#${course_id}`).on('change', `#${course_id}`, function(){
            disableWhenSelectCourse();
            let ffhnas_campus = $('#campus_select_ffhnas').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(this).val();
            
            disabledButton();

            //set value of year level
            $.ajax({
                url: "{{ route('get.year_level') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: ffhnas_campus,
                    main_insti: main_insti,
                    main_course: main_course
                },
                success: function(res){
                    $('#option_reset_year').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${year_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${year_id}`).prop('disabled', false);
                    })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set value of main section
        $('#sorting_filter_student').off('change', `#${year_id}`).on('change', `#${year_id}`, function(){
            disableWhenSelectYear();
            let ffhnas_campus = $('#campus_select_ffhnas').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(this).val();
           
            disabledButton();

            //set value of section
            $.ajax({
                url: "{{ route('get.section') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: ffhnas_campus,
                    main_insti: main_insti,
                    main_course: main_course,
                    main_year: main_year
                },
                success: function(res){
                    $('#option_reset_section').nextAll().remove();
                    res.forEach((name) => {
                        $(`#${section_id}`).append(`<option value="${name}">${name}</option>`);
                        $(`#${section_id}`).prop('disabled', false);
                        })
                }, error: function(err){
                    console.log(err);
                }
            })
            
        })

        //set disable of button
        $('#sorting_filter_student').off('change', `#${section_id}`).on('change',`#${section_id}`, function(){
            disabledButton();
        })

        //button sorting
        $(document).off('click', '#btn_filter_sorting').on('click', '#btn_filter_sorting', function() {
            let ffhnas_campus = $('#campus_select_ffhnas').attr('data-id');
            let main_insti = $(`#${insti_id}`).val();
            let main_course = $(`#${course_id}`).val();
            let main_year = $(`#${year_id}`).val();
            let main_section = $(`#${section_id}`).val();

            $.ajax({
                url: "{{ route('get.search') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    main_campus: ffhnas_campus,
                    main_institute: main_insti,
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

        //disable other  selection when institute is changed
        function disableWhenSelectInstitute(){
            $(`#${course_id}`).prop('selectedIndex', 0);
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);

            $(`#${year_id}`).prop('disabled', true);
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectCourse(){
            $(`#${year_id}`).prop('selectedIndex', 0);
            $(`#${section_id}`).prop('selectedIndex', 0);
            
            $(`#${section_id}`).prop('disabled', true);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectYear(){
            $(`#${section_id}`).prop('selectedIndex', 0);
        }
        //disable other  selection when institute is changed
        function disableWhenSelectSection(){
            
            $('#btn_filter_sorting').prop('disabled', true);
        }
     }
    
</script>