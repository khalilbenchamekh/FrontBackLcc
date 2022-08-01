import React from "react";

import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import {getCookie} from "../../utils/cookies";

import {connect} from "react-redux";

import "react-toastify/dist/ReactToastify.min.css";
import {toast} from "react-toastify";

import IconButton from "@material-ui/core/IconButton";
import EditIcon from "@material-ui/icons/EditOutlined";
import CircularProgress from "@material-ui/core/CircularProgress";

import PropTypes from "prop-types";
import {withStyles} from "@material-ui/core";
import {compose} from "recompose";
import Tooltip from "@material-ui/core/Tooltip";
import {confirmAlert} from "react-confirm-alert"; // Import
import "react-confirm-alert/src/react-confirm-alert.css";
import RevertIcon from "@material-ui/icons/NotInterestedOutlined";

import {getAutoCompleteAction} from "../../actions/autoCompleteActions";
import {
    deleteEmployeeAction,
    downloadEmployeeDocumentsAction,
    updateEmployeeAction
} from "../../actions/employeeActions";
import Scrollbar from "react-scrollbars-custom";
import {List, ListItem, ListItemText} from "@material-ui/core";
import {formaDate, toShortFormat} from "../../utils/dateConverter";
import {KeyboardDatePicker, MuiPickersUtilsProvider} from "@material-ui/pickers";
import MomentUtils from "@date-io/moment";
import moment from "moment";
import Select from "react-select";

import {DropzoneDialog} from "material-ui-dropzone";
import {workplace} from "../../Constansts/appconstant";
import {findItemInArray} from "../../utils/select/selectHelper";
import {i_need_id} from "../../Constansts/selectHelper";

const localeEn = moment.locale('es');

const defaultToolbarStyles = {
    files: {
        border: "solid thin #00000033",
        borderRadius: 5,
        marginTop: 10,
        "& h5": {
            background: "linear-gradient(45deg, #2ed8b644, #177d6955);",
            padding: "10px 15px 6px 15px",
            margin: 0,
        },
    },
    fileItem: {
        padding: "0 10px",
        margin: 0,
        color: "#666666",
    },
    inputField: {},
    rr: {
        padding: "2vh 3vh",
    },
    title: {
        background: "linear-gradient(45deg, #2ed8b666, #177d6977);",
        borderBottom: "#59e0c555 solid thick;",
        textAlign: "center",
        padding: 10,
    },
    controlButtons: {
        display: "flex",
        alignItems: "end",
        justifyContent: "flex-end",
        marginTop: 10,
    },
};

class FormUpdateEmployee extends React.Component {
    static propTypes = {
        // businessNatures: PropTypes.string.isRequired,
        employee: PropTypes.object.isRequired,
        id: PropTypes.number.isRequired
    };

    constructor(props) {
        super(props);
        this.state = {
            open: false,
            id: "",
            nom_complete: "",
            ref: "",
            personal_number: "",
            profession_number: "",
            position_held: "",
            start_date: "",
            salary: "",
            Start_date: toShortFormat(),
            openDropZone: false,
            files: [],
            formValid: false,
            multiValueWork: [],
            formErrors: {},
        };
        this.handleChange = this.handleChange.bind(this);
        this.handleMultiWorkChange = this.handleMultiWorkChange.bind(this);
    }

    handleClick = () => {
        this.setState({
            open: !this.state.open
        });
    };

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

    updateClick = () => {
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
        let employee = this.props.employee;
        if (employee) {
            let user = employee.user;
            if (user) {
                let firstname = user.firstname;
                let middlename = user.middlename;
                let lastname = user.lastname;
                let email = user.email;
                formdata.append('firstname', firstname);
                formdata.append('email', email);
                formdata.append('middlename', middlename);
                formdata.append('lastname', lastname);
            }
        }

        formdata.append('Salary', this.state.Salary);
        formdata.append('position_held', this.state.position_held);
        formdata.append('profession_number', this.state.profession_number);
        formdata.append('Start_date', formaDate(this.state.Start_date));
        formdata.append('personal_number', this.state.personal_number);
        formdata.append('workplace', this.state.multiValueWork.value);
        formdata.append('_method', 'PUT');

        this.props.updateEmployeeAction(token, formdata, employee.id);
        this.setState({
            open: !this.state.open
        });
    };

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error) {
            toast.error(nextProps.error);
        }

    }

    componentWillMount() {
        if (this.props.employee) {
            this.setState(this.props.employee)
            ;
            let employee = this.props.employee;
            if (employee) {
                let user = employee.user;
                if (user) {
                    let firstname = user.firstname;
                    let middlename = user.middlename;
                    let lastname = user.lastname;
                    let nom_complete = firstname + ' ' + middlename + ' ' + lastname;
                    this.setState({
                        nom_complete: nom_complete,
                        formValid: true,
                        multiValueWork: findItemInArray(workplace, employee.workplace, i_need_id),
                    });
                }
            }

        }
    }

    delete = () => {
        const {employee} = this.props;
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        let obj = {
            id: employee.id
        };

        confirmAlert({
            title: "Confirm to submit",
            message: "Are you sure to do this ",
            buttons: [
                {
                    label: "Yes",
                    onClick: () =>
                        this.props.deleteEmployeeAction(token, obj, obj.id)
                },
                {
                    label: "No"
                }
            ]
        });
    };

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let personal_numberValid, profession_numberValid, position_heldValid, salaryValid;

        switch (fieldName) {

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

            case "salary":
                salaryValid = value.length > 0;
                fieldValidationErrors.salaryValid = value.length ? "" : " is Required";
                break;
            default:
                return this.state;
        }
        this.setState(
            {
                formErrors: fieldValidationErrors,
                personal_numberValid,
                profession_numberValid,
                position_heldValid,
                salaryValid,
            },
            this.validateForm
        );
    }

    handleMultiWorkChange(option) {

        this.setState({
            multiValueWork: option
        });

    }

    validateForm = () => {
        let isValid = true;
        const {
            multiValueWork,
            personal_number,
            profession_number,
            position_held,
            start_date,
            salary,
            workplace,
        } = this.state;
        const errors = {};
        let validMultiValueWork = multiValueWork.label !== "" && multiValueWork.label;

        if (personal_number === "") {
            errors.personal_number = "is Required";
            isValid = false;
        } else {
            errors.personal_number = "";
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
        if (start_date === "") {
            errors.start_date = "is Required";
            isValid = false;
        } else {
            errors.start_date = "";
        }
        if (salary === "") {
            errors.salary = "is Required";
            isValid = false;
        } else {
            errors.salary = "";
        }
        if (validMultiValueWork) {
            errors.workplace = "is Required";
            isValid = false;
        } else {
            errors.workplace = "";
        }
        this.setState({
            formErrors: {...errors},
        });

        return isValid && validMultiValueWork;
    };

    handleChange(e) {
        const name = e.target.name;
        const value = e.target.value;
        this.setState({[name]: value}, () => {
            this.validateField(name, value);
        });
    }

    handleDownloadClick(user, filename) {
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        if (user) {
            let username = user.name;
            if (username && filename) {
                this.props.downloadEmployeeDocumentsAction(token, username, filename);
            }
        }

    }

    render() {
        const {formValid, open, Start_date, multiValueWork} = this.state;
        const {classes, suggestions, employee} = this.props;
        const ListItemLink = (props) => {
            return <ListItem
                button component="a" {...props} />;
        };
        return (
            <React.Fragment>
                <div>
                    <Dialog
                        open={open}
                        onClose={this.handleClick}
                        aria-labelledby="form-dialog-title-update"
                    >
                        <DialogTitle className={classes.title} id="form-dialog-title-update">Modification
                            d'employer</DialogTitle>
                        <Scrollbar style={{width: 600, height: 700}}>
                            <div className={classes.rr}>
                                <TextField
                                    value={this.state.nom_complete}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    disabled
                                    autoFocus
                                    margin="dense"
                                    id="nom_complete"
                                    label="nom complete"
                                    type="text"
                                    name="id"
                                    fullWidth
                                />
                                <TextField
                                    defaultValue={this.state.personal_number}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="ref"
                                    label="réference"
                                    type="text"
                                    name="id"
                                    fullWidth
                                />
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
                                />
                                <TextField
                                    defaultValue={this.state.position_held}
                                    onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="position_held"
                                    label="poste occupé"
                                    type="position_held"
                                    name="text"
                                    fullWidth
                                />
                                <TextField
                                    defaultValue={this.state.Salary}
                                    onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="salary"
                                    label="Salaire"
                                    type="salary"
                                    name="salary"
                                    fullWidth
                                />
                                <div className='table-index-no_margin'>
                                    <Select
                                        name="liée"
                                        placeholder="workplace"
                                        value={multiValueWork}
                                        options={workplace}
                                        onChange={this.handleMultiWorkChange}
                                    />
                                </div>

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
                                <div className={classes.files}>
                                    <h5>Fichiers Attachées</h5>
                                    <List component="nav">
                                        {employee.documents &&
                                        employee.documents.map((file, i) => (
                                            <ListItemLink button className={classes.fileItem} primaryText="Beach"
                                                          onClick={() => this.handleDownloadClick(employee.user, file.name)}>
                                                <ListItemText primary={file.name}/>
                                            </ListItemLink>
                                        ))}
                                        <ListItemLink
                                            button
                                            href="#simple-list"
                                            className={classes.fileItem}
                                        >
                                            <ListItemText primary="Spam"/>
                                        </ListItemLink>
                                    </List>
                                </div>

                                <div className={classes.controlButtons}>
                                    <Button onClick={this.handleClick} color="primary">
                                        Annuler
                                    </Button>
                                    <Button disabled={!formValid}
                                            onClick={this.updateClick} color="primary">
                                        Modifier
                                    </Button>
                                </div>
                            </div>
                        </Scrollbar>
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
    updateEmployeeAction,
    getAutoCompleteAction,
    deleteEmployeeAction,
    downloadEmployeeDocumentsAction
};

function mapStateToProps(state) {
    return {
        token: state.login.token,
        openAutoComplete: state.suggestions.openAutoComplete,
        suggestions: state.suggestions.suggestions,
        error: state.businessNatures.error
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: "UpdateBusinessNatures"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(FormUpdateEmployee);
//export default connect(mapStateToProps, mapDispatchToProps)(UpdateBusinessNatures);
