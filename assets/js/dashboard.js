$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '各票亭投票狀況'
        },
        xAxis: {
            categories: [
                '社科院',
                '文學院',
                '總圖',
                '水源',
                '男一'
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: '票數'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} 票</b></td></tr>',
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
            name: '票數',
            data: [49, 71, 106, 129 , 144 ]

        }]
    });
});