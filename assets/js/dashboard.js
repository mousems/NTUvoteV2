$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '各票亭投票狀況'
        },
        xAxis: {
            categories: vote_count_title
        },
        yAxis: {
            min: 0,
            title: {
                text: '使用人數'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} 次</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '次數',
            data: vote_count_value

        }]
    });
});