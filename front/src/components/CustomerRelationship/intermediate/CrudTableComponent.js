import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import CustomToolbar from "./CustomToolbar";
import UpdateBusinessSituations from "./UpdateBusinessSituations";

class CrudTableComponent extends Component {
    render() {
        const columns = [
            {
                name: "name",
                label: "Prénom"
            }, {
                name: "second_name",
                label: "Nom"
            }, {
                name: "Street",
                label: "Rue"
            }, {
                name: "Street2",
                label: "Rue 2"
            }, {
                name: "Country",
                label: "Pays"
            }, {
                name: "Function",
                label: "Fonction"
            }, {
                name: "Cour",
                label: "Cour"
            }, {
                name: "tel",
                label: "télephone"
            }, {
                name: "city",
                label: "Pays"
            }, {
                name: "fees",
                label: "Frais"
            }, {
                name: "ZIP code",
                label: "Code postal"
            },
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                            <UpdateBusinessSituations
                                index={intermediates[tableMeta.rowIndex]}
                                id={tableMeta.rowIndex}
                            />
                        );
                    }
                }
            }
        ];

        const options = {
            filterType: "dropdown",

            responsive: "stacked",

            customToolbar: () => <CustomToolbar />
        };
        const { intermediates } = this.props;

        return (
            <div className="row">
                <div className="col col-12 ">
                    {intermediates && (
                        <MUIDataTable
                            title={"Intermédiaires"}
                            data={intermediates}
                            columns={columns}
                            options={options}
                        />
                    )}
                </div>
            </div>
        );
    }
}

const mapDispatchToProps = {};

function mapStateToProps(state) {
    return {
        intermediates: state.intermediates.intermediates
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
