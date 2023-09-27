@if (session()->has('question_created'))
    <script>
        swalWithBootstrapButtons.fire(
            'Success',
            'Question Added!',
            'success'
        )
    </script>
@endif
@if (session()->has('question_existed'))
    <script>
        swalWithBootstrapButtons.fire(
            'Failed',
            'Question is already Exist!',
            'error'
        )
    </script>
@endif
@if (session()->has('question_updated'))
    <script>
        swalWithBootstrapButtons.fire(
            'Success',
            'Question Edited!',
            'success'
        )
    </script>
@endif
@if (session()->has('faculties_created'))
    <script>
        swalWithBootstrapButtons.fire(
            'Success',
            'Faculties Added!',
            'success'
        )
    </script>
@endif
