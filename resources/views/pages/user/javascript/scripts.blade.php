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
                                    <tr>
                                        <td>5</td>
                                        <td>gelo</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Jermyn</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Myrtel</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Mich</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Jerome</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Florentino</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>Crisper</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                </tbody>
                            </table>`;
        $('#faculties_table').html(table);
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

            console.log(selectedItems);
        }

        $(document).on('input', '#table tbody tr input[type="checkbox"]', function() {
            updateSelectedItems();
                
        });


        $(document).on('click', '#btn_prof_finalize', function() {
            $('#table').DataTable().search('').draw();
            console.log(selectedItems);

            var selectedItemsHtml = selectedItems.map(function(item) {
                return '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    '<strong>' + item + '</strong>' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" id="dismiss-alert" aria-label="Close"></button>' +
                    '</div>';
            }).join('');

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
            
        //remove unchecked data in selected var
        var index = selectedItems.indexOf(dismissedName);
            if (index !== -1) {
                selectedItems.splice(index, 1);
        }

        console.log(selectedItems);
        
        
        });
        
        // Listen for DataTables search event and update selectedItems when the search criteria change
        $('#table').on('search.dt', function () {
            updateSelectedItems();
        });    


}



  </script>