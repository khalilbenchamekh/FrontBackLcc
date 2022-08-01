import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import {withStyles} from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import {OutTable, ExcelRenderer} from "react-excel-renderer";
import Scrollbar from "react-scrollbars-custom";
import TextField from "@material-ui/core/TextField";
import {getCookie} from "../../utils/cookies";

import {connect} from "react-redux";
import {compose} from "recompose";
import "react-toastify/dist/ReactToastify.min.css";
import {toast, ToastContainer} from "react-toastify";
import {addEmployeeAction} from "../../actions/employeeActions";
import Select from "react-select";

import {
    KeyboardDatePicker, MuiPickersUtilsProvider,
} from '@material-ui/pickers';
import {DropzoneDialog} from "material-ui-dropzone";
import {formaDate, toShortFormat} from "../../utils/dateConverter";
import MomentUtils from "@date-io/moment";
import moment from "moment";
import {gender, workplace} from "../../Constansts/appconstant";
import {CheckDecimal} from "../../utils/validation/CheckDecimal";
import {validateEmail} from "../../utils/employee";

const localeEn = moment.locale('es');

const defaultToolbarStyles = {
    iconButton: {
        background: "#ffffffaa",
        padding: "5px",
        margin: "10px 0",
        "&:hover": {
            background: "#ffffff",
        }
    },
    inputField: {},
    rr: {
        padding: "2vh 3vh"
    },
    title: {
        background: "linear-gradient(45deg, #2ed8b666, #177d6977);",
        borderBottom: "#59e0c555 solid thick;",
        textAlign: "center",
        padding: 10
    },
    controlButtons: {
        display: "flex",
        alignItems: "end",
        justifyContent: "flex-end",
        marginTop: 10
    }
};


class CustomToolbar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            openDropZone: false,
            files: [],
            multiValueWork: [],
            multiValue: [],
            open: false,
            id: "",
            personal_number: "",
            profession_number: "",
            position_held: "",
            Salary: "",
            workplace: "",
            formErrors: {},
            birthdate: toShortFormat(),
            Start_date: toShortFormat(),
        };
        this.handleChange = this.handleChange.bind(this);
        this.handleMultiChange = this.handleMultiChange.bind(this);
        this.handleMultiWorkChange = this.handleMultiWorkChange.bind(this);
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

    handleClose() {
        this.setState({
            openDropZone: false
        });
    }

    handleClick = () => {
        this.setState({
            open: !this.state.open
        });
    };
    addClick = () => {
        const {formValid} = this.state;
        this.validateForm();
        if (!formValid) {
            return;
        }
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        let formdata = new FormData();
        let files = this.state.files;
        files.forEach(file => {
            formdata.append('filenames[]', file);
        });
        formdata.append('Salary', this.state.Salary);
        formdata.append('workplace', this.state.workplace);
        formdata.append('position_held', this.state.position_held);
        formdata.append('profession_number', this.state.profession_number);
        formdata.append('Start_date', formaDate(this.state.Start_date));
        formdata.append('personal_number', this.state.personal_number);
        formdata.append('username', this.state.username);
        formdata.append('email', this.state.email);
        formdata.append('firstname', this.state.firstname);
        formdata.append('middlename', this.state.middlename);
        formdata.append('lastname', this.state.lastname);
        formdata.append('birthdate', formaDate(this.state.birthdate));
        formdata.append('address', this.state.address);
        formdata.append('gender', this.state.multiValue.value);
        formdata.append('workplace', this.state.multiValueWork.value);
        this.props.addEmployeeAction(token, formdata);
        this.setState({
            open: !this.state.open
        });
    };

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error !== "") {
            toast.error(nextProps.error);
        }
    }

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let personal_numberValid, profession_numberValid, position_heldValid, SalaryValid,
            workplaceValid, firstnameValid, lastnameValid, addressValid,
            usernameValid,
            emailValid;

        switch (fieldName) {
            case "firstname":
                firstnameValid = value.length > 0;
                fieldValidationErrors.firstnameValid = firstnameValid
                    ? ""
                    : " is Required";
                break;
            case "lastname":
                lastnameValid = value.length > 0;
                fieldValidationErrors.lastnameValid = lastnameValid
                    ? ""
                    : " is Required";
                break;
            case "address":
                addressValid = value.length > 0;
                fieldValidationErrors.addressValid = addressValid
                    ? ""
                    : " is Required";
                break;
            case "username":
                usernameValid =validateEmail(value);
                fieldValidationErrors.usernameValid = usernameValid
                    ? ""
                    : " is Required";
                break;
            case "email":
                emailValid = value.length > 0;
                fieldValidationErrors.emailValid = emailValid
                    ? ""
                    : " is Required";
                break;
            case "personal_number":
                personal_numberValid = value.length > 0;
                fieldValidationErrors.personal_numberValid = personal_numberValid
                    ? ""
                    : " is Required";
                break;
            case "profession_number":
                profession_numberValid = value.length > 0;
                fieldValidationErrors.profession_numberValid = profession_numberValid
                    ? ""
                    : " is Required";
                break;

            case "position_held":
                position_heldValid = value.length > 0;
                fieldValidationErrors.position_heldValid = value.length ? "" : " is Required";
                break;

            case "Salary":
                SalaryValid = CheckDecimal(parseFloat(value));
                fieldValidationErrors.SalaryValid = value.length ? "" : " is Required";
                break;

            case "workplace":
                workplaceValid = value.length > 0;
                fieldValidationErrors.workplaceValid = value.length ? "" : " is Required";
                break;
            default:
                return this.state;
        }
        this.setState(
            {
                formErrors: fieldValidationErrors,
                personal_numberValid,
                profession_numberValid, firstnameValid, lastnameValid, addressValid,
                usernameValid,
                emailValid,
                position_heldValid,
                SalaryValid,
                workplaceValid
            },
            this.validateForm
        );
    }


    validateForm = () => {
        let isValid = true;

        const {
            firstname, lastname, address,
            username, multiValue,
            multiValueWork,
            email,
            personal_number,
            profession_number,
            position_held,
            Start_date,
            Salary,
            workplace,
        } = this.state;
        const errors = {};
        let validMultiValue = multiValue.label !== "" && multiValue.label;
        let validMultiValueWork = multiValueWork.label !== "" && multiValueWork.label;

        if (firstname === "") {
            errors.firstname = "is Required";
            isValid = false;
        } else {
            errors.firstname = "";
        }
        if (username === "") {
            errors.username = "is Required";
            isValid = false;
        } else {
            errors.username = "";
        }
        if (email === "") {
            errors.email = "is Required";
            isValid = false;
        } else {
            errors.email = "";
        }
        if (personal_number === "") {
            errors.personal_number = "is Required";
            isValid = false;
        } else {
            errors.personal_number = "";
        }
        if (lastname === "") {
            errors.lastname = "is Required";
            isValid = false;
        } else {
            errors.lastname = "";
        }
        if (address === "") {
            errors.address = "is Required";
            isValid = false;
        } else {
            errors.address = "";
        }
        if (profession_number === "") {
            errors.profession_number = "is Required";
            isValid = false;
        } else {
            errors.profession_number = "";
        }
        if (position_held === "") {
            errors.position_held = "is Required";
            isValid = false;
        } else {
            errors.position_held = "";
        }
        if (Start_date === "") {
            errors.Start_date = "is Required";
            isValid = false;
        } else {
            errors.Start_date = "";
        }
        if (Salary === "") {
            errors.Salary = "is Required";
            isValid = false;
        } else {
            errors.Salary = "";
        }
        if (workplace === "") {
            errors.workplace = "is Required";
            isValid = false;
        } else {
            errors.workplace = "";
        }
        this.setState({
            formErrors: {...errors},
        });

        return isValid && validMultiValue && validMultiValueWork;
    };

    handleMultiChange(option) {

        this.setState({
            multiValue: option
        });

    }

    handleMultiWorkChange(option) {

        this.setState({
            multiValueWork: option
        });

    }

    handleChange(e) {
        const name = e.target.name;
        const value = e.target.value;
        this.setState({[name]: value}, () => {
            this.validateField(name, value);
        });
    }

    render() {
        const {classes} = this.props;
        const {open, formErrors} = this.state;
        const {formValid, birthdate, Start_date, multiValue, multiValueWork} = this.state;

        return (
            <React.Fragment>
                <div>
                    <Dialog
                        open={open}
                        onClose={this.handleClick}
                        aria-labelledby="form-dialog-title"
                    >
                        <DialogTitle className={classes.title} id="form-dialog-title">
                            Ajouter un employer
                        </DialogTitle>
                        <Scrollbar style={{width: 600, height: 700}}>
                            <div className={classes.rr}>
                                <TextField
                                    value={this.state.email}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="email"
                                    label="email"
                                    type="text"
                                    name="email"
                                    fullWidth
                                    error={formErrors.email}
                                    helperText={formErrors.email}
                                />
                                <TextField
                                    value={this.state.username}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="username"
                                    label="Nom d'utilisateur"
                                    type="text"
                                    name="username"
                                    fullWidth
                                    error={formErrors.username}
                                    helperText={formErrors.username}
                                />
                                <TextField
                                    value={this.state.firstname}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="firstname"
                                    label="Prénom"
                                    type="text"
                                    name="firstname"
                                    fullWidth
                                    error={formErrors.firstname}
                                    helperText={formErrors.firstname}
                                />
                                <TextField
                                    value={this.state.middlename}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="middlename"
                                    label="deuxième nom"
                                    type="text"
                                    name="middlename"
                                    fullWidth
                                    error={formErrors.middlename}
                                    helperText={formErrors.middlename}
                                />
                                <TextField
                                    value={this.state.lastname}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="lastname"
                                    label="nom de famille"
                                    type="text"
                                    name="lastname"
                                    fullWidth
                                    error={formErrors.lastname}
                                    helperText={formErrors.lastname}
                                />
                                <TextField
                                    value={this.state.address}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="address"
                                    label="nom complete"
                                    type="text"
                                    name="address"
                                    fullWidth
                                    error={formErrors.address}
                                    helperText={formErrors.address}
                                />
                                <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                    <KeyboardDatePicker
                                        label="Date de naissance"
                                        variant="inline"
                                        format="DD/MM/YYYY"
                                        autoOk
                                        inputVariant="outlined"
                                        InputAdornmentProps={{position: "start"}}
                                        placeholder={birthdate}
                                        value={birthdate}
                                        onChange={date => this.setState(
                                            {
                                                birthdate: date
                                            }
                                        )}

                                    />
                                </MuiPickersUtilsProvider>
                                <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                    <KeyboardDatePicker
                                        label="Date de début"
                                        variant="inline"
                                        format="DD/MM/YYYY"
                                        autoOk
                                        inputVariant="outlined"
                                        InputAdornmentProps={{position: "start"}}
                                        placeholder={Start_date}
                                        value={Start_date}
                                        onChange={date => this.setState(
                                            {
                                                Start_date: date
                                            }
                                        )}

                                    />
                                </MuiPickersUtilsProvider>
                                <TextField
                                    defaultValue={this.state.personal_number}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="personal_number"
                                    label="numéro personnel"
                                    type="text"
                                    name="personal_number"
                                    fullWidth
                                    error={formErrors.personal_number}
                                    helperText={formErrors.personal_number}
                                />
                                <TextField
                                    defaultValue={this.state.profession_number}
                                    onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="profession_number"
                                    label="numéro professionnelle"
                                    type="text"
                                    name="profession_number"
                                    fullWidth
                                    error={formErrors.profession_number}
                                    helperText={formErrors.profession_number}
                                />
                                <TextField
                                    defaultValue={this.state.position_held}
                                    onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="position_held"
                                    label="poste occupé"
                                    type="text"
                                    name="position_held"
                                    fullWidth
                                    error={formErrors.position_held}
                                    helperText={formErrors.position_held}
                                />
                                <div className='table-index-no_margin'>
                                    <Select
                                        name="liée"
                                        placeholder="Gender"
                                        value={multiValue}
                                        options={gender}
                                        onChange={this.handleMultiChange}
                                    />
                                </div>
                                <div className='table-index-no_margin'>
                                    <Select
                                        name="liée"
                                        placeholder="workplace"
                                        value={multiValueWork}
                                        options={workplace}
                                        onChange={this.handleMultiWorkChange}
                                    />
                                </div>
                                <TextField
                                    defaultValue={this.state.Salary}
                                    onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="Salary"
                                    label="Salaire"
                                    type="Salary"
                                    name="Salary"
                                    fullWidth
                                    error={formErrors.Salary}
                                    helperText={formErrors.Salary}
                                />

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

                                <div className={classes.controlButtons}>
                                    <Button onClick={this.handleClick} color="primary">
                                        Cancel
                                    </Button>
                                    <Button
                                        disabled={!formValid}
                                        onClick={this.addClick}
                                        color="primary"
                                    >
                                        Add
                                    </Button>
                                </div>
                            </div>
                        </Scrollbar>
                    </Dialog>
                </div>
                <Tooltip title={"custom icon"}>
                    <IconButton className={classes.iconButton} onClick={this.handleClick}>
                        <AddIcon className={classes.addIcon}/>
                    </IconButton>
                </Tooltip>
            </React.Fragment>
        );
    }
}

const mapDispatchToProps = {
    addEmployeeAction,
};

function mapStateToProps(state) {
    return {
        token: state.login.token,

    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: "FormAddEmployee"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(CustomToolbar);
