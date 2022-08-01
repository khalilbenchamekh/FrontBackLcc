import React, {Component} from "react";
import MUIDataTable from "mui-datatables";
import {connect} from "react-redux";
import CustomToolbar from "./CustomToolbar";
import UpdateBusinessNatures from "./UpdateBusinessNatures";
import Chart from 'react-apexcharts'

class CrudTableComponent extends Component {

    constructor() {
        super();
        this.state = {
            loadingDates: undefined,
            popupVisibleDate: false
        };

    }


    render() {

        const columns = [
            {
                name: "REF",
                label: "REF"
            }, {
                name: "amount",
                label: "Montant"
            }, {
                name: "load_related_to",
                label: "Charge liée à"
            }, {
                name: "load_types_name",
                label: "Type de charge"
            }, {
                name: "TVA",
                label: "TVA"
            }, {
                name: "DATE_LOAD",
                label: "Date de facturation"
            },
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                            <UpdateBusinessNatures index={loads[tableMeta.rowIndex]} id={tableMeta.rowIndex}/>
                        );
                    }
                }
            },
        ];

        const options = {
            filterType: 'dropdown',
            responsive: 'stacked',
            customToolbar: () => <CustomToolbar/>
        };
        const {
            loads, statistics
        } = this.props;

        return (


            <div className='row'>
                <div className="col col-12 ">
                    {
                        loads && (
                            <MUIDataTable
                                title={"charges"}
                                data={loads}
                                columns={columns}
                                options={options}
                            />
                        )


                    }
                </div>
                <div className="col col-12">

                    {
                        statistics.series && <Chart options={statistics}
                                                    series={statistics.series} type="line" width={1000} height={500}/>
                    }

                </div>
            </div>
        )
            ;
    }
}

const mapDispatchToProps = {};


function mapStateToProps(state) {
    return {
        loads: state.loads.loads,
        statistics: state.loads.statistics,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
