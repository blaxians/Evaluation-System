<script>
    $(document).ready(function() {
        showTable();
        modifyDataTable();
        addProffessor();

    });

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

    function showTable(){
        $.ajax({
            url: "{{ route('show.user') }}",
            method: 'get',
            success: function(res){
                $('#faculties_table').html(res);
                modifyDataTable();
            }
        })
    }

    function addProffessor() {


        var selectedItems = [];

        function updateSelectedItems() {
            $('#table tbody tr').each(function() {
                var checkbox = $(this).find('input[type="checkbox"]');
                var name = $(this).find('td:eq(1)').text();

                if (checkbox.prop('checked')) {
                    $(this).addClass('checked');
                    if (selectedItems.indexOf(name) === -1) {
                        selectedItems.push(name);
                    }
                } else {
                    $(this).removeClass('checked');
                    var index = selectedItems.indexOf(name);
                    if (index !== -1) {
                        selectedItems.splice(index, 1);
                    }
                }
            });

        }

        $(document).on('input', '#table tbody tr input[type="checkbox"]', function() {
            updateSelectedItems();
                
        });


        $(document).on('click', '#btn_prof_finalize', function() {
            $('#table').DataTable().search('').draw();

            if(selectedItems.length > 0){
                var selectedItemsHtml = selectedItems.map(function(item) {
                return '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    '<strong>' + item + '</strong>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" id="dismiss-alert" aria-label="Close"></button>' +
                    '</div>';
            }).join('');

            $('#selected-items').html(selectedItemsHtml);
            $('#btn_prof_confirm').prop('disabled', false);
            } else {
                $('#selected-items').html(`<h3 class="text-center text-secondary my-4">No data!</h3>`);
                $('#btn_prof_confirm').prop('disabled', true);
            }
        });
        

        //confirm button
        $(document).on('click', '#btn_prof_confirm', function() {

            var prof_data = $('#selected-items').html();
            var $data = $(prof_data);
            var names = [];
            $data.each(function() {
                var name = $(this).find('strong').text();
                names.push(name);
            })
            console.log(names);
            window.location.href = "{{ route('index.user') }}"; 

        });

        //finalizing event unchecking
        $(document).on('click', '#dismiss-alert', function() {
            var dismissedName = $(this).siblings('strong').text();
            $('#table tbody tr').each(function() {
                var name = $(this).find('td:eq(1)').text();
                if (name === dismissedName) {
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                }
        });
            
        //remove unchecked data in selected var
        
        var index = selectedItems.indexOf(dismissedName);
            if (index !== -1) {
                selectedItems.splice(index, 1);
            }
        
        });
        
        $('#table').on('search.dt', function () {
            updateSelectedItems();
        });    


}




  </script>

  