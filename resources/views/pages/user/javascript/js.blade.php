<script>
    $(document).ready(function(){
        
        showFaculty();
        evaluateRoute();
        

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
            $('#card_faculty').append(res); 
        }
       })
    }

    //route to evaluate faculty
    function evaluateRoute(){
        $(document).on('click', '#btn_evaluate', function(){
            let id = $(this).attr('data-id');
            console.log(id);
            window.location.href = `/evaluation/faculties/${id}`;
        })
    }

    


    

    


</script>