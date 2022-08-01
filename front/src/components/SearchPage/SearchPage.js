import React, { Component } from "react";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import DateRangePicker from "../Shared/DateRangePicker";
import ResultTable from "./ResultTable";
import { findResult } from "../../actions/searchActions";
import { NavLink } from "react-router-dom";
import MoreHorizIcon from '@material-ui/icons/MoreHoriz';
import { Business, FolderTech, Load, Sites } from "../../Constansts/search";
import { getCookie } from "../../utils/cookies";
import moment from "moment";
import UpdateBusinessNatures from "../Loads/loads/CrudTableComponent";
import NoDataFound from "../Shared/NoDataFound";

const tableColumns = {
    grandChantiers: [
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
                        <>
                            <NavLink to={"/details/2/" + tableMeta.rowIndex}>
                                <MoreHorizIcon />
                            </NavLink>
                        </>);
                }
            }
        },
    ],
    loads: [
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
                        <>
                            <NavLink to={"/details/3/" + tableMeta.rowIndex}>
                                <MoreHorizIcon />
                            </NavLink>
                        </>
                    );
                }
            }
        },
    ],
    affaires: [
        {
            name: "REF",
            label: "Réference"
        },
        {
            name: "PTE_KNOWN",
            label: "PTE_KNOWN"
        },
        {
            name: "TIT_REQ",
            label: "TIT_REQ"
        },
        {
            name: "Endroit",
            label: "Endroit"
        },
        {
            name: "Date d'entrée",
            label: "Date d'entrée"
        },
        {
            name: "DATE_LAI",
            label: "DATE LAI"
        },
        {
            name: "Unité",
            label: "Unité"
        },
        {
            name: "Prix",
            label: "Prix"
        },
        {
            name: "Inter_id",
            label: "Inter_id"
        },
        {
            name: "aff_sit_id",
            label: "aff_sit_id"
        },
        {
            name: "Id Client",
            label: "Id Client"
        },
        {
            name: "Id Résponsable",
            label: "Id Résponsable"
        },
        {
            name: "nom de la nature",
            label: "nom de la nature"
        },
        {
            name: "Actions",
            options: {
                filter: false,
                sort: false,
                empty: true,
                customBodyRender: (value, tableMeta, updateValue) => {
                    return (
                        <>
                            <NavLink to={"/details/1/" + tableMeta.rowIndex}>
                                <MoreHorizIcon />
                            </NavLink>
                        </>
                    );
                }
            }
        }
    ],
    dossiersTechs: [
        {
            name: "REF",
            label: "Réference"
        },
        {
            name: "PTE_KNOWN",
            label: "PTE_KNOWN"
        },
        {
            name: "TIT_REQ",
            label: "TIT_REQ"
        },
        {
            name: "Endroit",
            label: "Endroit"
        },
        {
            name: "Date d'entrée",
            label: "Date d'entrée"
        },
        {
            name: "DATE_LAI",
            label: "DATE LAI"
        },
        {
            name: "Unité",
            label: "Unité"
        },
        {
            name: "Prix",
            label: "Prix"
        },
        {
            name: "Inter_id",
            label: "Inter_id"
        },
        {
            name: "fold_tech_sit_id",
            label: "Situation"
        },
        {
            name: "Id Client",
            label: "Id Client"
        },
        {
            name: "Id Résponsable",
            label: "Id Résponsable"
        },
        {
            name: "nom de la nature",
            label: "nom de la nature"
        },
        {
            name: "Actions",
            options: {
                filter: false,
                sort: false,
                empty: true,
                customBodyRender: (value, tableMeta, updateValue) => {
                    return (
                        <>
                            <NavLink to={"/details/0/" + tableMeta.rowIndex}>
                                <MoreHorizIcon />
                            </NavLink>
                        </>
                    );
                }
            }
        }
    ]
}
const styles = theme => ({
    root: {
        position: 'relative',
        display: 'flex',
        width: '100%',
        height: '100%',
    },
    noElement: {
        display: "flex",
        justifyContent: "center",
    }
});

class SearchPage extends Component {
    constructor() {
        super();
        this.state = {
            columns: [],
            table: ""
        }
    }

    componentDidMount() {

    }

    handleChange = (stateElement) => {
        this.setState({ ...stateElement });
    };

    handleChangeEntity = (entity) => {
        switch (entity) {
            case FolderTech:
                this.setState({ columns: tableColumns.dossiersTechs });
                break;
            case Business:
                this.setState({ columns: tableColumns.affaires });
                break;
            case Sites:
                this.setState({ columns: tableColumns.grandChantiers });
                break;
            case Load:
                this.setState({ columns: tableColumns.loads });
                break;
            default:
                break;
        }
        this.setState({ table: entity });
    };

    handleSearch = (params) => {
        const { date } = this.props;
        const { table } = this.state;
        if (table !== "") {
            let token = this.props.token === "" ? getCookie("token") : this.props.token;
            if (token) {
                let secondIso = moment(date.secondIso);
                secondIso = secondIso.utc().format('YYYY/MM/DD');
                let firstIso = moment(date.firstIso);
                firstIso = firstIso.utc().format('YYYY/MM/DD');
                let search = {
                    table: table,
                    to: secondIso || firstIso,
                    from: firstIso
                };
                this.props.findResult(token, search);
            }
        }
    }

    render() {
        const { columns } = this.state;
        const { results, classes } = this.props;

        return (
            <>
                <DateRangePicker
                    onEntityChange={this.handleChangeEntity}
                    onSearch={this.handleSearch}
                />
                {
                    (results && results.length > 0)
                        ? (<ResultTable
                            className={classes.table}
                            title={"Rechercher"}
                            columns={columns}
                            data={results}
                        />)
                        : (
                            <div className={classes.noElement}>
                                <NoDataFound />
                            </div>
                        )
                }

            </>
        );
    }
}

function mapStateToProps(state) {
    return {
        results: state.search.results,
        token: state.login.token,
        date: state.DatefilterReducer.date,
    };
}

const mapDispatchToProps = {
    findResult
}
export default compose(
    withStyles(styles),
    connect(mapStateToProps, mapDispatchToProps),
)(SearchPage);

