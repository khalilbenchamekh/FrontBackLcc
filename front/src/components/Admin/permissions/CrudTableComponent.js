import React, {Component} from "react";
import MUIDataTable from "mui-datatables";
import {connect} from "react-redux";

import UpdateBusinessNatures from "./UpdateBusinessNatures";


class CrudTableComponent extends Component {


    render() {
        const {userPer} = this.props;
        const columns = [
            "user",
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                            <UpdateBusinessNatures user={userPer[tableMeta.rowIndex]} id={tableMeta.rowIndex}/>
                        );
                    }
                }
            },
        ];

        const options = {
            filterType: 'dropdown',
            responsive: 'stacked',
        };

        return (


            <>
                {
                    userPer && (
                        <MUIDataTable
                            title={"PERMISSION"}
                            data={userPer}
                            columns={columns}
                            options={options}
                        />
                    )


                }
            </>
        )
            ;
    }
}

const mapDispatchToProps = {};


function mapStateToProps(state) {
    return {
        userPer: state.adminRes.uerPer,

    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
