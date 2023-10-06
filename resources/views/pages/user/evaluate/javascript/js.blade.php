<script>
    $(document).ready(function(){
        ToggleCard();
        showQuestions();
        submitAnswer();
       
    })
    //toggle card appearance
    function ToggleCard(){
        $(document).on('click', '#toggleCardBody', function(){
            $("#cardBody").toggleClass('collapse')
            $('#main_card').toggleClass('border-primary');
            $('#card_header').toggleClass('border-primary');
            $('#criteria_title').toggleClass('text-primary');
            
            
            var svgIcon = $('#svg_carret').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-primary" viewBox="0 0 16 16">
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
            $('#main_card_2').toggleClass('border-primary');
            $('#card_header_2').toggleClass('border-primary');
            $('#criteria_title_2').toggleClass('text-primary');
            
            
            var svgIcon = $('#svg_carret_2').find("svg");

            if (svgIcon.hasClass("bi-caret-right-fill")){
                $('#svg_carret_2').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-primary" viewBox="0 0 16 16">
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
    }

    //showQuestions
    function showQuestions(){
        $.ajax({
            url: "{{ route('questions.user') }}",
            method: 'get',
            success: function(res){
                $('#criteria_1').html(res.criteria_1);
                $('#criteria_2').html(res.criteria_2);
            }
        })    
    }

    //function submit
    function submitAnswer() {
    $(document).on('submit', '#evaluation_form', function (e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        var formDataArray = Array.from(formData.entries()); // Convert to key-value pairs
        var resultFinal = []; 

        for (var i = 0; i < formDataArray.length; i++) {
            var entry = formDataArray[i];
            var key = entry[0];
            var value = entry[1];

            // Check if the key starts 'id'
            if (key.startsWith('id')) {
                var id = value;
                var pairObj = { id: id }; // the key and value

                for (var j = i + 1; j < formDataArray.length; j++) {
                    var nextEntry = formDataArray[j];
                    var nextKey = nextEntry[0];
                    var nextValue = nextEntry[1];

                    // Check if the next key starts 'radio_'
                    if (nextKey.startsWith('radio_')) {
                        var radioNumber = nextKey.split('_')[1]; // extract the number
                        pairObj['radio_' + radioNumber] = nextValue; 
                        i = j; 
                    } else {
                        break; 
                    }
                }

                resultFinal.push(pairObj); // push the object pair
            }
        }

        console.log(resultFinal); 
    });
}

            
    




</script>