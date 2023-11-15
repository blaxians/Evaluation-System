<script>
    $(document).ready(function() {
        showTopRatedFaculty();
    })

    function showTopRatedFaculty() {
        $('#top_rated_facultys').on('change', '#selected_top_rateds', function() {
            let vals = $(this).val();

            $.ajax({
                url: "{{ route('rated.select') }}",
                method: 'get',
                data: {
                    _token: '{{ csrf_token() }}',
                    selected: vals
                },
                success: function(res) {


                    let top_table = `
                    <table class="table table-bordered table-hover" id="top_rated_table_faculty">
                            <thead>
                              <tr>
                                <th scope="col" width="90">Top</th>
                                <th scope="col">Name</th>
                                <th scope="col">Insitute</th>
                                <th scope="col">Average</th>
                                <th scope="col">Equivalent</th>
                                <th scope="col">View</th>
                              </tr>
                            </thead>
                            <tbody>
                    `;

                    $.each(res.top, (index, data) => {
                        const {
                            id,
                            name,
                            institute,
                            average,
                            equivalent
                        } = data;

                        top_table += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${name}</td>
                            <td>${institute}</td>
                            <td>${average.toFixed(1)}</td>
                            <td>${equivalent}</td>
                            <td class="text-center">
                                <button data-id="${id}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-eye-fill"></i></button>
                            </td>
                        </tr>
                        `;
                    })

                    top_table += '</tbody></table>';

                    $('#table_top_rated_eval').html(top_table);
                    $('table').DataTable();

                },
                error: function(err) {
                    console.log(err)
                }
            })
        })
    }
</script>
