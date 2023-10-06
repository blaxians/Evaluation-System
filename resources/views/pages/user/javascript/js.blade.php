<script>
    $(document).ready(function(){
        
        
        

    })
    //modify datatable 
    function modifyDataTable(){

        var table;

        if ($(window).width() < 768) {
            table = $('#table').DataTable({
                "lengthChange": false,
                "pageLength": 10,
                "info": false,
            });
        } else {
            table = $('#table').DataTable({
                "pageLength": 10,
            });
        }
        }

    //show chosen evaluate faculty
    function showFaculty(){
       $.ajax({
        url: "{{ route('view.user') }}",
        method: 'get',
        success: function(res){
            $('#evaluate_professor_table').html(res);
            modifyDataTable();
            $('#table').DataTable(); 
        }
       })
    }

    


    

    


</script>