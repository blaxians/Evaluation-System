<script>
     $(document).ready(function(){
        //default function
        resetCampusData();
        setActiveWhenClicked();
        disabledButton();
        $('table').DataTable();

     })

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
        $(document).on('click', '#campus_select_balagtas', function(){
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
        if($('#campus_select_balagtas').hasClass('active')){
            $('select.form-select.form-select-sm.d').prop('disabled', true);
            balagtasCampus();
            resetSelectOption();
        } 
     }

     function mainCampus(){
        $('#option_reset_institute').nextAll().remove();

        // set value of institute
        const institute_array = ['IEAT', 'IM', 'IED'];
        institute_array.forEach((name) => {
            $('#institute_select').append(`<option value="${name}">${name}</option>`);
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
            

            const main_course = ['BSIT', 'BSFT'];
            main_course.forEach((name) => {
                $('#course_select').append(`<option value="${name}">${name}</option>`);
                $('#course_select').prop('disabled', false);
            })
        })

        //set value of year level
        $(document).on('change', '#course_select', function(){
            disableWhenSelectCourse();
            $('#option_reset_year').nextAll().remove();
            let main_course = $(this).val();
            disabledButton();

            const main_year_level = ['1st Year', '2nd Year', '3rd Year'];
            main_year_level.forEach((name) => {
                $('#year_select').append(`<option value="${name}">${name}</option>`);
                $('#year_select').prop('disabled', false);
            })
        })

        //set value of section
        $(document).on('change', '#year_select', function(){
            disableWhenSelectYear();
            $('#option_reset_section').nextAll().remove();
            let main_year = $(this).val();
            disabledButton();

            const main_section = ['A', 'B', 'C'];
            main_section.forEach((name) => {
                $('#section_select').append(`<option value="${name}">${name}</option>`);
                $('#section_select').prop('disabled', false);
            })
        })

        //set disable of button
        $(document).on('change', '#section_select', function(){
            disabledButton();
        })

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

     function balagtasCampus(){
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