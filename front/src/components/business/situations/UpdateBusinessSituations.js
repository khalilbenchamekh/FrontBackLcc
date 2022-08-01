import React from "react";

import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import {getCookie} from "../../../utils/cookies";
import {
    deleteBusinessNaturesAction, deleteBusinessSituationsAction,

    updateBusinessNaturesAction, updateBusinessSituationsAction
} from "../../../actions/businessActions";
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

const defaultToolbarStyles = {
    iconButton: {},
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
            name: '',
            order: '',
            formErrors: {name: '', order: ''},
            orderValid: false,
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
            Name: this.state.name,
            orderChr: this.state.order,
        };
        this.props.updateBusinessSituationsAction(token, obj, this.props.id);
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
                    name: 'name',
                    value: this.props.index.Name
                },
                {
                    name: 'order',
                    value: this.props.index.orderChr
                },
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
        const {index} = this.props;
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        let obj = {
            id: this
                .props.index.id,
            Name: this.state.name
        };

        confirmAlert({
            title: 'Confirm to submit',
            message: 'Are you sure to do this ',
            buttons: [
                {
                    label: 'Yes',
                    onClick: () => this.props.deleteBusinessSituationsAction(token, obj, this.props.id)
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
        let orderValid = this.state.orderValid;

        switch (fieldName) {

            case 'name':
                nameValid = value.length > 0;
                fieldValidationErrors.name = nameValid ? '' : ' is Required';
                break;
            case 'order':
                orderValid = value.length > 0;
                fieldValidationErrors.order = orderValid ? '' : ' is Required';
                break;

            default:
                break;
        }
        this.setState({
            formErrors: fieldValidationErrors,
            nameValid: nameValid,
            orderValid: orderValid,

        }, this.validateForm);
    }

    validateForm() {
        this.setState({
            formValid:
            this.state.nameValid &&  this.state.orderValid
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
        const {formValid, open} = this.state;
        const {classes} = this.props;

        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title-update">
                        <DialogTitle id="form-dialog-title-update">Subscribe</DialogTitle>
                        <DialogContent>
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
                                defaultValue={this.state.order} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="order"
                                label="order"
                                type="orderChr"
                                name="order"
                                fullWidth
                            />
                        </DialogContent>
                        <DialogActions>
                            <Button onClick={this.handleClick} color="primary">
                                Cancel
                            </Button>
                            <Button disabled={!formValid} onClick={this.updateClick} color="primary">
                                Update
                            </Button>
                        </DialogActions>
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
    updateBusinessSituationsAction,
    deleteBusinessSituationsAction
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
