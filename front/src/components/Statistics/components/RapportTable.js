import React, { Component } from "react";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
const styles = {
    root: {
        position: 'relative',
        display: 'flex',
        flexFlow: "col",
        backgroundColor: "#ffffff",
        padding: "5px",
        width: "fit-content",
        margin: "0 auto 50px auto",
        borderRadius: "10px"
    },
};


class RapportTable extends Component {

    constructor() {
        super();
    }
    componentDidMount() {

    }

    render() {
        const columns = [
            {
                name: "reference",
                label: "Reference"
            }, {
                name: "price",
                label: "Prix"
            }, {
                name: "nomClient",
                label: "Nom Client"
            },
        ];

        const options = {
            filterType: 'dropdown',
            responsive: 'stacked',
        };
        const {
            content, rapportSelected
        } = this.props;

        return (

            <div className='row'>
                <div className="col col-12 ">
                    {
                        <MUIDataTable
                            title={rapportSelected}
                            data={content}
                            columns={columns}
                            options={options}
                        />
                    }
                </div>

            </div>
        )
            ;
    }
}

RapportTable.defaultProps = {
    searchStatistics: () => { },
    getClientsSelect: () => { },
    getEmployeesSelect: () => { }
}
function mapStateToProps(state) {
    return {
        statistics: state.statistics.content,
        rapportSelected: state.statistics.rapportSelected,
    };
}

const mapDispatchToProps = {
    // khalil : getClientsSelect, getEmployeesSelect
    searchStatistics: null
};

export default compose(
    withStyles(styles),
    connect(mapStateToProps, mapDispatchToProps),
)(RapportTable
);

