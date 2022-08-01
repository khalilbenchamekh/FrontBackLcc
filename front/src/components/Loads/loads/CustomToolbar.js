import React, { Fragment } from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import { withStyles } from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";
import { OutTable, ExcelRenderer } from 'react-excel-renderer';
import Select from "react-select";
import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import { getCookie } from "../../../utils/cookies";
import { DropzoneDialog } from 'material-ui-dropzone'
import { connect } from "react-redux";
import { compose } from "recompose";
import 'react-toastify/dist/ReactToastify.min.css'
import { toast, ToastContainer } from 'react-toastify';

import { selectTvaHelper } from "../../../utils/select/selectHelper";
import { CheckDecimal } from "../../../utils/validation/CheckDecimal";
import MomentUtils from '@date-io/moment';
import { KeyboardDatePicker, MuiPickersUtilsProvider } from "@material-ui/pickers";
import moment from "moment";
import { formaDate, toShortFormat } from "../../../utils/dateConverter";
import { addLoadAction } from "../../../actions/loadsActions";
import Scrollbar from "react-scrollbars-custom";

const defaultToolbarStyles = {
    iconButton: {},
    inputField: {},
    rr: {
        padding: "2vh 3vh"
    },
    title: {
        background: "linear-gradient(45deg, #2ed8b666, #177d6977);",
        borderBottom: "#59e0c555 solid thick;",
        textAlign: "center",
        padding: 10
    }
};
const REF = 'REF';
const amount = 'amount';
const TVA = 'TVA';
const localeEn = moment.locale('es');

const FontAwesomeCloseButton = ({ closeToast }) => (
    <i
        className="toastify__close fa fa-times"
        onClick={closeToast}
    />
);


class CustomToolbar extends React.Component {
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
            DATE_LOAD: toShortFormat(),
            load_types_name: undefined,
            load_related_to: undefined,
            formErrors: {
                REF: "",
                amount: 0,
                TVA: 20,
                DATE_LOAD: toShortFormat(),
                load_types_name: undefined,
                load_related_to: undefined,
            },
            REFValid: false,
            amountValid: false,
            TVAValid: true,
            DATE_LOADValid: true,
            load_types_nameValid: false,
            load_related_toValid: false,
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
        this.setState({ [name]: value },
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
        formdata.append('REF', this.state.REF);
        formdata.append('amount', this.state.amount);
        formdata.append('TVA', this.state.TVA.value);
        formdata.append('DATE_LOAD', formaDate(this.state.DATE_LOAD));
        formdata.append('load_types_name', this.state.multiLoad.value);
        formdata.append('load_related_to', this.state.multiValue.value);

        this.props.addLoadAction(token, formdata);
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
                multiValueSelect: nextProps.related_to
            })
        }
        if (nextProps.load_types !== this.props.load_types) {
            this.setState({
                multiLoadSelect: nextProps.load_types
            })
        }
        if (nextProps.tva) {
            this.setState({
                multiTvaValueSelect: nextProps.tva
            })
        }

    }

    componentWillMount() {

        if (this.props.related_to) {
            this.setState({
                multiValueSelect: this.props.related_to
            })
        }
        if (this.props.load_types) {
            this.setState({
                multiLoadSelect: this.props.load_types
            })
        }
        if (this.props.tva) {
            this.setState({
                multiTvaValueSelect: this.props.tva
            })
        }

    }

    render() {
        const { multiValue, multiTvaValueSelect, multiLoadSelect, multiLoad, multiValueSelect, formValid, open } = this.state;
        const { classes } = this.props;
        let validDate = moment(this.state.DATE_LOAD).isValid();
        let validMultiValue = multiValue.label !== "" && multiValue.label;
        let validMultiLoad = multiLoad.label !== "" && multiLoad.label;

        let isValidForm = validDate
            && validMultiValue && validMultiLoad
            && formValid;
        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title-update">
                        <DialogTitle id="form-dialog-title-update">Ajouter Charge</DialogTitle>
                        <Scrollbar style={{ width: 600, height: 700 }}>
                            <div className={classes.rr}>
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
                                            onChange={date => this.setState(
                                                {
                                                    DATE_LOAD: date
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
                            </div>
                        </Scrollbar>
                    </Dialog>
                </div>
                <Tooltip title={"custom icon"}>
                    <IconButton className={classes.iconButton} onClick={this.handleClick}>
                        <AddIcon className={classes.deleteIcon} />
                    </IconButton>
                </Tooltip>
            </React.Fragment>
        );
    }

}

const mapDispatchToProps = {
    addLoadAction,
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        related_to: state.select.related_to,
        load_types: state.select.load_types,
        error: state.select.error,
        tva: selectTvaHelper()
    };
}

//export default connect(mapStateToProps, mapDispatchToProps)(CustomToolbar);
export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'CustomToolbar',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(CustomToolbar);
// export default withStyles(defaultToolbarStyles, { name: "CustomToolbar" })(connect(mapStateToProps, mapDispatchToProps), CustomToolbar);
