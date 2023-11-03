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

                var text = donePercentage;
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
                        $('<td>').text(name),
                        $('<td>').text(institute),
                        $('<td class="text-center">').text(average),
                        $('<td class="text-center">').text(equivalent)
                    ).appendTo('#top_rated_faculty');
                })

                const rated_faculty = $('#top_rated_faculty tbody tr').children();
                const td_array_id = [];
                $.each(rated_faculty, (index, data) => {
                    if(data.id){
                        td_array_id.push(data.id)
                    }
                })
                final_top_rated_id = td_array_id.splice(0, 3);
                $.each(final_top_rated_id, (index, data) => {
                    let trophyCount = 3 - index;
                    let trophyHtml = '';
                    
                    while(trophyCount > 0){ 
                        trophyHtml += '<i class="bi bi-trophy-fill ms-2 text-warning fs-4"></i>';
                        trophyCount --
                    }
                    $(`#${data}`).append(trophyHtml);
                    $(`#${data}`).addClass('fw-bold fs-5 text-warning')
                })

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