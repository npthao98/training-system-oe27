$.ajax({
    url: '/trainees-by-course/data',
    type: 'get',
    dataType: 'json',
    success: function (data) {
        if (data.error) {
            toastr.error(data.error, 'Notification', {timeOut: 5000});
        } else {
            var course, i = 0;
            var values = [];
            var titles = [];
            var colors = [];
            for (course of data) {
                titles[i] = course.title;
                values[i] = course.trainees_active.length;
                colors[i] = `rgb(${Math.floor(Math.random() * 255)},
                    ${Math.floor(Math.random() * 255)},
                    ${Math.floor(Math.random() * 255)})`;
                i++;
            }
            var ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data : {
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                    }],
                    labels: titles,
                },
            });
        }
    },
});
