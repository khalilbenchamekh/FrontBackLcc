import MomentUtils from "@date-io/moment";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import IconButton from "@material-ui/core/IconButton";
import {withStyles} from "@material-ui/core/styles";
import TextField from "@material-ui/core/TextField";
import Tooltip from "@material-ui/core/Tooltip";
import AddIcon from "@material-ui/icons/Add";
import {KeyboardDatePicker, MuiPickersUtilsProvider} from "@material-ui/pickers";
import {DropzoneDialog} from "material-ui-dropzone";
import React from "react";
import {connect} from "react-redux";
import Scrollbar from "react-scrollbars-custom";
import Select from "react-select";
import {toast, ToastContainer} from "react-toastify";
import "react-toastify/dist/ReactToastify.min.css";
import {compose} from "recompose";
import _ from "underscore";
import {addBusinessAction} from "../../../actions/businessActions";
import {localeEn} from "../../../Constansts/appconstant";
import {getCookie} from "../../../utils/cookies";
import {formaDate, toShortFormat} from "../../../utils/dateConverter";
import {FormControlLabel, Checkbox} from "@material-ui/core";
import {CheckDecimal} from "../../../utils/validation/CheckDecimal";

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

const FontAwesomeCloseButton = ({closeToast}) => (
    <i className="toastify__close fa fa-times" onClick={closeToast}/>
);

class CustomToolbar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            open: false, files: [],

            REF: "",
            PTE_KNOWN: "",
            TIT_REQ: "",
            place: "",
            DATE_ENTRY: toShortFormat(),
            DATE_LAI: toShortFormat(),

            multiValue: [],
            multiValueSelect: [],

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
            formErrors: {
                PTE_KNOWN: "",
                TIT_REQ: "",
                place: "",
                DATE_ENTRY: toShortFormat(),
                DATE_LAI: toShortFormat(),
                UNITE: "",
                PRICE: "",
                Inter_id: "",
                aff_sit_id: "",
                client_id: "",
                resp_id: "",
                nature_name: ""
            },
            openDropZone: false,
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
            formValid: false,
            multiValueNatureName: [],
            multiValueNatureNameSelect: [],
            multiValueBusinesSituation: [],
            multiValueBusinesSituationSelect: [],
            multiValueIntermediateSelect: [],
            multiValueIntermediate: [],
        };
        this.handleChange = this.handleChange.bind(this);
    }

    handleMultiChange = (option) => {
        this.setState({
            multiValue: option
        });
    };

    handleMultiClientChange = (option) => {
        this.setState({
            multiValueClient: option
        });
    };
    handleMultiBusinesSituationChange = (option) => {
        this.setState({
            multiValueBusinesSituation: option
        });
    };

    handleMultiNatureNameChange = (option) => {
        this.setState({
            multiValueNatureName: option
        });
    };
    handleMultiIntermediateChange = (option) => {
        this.setState({
            multiValueIntermediate: option
        });
    };
    handleClick = () => {
        this.setState({
            open: !this.state.open
        });
    };

    validateField(fieldName, value) {
        let fieldValidationErrors = this.state.formErrors;
        let PTE_KNOWNValid = this.state.PTE_KNOWNValid;
        let TIT_REQValid = this.state.TIT_REQValid;
        let placeValid = this.state.placeValid;
        let UNITEValid = this.state.UNITEValid;
        let PRICEValid = this.state.PRICEValid;
        switch (fieldName) {

            case "PTE_KNOWN":
                PTE_KNOWNValid = value.length > 0;
                fieldValidationErrors.PTE_KNOWN = PTE_KNOWNValid ? "" : " is Required";
                break;
            case "TIT_REQ":
                TIT_REQValid = value.length > 0;
                fieldValidationErrors.city = TIT_REQValid ? "" : " is Required";
                break;
            case "place":
                placeValid = value.length > 0;
                fieldValidationErrors.placeValid = placeValid ? "" : " is Required";
                break;

            case "UNITE":
                UNITEValid = CheckDecimal(parseInt(value));
                fieldValidationErrors.UNITEValid = UNITEValid ? "" : " is Required";
                break;

            case "PRICE":
                PRICEValid = CheckDecimal(parseFloat(value));
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
                UNITEValid: UNITEValid,
                PRICEValid: PRICEValid,
            },
            this.validateForm
        );
    }

    handleClose() {
        this.setState({
            openDropZone: false
        });
    }

    handleSave(files) {
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

    validateForm() {
        this.setState({
            formValid:
                this.state.PTE_KNOWNValid &&
                this.state.TIT_REQValid &&
                this.state.placeValid &&
                this.state.UNITEValid &&
                this.state.PRICEValid

        });
    }

    handleChange(e) {
        const name = e.target.name;
        const value = e.target.value;
        this.setState({[name]: value}, () => {
            this.validateField(name, value);
        });
    }

    handleInputChange(e) {
        this.setState({...this.state, ...e});
    }

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error !== "") {
            toast.error(nextProps.error);
        }
        if (nextProps.related_to !== this.props.related_to) {
            this.setState({
                multiValueSelect: nextProps.related_to
            })
        }
        if (nextProps.client !== this.props.client) {
            this.setState({
                multiValueClientSelect: nextProps.client
            })
        }
        if (nextProps.businessName !== this.props.businessName) {
            this.setState({
                multiValueNatureNameSelect: nextProps.businessName
            })
        }
        if (nextProps.intermediates !== this.props.intermediates) {
            this.setState({
                multiValueIntermediateSelect: nextProps.intermediates
            })
        }
        if (nextProps.businessSituations !== this.props.businessSituations) {
            this.setState({
                multiValueBusinesSituationSelect: nextProps.businessSituations
            })
        }
    }

    addClick = () => {
        const errors = {};
        if (!this.state.multiValueBusinesSituation.value) {
            errors.multiValueBusinesSituation = "Affaire Situation est necessaire";
        }
        if (!this.state.multiValueClient.value) {
            errors.multiValueClient = "Client est necessaire";
        }
        if (!this.state.multiValue.value) {
            errors.multiValue = "Responsable est necessaire";
        }
        if (!this.state.multiValueNatureName.value) {
            errors.multiValueNatureName = "AffaireNatures est necessaire";
        }
        let size = _.size(errors);
        if (size === 0) {
            let token = this.props.token === "" ? getCookie("token") : this.props.token;
            let formdata = new FormData();
            let files = this.state.files;
            files.forEach(file => {
                formdata.append('filenames[]', file);
            });
            formdata.append('PTE_KNOWN', this.state.PTE_KNOWN);
            formdata.append('TIT_REQ', this.state.TIT_REQ);
            formdata.append('place', this.state.place);
            formdata.append('UNITE', this.state.UNITE);
            formdata.append('PRICE', this.state.PRICE);
            if (this.state.multiValueIntermediate.value) {
                formdata.append('Inter_id', this.state.multiValueIntermediate.value);
            }
            formdata.append('aff_sit_id', this.state.multiValueBusinesSituation.value);
            formdata.append('client_id', this.state.multiValueClient.value);
            formdata.append('resp_id', this.state.multiValue.value);
            formdata.append('nature_name', this.state.multiValueNatureName.value);
            formdata.append('DATE_ENTRY', formaDate(this.state.DATE_ENTRY));
            formdata.append('DATE_LAI', formaDate(this.state.DATE_LAI));
            formdata.append('ttc', this.state.ttc);
            formdata.append('long', this.state.long);
            formdata.append('lat', this.state.lat);
            this.props.addBusinessAction(token, formdata);
        } else {
            Object.keys(errors).forEach(function (key) {
                let error = errors[key];
                toast.error(error, {
                    toastId: key
                });
            });

        }
        this.setState({
            open: !this.state.open
        });
    };

    render() {
        const {
            multiValue, multiValueNatureName, multiValueBusinesSituationSelect, multiValueBusinesSituation,
            multiValueNatureNameSelect, multiValueClientSelect, multiValueClient, multiValueIntermediateSelect, multiValueIntermediate,
            multiValueSelect, formValid, open
        } = this.state;
        const {classes} = this.props;
        let isValidForm = valid();

        function valid() {
            let bool = false;
            if (multiValueBusinesSituation && multiValue && multiValueClient && multiValueNatureName) {
                if (multiValueBusinesSituation.value !== "" && multiValueBusinesSituation.value &&
                    multiValueClient.value !== "" && multiValueClient.value &&
                    multiValue.value !== "" && multiValue.value &&
                    multiValueNatureName.value !== "" && multiValueNatureName.value && formValid) {
                    bool = true;
                }
            }
            return bool;

        }

        return (
            <React.Fragment>
                <div>
                    <ToastContainer autoClose={4000} position={toast.POSITION.BOTTOM_LEFT}
                                    closeButton={<FontAwesomeCloseButton/>}/>
                    <Dialog
                        open={open}
                        onClose={this.handleClick}
                        aria-labelledby="form-dialog-title"
                    >
                        <DialogTitle className={classes.title} id="form-dialog-title">
                            Ajouter une affaire
                        </DialogTitle>
                        <Scrollbar style={{width: 600, height: 700}}>
                            <div className={classes.rr}>
                                <TextField
                                    defaultValue={this.props.index && this.props.index.PTE_KNOWN}
                                    onChange={this.handleChange}
                                    className={classes.inputField}
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
                                <div className="mt-3">
                                    <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                        <KeyboardDatePicker
                                            label="date d'entrée"
                                            variant="inline"
                                            format="DD/MM/YYYY"
                                            autoOk
                                            inputVariant="outlined"
                                            InputAdornmentProps={{position: "start"}}
                                            placeholder={this.state.DATE_ENTRY}
                                            value={this.state.DATE_ENTRY}
                                            onChange={date => this.setState(
                                                {
                                                    DATE_ENTRY: date
                                                }
                                            )}

                                        />
                                    </MuiPickersUtilsProvider>
                                    <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                        <KeyboardDatePicker
                                            label="date de livraison"
                                            variant="inline"
                                            format="DD/MM/YYYY"
                                            autoOk
                                            inputVariant="outlined"
                                            InputAdornmentProps={{position: "start"}}
                                            placeholder={this.state.DATE_LAI}
                                            value={this.state.DATE_LAI}
                                            onChange={date => this.setState(
                                                {
                                                    DATE_LAI: date
                                                }
                                            )}

                                        />

                                    </MuiPickersUtilsProvider>
                                </div>
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
                                    label="Prix"
                                    type="PRICE"
                                    name="PRICE"
                                    fullWidth
                                />

                                <FormControlLabel
                                    control={
                                        <Checkbox
                                            checked={this.state.ttc === 1}
                                            onChange={e => this.handleInputChange({ttc: e.target.checked ? 1 : 0})}
                                            name="ttc"
                                            color="primary"
                                        />
                                    }
                                    label="Avec TTC"
                                />

                                <TextField
                                    defaultValue={this.props.index && this.props.index.long}
                                    onChange={this.handleChange}
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

                                <div className='table-index-no_margin'>
                                    <Select
                                        name="intermediates"
                                        placeholder="intermédiaires"
                                        value={multiValueIntermediate}
                                        options={multiValueIntermediateSelect}
                                        onChange={this.handleMultiIntermediateChange}
                                    />
                                </div>
                                <div className='table-index-no_margin'>
                                    <Select
                                        name="Affaire Situation"
                                        placeholder="Affaire Situation"
                                        value={multiValueBusinesSituation}
                                        options={multiValueBusinesSituationSelect}
                                        onChange={this.handleMultiBusinesSituationChange}
                                    />
                                </div>

                                <div className='table-index-no_margin'>
                                    <Select
                                        name="client"
                                        placeholder="client"
                                        value={multiValueClient}
                                        options={multiValueClientSelect}
                                        onChange={this.handleMultiClientChange}
                                    />
                                </div>

                                <div className='table-index-no_margin'>
                                    <Select
                                        name="Managed_by"
                                        placeholder="Dirigé parà"
                                        value={multiValue}
                                        options={multiValueSelect}
                                        onChange={this.handleMultiChange}
                                    />
                                </div>
                                <div className='table-index-no_margin'>
                                    <Select
                                        name="NatureName"
                                        placeholder="Affaire Nature"
                                        value={multiValueNatureName}
                                        options={multiValueNatureNameSelect}
                                        onChange={this.handleMultiNatureNameChange}
                                    />
                                </div>

                                <div className="files">
                                    <div>
                                        <Button onClick={this.handleOpen.bind(this)}>
                                            Choisire un fichiers
                                        </Button>
                                        <DropzoneDialog
                                            open={this.state.openDropZone}
                                            onSave={this.handleSave.bind(this)}
                                            showPreviews={true}
                                            maxFileSize={5000000}
                                            onClose={this.handleClose.bind(this)}
                                        />
                                    </div>
                                </div>
                                <Button onClick={this.handleClick} color="primary">
                                    Cancel
                                </Button>
                                <Button
                                    disabled={!isValidForm}
                                    onClick={this.addClick}
                                    color="primary"
                                >
                                    Add
                                </Button>
                            </div>
                        </Scrollbar>
                    </Dialog>
                </div>
                <Tooltip title={"custom icon"}>
                    <IconButton className={classes.iconButton} onClick={this.handleClick}>
                        <AddIcon className={classes.deleteIcon}/>
                    </IconButton>
                </Tooltip>
            </React.Fragment>
        );
    }
}

const mapDispatchToProps = {
    addBusinessAction
};

function mapStateToProps(state) {
    return {
        token: state.login.token,
        related_to: state.select.related_to,
        client: state.select.client,
        businessSituations: state.select.businessSituations,
        businessName: state.select.businessName,
        intermediates: state.select.intermediates,
        error: state.businessNatures.error
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: "CustomToolbar"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(CustomToolbar);
