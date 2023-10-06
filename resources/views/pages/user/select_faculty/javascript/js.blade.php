<script>
    $(document).ready(function() {
        showTable();
        modifyDataTable();
        addProffessor();
        showSetYear();

    });
    //show on set year
    function showSetYear(){
        $.ajax({
            url: "{{ route('show.dashboard') }}",
            method: 'get',
            success: function(res){
                if(Object.keys(res).length > 0){
                    $('#academic_year').text(res.year);
                    currentYear = res.year;
                    if(res.semester == 1){
                        $('#semester').text(`${res.semester}st semester`);
                    } else {
                        $('#semester').text(`${res.semester}nd semester`);
                    }
                } else {
                    $('#academic_year').text('---');
                    $('#semester').text('---');
                }
                
                
            }
        })

    }

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


        var selectedItems = {};

        function updateSelectedItems() {
            $('#table tbody tr').each(function() {
                var checkbox = $(this).find('input[type="checkbox"]');
                var name = $(this).find('td:eq(1)').text();
                var checkboxID = checkbox.attr('data-id');

                if (checkbox.prop('checked')) {
                    $(this).addClass('checked');

                    if (!selectedItems.hasOwnProperty(checkboxID)) {
                        selectedItems[checkboxID] = {
                            id: checkboxID,
                            name: name
                        };
                    }
                } else {
                    $(this).removeClass('checked');

                    if (selectedItems.hasOwnProperty(checkboxID)) {
                        delete selectedItems[checkboxID];
                    }
                }
            });
        }

        $(document).on('input', '#table tbody tr input[type="checkbox"]', function() {
            updateSelectedItems();
        });

        $(document).on('click', '#btn_prof_finalize', function() {
            $('#table').DataTable().search('').draw();

            if (Object.keys(selectedItems).length > 0) {
                var selectedItemsHtml = Object.keys(selectedItems).map(function(id) {
                    var item = selectedItems[id];
                    return '<input type="hidden" id="id_faculty" name="id_faculty" value="' + item.id + '">' +
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<strong>' + item.name + '</strong>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" data-id="' + item.id + '" aria-label="Close"></button>' +
                        '</div>';
                }).join('');

                $('#selected-items').html(selectedItemsHtml);
                $('#btn_prof_confirm').prop('disabled', false);

                // Add event listener for the close button
                $('.btn-close').on('click', function() {
                    var idToRemove = $(this).data('id');
                    if (idToRemove !== undefined) {
                        delete selectedItems[idToRemove];
                        $(this).closest('.alert').remove();
                        // Uncheck the checkbox in the table
                        $('input[data-id="' + idToRemove + '"]').prop('checked', false);
                    }
                });
            } else {
                $('#selected-items').html(`<h3 class="text-center text-secondary my-4">No data!</h3>`);
                $('#btn_prof_confirm').prop('disabled', true);
            }
        });


        //confirm button
        $(document).on('click', '#btn_prof_confirm', function() {
            var arrayID = Object.keys(selectedItems);
            console.log(arrayID);
            $.ajax({
                url: "{{ route('post.user') }}",
                method: 'post',
                data: {_token: "{{ csrf_token() }}",
                id:arrayID},
                success: function(res){
                    if(res == 'success'){
                        window.location.href = '/evaluation';
                    }
                }

            })
       

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

  