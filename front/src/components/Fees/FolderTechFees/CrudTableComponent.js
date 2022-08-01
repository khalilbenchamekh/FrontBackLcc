import React, {Component} from "react";
import MUIDataTable from "mui-datatables";
import {connect} from "react-redux";
import CustomToolbar from "./CustomToolbar";
import UpdateBusinessNatures from "./UpdateBusinessNatures";
import feesFolderTech from "../../../reducers/crud/feesFolderTechReducer";

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
                name: "advanced",
                label: "Avence"
            }, {
                name: "price",
                label: "Prix"
            }, {
                name: "observation",
                label: "observation"
            },
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                            <UpdateBusinessNatures index={fees[tableMeta.rowIndex]} id={tableMeta.rowIndex}/>
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
            fees
        } = this.props;

        return (

            <div className='row'>
                <div className="col col-12 ">
                    {
                        fees && (
                            <MUIDataTable
                                title={"charges"}
                                data={fees}
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
        fees: state.feesFolderTech.feesFolder,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
