import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import {withStyles} from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import {ExcelRenderer} from "react-excel-renderer";
import Scrollbar from "react-scrollbars-custom";

import TextField from "@material-ui/core/TextField";
import {getCookie} from "../../utils/cookies";

import {connect} from "react-redux";
import {compose} from "recompose";
import "react-toastify/dist/ReactToastify.min.css";
import {
    addClientAction,
    addMultipleClientsAction,
} from "../../actions/clientActions";
import {List, ListItem, ListItemText} from "@material-ui/core";
import {downloadEmployeeDocumentsAction} from "../../actions/employeeActions";

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

const FontAwesomeCloseButton = ({closeToast}) => (
    <i className="toastify__close fa fa-times" onClick={closeToast}/>
);

class EmployeeDetails extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false,
            id: "",
            personal_number: "",
            profession_number: "",
            position_held: "",
            start_date: "",
            salary: "",
            workplace: "",
        };
    }

    handleClick = () => {
        this.setState({
            open: !this.state.open,
        });
    };

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
        const {classes} = this.props;
        const {open, onClose, onUpdate, employee} = this.props;
        const ListItemLink = (props) => {
            return <ListItem button component="a" {...props} />;
        };
        console.log(employee);

        return (
            <React.Fragment>
                <Dialog
                    open={open}
                    onClose={onClose}
                    aria-labelledby="form-dialog-title"
                >
                    <DialogTitle className={classes.title} id="form-dialog-title">
                        Details
                    </DialogTitle>
                    <Scrollbar style={{width: 600, height: 700}}>
                        <div className={classes.rr}>
                            <TextField
                                value={employee.name}
                                onChange={this.handleChange}
                                className={classes.inputField}
                                autoFocus
                                margin="dense"
                                id="name"
                                label="nom complete"
                                type="text"
                                name="id"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.personal_number}
                                onChange={this.handleChange}
                                className={classes.inputField}
                                autoFocus
                                margin="dense"
                                id="ref"
                                label="réference"
                                type="text"
                                name="id"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.personal_number}
                                onChange={this.handleChange}
                                className={classes.inputField}
                                autoFocus
                                margin="dense"
                                id="personal_number"
                                label="numéro personnel"
                                type="text"
                                name="personal_number"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.profession_number}
                                onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="profession_number"
                                label="numéro professionnelle"
                                type="text"
                                name="profession_number"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.position_held}
                                onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="position_held"
                                label="poste occupé"
                                type="position_held"
                                name="text"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.Start_date}
                                onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="start_date"
                                label="Date de début"
                                type="text"
                                name="Start_date"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.Salary}
                                onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="salary"
                                label="Salaire"
                                type="salary"
                                name="salary"
                                fullWidth
                                disabled
                            />
                            <TextField
                                defaultValue={employee.workplace}
                                onChange={this.handleChange}
                                autoFocus
                                margin="dense"
                                id="workplace"
                                label="lieu de travail"
                                type="text"
                                name="workplace"
                                fullWidth
                                disabled
                            />
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
                                <Button onClick={onClose} color="primary">
                                    Annuler
                                </Button>
                            </div>
                        </div>
                    </Scrollbar>
                </Dialog>
            </React.Fragment>
        );
    }
}

EmployeeDetails.defaultProps = {
    employee: {},
    open: false,
    onClose: () => {
    },
    onUpdate: () => {
    }
}

const mapDispatchToProps = {
    addClientAction,
    addMultipleClientsAction,
    downloadEmployeeDocumentsAction
};

function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: "FormAddEmployee",
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(EmployeeDetails);
