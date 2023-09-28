<script>
    $(document).ready(function() {
        addQuestion();
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
                    }
                }
            })

        })
    }

    //show questionnaire table
    function showQuestion() {
        $.ajax({
            url: "",
            method: 'get',
            success: function(res) {
                console.log(res);
            }
        })
    }

    //edit question
    function editQuestion() {
        $(documennt).on('click', '#questionnaire_btn_edit', function(e) {

        })
    }
</script>
