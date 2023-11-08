<script>
    $(document).ready(function(){
        showSetYear();
        addYear();
        viewSemester();
        initializePage(); 
        scrollUpDashboard();
    })

    function scrollUpDashboard(){
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
            $('#scroll-to-top-button').fadeIn();
            } else {
            $('#scroll-to-top-button').fadeOut();
            }
        });

        $('#scroll-to-top-button').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 100);
            return false;
        });
    }

    function chart(deansDoneCount, deansNotDoneCount, studentsDoneCount, studentsNotDoneCount) {
        $('#student_dean_dougnut').removeClass('d-none');
        $('#dougnut_chart_load').addClass('d-none');
        var deansData = getDeansData(deansDoneCount, deansNotDoneCount);
        var studentsData = getStudentsData(studentsDoneCount, studentsNotDoneCount);

        createOrUpdateChart('deansCanvas', deansData, 55);
        createOrUpdateChart('studentsCanvas', studentsData, 55);
    }

    function createOrUpdateChart(canvasId, chartData, cutoutPercentage) {
        var canvas = $('#' + canvasId);
        var existingChart = canvas.data('chart');

        if (existingChart) {
            existingChart.data = chartData;
            existingChart.update();
        } else {
            var newChart = new Chart(canvas, {
                type: 'doughnut',
                data: chartData,
                options: {
                    cutoutPercentage: cutoutPercentage,
                }
            });

            canvas.data('chart', newChart);
        }
    }

    //dougnut get deans data
    function getDeansData(deansDoneCount, deansNotDoneCount) {
        return {
            labels: ["Done", "Pending"],
            datasets: [
                {
                    data: [deansDoneCount, deansNotDoneCount],
                    backgroundColor: ["#004225", "#AEC3AE"],
                },
            ],
        };
    }

    //doughnut get student data
    function getStudentsData(studentsDoneCount, studentsNotDoneCount) {
        return {
            labels: ["Done", "Pending"],
            datasets: [
                {
                    data: [studentsDoneCount, studentsNotDoneCount],
                    backgroundColor: ["#952323", "#EEE2DE"],
                },
            ],
        };
    }

    Chart.plugins.register({
        afterDraw: function (chart) {
            if (chart.config.type === 'doughnut') {
                var ctx = chart.chart.ctx;
                var width = chart.chart.width;
                var height = chart.chart.height;
                var total = 0;
                chart.data.datasets[0].data.forEach(function (value) {
                    total += value;
                })

                var donePercentage = ((chart.data.datasets[0].data[0] / total) * 100).toFixed(2) + '%';

                ctx.restore();
                ctx.font = "18px Arial";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#000";

                var text = (donePercentage == 'NaN%') ? 'No data' : donePercentage;
                var textX = Math.round((width - ctx.measureText(text).width) / 2);
                var textY = height / 1.8;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    });

    async function loadDataAndInitializeChart() {
        try {
            const response = await fetch("{{ route('statistic') }}");
            const res = await response.json();

            var numberFormat = res.total_faculty.toLocaleString();
            $('#dashboard_total_students').text(res.total_student);
            $('#dashboard_total_faculties').text(numberFormat);
            
            if (res.dean && res.student) {
                chart(res.dean[0], res.dean[1], res.student[0], res.student[1]);

            } else {
                console.log("Data not available.");  
            }

            if(res.top_10){
                $('#top_rated_faculty').removeClass('d-none');
                $('#top_rated_faculty_load').addClass('d-none');
                $.each(res.top_10, (index, data) => {
                    const {name, institute, average, equivalent} = data;
                    $('<tr class="text-capitalize text-start">').append(
                        $(`<td id='top_rated_${index+1}'>`).text(`${index+1} .`),
                        $(`<td id="top_rated_name_${index+1}">`).text(name),
                        $(`<td class="text-center" id="top_rated_intitute_${index+1}">`).text(institute),
                        $(`<td class="text-center" id="top_rated_average_${index+1}">`).text(average),
                        $(`<td class="text-center" id="top_rated_equi_${index+1}">`).text(equivalent)
                    ).appendTo('#top_rated_table_faculty');
                })

                const rated_faculty = $('#top_rated_faculty tbody tr').children();
                const td_array_id = [];

                $.each(rated_faculty, (index, data) => {
                    if(data.id){
                        td_array_id.push(data.id)
                    }
                })

                
                const final_top_rated_1 = td_array_id.splice(0, 5);
                $(`#${final_top_rated_1[0]}`).append(`
                <i class="fa-solid fa-medal ms-2 fs-4" style="color:#FFD700;"></i>`);

                // html card 1 
                    let topRatedName1 = $(`#${final_top_rated_1[1]}`).text();
                    let topRatedInstitute1 = $(`#${final_top_rated_1[2]}`).text();
                    let topRatedEquivalent1 = $(`#${final_top_rated_1[4]}`).text();

                    const topHtml_1 = `<div class="card rounded-1 bg-white text-center h-100">
                                    <div class="card-body p-4">
                                        <div class="position-relative border-bottom">
                                            <img src="assets/img/main/basc.png" class="img-thumbnail rounded-circle mb-3" width="75">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-0" style="background-color:#FFD700;">
                                                    1st
                                                <span class="visually-hidden">placer</span>
                                            </span>
                                            
                                        </div>
                                        
                                        <p class="fs-6 fw-semibold mt-2 mb-0 p-0 text-capitalize">${topRatedName1}</p>
                                        <p class="fs-6 text-secondary p-0 text-capitalize">${topRatedEquivalent1}</p>
                                    </div>
                                </div>`;
                    
                    $('#top_rated_first').append(topHtml_1)
                // html card 1 

                const final_top_rated_2 = td_array_id.splice(0, 5);
                $(`#${final_top_rated_2[0]}`).append(`
                <i class="fa-solid fa-medal ms-2 fs-4" style="color:#c0c0c0;"></i>`);

                // html card 2
                let topRatedName2 = $(`#${final_top_rated_2[1]}`).text();
                    let topRatedInstitute2 = $(`#${final_top_rated_2[2]}`).text();
                    let topRatedEquivalent2 = $(`#${final_top_rated_2[4]}`).text();

                    const topHtml_2 = `<div class="card rounded-1 bg-white text-center h-100">
                                    <div class="card-body p-4">
                                        <div class="position-relative border-bottom">
                                            <img src="assets/img/main/basc.png" class="img-thumbnail rounded-circle mb-3" width="75">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-0" style="background-color:#c0c0c0;">
                                                    2nd
                                                <span class="visually-hidden">placer</span>
                                            </span>
                                            
                                        </div>
                                        
                                        <p class="fs-6 fw-semibold mt-2 mb-0 p-0 text-capitalize">${topRatedName2}</p>
                                        <p class="fs-6 text-secondary p-0 text-capitalize">${topRatedEquivalent2}</p>
                                    </div>
                                </div>`;
                    
                    $('#top_rated_second').append(topHtml_2)
                // html card 2

                const final_top_rated_3 = td_array_id.splice(0, 5);
                $(`#${final_top_rated_3[0]}`).append(`
                <i class="fa-solid fa-medal ms-2 fs-4" style="color:#CD8032;"></i>`);

                // html card 3
                let topRatedName3 = $(`#${final_top_rated_3[1]}`).text();
                    let topRatedInstitute3 = $(`#${final_top_rated_3[2]}`).text();
                    let topRatedEquivalent3 = $(`#${final_top_rated_3[4]}`).text();
                    console.log(topRatedEquivalent3[4])

                    const topHtml_3 = `<div class="card rounded-1 bg-white text-center h-100">
                                    <div class="card-body p-4">
                                        <div class="position-relative border-bottom">
                                            <img src="assets/img/main/basc.png" class="img-thumbnail rounded-circle mb-3" width="75">
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-0" style="background-color:#CD8032;">
                                                    3rd
                                                <span class="visually-hidden">placer</span>
                                            </span>
                                            
                                        </div>
                                        
                                        <p class="fs-6 fw-semibold mt-2 mb-0 p-0 text-capitalize">${topRatedName3}</p>
                                        <p class="fs-6 text-secondary p-0 text-capitalize">${topRatedEquivalent3}</p>
                                    </div>
                                </div>`;
                    
                    $('#top_rated_third').append(topHtml_3)
                // html card 3


                // $.each(final_top_rated_1, (index, data) => {
                    // console.log(data)
                    // let trophyColor = (data == 'top_rated_1') ? '#FFD700' : (data == 'top_rated_2') ? '#c0c0c0' : (data == 'top_rated_3') ? '#CD8032' : '';
                    // let trophyHtml = `<i class="bi bi-trophy-fill ms-2 fs-4" style="color:${trophyColor};"></i>`; 
                    // $(`#${data}`).append(trophyHtml);

                // })

            }

            if (res.total_institute && res.total_institute.length >= 5) {
                var facultyData = {
                    labels: ['CA', 'IAS', 'IEAT', 'IED', 'IM'],
                    datasets: [{
                        label: 'Number of Faculty',
                        data: res.total_institute.slice(0, 5),
                        backgroundColor: [
                            'rgba(0, 255, 0, 0.2)',
                            'rgb(54, 162, 235, 0.2)',
                            'rgb(149, 35, 35, 0.2)',
                            'rgba(83, 112, 252, 0.2)',
                            'rgba(139, 80, 253, 0.2)'
                        ],
                        borderColor: [
                            'rgb(0, 255, 0)',
                            'rgb(54, 162, 235)',
                            'rgb(149, 35, 35)',
                            'rgb(83, 112, 252)',
                            'rgb(139, 80, 253)'
                        ],
                        borderWidth: 1
                    }]
                };

                $('#barchart_faculty_load').addClass('d-none');
                $('#facultyChart').removeClass('d-none');
                updateBarGraphWithData(facultyData);
            } else {
                console.log("Data not available.");
            }
        } catch (error) {
            console.log("Error:", error);
        }
    }

    //bar chart
    function updateBarGraphWithData(data) {
        var ctx = document.getElementById('facultyChart').getContext('2d');
        var facultyChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        min: 0
                    }
                }
            }
        });
    }

    //bar chart total faculties
    // function totalStudentsFaculties() {
    //     $.ajax({
    //         url: "{{ route('statistic') }}",
    //         method: 'get',
    //         success: function (res) {
    //             var numberFormat = res.total_faculty.toLocaleString();
    //             $('#dashboard_total_students').text(res.total_student);
    //             $('#dashboard_total_faculties').text(numberFormat);
    //         },
    //         error: function (error) {
    //             console.log("Error:", error);
    //         }
    //     });
    // }

    // total faculties async
    async function totalStudentsFaculties() {
        try {
            const response = await fetch("{{ route('statistic') }}");
            const data = await response.json();

            var numberFormat = data.total_faculty.toLocaleString();
            $('#dashboard_total_students').text(data.total_student);
            $('#dashboard_total_faculties').text(numberFormat);
        } catch (error) {
            console.log("Error:", error);
            }
        }

    //intitialize
    function initializePage() {
        loadDataAndInitializeChart();
        totalStudentsFaculties();
    }

    //add year
    function addYear(){
        $(document).on('click', '#btn_update_year', function(e){
            e.preventDefault();

            const currentYear = new Date().getFullYear();
            const nextYear = currentYear + 1;
            const academicYearNow = `${currentYear}-${nextYear}`;

            $.ajax({
                url: "{{ route('post.dashboard') }}",
                method: 'post',
                data:{_token: "{{ csrf_token() }}",
                year:academicYearNow},
                success: function(res){
                    if(res == 'success'){
                        Swal.fire('Updated!',
                        'Academic Year updated successfully.',
                        'success');
                        showSetYear();  

                    } else {
                        Swal.fire('Up to Date!',
                        'Academic Year is already updated.',
                        'success');
                        showSetYear();
                    }
                }
            })
        })
    }

    //show on set year
    async function showSetYear() {
        try {
            const response = await fetch("{{ route('show.dashboard') }}", {
                method: 'get',
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const res = await response.json();

            if (Object.keys(res).length > 0) {
                $('#academic_year').text(res.year);
                currentYear = res.year;
                if (res.semester == 1) {
                    $('#semester').text(`${res.semester}st semester`);
                } else {
                    $('#semester').text(`${res.semester}nd semester`);
                }
            } else {
                $('#academic_year').text('---');
                $('#semester').text('---');
            }
        } catch (error) {
            console.error('An error occurred:', error);
        }
    }

    //view semester
    function viewSemester() {
        $(document).on('submit', '#update_sem', function (e) {
            e.preventDefault();
            $('#btn_update_sem').text('Updating...');
            const fd = new FormData(this);

            $.ajax({
                url: "{{ route('edit.dashboard') }}",
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res == 'success') {
                        Swal.fire('Updated!',
                            'Semester updated successfully.',
                            'success');
                        $('#btn_update_sem').text('Update Sem');
                        $('#edit_sem').modal('hide');
                        showSetYear();
                    } else {
                        $('#btn_update_sem').text('Update Sem');
                        Swal.fire('Error!',
                        'Cannot go back any further.',
                        'error')
                    }
                }
            });
        });

        $(document).on('shown.bs.modal', '#edit_sem', function () {
            $.ajax({
                url: "{{ route('show.dashboard') }}",
                method: 'get',
                success: function (res) {
                    $('#semester_id').val(res.id);
                    if(res.semester == 2){
                        $('#btn_update_sem').prop('disabled', true);
                        $('#first_sem').prop('selected', false);                        
                        $('#second_sem').prop('selected', true);                        
                    }
                }
            });
        });
}

</script>