import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import CustomToolbar from "./CustomToolbar";

import UpdateGreatConstructions from "./UpdateGreatConstructions";
import Chart from 'react-apexcharts'
import DayPickerRangeControllerWrapper from "../DateAirbnb/DayPickerRangeControllerWrapper";

class CrudTableComponent extends Component {

    constructor() {
        super();
        this.state = {
            loadingDates: undefined,
            popupVisibleDate: false
        };
        this.handleClick = this.handleClick.bind(this);

    }

    handleClick() {

        const { date } = this.props.date;
        if (date !== undefined) {
            let loadingDates;
            if (date.secondIso === null) {
                loadingDates = {
                    loadingDates: {
                        from: date.firstIso,
                    }
                }
            } else {
                loadingDates = {
                    loadingDates: {
                        from: date.firstIso,
                        upto: date.secondIso
                    }
                }
            }
            this.setState({
                loadingDates: loadingDates,

            });
        }

        this.setState(prevState => ({
            popupVisibleDate: !prevState.popupVisibleDate,

        }));
    }

    render() {

        const columns = [
            {
                name: "Market_title",
                label: "Intitulé du marché"
            }, {
                name: "location_name",
                label: "Emplacement"
            }, {
                name: "name",
                label: "Gérer Par"
            }, {
                name: "State_of_progress",
                label: "Etat d’avancement"
            },
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                            <UpdateGreatConstructions index={sites[tableMeta.rowIndex]} id={tableMeta.rowIndex} />
                        );
                    }
                }
            },
        ];

        const options = {
            filterType: 'dropdown',

            responsive: 'stacked',

            customToolbar: () => <CustomToolbar />
        };
        const {
            sites, statistics, date
        } = this.props;
        const {
            popupVisibleDate
        } = this.state;

        return (


            <div className='row'>
                <div className="col col-12 ">
                    {
                        sites && (
                            <MUIDataTable
                                title={"Grands Chantiers"}
                                data={sites}
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
        sites: state.constructionSites.sites,
        site: state.constructionSites.site,
        statistics: state.constructionSites.statistics,
        date: state.DatefilterReducer.date,

    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
