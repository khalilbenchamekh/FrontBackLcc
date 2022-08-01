import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import { withStyles } from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";
import {OutTable, ExcelRenderer} from 'react-excel-renderer';

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import {getCookie} from "../../../utils/cookies";

import {connect} from "react-redux";
import {compose} from "recompose";
import 'react-toastify/dist/ReactToastify.min.css'
import {toast, ToastContainer} from 'react-toastify';
import {addLoadNaturesAction, addMultipleLoadNaturesAction} from "../../../actions/loadNaturesActions";
import {addChargeNatureAction} from "../../../actions/chargeTypeActions";
const defaultToolbarStyles = {
    iconButton: {
    },
};
const FontAwesomeCloseButton = ({ closeToast }) => (
    <i
        className="toastify__close fa fa-times"
        onClick={closeToast}
    />
);

class CustomToolbar extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            open:false,
            name: '',
            formErrors: {name: ''},
            nameValid: false,
            formValid: false,
        };
        this.handleChange = this.handleChange.bind(this);
    }
    handleClick = () => {
        this.setState({
            open:!this.state.open
        });
    };
    addClick = () => {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;

        this.props.addChargeNatureAction(token, this.state.name);
        this.setState({
            open:!this.state.open
        });
    };
    componentWillReceiveProps(nextProps, nextContext) {
        if(nextProps.error !==''){
            toast.error(nextProps.error)
        }
    }

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let nameValid = this.state.nameValid;

        switch (fieldName) {

            case 'name':
                nameValid = value.length > 0;
                fieldValidationErrors.name = nameValid ? '' : ' is Required';
                break;

            default:
                break;
        }
        this.setState({
            formErrors: fieldValidationErrors,
            nameValid: nameValid,

        }, this.validateForm);
    }
    validateForm() {
        this.setState({
            formValid:
                this.state.nameValid
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
                        <DialogContent>
                            <TextField
                                defaultValue={this.state.name} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="name"
                                label="typde de la charge"
                                type="Name"
                                name="name"
                                fullWidth
                            />
                        </DialogContent>
                        <DialogActions>
                            <Button onClick={this.handleClick} color="primary">
                                Cancel
                            </Button>
                            <Button disabled={!formValid} onClick={this.addClick} color="primary">
                                Add
                            </Button>

                        </DialogActions>
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
    addChargeNatureAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        businessNatures: state.chargeTypes.chargeTypes,
        error: state.chargeTypes.error,
    };
}
export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'CustomToolbar',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(CustomToolbar);
