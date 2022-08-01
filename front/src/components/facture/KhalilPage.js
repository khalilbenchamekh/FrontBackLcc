import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import { withStyles } from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import { OutTable, ExcelRenderer } from "react-excel-renderer";
import Scrollbar from "react-scrollbars-custom";

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import { getCookie } from "../../utils/cookies";

import { connect } from "react-redux";
import { compose } from "recompose";
import "react-toastify/dist/ReactToastify.min.css";
import { toast, ToastContainer } from "react-toastify";
import {
  addClientAction,
  addMultipleClientsAction,
} from "../../actions/clientActions";
import { ButtonBase } from "@material-ui/core";

const defaultToolbarStyles = {
  iconButton: {},
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
    marginTop: 20,
  },
};

const FontAwesomeCloseButton = ({ closeToast }) => (
  <i className="toastify__close fa fa-times" onClick={closeToast} />
);

class Page extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      open: true,
      price: "",
      fees_decompte: "",
      location_id: "",
      Market_title: "",
      Managed_by: "",
      State_of_progress: "",
      Class_service: "",
      Execution_report: "",
      Execution_phase: "",
      date_of_receipt: "",
      filenames: [],
      errors: [],
    };
  }
  handleClick = () => {
    this.setState({
      open: !this.state.open,
    });
  };

  handleSubmit = () => {
    this.validateForm();
  };

  validateForm = () => {
    const {
      price,
      fees_decompte,
      location_id,
      Market_title,
      Managed_by,
      State_of_progress,
      Class_service,
      Execution_report,
      Execution_phase,
      date_of_receipt,
      filenames,
    } = this.state;
    const errors = {};
    if (price === "") {
      errors.price = "Prix est necessaire";
    }
    if (fees_decompte === "") {
      errors.fees_decompte = "décompte des frais est necessaire";
    }
    if (location_id === "") {
      errors.location_id = "localisation est necessaire";
    }
    if (Market_title === "") {
      errors.Market_title = "titre du marché est necessaire";
    }
    if (Managed_by === "") {
      errors.Managed_by = "le champ dirigé par est necessaire";
    }
    if (date_of_receipt === "") {
      errors.date_of_receipt = "le champ date de réception est necessaire";
    }
    this.setState({
      errors: { ...errors },
    });
  };

  handleChange = (input) => {
    console.log(input);

    this.setState({ ...input });
  };

  render() {
    const { classes } = this.props;
    const { open, errors } = this.state;
    console.log(this.state);

    return (
      <React.Fragment>
        <div>
          <Dialog
            open={open}
            onClose={this.handleClick}
            aria-labelledby="form-dialog-title"
          >
            <DialogTitle className={classes.title} id="form-dialog-title">
              Ajouter un XXX
            </DialogTitle>
            <Scrollbar style={{ width: 600, height: 440 }}>
              <div className={classes.rr}>
                <TextField
                  defaultValue={this.state.price}
                  onChange={(e) => this.handleChange({ price: e.target.value })}
                  className={classes.inputField}
                  autoFocus
                  margin="dense"
                  id="price"
                  label="Prix"
                  type="text"
                  name="price"
                  fullWidth
                  error={errors.price}
                  helperText={errors.price}
                />
                <TextField
                  defaultValue={this.state.fees_decompte}
                  onChange={(e) =>
                    this.handleChange({ fees_decompte: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="fees_decompte"
                  label="Décompte des frais"
                  type="text"
                  name="fees_decompte"
                  fullWidth
                  error={errors.fees_decompte}
                  helperText={errors.fees_decompte}
                />
                <TextField
                  defaultValue={this.state.location_id}
                  onChange={(e) =>
                    this.handleChange({ location_id: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="location_id"
                  label="Emplacement"
                  type="text"
                  name="location_id"
                  fullWidth
                  error={errors.location_id}
                  helperText={errors.location_id}
                />
                <TextField
                  defaultValue={this.state.Market_title}
                  onChange={(e) =>
                    this.handleChange({ Market_title: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="Market_title"
                  label="Titre du marché"
                  type="text"
                  name="Market_title"
                  fullWidth
                  error={errors.Market_title}
                  helperText={errors.Market_title}
                />
                <TextField
                  defaultValue={this.state.Managed_by}
                  onChange={(e) =>
                    this.handleChange({ Managed_by: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="Managed_by"
                  label="Dirigé par"
                  type="text"
                  name="Managed_by"
                  fullWidth
                  error={errors.Managed_by}
                  helperText={errors.Managed_by}
                />
                <TextField
                  defaultValue={this.state.State_of_progress}
                  onChange={(e) =>
                    this.handleChange({ State_of_progress: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="State_of_progress"
                  label="Etat d'avancement"
                  type="text"
                  name="State_of_progress"
                  fullWidth
                  error={errors.State_of_progress}
                  helperText={errors.State_of_progress}
                />
                <TextField
                  defaultValue={this.state.Class_service}
                  onChange={(e) =>
                    this.handleChange({ Class_service: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="Class_service"
                  label="Service de classe"
                  type="text"
                  name="Class_service"
                  fullWidth
                  error={errors.Class_service}
                  helperText={errors.Class_service}
                />
                <TextField
                  defaultValue={this.state.Execution_report}
                  onChange={(e) =>
                    this.handleChange({ Execution_report: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="Execution_report"
                  label="Rapport d'exécution"
                  type="text"
                  name="Execution_report"
                  fullWidth
                  error={errors.Execution_report}
                  helperText={errors.Execution_report}
                />
                <TextField
                  defaultValue={this.state.Execution_phase}
                  onChange={(e) =>
                    this.handleChange({ Execution_phase: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="Execution_phase"
                  label="Phase d'exécution"
                  type="text"
                  name="Execution_phase"
                  fullWidth
                  error={errors.Execution_phase}
                  helperText={errors.Execution_phase}
                />
                <TextField
                  defaultValue={this.state.date_of_receipt}
                  onChange={(e) =>
                    this.handleChange({ date_of_receipt: e.target.value })
                  }
                  className={classes.inputField}
                  margin="dense"
                  id="date_of_receipt"
                  placeholder="date de réception"
                  type="date"
                  name="date_of_receipt"
                  fullWidth
                  error={errors.date_of_receipt}
                  helperText={errors.date_of_receipt}
                />
                <input
                  ref={"file-upload"}
                  type="file"
                  style={{ display: "none" }}
                  onChange={(e) =>
                    this.handleChange({ filenames: e.target.files })
                  }
                  multiple
                />
                <Button
                  type="file"
                  onClick={(e) => {
                    this.refs["file-upload"].click();
                  }}
                >
                  Choisire un fichiers
                </Button>

                <div className={classes.controlButtons}>
                  <Button onClick={this.handleClick} color="primary">
                    Cancel
                  </Button>
                  <Button onClick={this.handleSubmit} color="primary">
                    Add
                  </Button>
                </div>
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
  addClientAction,
  addMultipleClientsAction,
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
    name: "FormAddEmployee",
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(Page);
