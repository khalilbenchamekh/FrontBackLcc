import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import CustomToolbar from "./CustomToolbar";
import { checkCookie } from "../../utils/cookies";
import { owner } from "../../Constansts/file";
import ConsultationDetails from "./ConsultationDetails";



class CrudTableComponent extends Component {


    render() {

        const columns = [

            'REQ_TIT',
            'NUM',
            'INDICE',
            'GENRE_OP',
            'TITRE_MERE',
            'REQ_MERE',
            'X',
            'Y',
            'DATE_ARRIVEE',
            'DATE_BORNAGE',
            'RESULTAT_BORNAGE',
            'BORNEUR',
            'NUM_DEPOT',
            'DATE_DEPOT',
            'CARNET',
            'BON',
            'DATE_DELIVRANCE',
            'NBRE_FRACTION',
            'PRIVE',
            'OBSERVATIONS',
            'DATE_ARCHIVE',
            'CONT_ARR',
            'SITUATION',
            'PTE_DITE',
            'MAPPE',
            'STATUT',
            'COMMUNE',
            'CONSISTANCE',
            'CLEF',
            {
                name: "Actions",
                options: {
                    filter: false,
                    sort: false,
                    empty: true,
                    customBodyRender: (value, tableMeta, updateValue) => {
                        return (
                            <ConsultationDetails
                                files={[{ link: "#hello", content: "contrat-458786.pdf" }]}
                            />
                        );
                    }
                }
            }
        ];

        const options = {
            filterType: 'dropdown',

            responsive: 'stacked',

            customToolbar: () => checkCookie() === owner ? <CustomToolbar /> : undefined
        };
        const { cadaster } = this.props;

        return (


            <div className='row'>
                <div className="col col-12 ">

                    {
                        cadaster && (
                            <MUIDataTable
                                title={"Consultation Cadastrale"}
                                data={cadaster}
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
        cadaster: state.cadastraux.cadaster,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
