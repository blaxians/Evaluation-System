<script>
    $(document).ready(function(){
        showStudent();
    })

    //show student
    function showStudent(){
        $.ajax({
            url: "{{ route('show.student') }}",
            method: 'get',
            success: function(res){
                $('#student_table').html(res);
                $('#table').DataTable();
            }

        })
    }



</script>