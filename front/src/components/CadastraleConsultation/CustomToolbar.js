import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import {withStyles} from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import {OutTable, ExcelRenderer} from 'react-excel-renderer';

import DialogActions from "@material-ui/core/DialogActions";

import {connect} from "react-redux";
import {compose} from "recompose";
import 'react-toastify/dist/ReactToastify.min.css'
import {toast, ToastContainer} from 'react-toastify';
import {addCadastraleConsultationAction} from "../../actions/CadastralconsultationActions";
import {getCookie} from "../../utils/cookies";
import moment from "moment";


const defaultToolbarStyles = {
    iconButton: {},
};
const FontAwesomeCloseButton = ({closeToast}) => (
    <i
        className="toastify__close fa fa-times"
        onClick={closeToast}
    />
);

class CustomToolbar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open:false,
        };
    }
    handleClick = () => {
        this.setState({
            open: !this.state.open
        });
    };

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error !== '') {
            toast.error(nextProps.error)
        }
    }

    fileHandler = (event) => {
        let validExts = [".xlsx", ".xls", ".csv"];
        let fileExt;
        for (let i = 0; i < event.target.files.length; i++) {

            fileExt = event.target.files[i].name;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if (validExts.indexOf(fileExt) < 0) {
                toast.error("Invalid file selected, valid files are of " +
                    validExts.toString() + " types.");
            } else {
                ExcelRenderer(event.target.files[i], (err, resp) => {
                    if (err) {
                        toast.error(err)
                    } else {
                        this.setState({
                            cols: resp.cols,
                            rows: resp.rows
                        });
                        let ValueNeeded = [
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
                        ];
                        if (resp.rows.length > 0) {
                            let nbr = 0;
                            let indexItem = [];
                            for (let j = 0; j < resp.rows[0].length; j++) {

                                if (ValueNeeded.indexOf(resp.rows[0][j]) < 0) {
                                    nbr++
                                } else {
                                    indexItem.push({name: resp.rows[0][j], value: j})
                                }

                            }
                            if (nbr !== 0) {
                                toast.error('excel bad')

                            } else {
                                toast.success("Success Import");
                                let businessNatures = [];
                                let REQ_TIT = this.getIndexOfColmun(indexItem, 'REQ_TIT');
                                let NUM = this.getIndexOfColmun(indexItem, 'NUM');
                                let INDICE = this.getIndexOfColmun(indexItem, 'INDICE');
                                let GENRE_OP = this.getIndexOfColmun(indexItem, 'GENRE_OP');
                                let TITRE_MERE = this.getIndexOfColmun(indexItem, 'TITRE_MERE');
                                let CLEF = this.getIndexOfColmun(indexItem, 'CLEF');
                                let CONSISTANCE = this.getIndexOfColmun(indexItem, 'CONSISTANCE');
                                let COMMUNE = this.getIndexOfColmun(indexItem, 'COMMUNE');
                                let STATUT = this.getIndexOfColmun(indexItem, 'STATUT');
                                let MAPPE = this.getIndexOfColmun(indexItem, 'MAPPE');
                                let PTE_DITE = this.getIndexOfColmun(indexItem, 'PTE_DITE');
                                let SITUATION = this.getIndexOfColmun(indexItem, 'SITUATION');
                                let CONT_ARR = this.getIndexOfColmun(indexItem, 'CONT_ARR');
                                let DATE_ARCHIVE = this.getIndexOfColmun(indexItem, 'DATE_ARCHIVE');
                                let OBSERVATIONS = this.getIndexOfColmun(indexItem, 'OBSERVATIONS');
                                let PRIVE = this.getIndexOfColmun(indexItem, 'PRIVE');
                                let NBRE_FRACTION = this.getIndexOfColmun(indexItem, 'NBRE_FRACTION');
                                let DATE_DELIVRANCE = this.getIndexOfColmun(indexItem, 'DATE_DELIVRANCE');
                                let BON = this.getIndexOfColmun(indexItem, 'BON');
                                let CARNET = this.getIndexOfColmun(indexItem, 'CARNET');
                                let DATE_DEPOT = this.getIndexOfColmun(indexItem, 'DATE_DEPOT');
                                let REQ_MERE = this.getIndexOfColmun(indexItem, 'REQ_MERE');
                                let NUM_DEPOT = this.getIndexOfColmun(indexItem, 'NUM_DEPOT');
                                let BORNEUR = this.getIndexOfColmun(indexItem, 'BORNEUR');
                                let DATE_ARRIVEE = this.getIndexOfColmun(indexItem, 'DATE_ARRIVEE');
                                let RESULTAT_BORNAGE = this.getIndexOfColmun(indexItem, 'RESULTAT_BORNAGE');
                                let DATE_BORNAGE = this.getIndexOfColmun(indexItem, 'DATE_BORNAGE');
                                let Y = this.getIndexOfColmun(indexItem, 'Y');
                                let X = this.getIndexOfColmun(indexItem, 'X');

                                for (let j = 1; j < resp.rows.length; j++) {
                                    if (resp.rows[j].length > 0) {
                                        businessNatures.push(
                                            {
                                                "REQ_TIT": resp.rows[j][REQ_TIT],
                                                "NUM": resp.rows[j][NUM],
                                                "INDICE": resp.rows[j][INDICE],
                                                "GENRE_OP": resp.rows[j][GENRE_OP],
                                                "TITRE_MERE": resp.rows[j][TITRE_MERE],
                                                "CLEF": resp.rows[j][CLEF],
                                                "CONSISTANCE": resp.rows[j][CONSISTANCE],
                                                "COMMUNE": resp.rows[j][COMMUNE],
                                                "STATUT": resp.rows[j][STATUT],
                                                "MAPPE": resp.rows[j][MAPPE],
                                                "PTE_DITE": resp.rows[j][PTE_DITE],
                                                "SITUATION": resp.rows[j][SITUATION],
                                                "CONT_ARR": resp.rows[j][CONT_ARR],
                                                "DATE_ARCHIVE": moment(resp.rows[j][DATE_ARCHIVE] ,"DD/MM/YYYY").toDate(),
                                                "OBSERVATIONS": resp.rows[j][OBSERVATIONS],
                                                "PRIVE": resp.rows[j][PRIVE],
                                                "NBRE_FRACTION": resp.rows[j][NBRE_FRACTION],
                                                "DATE_DELIVRANCE": moment(resp.rows[j][DATE_DELIVRANCE], "DD/MM/YYYY").toDate(),
                                                "BON": resp.rows[j][BON],
                                                "CARNET": resp.rows[j][CARNET],
                                                "DATE_DEPOT": resp.rows[j][DATE_DEPOT],
                                                "REQ_MERE": resp.rows[j][REQ_MERE],
                                                "NUM_DEPOT": resp.rows[j][NUM_DEPOT],
                                                "BORNEUR": resp.rows[j][BORNEUR],
                                                "DATE_ARRIVEE": moment(resp.rows[j][DATE_ARRIVEE], "DD/MM/YYYY").toDate(),
                                                "RESULTAT_BORNAGE": resp.rows[j][RESULTAT_BORNAGE],
                                                "DATE_BORNAGE": moment(resp.rows[j][DATE_BORNAGE], "DD/MM/YYYY").toDate(),
                                                "Y": resp.rows[j][Y],
                                                "X": resp.rows[j][X],
                                            }
                                        )
                                    }
                                }
                                let token = this.props.token === '' ? getCookie('token') : this.props.token;

                                this.props.addCadastraleConsultationAction(token, businessNatures);
                                this.handleClick();
                            }
                        }

                    }
                });

            }
        }

    };

    getIndexOfColmun(objc, value) {
        let nbr = -1;
        for (let j = 0; j < objc.length; j++) {

            if (objc[j].name === value) {
                nbr = objc[j].value
            }
        }

        return nbr;
    }



    render() {
        const {classes} = this.props;
        const {open} = this.state;

        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title">
                        <DialogTitle id="form-dialog-title">Subscribe</DialogTitle>

                        <DialogActions>
                            <Button onClick={this.handleClick} color="primary">
                                Cancel
                            </Button>
                            <div className="form-group files">
                                <input type="file"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       className="form-control" multiple onChange={this.fileHandler.bind(this)}/>
                                <ToastContainer autoClose={4000} position={toast.POSITION.TOP_RIGHT}
                                                closeButton={<FontAwesomeCloseButton/>}/>
                            </div>
                        </DialogActions>
                    </Dialog>
                </div>
                <Tooltip title={"custom icon"}>
                    <IconButton className={classes.iconButton} onClick={this.handleClick}>
                        <AddIcon className={classes.deleteIcon}/>
                    </IconButton>
                </Tooltip>
            </React.Fragment>
        );
    }

}

const mapDispatchToProps = {

    addCadastraleConsultationAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        error: state.businessNatures.error,
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'CustomToolbar',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(CustomToolbar);
