import React from "react";

import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import { getCookie } from "../../../utils/cookies";

import { connect } from "react-redux";

import 'react-toastify/dist/ReactToastify.min.css'
import { toast, ToastContainer } from 'react-toastify';

import IconButton from "@material-ui/core/IconButton";
import EditIcon from "@material-ui/icons/EditOutlined";


import PropTypes from 'prop-types';
import { withStyles } from "@material-ui/core";
import { compose } from "recompose";
import Tooltip from "@material-ui/core/Tooltip";
import { confirmAlert } from 'react-confirm-alert'; // Import
import 'react-confirm-alert/src/react-confirm-alert.css';
import RevertIcon from "@material-ui/icons/NotInterestedOutlined";
import { deleteFolderTechSituationsAction, updateFolderTechSituationsAction } from "../../../actions/folderTechActions";
import { deleteIntermediateAction, updateIntermediateAction } from "../../../actions/intermediateActions";
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

class UpdateBusinessSituations extends React.Component {
    static propTypes = {
        // businessNatures: PropTypes.string.isRequired,
        index: PropTypes.object.isRequired,
        id: PropTypes.number.isRequired,
    };

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
    updateClick = () => {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        let obj = {
            id: this
                .props.index.id,
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
        this.props.updateIntermediateAction(token, obj, this.props.id);
        this.setState({
            open: !this.state.open
        });
    };

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error) {
            toast.error(nextProps.error)
        }


    }

    componentWillMount() {
        if (this.props.index) {
            let arr = [
                {
                    name: 'ZIP_code',
                    value: this.props.index.ZIP_code
                }, {
                    name: 'fees',
                    value: this.props.index.fees
                }, {
                    name: 'Cour',
                    value: this.props.index.Street2
                }, {
                    name: 'tel',
                    value: this.props.index.tel
                }, {
                    name: 'Street2',
                    value: this.props.index.Street2
                }, {
                    name: 'Function',
                    value: this.props.index.Function
                }, {
                    name: 'Country',
                    value: this.props.index.Country
                }, {
                    name: 'name',
                    value: this.props.index.name
                }, {
                    name: 'second_name',
                    value: this.props.index.second_name
                }, {
                    name: 'Street',
                    value: this.props.index.Street
                },
                {
                    name: 'city',
                    value: this.props.index.city
                },
            ];
            for (let i = 0; i < arr.length; i++) {
                const name = arr[i].name;
                const value = arr[i].value;
                this.setState({ [name]: value },
                    () => {
                        this.validateField(name, value)
                    },
                );
            }

        }

    }

    delete = () => {
        const { index } = this.props;
        let token = this.props.token === '' ? getCookie('token') : this.props.token;

        let obj = {
            id: this
                .props.index.id,
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
        confirmAlert({
            title: 'Confirm to submit',
            message: 'Are you sure to do this ',
            buttons: [
                {
                    label: 'Yes',
                    onClick: () => this.props.deleteIntermediateAction(token, obj, this.props.id)
                },
                {
                    label: 'No',
                }
            ]
        });
    };

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
        const { formValid, open } = this.state;
        const { classes } = this.props;

        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title-update">
                        <DialogTitle id="form-dialog-title-update">Modifier</DialogTitle>
                        <Scrollbar style={{ width: 600, height: 500 }}>
                            <div className={classes.rr}>
                                <DialogContent>
                                    <TextField
                                        defaultValue={this.state.city} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="city"
                                        label="city"
                                        type="city"
                                        name="city"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.second_name} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="second_name"
                                        label="second_name"
                                        type="second_name"
                                        name="second_name"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.name} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="name"
                                        label="Name business natures"
                                        type="Name"
                                        name="name"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.ZIP_code} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="ZIP_code"
                                        label="ZIP_code"
                                        type="ZIP_code"
                                        name="ZIP_code"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.Function} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="Function"
                                        label="Function"
                                        type="Function"
                                        name="Function"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.Country} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="Country"
                                        label="Country"
                                        type="Country"
                                        name="Country"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.Cour} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="Cour"
                                        label="Cour"
                                        type="Cour"
                                        name="Cour"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.Street} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="Street"
                                        label="Street"
                                        type="Street"
                                        name="Street"
                                        fullWidth
                                    />

                                    <TextField
                                        defaultValue={this.state.Street2} onChange={this.handleChange}
                                        autoFocus
                                        margin="dense"
                                        id="Street2"
                                        label="Street2"
                                        type="Street2"
                                        name="Street2"
                                        fullWidth
                                    />
                                </DialogContent>
                                <DialogActions>
                                    <Button onClick={this.handleClick} color="primary">
                                        Cancel
                            </Button>
                                    <Button onClick={this.updateClick} color="primary">
                                        Update
                            </Button>
                                </DialogActions>
                            </div>
                        </Scrollbar>
                    </Dialog>


                </div>

                <Tooltip title={"edit icon"}>
                    <IconButton className={classes.iconButton} onClick={this.handleClick}>
                        <EditIcon className={classes.deleteIcon} />
                    </IconButton>
                </Tooltip>
                <Tooltip title={"delete icon"}>

                    <IconButton className={classes.iconButton} onClick={this.delete}>
                        <RevertIcon className={classes.deleteIcon} />
                    </IconButton>

                </Tooltip>
            </React.Fragment>

        );
    }

}

const mapDispatchToProps = {
    updateIntermediateAction,
    deleteIntermediateAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        error: state.businessNatures.error,
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'UpdateBusinessSituations',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(UpdateBusinessSituations);
//export default connect(mapStateToProps, mapDispatchToProps)(UpdateBusinessNatures);
