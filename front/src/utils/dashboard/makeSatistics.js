export function makeOptionForChart(array) {
    let pe = 0;
    let pt = 0;
    let fi = 0;
    let fp = 0;

    for (let i = 0; i < array.series.length; i++) {
        let item = array.series[i];
        if (item.name === "projets encours") {
            for (let j = 0; j < item.data.length; j++) {
                pe = pe + item.data[j];
            }
        }
        if (item.name === "projets terminés") {
            for (let j = 0; j < item.data.length; j++) {
                pt = pt + item.data[j];
            }
        }
        if (item.name === "factures impayées") {
            for (let j = 0; j < item.data.length; j++) {
                fi = fi + item.data[j];
            }
        }
        if (item.name === "factures_payées") {
            for (let j = 0; j < item.data.length; j++) {
                fp = fp + item.data[j];
            }
        }

    }

    let options = {
        series: array.series,
        fi:fi,
        pt:pt,
        pe:pe,
        fp:fp,
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
