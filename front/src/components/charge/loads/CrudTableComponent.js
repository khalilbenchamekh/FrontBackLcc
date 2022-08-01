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
                name: "others",
                label: "Autres"
            }, {
                name: "observation",
                label: "observation"
            }, {
                name: "desi",
                label: "Désignation"
            }, {
                name: "num_quit",
                label: "Numéro de quittance"
            }, {
                name: "reste",
                label: "reste"
            }, {
                name: "somme_due",
                label: "Somme Due"
            }, {
                name: "avence",
                label: "Avence"
            }, {
                name: "unite",
                label: "unite"
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
            </div>
        )
            ;
    }
}

const mapDispatchToProps = {};


function mapStateToProps(state) {
    return {
        loads: state.charges.charges,

    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
