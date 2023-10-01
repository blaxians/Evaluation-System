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


    //add profeffor
    function showTable(){
        const table = `<table class="table table-hover hover-success" id="table">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Checkbox</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Ma. Melanie Ablaza Cruz</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Ian Blas</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Ralp Juts</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Jek jek</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                </tbody>
                            </table>`;
        $('#faculties_table').html(table);
    }
    function addProffessor() {
        var selectedItems = [];

            // save selected items in array
            function updateSelectedItems() {
                selectedItems = [];
                $('#table tbody tr').each(function() {
                    var checkbox = $(this).find('input[type="checkbox"]');
                    if (checkbox.prop('checked')) {
                        var name = $(this).find('td:eq(1)').text();
                        selectedItems.push(name);
                    }
                });
            }

        //button finalize
        $(document).on('click', '#btn_prof_finalize', function() {
            $('#table').DataTable().search('').draw();
            updateSelectedItems();
            console.log(selectedItems);

            var selectedItemsHtml = selectedItems.map(function(item) {
                return '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    '<strong>' + item + '</strong>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" id="dismiss-alert" aria-label="Close"></button>' +
                    '</div>';
            }).join('');

            console.log(selectedItemsHtml);
            $('#selected-items').html(selectedItemsHtml);
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
        
        });
}



  </script>