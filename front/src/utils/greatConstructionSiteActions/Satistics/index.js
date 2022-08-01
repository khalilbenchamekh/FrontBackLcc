export function makeOptionForChart(array){
     let options={
        series: array.series,
            chart: {
            height: 350,
                type: 'line',
                zoom: {
                enabled: true
            },
            toolbar: {
                show: true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                    download: true,
                        selection: true,
                        zoom: true,
                        customIcons: []
                },
                autoSelected: 'zoom'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [5, 7, 5],
                    curve: 'straight',
                    dashArray: [0, 8, 5]
            },
            title: {
                text: 'Page Statistics',
                    align: 'left'
            },
            legend: {
                tooltipHoverFormatter: function (val, opts) {
                    return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                }
            },
            markers: {
                size: 0,
                    hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: array.categories,
            },
            grid: {
                borderColor: '#f1f1f1',
            }
        }
    };
    return options;
}
