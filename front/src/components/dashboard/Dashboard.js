import React, {Component} from "react";
import Chart from 'react-apexcharts'
import {connect} from "react-redux";
import MapBox from "./MapBox";
import {getLocationsAction} from "../../actions/mapActions";
import {getCookie} from "../../utils/cookies";
import {getSatitstiquesAction} from "../../actions/adminActions";
import adminRes from "../../reducers/adminResourcesReducer";


class Dashboard extends Component {
    constructor() {
        super();
        this.state = {
            options: {
                series: [{
                    name: "Session Duration",
                    data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
                },
                    {
                        name: "Page ",
                        data: [25, 41, 62, 33, 26, 21, 29, 62, 47, 82, 56, 45, 47]
                    }, {
                        name: "Page Views",
                        data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
                    },
                    {
                        name: 'Total Visits',
                        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
                    }
                ],
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
                        categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
                            '10 Jan', '11 Jan', '12 Jan'
                        ],
                    },
                    // tooltip: {
                    //     y: [
                    //         {
                    //             title: {
                    //                 formatter: function (val) {
                    //                     return val + " (mins)"
                    //                 }
                    //             }
                    //         },
                    //         {
                    //             title: {
                    //                 formatter: function (val) {
                    //                     return val + " per session"
                    //                 }
                    //             }
                    //         },
                    //         {
                    //             title: {
                    //                 formatter: function (val) {
                    //                     return val;
                    //                 }
                    //             }
                    //         }
                    //     ]
                    // },
                    grid: {
                        borderColor: '#f1f1f1',
                    }
                }
            }
        }
    }

    componentDidMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            this.props.getLocationsAction(token);
            this.props.getSatitstiquesAction(token);
        }
    }

    render() {
        const {
            statistics
        } = this.props;
        return (

            <div className="row">

                <div className="col-md-4 col-xl-3">
                    <div className="card bg-c-blue order-card">
                        <div className="card-block">
                            <h6 className="m-b-20">Projets en cours</h6>
                            <h2 className="text-right">
                                <i className="fas fa-file-invoice  f-left"/><span>
                                     {
                                         statistics.pe ?
                                             statistics.pe : 0
                                     }
                                   </span>
                            </h2>
                        </div>
                    </div>
                </div>

                <div className="col-md-4 col-xl-3">
                    <div className="card bg-c-green order-card">
                        <div className="card-block">
                            <h6 className="m-b-20">Projets terminés</h6>
                            <h2 className="text-right">
                                <i className="fa fa-file-invoice f-left"/><span>
                                    {
                                        statistics.pt ?
                                            statistics.pt : 0
                                    }</span></h2>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 col-xl-3">
                    <div className="card bg-c-yellow order-card">
                        <div className="card-block">
                            <h6 className="m-b-20">Factures impayées</h6>
                            <h2 className="text-right"><i className="fa  fa-money-check-alt f-left"/><span>
                                {
                                    statistics.fi ?
                                        statistics.fi : 0}
                               </span></h2>

                        </div>
                    </div>
                </div>


                <div className="col-md-4 col-xl-3">
                    <div className="card bg-c-pink order-card">
                        <div className="card-block">
                            <h6 className="m-b-20">Factures payées</h6>
                            <h2 className="text-right">
                                <i className="fas fa-money-check-alt f-left"/><span>{
                                statistics.fp ?
                                    statistics.fp : 0}</span>
                            </h2>
                        </div>
                    </div>
                </div>


                <div className="col-md-12 col-xl-12">

                    {statistics.series && <Chart options={statistics}
                                                 series={statistics.series} type="line" width={1200} height={600}/>}
                </div>

                <div className="col-md-12 col-xl-12">

                    <MapBox/>
                </div>
            </div>

        );
    }

}

const mapDispatchToProps = {
    getLocationsAction,
    getSatitstiquesAction
};

function mapStateToProps(state) {
    return {
        adr: state.locations.adr,
        statistics: state.adminRes.statistics,
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Dashboard);
