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
import { getCookie } from "../../../utils/cookies";
import { DropzoneDialog } from 'material-ui-dropzone'
import { connect } from "react-redux";
import { compose } from "recompose";
import 'react-toastify/dist/ReactToastify.min.css'
import { toast, ToastContainer } from 'react-toastify';

import { CheckDecimal } from "../../../utils/validation/CheckDecimal";
import { saveBusinessFeesAction } from "../../../actions/feesActions";

const defaultToolbarStyles = {
    iconButton: {},
};

const advancedCosnt = 'advanced';
const priceCosnt = 'price';
const observationCosnt = 'observation';

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
            open: false,
            advanced: 0,
            price: 0,
            observation: "",
            formErrors: {
                observation: "",
                advanced: 0,
                price: 0,
            },
            priceValid: false,
            advancedValid: false,
            formValid: false,
        };
        this.handleChange = this.handleChange.bind(this);
        this.handleMultiChange = this.handleMultiChange.bind(this);
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


    handleClick = () => {
        this.setState({
            open: !this.state.open
        });

    };

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let priceValid = this.state.priceValid;
        let advancedValid = this.state.advancedValid;

        switch (fieldName) {

            case 'price':
                priceValid = CheckDecimal(parseFloat(value));
                fieldValidationErrors.price = priceValid ? '' : ' is Required';
                break;
            case 'advanced':
                advancedValid = CheckDecimal(parseFloat(value));
                fieldValidationErrors.advanced = advancedValid ? '' : ' is Required';
                break;

            default:
                break;
        }
        this.setState({
            formErrors: fieldValidationErrors,
            priceValid: priceValid,
            advancedValid: advancedValid,
        }, this.validateForm);
    }

    validateForm() {
        this.setState({
            formValid:
                this.state.priceValid && this.state.advancedValid
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
        formdata.append('advanced', this.state.advanced);
        formdata.append('price', this.state.price);
        formdata.append('observation', this.state.observation);
        formdata.append('id', this.state.multiValue.value || this.state.multiValue);

        this.props.saveBusinessFeesAction(token, formdata);
        this.setState({
            open: !this.state.open
        });

    };

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error) {
            toast.error(nextProps.error)
        }
        if (nextProps.BusinessBy_Id !== this.props.BusinessBy_Id) {
            this.setState({
                multiValueSelect: nextProps.BusinessBy_Id
            })
        }
    }

    componentWillMount() {

        if (this.props.BusinessBy_Id) {
            this.setState({
                multiValueSelect: this.props.BusinessBy_Id
            })
        }
    }

    render() {
        const { multiValue, multiValueSelect, formValid, open } = this.state;
        const { classes } = this.props;
        let isValidForm = multiValue.value !== "" && multiValue.value && formValid;
        return (
            <React.Fragment>
                <div>
                    <Dialog open={open} onClose={this.handleClick} aria-labelledby="form-dialog-title-update">
                        <DialogTitle id="form-dialog-title-update">Subscribe</DialogTitle>
                        <form onSubmit={this.submitForm}>

                            <TextField
                                defaultValue={this.state.advanced} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id={advancedCosnt}
                                label="Name business natures"
                                type="Name"
                                name={advancedCosnt}
                                fullWidth
                            />

                            <TextField
                                defaultValue={this.state.price} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id={priceCosnt}
                                label="Name business natures"
                                type="amount"
                                name={priceCosnt}
                                fullWidth
                            />
                            <div className='table-index-no_margin'>
                                <Select
                                    name="liée"
                                    placeholder="Charge liée à"
                                    value={multiValue}
                                    options={multiValueSelect}
                                    onChange={this.handleMultiChange}
                                />
                            </div>
                            <TextField
                                defaultValue={this.state.observation} onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id={observationCosnt}
                                label="Name business natures"
                                type="Name"
                                name={observationCosnt}
                                fullWidth={true}
                                multiLine={true}
                            />
                            <div>
                                <Button onClick={this.handleOpen.bind(this)}>
                                    Add Image
                                </Button>
                                <DropzoneDialog
                                    open={this.state.openDropZone}
                                    onSave={this.handleSave.bind(this)}
                                    showPreviews={true}
                                    maxFileSize={5000000}
                                    onClose={this.handleClose.bind(this)}
                                />
                            </div>

                            <button disabled={!isValidForm} type="submit">Submit</button>
                            <Button onClick={this.handleClick} color="primary">
                                Cancel
                            </Button>
                        </form>


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
    saveBusinessFeesAction,
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        BusinessBy_Id: state.select.BusinessBy_Id,
        error: state.select.error,
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'CustomToolbar',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(CustomToolbar);
