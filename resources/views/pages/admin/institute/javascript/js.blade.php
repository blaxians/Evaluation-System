
    
        
<script>
    $(document).ready(function(){
        // Swal.fire('success')
        showCardsRatedInstitute();
        viewTopRatedEquivalent();
    })

    //function to view 
    function viewTopRatedEquivalent(){
        $('#top_rated_per_insti').on('click', '#viewtop_rated_equivalent', function(){
            let arr = $(this).attr('data-array').split(',');
            let percent = $(this).attr('data-percent');
            let equivalent = $(this).attr('data-equivalent');
            
            let name_table = `<table class="table table-bordered">
                                <thead>
                                    <th>Name</th>
                                    <th>Percentage</th>
                                </thead>
                                <tbody>`;
                $.each(arr, (index, data)=>{
                    name_table += `
                    <tr>
                        <td>${data}</td>
                        <td>${percent}</td>
                    </tr>`;
                });
                
                name_table += `
                    </tbody>
                </table>
                `;

            $('#name_of_rated_facultyperinsti').html(name_table)
            $('#facultyperinsti_title_modal').text(equivalent)
        })
    }
    

    //function show card 
    function showCardsRatedInstitute(){
        $('#top_rated_per_insti').on('change', '#selected_top_rated_institute', function(){
            let institute = $(this).val();
            $.ajax({
                url: "{{ route('institute.select') }}",
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}",
                    institute:institute
                },
                success: (res) => {
                    console.log(res)               
                    let criteria = [
                        `Teacher's Personality`,
                        `Classroom Management`,
                        `Knowledge of the Subject Matter`,
                        `Teaching Skills`,
                        `Skills in Evaluating the Students`,
                        `Attitude towards the Subject and the Students`
                    ];

                    let equivalent = [
                        'Outstanding',
                        'Very Satisfactory',
                        'Satisfactory',
                        'Fairly Satisfactory',
                        'Needs Improvement'
                    ];

                    let topRatedCard = '';

                    $.each(res.data, (index, data) => {
                        topRatedCard += `
                            <div class="col">
                                <div class="rounded-1 border p-3">
                                    <div>
                                        <h5>${criteria[index]}</h5>
                                    </div>
                                    <div>
                                        <table class="table table-bordered">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Equivalent</th>
                                                    <th>Count</th>
                                                    <th>Percentage</th>
                                                    <th class="text-center">View</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                        $.each(equivalent, (eqIndex, eqData) => {
                            let oneDecimalOnly = (data[eqIndex]['percent'] == 100) ? data[eqIndex]['percent'] : data[eqIndex]['percent'].toFixed(1);

                            topRatedCard += `
                                <tr>
                                    <td>${eqData}</td>
                                    <td>${data[eqIndex]['count']}</td>
                                    <td>${oneDecimalOnly}%</td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#modal_top_rated_institute"
                                            data-array="${data[eqIndex]['names']}"
                                            data-percent="${oneDecimalOnly}%"
                                            data-equivalent="${eqData}" id="viewtop_rated_equivalent" 
                                            ${(data[eqIndex]['count'] == 0) ? 'disabled' : ''}><i class="bi bi-eye-fill"></i></button>
                                    </td>
                                </tr>`;
                        });

                        topRatedCard += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    

                    $('#top_rated_per_institute_card').html(topRatedCard);
                    $('#totoal_faculty').html(`
                    <h4>Total Faculty: ${res.total_faculty}</h3>
                    `)

                }, error : (err) => {
                    console.log(err)
                }
            })

        })
    }
</script>