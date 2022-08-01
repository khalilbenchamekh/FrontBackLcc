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

        this.props.addLoadNaturesAction(token, this.state.name);
        this.setState({
            open:!this.state.open
        });
    };
    componentWillReceiveProps(nextProps, nextContext) {
        if(nextProps.error !==''){
            toast.error(nextProps.error)
        }
    }

    fileHandler = (event) => {
        let validExts = [".xlsx", ".xls",".csv"];
        let fileExt;
        for(let i=0;i<event.target.files.length;i++){

            fileExt =  event.target.files[i].name;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if (validExts.indexOf(fileExt) < 0) {
                toast.error("Invalid file selected, valid files are of " +
                    validExts.toString() + " types.");
            }
            else
            {
                ExcelRenderer(event.target.files[i], (err, resp) => {
                    if(err){
                        toast.error(err)
                    }
                    else{
                        this.setState({
                            cols: resp.cols,
                            rows: resp.rows
                        });
                        let ValueNeeded=['name'];
                        if(resp.rows.length>0){
                            let nbr=0;
                            let indexItem=[];
                            for(let j=0;j<resp.rows[0].length;j++){

                                if (ValueNeeded.indexOf(resp.rows[0][j]) < 0) {
                                    nbr++
                                }else {
                                    indexItem.push({name:resp.rows[0][j],value:j})
                                }

                            }
                            if(nbr!==0){
                                toast.error('excel bad')

                            }else {
                                toast.success("Success Import");
                                let businessNatures=[];

                                let nameIndex= this.getIndexOfColmun(indexItem,'name');
                                for(let j=1;j<resp.rows.length;j++){
                                    if(resp.rows[j].length >0){
                                        businessNatures.push(
                                            {
                                                "name": resp.rows[j][nameIndex],
                                            }
                                        )
                                    }
                                }
                                let token = this.props.token === '' ? getCookie('token') : this.props.token;
                                this.props.addMultipleLoadNaturesAction(token,businessNatures)
                            }
                        }

                    }
                });

            }
        }

    };
    getIndexOfColmun(objc ,value){
        let nbr=-1;
        for(let j=0;j<objc.length;j++){

            if(objc[j].name===value){
                nbr=objc[j].value
            }
        }

        return nbr;
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
                                label="Name business natures"
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
                            <div className="form-group files">
                                <input type="file"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       className="form-control" multiple onChange={this.fileHandler.bind(this)} />
                                <ToastContainer autoClose={4000} position={toast.POSITION.TOP_RIGHT} closeButton={<FontAwesomeCloseButton />}/>
                            </div>

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
    addLoadNaturesAction,
    addMultipleLoadNaturesAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        businessNatures: state.businessNatures.businessNatures,
        error: state.businessNatures.error,
    };
}
export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'CustomToolbar',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(CustomToolbar);
