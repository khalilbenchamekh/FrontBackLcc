import 'date-fns';
import React from 'react';
import Grid from '@material-ui/core/Grid';
import DateFnsUtils from '@date-io/date-fns';
import {
    MuiPickersUtilsProvider,
    KeyboardTimePicker,
    KeyboardDatePicker,
} from '@material-ui/pickers';

import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import {getCookie} from "../../../utils/cookies";

import {connect} from "react-redux";

import 'react-toastify/dist/ReactToastify.min.css'
import {toast, ToastContainer} from 'react-toastify';

import IconButton from "@material-ui/core/IconButton";
import EditIcon from "@material-ui/icons/EditOutlined";

import PropTypes from 'prop-types';
import {withStyles} from "@material-ui/core";
import {compose} from "recompose";
import Tooltip from "@material-ui/core/Tooltip";
import {confirmAlert} from 'react-confirm-alert'; // Import
import 'react-confirm-alert/src/react-confirm-alert.css';
import RevertIcon from "@material-ui/icons/NotInterestedOutlined";
import Select from "react-select";
import moment from "moment";
import {CheckDecimal} from "../../../utils/validation/CheckDecimal";
import {findItemInArray, selectTvaHelper} from "../../../utils/select/selectHelper";
import MomentUtils from "@date-io/moment";
import {DropzoneDialog} from "material-ui-dropzone";
import {formaDate, toShortFormat} from "../../../utils/dateConverter";
import {i_need_id, i_need_name} from "../../../Constansts/selectHelper";
import {deleteChargeAction, updateChargeAction} from "../../../actions/chargeActions";
import FormControlLabel from "@material-ui/core/FormControlLabel";
import Checkbox from "@material-ui/core/Checkbox";


const localeEn = moment.locale('es');

const defaultToolbarStyles = {
    iconButton: {},
};


class UpdateBusinessNatures extends React.Component {
    static propTypes = {
        index: PropTypes.object.isRequired,
        id: PropTypes.number.isRequired,
    };

    constructor(props) {
        super(props);
        this.state = {
            openDropZone: false,
            files: [],
            multiValue: [],
            multiValueSelect: [],
            multiLoad: [],
            multiLoadSelect: [],
            open: false,
            others: ''
            , observation: ''
            , desi: ''
            , num_quit: '', date_fac: toShortFormat(), date_pai: toShortFormat(), date_del: toShortFormat(),
            unite: 0, archive: 0, isPayed: 0, reste: 0, avence: 0, somme_due: 0,
            formErrors: {
                others: ''
                , observation: ''
                , desi: ''
                , num_quit: '', date_fac: toShortFormat(), date_pai: toShortFormat(), date_del: toShortFormat(),

            },
            othersValid: false
            , observationValid: false
            , desiValid: false
            , num_quitValid: false,
            formValid: false,
        };
        this.handleChange = this.handleChange.bind(this);
        this.handleMultiChange = this.handleMultiChange.bind(this);
        this.handleMultiLoadSelectChange = this.handleMultiLoadSelectChange.bind(this);
        this.handleTvaMultiChange = this.handleTvaMultiChange.bind(this);


    }

    handleClose() {
        this.setState({
            openDropZone: false
        });
    }

    handleSave(files) {
        //Saving files to state for further use and closing Modal.
        this.setState({
            files: files,
            openDropZone: false
        });
    }

    handleOpen() {
        this.setState({
            openDropZone: true,
        });
    }

    handleMultiChange(option) {

        this.setState({
            multiValue: option
        });

    }

    handleTvaMultiChange(option) {

        this.setState({
            TVA: option
        });

    }

    handleMultiLoadSelectChange(option) {

        this.setState({
            multiLoad: option
        });

    }

    handleClick = () => {
        this.setState({
            open: !this.state.open
        });

    };

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let othersValid = this.state.othersValid;
        let observationValid = this.state.observationValid;
        let desiValid = this.state.desiValid;
        let num_quitValid = this.state.num_quitValid;

        switch (fieldName) {
            // ;
            case 'others':
                othersValid = value.length > 0;
                fieldValidationErrors.REF = othersValid ? '' : ' is Required';
                break;
            case 'observation':
                observationValid = value.length > 0;
                fieldValidationErrors.observation = observationValid ? '' : ' is Required';
                break;
            case 'desi':
                desiValid = value.length > 0;
                fieldValidationErrors.desi = desiValid ? '' : ' is Required';
                break;
            case 'num_quit':
                num_quitValid = value.length > 0;
                fieldValidationErrors.num_quit = num_quitValid ? '' : ' is Required';
                break;
            default:
                break;
        }
        this.setState({
            formErrors: fieldValidationErrors,
            othersValid: othersValid,
            num_quitValid: num_quitValid,
            desiValid: desiValid,
            observationValid: observationValid,
        }, this.validateForm);
    }

    handleChangeCheckbox = (event) => {
        let ch = event.target.checked ===true ? 1:0;
        this.setState({
            [event.currentTarget.name]: ch
        });

    };

    validateForm() {
        this.setState({
            formValid:
                this.state.othersValid && this.state.num_quitValid &&
                this.state.observationValid && this.state.desiValid && CheckDecimal(parseFloat(this.state.unite)) &&
                CheckDecimal(parseFloat(this.state.avence)) && CheckDecimal(parseFloat(this.state.somme_due))
                && CheckDecimal(parseFloat(this.state.reste))
        });
    }

    handleChange(e) {
        const name = e.target.name;
        const value = e.target.value;
        this.setState({[name]: value},
            () => {
                this.validateField(name, value)
            });
    }

    submitForm = (e) => {
        let formdata = new FormData();
        e.preventDefault();
        let files = this.state.files;
        files.forEach(file => {
            formdata.append('filenames[]', file);
        });
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        formdata.append('others', this.state.others);
        formdata.append('observation', this.state.observation);
        formdata.append('desi', this.state.desi);
        formdata.append('num_quit', this.state.num_quit);
        formdata.append('date_fac', formaDate(this.state.date_fac));
        formdata.append('date_pai', formaDate(this.state.date_pai));
        formdata.append('date_del', formaDate(this.state.date_del));
        formdata.append('unite', this.state.unite);
        formdata.append('archive', this.state.archive);
        formdata.append('isPayed', this.state.isPayed);
        formdata.append('reste', this.state.reste);
        formdata.append('avence', this.state.avence);
        formdata.append('somme_due', this.state.somme_due);
        formdata.append('typeSchargesId', this.state.multiLoad.value);
        formdata.append('invoiceStatus_id', this.state.multiValue.value);
        formdata.append('_method', 'PUT');
        this.props.updateChargeAction(token, formdata, this.props.index.id, this.props.id);
        this.setState({
            open: !this.state.open
        });

    };


    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error) {
            toast.error(nextProps.error)
        }
        if (nextProps.invoiceStatusId !== this.props.invoiceStatusId) {
            this.setState({
                multiValue: findItemInArray(nextProps.invoiceStatusId, nextProps.index.invoiceStatusId, i_need_id),
                multiValueSelect: nextProps.invoiceStatusId
            })
        }

        if (nextProps.chargeTypesId) {
            if(nextProps.chargeTypesId.length >0){
                this.setState({
                    multiLoad: findItemInArray(nextProps.chargeTypesId, nextProps.index.typeSchargeId, i_need_id),
                    multiLoadSelect: nextProps.chargeTypesId
                })

            }
          
        }
        if (this.props.index) {

            this.setState(this.props.index
                );
                
                this.setState({
                    formValid:true
                }
                    );
    }


    }


 

    delete = () => {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        let obj = {
            id: this
                .props.index.id,
        };

        confirmAlert({
            title: 'Confirm to submit',
            message: 'Are you sure to do this ',
            buttons: [
                {
                    label: 'Yes',
                    onClick: () => this.props.deleteLoadAction(token, obj, this.props.id)
                },
                {
                    label: 'No',
                }
            ]
        });
    };


    render() {
        const {multiValue, others, observation, desi, num_quit, date_fac, date_pai, date_del, unite, archive, isPayed, reste, avence, somme_due, multiLoadSelect, multiLoad, multiValueSelect, formValid, open} = this.state;
        const {classes} = this.props;
        let validDate = moment(this.state.date_fac).isValid() && moment(this.state.date_pai).isValid() && moment(this.state.date_del).isValid();
        let validMultiValue = multiValue.label !== "" && multiValue.label;
        let validMultiLoad = multiLoad.label !== "" && multiLoad.label;

        let isValidForm = validDate
            && validMultiValue && validMultiLoad
            && formValid;
        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title-update">
                        <DialogTitle id="form-dialog-title-update">Subscribe</DialogTitle>
                        <form onSubmit={this.submitForm}>

                            <TextField
                                defaultValue={others} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="others"
                                label={"Autres"}
                                type="text"
                                name="others"
                                fullWidth
                            /> <TextField
                            defaultValue={num_quit} onChange={this.handleChange}
                            autoFocus
                            margin="dense"
                            id="num_quit"
                            label={"Numéro de Quittance"}
                            type="text"
                            name="num_quit"
                            fullWidth
                        />
                            <TextField
                                defaultValue={observation} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="observation"
                                label="Observation"
                                type="text"
                                name="observation"
                                fullWidth
                            />
                            <TextField
                                defaultValue={desi} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="desi"
                                label="Désignation"
                                type="text"
                                name="desi"
                                fullWidth
                            />
                            <TextField
                                defaultValue={somme_due} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="somme_due"
                                label="Somme Due"
                                type="text"
                                name="somme_due"
                                fullWidth
                            /> <TextField
                            defaultValue={avence} onChange={this.handleChange}
                            autoFocus
                            margin="dense"
                            id="avence"
                            label="Avence"
                            type="text"
                            name="avence"
                            fullWidth
                        /> <TextField
                            defaultValue={reste} onChange={this.handleChange}
                            autoFocus
                            margin="dense"
                            id="reste"
                            label="Reste"
                            type="text"
                            name="reste"
                            fullWidth
                        />
                            <TextField
                                defaultValue={unite} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="unite"
                                label="unite"
                                type="text"
                                name="unite"
                                fullWidth
                            />

                            <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                <KeyboardDatePicker
                                    label="Date de facturation"
                                    variant="inline"
                                    format="DD/MM/YYYY"
                                    autoOk
                                    inputVariant="outlined"
                                    InputAdornmentProps={{position: "start"}}
                                    placeholder={date_fac}
                                    value={date_fac}
                                    onChange={date => this.setState(
                                        {
                                            date_fac: date
                                        }
                                    )}

                                />

                            </MuiPickersUtilsProvider>
                            <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                <KeyboardDatePicker
                                    label="Date de paiement"
                                    variant="inline"
                                    format="DD/MM/YYYY"
                                    autoOk
                                    inputVariant="outlined"
                                    InputAdornmentProps={{position: "start"}}
                                    placeholder={date_pai}
                                    value={date_pai}
                                    onChange={date => this.setState(
                                        {
                                            date_pai: date
                                        }
                                    )}

                                />

                            </MuiPickersUtilsProvider>
                            <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                <KeyboardDatePicker
                                    label="Date de délivrance"
                                    variant="inline"
                                    format="DD/MM/YYYY"
                                    autoOk
                                    inputVariant="outlined"
                                    InputAdornmentProps={{position: "start"}}
                                    placeholder={date_del}
                                    value={date_del}
                                    onChange={date => this.setState(
                                        {
                                            date_del: date
                                        }
                                    )}

                                />

                            </MuiPickersUtilsProvider>
                            <div className='table-index-no_margin'>
                                <Select
                                    name="liée"
                                    placeholder="Etat de facture"
                                    value={multiValue}
                                    options={multiValueSelect}
                                    onChange={this.handleMultiChange}
                                />
                            </div>
                            <div className='table-index-no_margin'>
                                <Select
                                    name="multiLoad"
                                    placeholder="Type de la charge"
                                    value={multiLoad}
                                    options={multiLoadSelect}
                                    onChange={this.handleMultiLoadSelectChange}
                                />
                            </div>
                            <div className="">

                                <FormControlLabel
                                    control={
                                        <Checkbox
                                            checked={archive}
                                            name="archive"
                                            color="primary"
                                            onChange={this.handleChangeCheckbox}
                                        />
                                    }
                                    label="archive"
                                />
                                <FormControlLabel
                                    control={
                                        <Checkbox
                                            checked={isPayed}
                                            name="isPayed"
                                            color="primary"
                                            onChange={this.handleChangeCheckbox}
                                        />
                                    }
                                    label="isPayed"
                                />

                            </div>
                            <div>
                                <Button onClick={this.handleOpen.bind(this)}>
                                    Document liés à la charge
                                </Button>
                                <DropzoneDialog
                                    open={this.state.openDropZone}
                                    onSave={this.handleSave.bind(this)}
                                    showPreviews={true}
                                    maxFileSize={5000000}
                                    onClose={this.handleClose.bind(this)}
                                />
                            </div>
                            <button disabled={!isValidForm} type="submit">Validé</button>
                            <Button onClick={this.handleClick} color="primary">
                                Cancel
                            </Button>
                        </form>
                    </Dialog>
                </div>
                <Tooltip title={"edit icon"}>
                    <IconButton className={classes.iconButton} onClick={this.handleClick}>
                        <EditIcon className={classes.deleteIcon}/>
                    </IconButton>
                </Tooltip>
                <Tooltip title={"delete icon"}>

                    <IconButton className={classes.iconButton} onClick={this.delete}>
                        <RevertIcon className={classes.deleteIcon}/>
                    </IconButton>

                </Tooltip>
            </React.Fragment>

        );
    }

}

const mapDispatchToProps = {
    updateChargeAction, deleteChargeAction
};

function mapStateToProps(state) {
    return {
        token: state.login.token,
        invoiceStatusId: state.select.invoiceStatusId,
        chargeTypesId: state.select.chargeTypesId,
        error: state.select.error,
        tva: selectTvaHelper()
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'UpdateBusinessNatures',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(UpdateBusinessNatures);
