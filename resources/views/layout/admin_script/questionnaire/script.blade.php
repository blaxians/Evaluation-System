{{-- Jquery --}}
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- Datatables --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

{{-- Sweet Alert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- Sweet Alert Header --}}


<script>
    $(document).ready(function(){
        addQuestion();
    })

    //function add question
    function addQuestion(){
        $(document).on('submit', '#add_questionnaire', function(e){
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
                success: function(res){
                    if(res.status == 'success'){
                        Swal.fire(
                            'Added!',
                            'Question added successfully.',
                            'success'
                        );

                        $('#add_question_modal').modal('hide');
                        $('#btn_submit').text('Submit');
                        $('#add_questionnaire').trigger('reset');
                    }
                }
            })

        })
    }

    //show questionnaire table
    function showQuestion(){
        $.ajax({
            url: "",
            method: 'get',
            success: function(res){
                console.log(res);
            }
        })
    }

    //edit question
    function editQuestion(){
        $(documennt).on('click', '#questionnaire_btn_edit', function(e){

        })
    }
</script>