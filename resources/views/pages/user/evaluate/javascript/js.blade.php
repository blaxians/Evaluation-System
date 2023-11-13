<script>
    $(document).ready(function(){
        ToggleCard();
        showQuestions();
        submitAnswer();
        checkBox();
       
    })
    //toggle card appearance
    function ToggleCard(){
        $(document).on('click', '#toggleCardBody', function(){
            $("#cardBody").toggleClass('collapse')
            $('#main_card').toggleClass('border-success');
            $('#card_header').toggleClass('border-success');
            $('#criteria_title').toggleClass('text-success');
            
            
            var svgIcon = $('#svg_carret').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
                `)
            } else if(svgIcon.hasClass("bi-caret-down-fill")) {
                $('#svg_carret').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill text-dark" viewBox="0 0 16 16">
                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                `)
            }
        })
        $(document).on('click', '#toggleCardBody_2', function(){
            $("#cardBody_2").toggleClass('collapse')
            $('#main_card_2').toggleClass('border-success');
            $('#card_header_2').toggleClass('border-success');
            $('#criteria_title_2').toggleClass('text-success');
            
            
            var svgIcon = $('#svg_carret_2').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret_2').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
                `)
            } else if(svgIcon.hasClass("bi-caret-down-fill")) {
                $('#svg_carret_2').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill text-dark" viewBox="0 0 16 16">
                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                `)
            }
        })
        $(document).on('click', '#toggleCardBody_3', function(){
            $("#cardBody_3").toggleClass('collapse')
            $('#main_card_3').toggleClass('border-success');
            $('#card_header_3').toggleClass('border-success');
            $('#criteria_title_3').toggleClass('text-success');
            
            
            var svgIcon = $('#svg_carret_3').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret_3').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
                `)
            } else if(svgIcon.hasClass("bi-caret-down-fill")) {
                $('#svg_carret_3').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill text-dark" viewBox="0 0 16 16">
                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                `)
            }
        })
        $(document).on('click', '#toggleCardBody_4', function(){
            $("#cardBody_4").toggleClass('collapse')
            $('#main_card_4').toggleClass('border-success');
            $('#card_header_4').toggleClass('border-success');
            $('#criteria_title_4').toggleClass('text-success');
            
            
            var svgIcon = $('#svg_carret_4').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret_4').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
                `)
            } else if(svgIcon.hasClass("bi-caret-down-fill")) {
                $('#svg_carret_4').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill text-dark" viewBox="0 0 16 16">
                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                `)
            }
        })
        $(document).on('click', '#toggleCardBody_5', function(){
            $("#cardBody_5").toggleClass('collapse')
            $('#main_card_5').toggleClass('border-success');
            $('#card_header_5').toggleClass('border-success');
            $('#criteria_title_5').toggleClass('text-success');
            
            
            var svgIcon = $('#svg_carret_5').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret_5').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
                `)
            } else if(svgIcon.hasClass("bi-caret-down-fill")) {
                $('#svg_carret_5').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill text-dark" viewBox="0 0 16 16">
                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
                `)
            }
        })
    }

    //showQuestions
    function showQuestions(){
        $.ajax({
            url: "{{ route('questions.user') }}",
            method: 'get',
            success: function(res){
                $('#criteria_1').html(res.criteria_1);
                $('#criteria_2').html(res.criteria_2);
                $('#criteria_3').html(res.criteria_3);
                $('#criteria_4').html(res.criteria_4);
                $('#criteria_5').html(res.criteria_5);
                $('#criteria_6').html(res.criteria_6);
            }
        })    
    }

    //function submit
    function submitAnswer() {
    $(document).on('submit', '#evaluation_form', function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        Swal.fire({
            title: "Review evaluation before submitting?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Submit now",
            denyButtonText: `Review`,
            allowOutsideClick: false 
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('evaluate.user') }}",
                        method: 'post',
                        data: fd,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: (res) => {
                            if(res == 'success'){
                                Swal.fire(
                                    'Evaluated!',
                                    'Faculty evaluated successfully.',
                                    'success'
                                )
                                window.location.href = '/evaluation';
                            }
                        }
                    })
                } else if (result.isDenied) {
                    $('html, body').animate({ scrollTop: 400 }, 'normal');
                }
            });

    });
}

//event for checkbox 
function checkBox(){
    $(document).on('click', '.form-check-label', function(){
        const radioInput = $(this).prev();
            if (radioInput.length) {
                radioInput.prop('checked', true);
            }
    })
        
}


            
    




</script>