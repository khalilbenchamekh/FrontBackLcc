import React from "react";

import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";

import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import { getCookie } from "../../../utils/cookies";

import { connect } from "react-redux";

import "react-toastify/dist/ReactToastify.min.css";
import { toast } from "react-toastify";

import IconButton from "@material-ui/core/IconButton";
import EditIcon from "@material-ui/icons/EditOutlined";
import CircularProgress from "@material-ui/core/CircularProgress";

import PropTypes from "prop-types";
import { withStyles, FormControlLabel, Checkbox } from "@material-ui/core";
import { compose } from "recompose";
import Tooltip from "@material-ui/core/Tooltip";
import { confirmAlert } from "react-confirm-alert"; // Import
import "react-confirm-alert/src/react-confirm-alert.css";
import RevertIcon from "@material-ui/icons/NotInterestedOutlined";
import {
  deleteBusinessAction,
  updateBusinessAction
} from "../../../actions/businessActions";
import { debounce } from "throttle-debounce";
import { getAutoCompleteAction } from "../../../actions/autoCompleteActions";
import Autocomplete from "@material-ui/lab/Autocomplete";
import { throttle } from "throttle-debounce";
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

class UpdateFolderTech extends React.Component {
  static propTypes = {
    // businessNatures: PropTypes.string.isRequired,
    index: PropTypes.object.isRequired,
    id: PropTypes.number.isRequired
  };

  constructor(props) {
    super(props);
    this.state = {
      open: false,
      openAuto: false,
      REF: "",
      PTE_KNOWN: "",
      TIT_REQ: "",
      place: "",
      DATE_ENTRY: "",
      DATE_LAI: "",
      UNITE: "",
      PRICE: "",
      Inter_id: "",
      aff_sit_id: "",
      client_id: "",
      resp_id: "",
      nature_name: "",
      ttc: 0,
      long: "",
      lat: "",
      suggestions: [
        {
          value: "",
          id: ""
        }
      ],
      formErrors: {
        PTE_KNOWN: "",
        TIT_REQ: "",
        place: "",
        DATE_ENTRY: "",
        DATE_LAI: "",
        UNITE: "",
        PRICE: "",
        Inter_id: "",
        aff_sit_id: "",
        client_id: "",
        resp_id: "",
        nature_name: ""
      },
      PTE_KNOWNValid: false,
      TIT_REQValid: false,
      placeValid: false,
      DATE_ENTRYValid: false,
      DATE_LAIValid: false,
      UNITEValid: false,
      PRICEValid: false,
      Inter_idValid: false,
      aff_sit_idValid: false,
      client_idValid: false,
      nature_nameValid: false,
      resp_idValid: false,
      formValid: false
    };
    this.handleChange = this.handleChange.bind(this);
    this.autocompleteSearchThrottled = throttle(500, this.autocompleteSearch);
  }

  handleClick = () => {
    this.setState({
      open: !this.state.open
    });
  };
  updateClick = () => {
    let token = this.props.token === "" ? getCookie("token") : this.props.token;

    let obj = {
      id: this.props.index.id,
      PTE_KNOWN: this.state.PTE_KNOWN,
      TIT_REQ: this.state.TIT_REQ,
      place: this.state.place,
      DATE_ENTRY: this.state.DATE_ENTRY,
      DATE_LAI: this.state.DATE_LAI,
      UNITE: this.state.UNITE,
      PRICE: this.state.PRICE,
      Inter_id: this.state.Inter_id,
      aff_sit_id: this.state.aff_sit_id,
      client_id: this.state.client_id,
      resp_id: this.state.resp_id,
      nature_name: this.state.nature_name,
      long: this.state.long,
      lat: this.state.lat,
    };
    this.props.updateBusinessAction(token, obj, this.props.id);
    this.setState({
      open: !this.state.open
    });
  };

  componentWillReceiveProps(nextProps, nextContext) {
    console.log("nextProps: ", nextProps);

    if (nextProps.error) {
      toast.error(nextProps.error);
    }
    // if (nextProps.suggestions) {
    //     console.log(nextProps.suggestions);
    //     this.setState({
    //         suggestions: nextProps.suggestions
    //     })
    // }
  }

  componentWillMount() {
    if (this.props.index) {
      let arr = [
        {
          name: "ZIP_code",
          value: this.props.index.ZIP_code
        },
        {
          name: "ICE",
          value: this.props.index.ICE
        },
        {
          name: "Cour",
          value: this.props.index.Street2
        },
        {
          name: "tel",
          value: this.props.index.tel
        },
        {
          name: "Street2",
          value: this.props.index.Street2
        },
        {
          name: "RC",
          value: this.props.index.RC
        },
        {
          name: "Country",
          value: this.props.index.Country
        },
        {
          name: "name",
          value: this.props.index.name
        },
        {
          name: "Street",
          value: this.props.index.Street
        },
        {
          name: "city",
          value: this.props.index.city
        },
        {
          name: 'long',
          value: this.props.index.long
        },
        {
          name: 'latt',
          value: this.props.index.lat
        }
      ];

      for (let i = 0; i < arr.length; i++) {
        const name = arr[i].name;
        const value = arr[i].value;
        this.setState({ [name]: value }, () => {
          this.validateField(name, value);
        });
      }
    }
  }

  delete = () => {
    const { index } = this.props;
    let token = this.props.token === "" ? getCookie("token") : this.props.token;
    let obj = {
      id: this.props.index.id,
      PTE_KNOWN: this.state.PTE_KNOWN,
      TIT_REQ: this.state.TIT_REQ,
      place: this.state.place,
      DATE_ENTRY: this.state.DATE_ENTRY,
      DATE_LAI: this.state.DATE_LAI,
      UNITE: this.state.UNITE,
      PRICE: this.state.PRICE,
      Inter_id: this.state.Inter_id,
      aff_sit_id: this.state.aff_sit_id,
      client_id: this.state.client_id,
      resp_id: this.state.resp_id,
      nature_name: this.state.nature_name,
      long: this.state.long,
      lat: this.state.lat,
    };

    confirmAlert({
      title: "Confirm to submit",
      message: "Are you sure to do this ",
      buttons: [
        {
          label: "Yes",
          onClick: () =>
            this.props.deleteBusinessAction(token, obj, this.props.id)
        },
        {
          label: "No"
        }
      ]
    });
  };

  validateField(fieldName, value) {
    let fieldValidationErrors = this.state.formErrors;
    let PTE_KNOWNValid = this.state.PTE_KNOWNValid;
    let TIT_REQValid = this.state.TIT_REQValid;
    let placeValid = this.state.placeValid;
    let DATE_ENTRYValid = this.state.DATE_ENTRYValid;
    let DATE_LAIValid = this.state.DATE_LAIValid;
    let UNITEValid = this.state.UNITEValid;
    let PRICEValid = this.state.PRICEValid;
    let Inter_idValid = this.state.Inter_idValid;
    let aff_sit_idValid = this.state.aff_sit_idValid;
    let client_idValid = this.state.client_idValid;
    let resp_idValid = this.state.resp_idValid;
    let nature_nameValid = this.state.nature_nameValid;
    switch (fieldName) {
      case "client_id":
        client_idValid = value.length > 0;
        fieldValidationErrors.client_id = client_idValid ? "" : " is Required";
        break;
      case "resp_id":
        resp_idValid = value.length > 0;
        fieldValidationErrors.resp_id = resp_idValid ? "" : " is Required";
        break;
      case "nature_name":
        nature_nameValid = value.length > 0;
        fieldValidationErrors.nature_name = nature_nameValid
          ? ""
          : " is Required";
        break;
      case "Inter_id":
        Inter_idValid = value.length > 0;
        fieldValidationErrors.Inter_id = Inter_idValid ? "" : " is Required";
        break;
      case "aff_sit_id":
        aff_sit_idValid = value.length > 0;
        fieldValidationErrors.aff_sit_id = aff_sit_idValid
          ? ""
          : " is Required";
        break;
      case "PTE_KNOWNValid":
        PTE_KNOWNValid = value.length > 0;
        fieldValidationErrors.PTE_KNOWN = PTE_KNOWNValid ? "" : " is Required";
        break;
      case "TIT_REQValid":
        TIT_REQValid = value.length > 0;
        fieldValidationErrors.city = TIT_REQValid ? "" : " is Required";
        break;
      case "placeValid":
        placeValid = value.length > 0;
        fieldValidationErrors.placeValid = placeValid ? "" : " is Required";
        break;
      case "DATE_ENTRYValid":
        DATE_ENTRYValid = value.length > 0;
        fieldValidationErrors.DATE_ENTRYValid = DATE_ENTRYValid
          ? ""
          : " is Required";
        break;
      case "DATE_LAIValid":
        DATE_LAIValid = value.length > 0;
        fieldValidationErrors.DATE_LAIValid = DATE_LAIValid
          ? ""
          : " is Required";
        break;
      case "UNITEValid":
        UNITEValid = value.length > 0;
        fieldValidationErrors.UNITEValid = UNITEValid ? "" : " is Required";
        break;

      case "PRICEValid":
        PRICEValid = value.length > 0;
        fieldValidationErrors.PRICEValid = PRICEValid ? "" : " is Required";
        break;
      default:
        return this.state;
    }
    this.setState(
      {
        formErrors: fieldValidationErrors,
        PTE_KNOWNValid: PTE_KNOWNValid,
        TIT_REQValid: TIT_REQValid,
        placeValid: placeValid,
        DATE_ENTRYValid: DATE_ENTRYValid,
        DATE_LAIValid: DATE_LAIValid,
        UNITEValid: UNITEValid,
        PRICEValid: PRICEValid,
        Inter_idValid: Inter_idValid,
        aff_sit_idValid: aff_sit_idValid,
        client_idValid: client_idValid,
        resp_idValid: resp_idValid,
        nature_nameValid: nature_nameValid
      },
      this.validateForm
    );
  }

  validateForm() {
    this.setState({
      formValid:
        this.state.PTE_KNOWNValid &&
        this.state.TIT_REQValid &&
        this.state.placeValid &&
        this.state.DATE_ENTRYValid &&
        this.state.DATE_LAIValid &&
        this.state.UNITEValid &&
        this.state.PRICEValid &&
        this.state.Inter_idValid &&
        this.state.aff_sit_idValid &&
        this.state.client_idValid &&
        this.state.resp_idValid &&
        this.state.nature_nameValid
    });
  }

  handleChange(e) {
    const name = e.target.name;
    const value = e.target.value;
    this.setState({ [name]: value }, () => {
      this.validateField(name, value);
    });
  }


  handleInputChange(e) {
    this.setState({ ...this.state, ...e });
  }

  autocompleteSearch = (route, value) => {
    if (route && value) {
      value = value.toString();
      let type = typeof String(value);
      if (type === "string") {
        let token =
          this.props.token === "" ? getCookie("token") : this.props.token;
        let obj = {
          key: value
        };
        this.props.getAutoCompleteAction(token, obj, route);
        this.setState({
          openAuto: !this.state.openAuto
        });
      }
    }
  };
  onTagsChange = event => {
    let route = event.target.id;
    let value = event.target.value;

    if (route && value) {
      this.autocompleteSearchThrottled(route, value);
    }
  };

  render() {
    const { formValid, open } = this.state;
    const { classes, suggestions } = this.props;
    const flatProps = {
      options: suggestions.filter(option => option.id)
    };
    console.log(this.props)
    return (
      <React.Fragment>
        <div>
          <Dialog
            open={open}
            onClose={this.handleClick}
            aria-labelledby="form-dialog-title-update"
          >
            <DialogTitle id="form-dialog-title-update">Modifier un dossier technique</DialogTitle>

            <Scrollbar style={{ width: 600, height: 500 }}>
              <div style={{ margin: "2vh 1vw" }}>
                <TextField
                  defaultValue={this.props.index && this.props.index.PTE_KNOWN}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="PTE_KNOWN"
                  label="PTE_KNOWN"
                  type="PTE_KNOWN"
                  name="PTE_KNOWN"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.TIT_REQ}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="TIT_REQ"
                  label="TIT_REQ"
                  type="TIT_REQ"
                  name="TIT_REQ"
                  fullWidth
                />


                <TextField
                  defaultValue={this.props.index && this.props.index.place}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="place"
                  label="place"
                  type="place"
                  name="place"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.DATE_ENTRY}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="DATE_ENTRY"
                  label="DATE_ENTRY"
                  type="DATE_ENTRY"
                  name="DATE_ENTRY"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.DATE_LAI}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="DATE_LAI"
                  label="DATE_LAI"
                  type="DATE_LAI"
                  name="DATE_LAI"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.UNITE}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="UNITE"
                  label="UNITE"
                  type="UNITE"
                  name="UNITE"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.PRICE}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="PRICE"
                  label="PRICE"
                  type="PRICE"
                  name="PRICE"
                  fullWidth
                />
                <FormControlLabel
                  control={
                    <Checkbox
                      checked={this.state.ttc === 1}
                      onChange={e => this.handleInputChange({ ttc: e.target.checked ? 1 : 0 })}
                      name="ttc"
                      color="primary"
                    />
                  }
                  label="Avec TTC"
                />
                <Autocomplete
                  {...flatProps}
                  id="getIntermediate"
                  getOptionLabel={option => option.value}
                  renderInput={params => {
                    return (
                      <TextField
                        {...params}
                        margin="normal"
                        fullWidth
                        onChange={this.onTagsChange}
                      // InputProps={{
                      //     ...params.InputProps,
                      //     endAdornment: (
                      //         <React.Fragment>
                      //             {openAutoComplete ? <CircularProgress color="inherit" size={20} /> : null}
                      //             {params.InputProps.endAdornment}
                      //         </React.Fragment>
                      //     ),
                      // }}
                      />
                    );
                  }}
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.aff_sit_id}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="aff_sit_id"
                  label="aff_sit_id"
                  type="aff_sit_id"
                  name="aff_sit_id"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.client_id}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="client_id"
                  label="client_id"
                  type="client_id"
                  name="client_id"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.resp_id}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="resp_id"
                  label="resp_id"
                  type="resp_id"
                  name="resp_id"
                  fullWidth
                />
                <TextField
                  defaultValue={this.props.index && this.props.index.nature_name}
                  onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="nature_name"
                  label="nature_name"
                  type="nature_name"
                  name="nature_name"
                  fullWidth
                />

                <TextField
                  defaultValue={this.props.index && this.props.index.long} onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="long"
                  label="Longitude"
                  type="long"
                  name="long"
                  fullWidth
                />

                <TextField
                  defaultValue={this.props.index && this.props.index.lat} onChange={this.handleChange}
                  autoFocus
                  margin="dense"
                  id="lat"
                  label="Latitude"
                  type="lat"
                  name="lat"
                  fullWidth
                />

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
  updateBusinessAction,
  getAutoCompleteAction,

  deleteBusinessAction
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
    name: "UpdateFolderTech"
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(UpdateFolderTech);
