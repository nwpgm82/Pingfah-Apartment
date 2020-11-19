$(document).ready(function() {
    showGraph();
})

function showGraph() {
    $.post('data.php', function(data) {
        console.log(data)
        let date = [];
        let price = [];
        for (let i in data) {
            date.push(data[i].date);
            price.push(data[i].total);
        }
        let chartdata = {
            labels: date,
            datasets: [{
                label: 'cost',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                hoverBackgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                data: price
            }]
        };

        let graphTarget = $('#graphCanvas');
        let barGraph = new Chart(graphTarget, {
            type: 'bar',
            data: chartdata,
        })
    })
}