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
import {addLoadAction, deleteLoadAction, updateLoadAction} from "../../../actions/loadsActions";
import {getAutoCompleteAction} from "../../../actions/autoCompleteActions";
import Select from "react-select";
import moment from "moment";
import {CheckDecimal} from "../../../utils/validation/CheckDecimal";
import {findItemInArray, selectTvaHelper} from "../../../utils/select/selectHelper";
import MomentUtils from "@date-io/moment";
import {DropzoneDialog} from "material-ui-dropzone";
import {formaDate, toShortFormat} from "../../../utils/dateConverter";
import {i_need_id, i_need_name} from "../../../Constansts/selectHelper";

const localeEn = moment.locale('es');

const defaultToolbarStyles = {
    iconButton: {},
};
const REF = 'REF';
const amount = 'amount';
const TVA = 'TVA';
const DATE_LOAD = 'DATE_LOAD';
const load_types_name = 'load_types_name';
const load_related_to = 'load_related_to';


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
            REF: "",
            amount: 0,
            TVA: 20,
            DATE_LOAD:  toShortFormat(),
            load_types_name: undefined,
            load_related_to: undefined,
            formErrors: {
                REF: "",
                amount: 0,
                TVA: 20,

            },
            REFValid: false,
            amountValid: false,
            TVAValid: true,
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
        let REFValid = this.state.REFValid;
        let amountValid = this.state.amountValid;

        switch (fieldName) {

            case 'REF':
                REFValid = value.length > 0;
                fieldValidationErrors.REF = REFValid ? '' : ' is Required';
                break;
            case 'amount':
                amountValid = CheckDecimal(parseFloat(value));
                fieldValidationErrors.amount = amountValid ? '' : ' is Required';
                break;

            default:
                break;
        }
        this.setState({
            formErrors: fieldValidationErrors,
            REFValid: REFValid,
            amountValid: amountValid,

        }, this.validateForm);
    }
    validateForm() {
        this.setState({
            formValid:
                this.state.REFValid && this.state.amountValid
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
    submitForm = (e)=> {
        let formdata = new FormData();
        e.preventDefault();
        let files =this.state.files;
        files.forEach(file => {
            formdata.append('filenames[]', file);
        });
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        formdata.append('REF',this.state.REF);
        formdata.append('amount',this.state.amount);
        formdata.append('TVA',this.state.TVA.value);
        formdata.append('DATE_LOAD',formaDate(this.state.DATE_LOAD));
        formdata.append('load_types_name',this.state.multiLoad.value);
        formdata.append('load_related_to',this.state.multiValue.value);
        formdata.append('id',this.props.index.id);
        formdata.append('_method', 'PUT');
        this.props.updateLoadAction(token, formdata, this.props.index.id,this.props.id);
        this.setState({
            open: !this.state.open
        });
    };

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error) {
            toast.error(nextProps.error)
        }
        if (nextProps.related_to !== this.props.related_to) {
            this.setState({
                multiValue:findItemInArray(nextProps.related_to,nextProps.index.load_related_to,i_need_id),
                multiValueSelect: nextProps.related_to
            })
        }

        if (nextProps.load_types !== this.props.load_types) {
            this.setState({
                multiLoad:findItemInArray(nextProps.load_types,nextProps.index.load_types_name,i_need_name),
                multiLoadSelect: nextProps.load_types
            })
        }
        if (nextProps.tva) {

            this.setState({
                TVA:findItemInArray(nextProps.tva,nextProps.index.TVA,i_need_name),
                multiTvaValueSelect: nextProps.tva
            })
        }

    }


componentDidMount() {
        if (this.props.index) {

            let arr = [
                {
                    name: REF,
                    value: this.props.index.REF
                }, {
                    name: amount,
                    value: this.props.index.amount
                }
            ];

            for (let i = 0; i < arr.length; i++) {
                const name = arr[i].name;
                const value = arr[i].value;
                this.setState({[name]: value},
                    () => {
                        this.validateField(name, value)
                    },
                );
            }
        }

    }

    delete = () => {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        let obj = {
            id: this
                .props.index.id,
            REF: this.state.REF,
            amount: this.state.amount,
            TVA: this.state.TVA,
            DATE_LOAD: this.state.DATE_LOAD,
            load_types_name: this.state.load_types_name,
            load_related_to: this.state.load_related_to,
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
        const {multiValue, multiTvaValueSelect, multiLoadSelect, multiLoad, multiValueSelect, formValid, open} = this.state;
        const {classes} = this.props;
        let validDate= moment(this.state.DATE_LOAD).isValid();
        let validMultiValue=multiValue.label !== "" && multiValue.label;
        let validMultiLoad= multiLoad.label !== "" && multiLoad.label;
        let isValidForm = validDate
            && validMultiValue && validMultiLoad
            &&formValid;
        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title-update">
                        <DialogTitle id="form-dialog-title-update">Subscribe</DialogTitle>
                        <form onSubmit={this.submitForm}>

                            <TextField
                                defaultValue={this.state.REF} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id={REF}
                                label={REF}
                                type="text"
                                name={REF}
                                fullWidth
                            />
                            <TextField
                                defaultValue={this.state.amount} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id={amount}
                                label="Montant"
                                type="text"
                                name={amount}
                                fullWidth
                            />
                            <div className='table-index-no_margin'>
                                <Select
                                    name={TVA}
                                    placeholder="TVA"
                                    value={this.state.TVA}
                                    options={multiTvaValueSelect}
                                    onChange={this.handleTvaMultiChange}
                                />
                            </div>
                            <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                <KeyboardDatePicker
                                    label="Date de facturation"
                                    variant="inline"
                                    format="DD/MM/YYYY"
                                    autoOk
                                    inputVariant="outlined"
                                    InputAdornmentProps={{ position: "start" }}
                                    placeholder={this.state.DATE_LOAD}
                                    value={this.state.DATE_LOAD}
                                    onChange={date =>  this.setState(
                                        {
                                            DATE_LOAD:date
                                        }
                                    )}

                                />

                            </MuiPickersUtilsProvider>
                            <div className='table-index-no_margin'>
                                <Select
                                    name="liée"
                                    placeholder="Charge liée à"
                                    value={multiValue}
                                    options={multiValueSelect}
                                    onChange={this.handleMultiChange}
                                />
                            </div>
                            <div className='table-index-no_margin'>
                                <Select
                                    name="multiLoad"
                                    placeholder="Type de charge"
                                    value={multiLoad}
                                    options={multiLoadSelect}
                                    onChange={this.handleMultiLoadSelectChange}
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
    updateLoadAction,
    addLoadAction,
    getAutoCompleteAction,
    deleteLoadAction
};

function mapStateToProps(state) {
    return {
        token: state.login.token,
        related_to: state.select.related_to,
        load_types: state.select.load_types,
        error: state.select.error,
        tva:selectTvaHelper()
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'UpdateBusinessNatures',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(UpdateBusinessNatures);
