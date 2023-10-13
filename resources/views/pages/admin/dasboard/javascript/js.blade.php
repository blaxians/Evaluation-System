<script>
    $(document).ready(function(){
        showSetYear();
        addYear();
        viewSemester();
        //total student and faculties
        totalStudenFaculties();

        //dougnut chart
        initializeCharts();
        showTotalData();

        //bar chart
        createInitialBarGraph();
        loadDataAndInitializeChart();
        
       
    })


    //kunin yung data ng dean at student
    function showTotalData() {
        $.ajax({
            url: "{{ route('statistic') }}",
            method: 'get',
            success: function (res) {
                chart(res.dean[0], res.dean[1], res.student[0], res.student[1]);
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    }

    ///default data bago mag loading yung sa ajax
    function initializeCharts() {
        var deansData = getDeansData(0, 10); 
        var studentsData = getStudentsData(0, 10); 

        createOrUpdateChart('deansCanvas', deansData, 55);
        createOrUpdateChart('studentsCanvas', studentsData, 55);
    }

    //kunin yung data mula sa db
    function showTotalData() {
        $.ajax({
            url: "{{ route('statistic') }}",
            method: 'get',
            success: function (res) {
            
                if (res.dean && res.student) {
                    chart(res.dean[0], res.dean[1], res.student[0], res.student[1]);
                }
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    }

    //function ng chart
    function chart(deansDoneCount, deansNotDoneCount, studentsDoneCount, studentsNotDoneCount) {
        var deansData = getDeansData(deansDoneCount, deansNotDoneCount);
        var studentsData = getStudentsData(studentsDoneCount, studentsNotDoneCount);

        createOrUpdateChart('deansCanvas', deansData, 55);
        createOrUpdateChart('studentsCanvas', studentsData, 55);
    }

    //update canvas
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

    //set ng data ng daen
    function getDeansData(deansDoneCount, deansNotDoneCount) {
        return {
            labels: ["Done", "Pending"],
            datasets: [
                {
                    data: [deansDoneCount, deansNotDoneCount],
                    backgroundColor: ["#36A2EB", "#FFCE56"],
                },
            ],
        };
    }
    //function set ng data ng student
    function getStudentsData(studentsDoneCount, studentsNotDoneCount) {
        return {
            labels: ["Done", "Pending"],
            datasets: [
                {
                    data: [studentsDoneCount, studentsNotDoneCount],
                    backgroundColor: ["#1BC500", "#FF5733"],
                },
            ],
        };
    }

    //yung text sa gitna ng downut chart
    Chart.plugins.register({
        afterDraw: function(chart) {
            if (chart.config.type === 'doughnut') {
            var ctx = chart.chart.ctx;
            var width = chart.chart.width;
            var height = chart.chart.height;
            var total = 0;
            
            chart.data.datasets[0].data.forEach(function (value) {
                total += value;
            });

            var donePercentage = ((chart.data.datasets[0].data[0] / total) * 100).toFixed(2) + '%';

            //format nung text percentage
            ctx.restore();
            ctx.font = "18px Arial";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#000";
            
            //alignment nung text percentage
            var text = donePercentage;
            var textX = Math.round((width - ctx.measureText(text).width) / 2);
            var textY = height / 1.8;
            
            ctx.fillText(text, textX, textY);
            ctx.save();
            }
        }
        });

    // function chart() {
    //     var deansData = getDeansData();

    //     new Chart($('#deansCanvas'), {
    //         type: 'doughnut',
    //         data: deansData,
    //         options: {
    //         cutoutPercentage: 55, //kapal nung downut
    //         }
    //     });

    //     var studentsData = getStudentsData();

    //     new Chart($('#studentsCanvas'), {
    //         type: 'doughnut',
    //         data: studentsData,
    //         options: {
    //         cutoutPercentage: 55, //yung kapal nung downut
    //         }
    //     });
    // }

    //bargraph
    function createInitialBarGraph() {
        var staticData = {
            labels: ['CA', 'IAS', 'IEAT', 'IED', 'IM'],
            datasets: [{
                label: 'Number of Faculty',
                data: [0, 0, 0, 0, 0], 
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)'
                ],
                borderWidth: 1
            }]
        };

        var ctx = document.getElementById('facultyChart').getContext('2d');
        var facultyChart = new Chart(ctx, {
            type: 'bar',
            data: staticData, // static data nung barchart bago mag ajax
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    }

    // update the chart data from ajax
    function updateBarGraphWithData(data) {
        var ctx = document.getElementById('facultyChart').getContext('2d');
        var facultyChart = new Chart(ctx, {
            type: 'bar',
            data: data, // yung tunay na data galing ajax
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    }

    // Function to load data from the server
    function loadDataAndInitializeChart() {
        $.ajax({
            url: "{{ route('statistic') }}",
            method: 'get',
            success: function (res) {

                if (res.total_institute && res.total_institute.length >= 5) {
                    var facultyData = {
                        labels: ['CA', 'IAS', 'IEAT', 'IED', 'IM'],
                        datasets: [{
                            label: 'Number of Faculty',
                            data: res.total_institute.slice(0, 5), // take first 5 values
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    // Update the chart with real data
                    updateBarGraphWithData(facultyData);
                }
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    }


    //total student and faculties
    function totalStudenFaculties(){
        $.ajax({
            url: "{{ route('statistic') }}",
            method: 'get',
            success: function (res) {
                console.log(res.total_faculty, );
                $('#dashboard_total_students').text(res.total_student);
                $('#dashboard_total_faculties').text(res.total_faculty);
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });
    }

    
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
                        'Semester cant back set.',
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
                }
            });
        });
}

</script>