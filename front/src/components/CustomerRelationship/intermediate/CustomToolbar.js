import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import { withStyles } from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";
import { OutTable, ExcelRenderer } from 'react-excel-renderer';

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import { getCookie } from "../../../utils/cookies";

import { connect } from "react-redux";
import { compose } from "recompose";
import 'react-toastify/dist/ReactToastify.min.css'
import { toast, ToastContainer } from 'react-toastify';
import { addFolderTechSituationsAction, addMultipleFolderTechSituationsAction } from "../../../actions/folderTechActions";
import { addIntermediateAction, addMultipleIntermediatesAction } from "../../../actions/intermediateActions";
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
            open: false,
            city: '',
            ZIP_code: ''
            , Country: '',
            tel: ''
            , Cour: ''
            , name: ''
            , second_name: '',
            Street: '',
            Street2: '',
            formErrors: {
                city: '',
                ZIP_code: ''
                , Country: ''
                , Function: '',
                tel: ''
                , Cour: '',
                second_name: ''
                , name: '',
                Street: '',
                Street2: '',
            },
            Street2Valid: false,
            FunctionValid: false,
            cityValid: false,
            ZIP_codeValid: false,
            CountryValid: false,
            telValid: false,
            CourValid: false,
            StreetValid: false,
            second_nameValid: false,
            nameValid: false,
            formValid: false,
        };
        this.handleChange = this.handleChange.bind(this);
    }

    handleClick = () => {
        this.setState({
            open: !this.state.open
        });
    };
    addClick = () => {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        let obj = {
            city: this.state.city,
            ZIP_code: this.state.ZIP_code
            , Country: this.state.Country
            , Function: this.state.Function,
            tel: this.state.tel
            , Cour: this.state.Cour,
            second_name: this.state.second_name
            , name: this.state.name,
            Street: this.state.Street,
            Street2: this.state.Street2
        };
        this.props.addIntermediateAction(token, obj);
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
                        let ValueNeeded = ['Name', 'orderChr'];
                        if (resp.rows.length > 0) {
                            let nbr = 0;
                            let indexItem = [];
                            for (let j = 0; j < resp.rows[0].length; j++) {

                                if (ValueNeeded.indexOf(resp.rows[0][j]) < 0) {
                                    nbr++
                                } else {
                                    indexItem.push({ name: resp.rows[0][j], value: j })
                                }

                            }
                            if (nbr !== 0) {
                                toast.error('excel bad')

                            } else {
                                toast.success("Success Import");
                                let businessNatures = [];

                                let nameIndex = this.getIndexOfColmun(indexItem, 'Name');
                                let abrIndex = this.getIndexOfColmun(indexItem, 'orderChr');

                                for (let j = 1; j < resp.rows.length; j++) {
                                    if (resp.rows[j].length > 0) {
                                        businessNatures.push(
                                            {
                                                "Name": resp.rows[j][nameIndex],
                                                "orderChr": resp.rows[j][abrIndex],
                                            }
                                        )
                                    }
                                }
                                let token = this.props.token === '' ? getCookie('token') : this.props.token;

                                this.props.addMultipleIntermediatesAction(token, businessNatures)

                                /// call action

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

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let nameValid = this.state.nameValid;
        let second_nameValid = this.state.second_nameValid;
        let cityValid = this.state.cityValid;
        let ZIP_codeValid = this.state.ZIP_codeValid;
        let CountryValid = this.state.CountryValid;
        let telValid = this.state.telValid;
        let CourValid = this.state.CourValid;
        let FunctionValid = this.state.FunctionValid;
        let StreetValid = this.state.StreetValid;
        let Street2Valid = this.state.Street2Valid;
        switch (fieldName) {

            case 'name':
                nameValid = value.length > 0;
                fieldValidationErrors.name = nameValid ? '' : ' is Required';
                break;
            case 'city':
                cityValid = value.length > 0;
                fieldValidationErrors.city = cityValid ? '' : ' is Required';
                break;
            case 'ZIP_code':
                ZIP_codeValid = value.length > 0;
                fieldValidationErrors.ZIP_code = ZIP_codeValid ? '' : ' is Required';
                break;
            case 'Country':
                CountryValid = value.length > 0;
                fieldValidationErrors.CountryValid = CountryValid ? '' : ' is Required';
                break;
            case 'Function':
                FunctionValid = value.length > 0;
                fieldValidationErrors.Function = FunctionValid ? '' : ' is Required';
                break;
            case 'second_name':
                second_nameValid = value.length > 0;
                fieldValidationErrors.second_name = second_nameValid ? '' : ' is Required';
                break;

            case 'tel':
                telValid = value.length > 0;
                fieldValidationErrors.tel = telValid ? '' : ' is Required';
                break;

            case 'Cour':
                CourValid = value.length > 0;
                fieldValidationErrors.Cour = CourValid ? '' : ' is Required';
                break;

            case 'Street':
                StreetValid = value.length > 0;
                fieldValidationErrors.Street = StreetValid ? '' : ' is Required';
                break;

            case 'Street2':
                Street2Valid = value.length > 0;
                fieldValidationErrors.Street2 = Street2Valid ? '' : ' is Required';
                break;

            default:
                break;
        }
        this.setState({
            formErrors: fieldValidationErrors,
            nameValid: nameValid,
            second_nameValid: second_nameValid,
            cityValid: cityValid,
            ZIP_codeValid: ZIP_codeValid,
            CountryValid: CountryValid,
            telValid: telValid,
            CourValid: CourValid,
            FunctionValid: FunctionValid,
            StreetValid: StreetValid,
            Street2Valid: Street2Valid,

        }, this.validateForm);
    }

    validateForm() {
        this.setState({
            formValid:
                this.state.nameValid &&
                this.state.second_nameValid &&
                this.state.cityValid &&
                this.state.ZIP_codeValid &&
                this.state.CountryValid &&
                this.state.telValid &&
                this.state.CourValid &&
                this.state.FunctionValid &&
                this.state.StreetValid &&
                this.state.Street2Valid
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

    render() {
        const { classes } = this.props;
        const { open } = this.state;
        const {
            formValid
        } = this.state;
        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title">
                        <DialogTitle id="form-dialog-title">Subscribe</DialogTitle>
                        <Scrollbar style={{ width: 600, height: 500 }}>
                            <div className={classes.rr}>

                                <TextField
                                    defaultValue={this.state.city} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="city"
                                    label="Ville"
                                    type="city"
                                    name="city"
                                    fullWidth
                                />


                                <TextField
                                    defaultValue={this.state.second_name} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="second_name"
                                    label="Nom complet"
                                    type="second_name"
                                    name="second_name"
                                    fullWidth
                                />


                                <TextField
                                    defaultValue={this.state.tel} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="tel"
                                    label="N° de téléphone"
                                    type="tel"
                                    name="tel"
                                    fullWidth
                                />


                                <TextField
                                    defaultValue={this.state.name} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="name"
                                    label="Nature de l'affaire"
                                    type="Name"
                                    name="name"
                                    fullWidth
                                />

                                <TextField
                                    defaultValue={this.state.ZIP_code} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="ZIP_code"
                                    label="Code postal"
                                    type="ZIP_code"
                                    name="ZIP_code"
                                    fullWidth
                                />

                                <TextField
                                    defaultValue={this.state.Function} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="Function"
                                    label="Poste de l'intermédiaire"
                                    type="Function"
                                    name="Function"
                                    fullWidth
                                />

                                <TextField
                                    defaultValue={this.state.Country} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="Country"
                                    label="Pays"
                                    type="Country"
                                    name="Country"
                                    fullWidth
                                />

                                <TextField
                                    defaultValue={this.state.Cour} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="Cour"
                                    label="Adresse e-mail"
                                    type="Cour"
                                    name="Cour"
                                    fullWidth
                                />

                                <TextField
                                    defaultValue={this.state.Street} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="Street"
                                    label="Adresse"
                                    type="Street"
                                    name="Street"
                                    fullWidth
                                />

                                <TextField
                                    defaultValue={this.state.Street2} onChange={this.handleChange}
                                    autoFocus
                                    margin="dense"
                                    id="Street2"
                                    label="Adresse 2"
                                    type="Street2"
                                    name="Street2"
                                    fullWidth
                                />

                                <DialogActions>
                                    <Button onClick={this.handleClick} color="primary">
                                        Cancel
                            </Button>
                                    <Button onClick={this.addClick} color="primary">
                                        Add
                            </Button>
                                    <div className="form-group files">
                                        <input type="file"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                            className="form-control" multiple onChange={this.fileHandler.bind(this)} />
                                        <ToastContainer autoClose={4000} position={toast.POSITION.TOP_RIGHT}
                                            closeButton={<FontAwesomeCloseButton />} />
                                    </div>

                                </DialogActions>
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
    addIntermediateAction,
    addMultipleIntermediatesAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        intermediates: state.intermediates.intermediates,
        error: state.intermediates.error,
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
