import React, {Component} from "react";
import MUIDataTable from "mui-datatables";
import {connect} from "react-redux";
import CustomToolbar from "./CustomToolbar";


import UpdateBusinessNatures from "./UpdateBusinessNatures";


class CrudTableComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            id:undefined
        };
    }

    render() {

        const columns = [
            {
                name: "name",
                label: "Nom"
            },
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                           <UpdateBusinessNatures index={ loadNatures[tableMeta.rowIndex]} id={tableMeta.rowIndex}/>
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
        const {loadNatures} = this.props;

        return (


                <div className='row'>
                    <div className="col col-12 ">

                        {
                            loadNatures && (
                                <MUIDataTable
                                    title={"title"}
                                    data={loadNatures}
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

const mapDispatchToProps = {

};


function mapStateToProps(state) {
    return {
        loadNatures: state.loadNature.loadNatures,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
