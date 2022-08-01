import React from "react";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import { withStyles } from "@material-ui/core/styles";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import Scrollbar from "react-scrollbars-custom";
import CreatableSelect from 'react-select/creatable';
import TextField from "@material-ui/core/TextField";
import EditIcon from "@material-ui/icons/EditOutlined";
import { getCookie } from "../../utils/cookies";
import { connect } from "react-redux";
import { compose } from "recompose";
import "react-toastify/dist/ReactToastify.min.css";

import MomentUtils from '@date-io/moment';
import { KeyboardDatePicker, MuiPickersUtilsProvider } from "@material-ui/pickers";
import moment from "moment";
import { DropzoneDialog } from "material-ui-dropzone";
import { formaDate, toShortFormat } from "../../utils/dateConverter";
import Select from "react-select";
import { State_of_progressConst } from "../../Constansts/selectHelper";
import PropTypes from 'prop-types';
import 'react-confirm-alert/src/react-confirm-alert.css';
import RevertIcon from "@material-ui/icons/NotInterestedOutlined";
import { updateGreatConstructionSitesAction } from "../../actions/greatConstructionSiteActions";
import { CheckDecimal } from "../../utils/validation/CheckDecimal";
import { toast, ToastContainer } from 'react-toastify';
import _ from 'underscore';
import 'react-toastify/dist/ReactToastify.min.css'
import { FormControlLabel, Checkbox } from "@material-ui/core";

const localeEn = moment.locale('es');
const createOption = (label) => ({
    label,
    value: label.toLowerCase().replace(/\W/g, ''),
});
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
    <i
        className="toastify__close fa fa-times"
        onClick={closeToast}
    />
);

class UpdateGreatConstructions extends React.Component {
    static propTypes = {
        // businessNatures: PropTypes.string.isRequired,
        index: PropTypes.object.isRequired,
        id: PropTypes.number.isRequired,
    };

    constructor(props) {
        super(props);
        this.state = {
            locatedBrigades: "",
            isLoading: false,
            open: false,
            openDropZone: false,
            openDropZoneExecution_report: false,
            openDropZoneClass_service: false,
            process_enumValue: {
                label: "",
                value: ''
            },
            process_enum: [],
            multiValueSelect: [],
            multiLocationSelect: [],
            multiLocation: {
                label: "",
                value: ''
            }, multiValue: {
                label: "",
                value: ''
            }, multiLocatedBrigadesSelect: [],
            multiLocatedBrigades: {},
            files: [],
            advanced: "",
            observation: "",
            ttc: 0,
            long: "",
            lat: "",
            price: "",
            fees_decompte: "",
            location_id: "",
            Market_title: "",
            Managed_by: "",
            State_of_progress: "",
            Class_service: [],
            DATE_LAI: toShortFormat(),
            date_of_receipt: toShortFormat(),
            Execution_report: [],
            Execution_phase: "",
            errors: [],
        };
    }

    handleClick = () => {
        this.setState({
            open: !this.state.open,
        });
    };


    handleExecution_reportClose() {
        this.setState({
            openDropZoneClass_service: false
        });
    }

    handleClass_serviceSave(files) {
        //Saving files to state for further use and closing Modal.
        this.setState({
            Class_service: files,
            openDropZoneClass_service: false
        });
    }

    handleClass_serviceOpen() {
        this.setState({
            openDropZoneClass_service: true,
        });
    }

    handleClass_serviceClose() {
        this.setState({
            openDropZoneClass_service: false
        });
    }

    handleExecution_reportSave(files) {
        //Saving files to state for further use and closing Modal.
        this.setState({
            Execution_report: files,
            openDropZoneExecution_report: false
        });
    }

    handleExecution_reportOpen() {
        this.setState({
            openDropZoneExecution_report: true,
        });
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

    handleSubmit = () => {
        this.validateForm();
    };
    componentWillMount() {
        if (this.props.related_to) {
            this.setState({
                multiValueSelect: this.props.related_to
            })
        }
        if (this.props.locationsBy_Id) {
            this.setState({
                multiLocationSelect: this.props.locationsBy_Id
            })
        }
        if (this.props.locatedBrigades) {
            this.setState({
                multiLocatedBrigadesSelect: this.props.locatedBrigades
            })
        }
    }

    componentWillReceiveProps(nextProps, nextContext) {

        if (nextProps.related_to !== this.props.related_to) {
            this.setState({
                multiValueSelect: nextProps.related_to
            })
        }
        if (nextProps.locationsBy_Id !== this.props.locationsBy_Id) {
            this.setState({
                multiLocationSelect: nextProps.locationsBy_Id
            })
        }
        if (nextProps.locatedBrigades !== this.props.locatedBrigades) {
            this.setState({
                multiLocatedBrigadesSelect: nextProps.locatedBrigades
            })
        }
    }

    validateForm = () => {
        const {
            price,
            advanced,
            multiLocation,
            Market_title,
            multiValue,
            process_enumValue,
        } = this.state;
        const errors = {};
        if (advanced === "") {
            errors.price = "Prix est necessaire";
        }
        if (CheckDecimal(parseFloat(price))) {
            errors.price = "Prix doit etre un chiffre";
        }
        if (advanced === "") {
            errors.advanced = "Avence est necessaire";
        }
        if (CheckDecimal(parseFloat(advanced))) {
            errors.advanced = "Avence doit etre un chiffre";
        }
        if (!multiLocation.label) {
            errors.location_id = "Emplacement est necessaire";
        }
        if (Market_title === "") {
            errors.Market_title = "titre du marché est necessaire";
        }
        if (!multiValue.label) {
            errors.Managed_by = "le champ dirigé par est necessaire";
        }
        if (!process_enumValue.label) {
            errors.process_enumValue = "etat avencement est necessaire";
        }
        let size = _.size(errors);
        if (size === 0) {
            let formdata = new FormData();
            let files = this.state.files;
            files.forEach(file => {
                formdata.append('filenames[]', file);
            });
            let Class_service = this.state.Class_service;
            Class_service.forEach(file => {
                formdata.append('Class_service[]', file);
            });
            let Execution_report = this.state.Execution_report;
            Execution_report.forEach(file => {
                formdata.append('Execution_report[]', file);
            });
            let token = this.props.token === '' ? getCookie('token') : this.props.token;
            formdata.append('price', this.state.price);
            formdata.append('advanced', this.state.advanced);
            formdata.append('observation', this.state.observation);
            formdata.append('allocated_brigades', this.state.locatedBrigades);
            formdata.append('location_id', this.state.multiLocation.value);
            formdata.append('Market_title', this.state.Market_title);
            formdata.append('Managed_by', this.state.multiValue.value);
            formdata.append('State_of_progress', this.state.process_enumValue.label);
            formdata.append('Class_service', Class_service);
            formdata.append('Execution_report', Execution_report);
            formdata.append('Execution_phase', this.state.Execution_phase);
            formdata.append('date_of_receipt', formaDate(this.state.date_of_receipt));
            formdata.append('DATE_LAI', formaDate(this.state.DATE_LAI));
            formdata.append('long', formaDate(this.state.long));
            formdata.append('lat', formaDate(this.state.lat));
            formdata.append('ttc', this.state.ttc);
            let obj = {
                Market_title: this.state.Market_title,
                location_name: this.state.multiLocation.label,
                name: this.state.multiValue.label,
                State_of_progress: this.state.process_enumValue.label,
            };
            this.props.updateGreatConstructionSitesAction(token, formdata, obj);

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

    handleChange = (input) => {
        console.log(input);

        this.setState({ ...input });
    };


    handleProcessChange = (option) => {
        this.setState({
            process_enumValue: option
        });
    };
    handlemultiLocatedBrigadesChange = (option) => {
        let op = option !== null ? option.value : '';
        let locatedBrigades = this.state.locatedBrigades + ',' + op;
        locatedBrigades = locatedBrigades === ',' ? '' : locatedBrigades;
        if (locatedBrigades && locatedBrigades !== '') {
            this.setState({
                locatedBrigades: locatedBrigades,
                multiLocatedBrigades: option
            });
        }

    };
    handleCreate = (inputValue) => {
        this.setState({ isLoading: true });
        console.group('Option created');
        console.log('Wait a moment...');
        setTimeout(() => {
            const { multiLocatedBrigadesSelect } = this.state;
            const newOption = createOption(inputValue);
            let locatedBrigades = this.state.locatedBrigades + ',' + newOption.value;
            locatedBrigades = locatedBrigades === ',' ? '' : locatedBrigades;
            if (locatedBrigades && locatedBrigades !== '') {
                this.setState({
                    locatedBrigades: locatedBrigades,
                    multiLocatedBrigadesSelect: [...multiLocatedBrigadesSelect, newOption],
                    multiLocatedBrigades: newOption,
                });
            }
            this.setState({
                isLoading: false,
            });
        }, 500);
    };
    handleMultiChange = (option) => {
        this.setState({
            multiValue: option
        });
    }
    handleLocationMultiChange = (option) => {
        this.setState({
            multiLocation: option
        });
    }

    render() {
        const { classes } = this.props;
        const {
            multiLocatedBrigades, multiLocatedBrigadesSelect, isLoading,
            multiValue, errors, process_enumValue, process_enum,
            multiLocation, multiValueSelect, formValid, open, multiLocationSelect
        } = this.state;

        console.log(this.props);


        return (
            <React.Fragment>
                <div>
                    <ToastContainer autoClose={4000} position={toast.POSITION.BOTTOM_LEFT}
                        closeButton={<FontAwesomeCloseButton />} />
                    <Dialog
                        open={open}
                        onClose={this.handleClick}
                        aria-labelledby="form-dialog-title"
                    >
                        <DialogTitle className={classes.title} id="form-dialog-title">
                            Modifier un Grand Chantier
                        </DialogTitle>
                        <Scrollbar style={{ width: 600, height: 660 }}>
                            <div className={classes.rr}>
                                <TextField
                                    defaultValue={this.props.index && this.props.index.Market_title}
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
                                    defaultValue={this.props.index && this.props.index.advanced}
                                    onChange={(e) => this.handleChange({ advanced: e.target.value })}
                                    className={classes.inputField}
                                    autoFocus
                                    margin="dense"
                                    id="advanced"
                                    label="avances"
                                    type="text"
                                    name="advanced"
                                    fullWidth
                                    error={errors.advanced}
                                    helperText={errors.advanced}
                                />

                                <TextField
                                    defaultValue={this.props.index && this.props.index.price}
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
                                <FormControlLabel
                                    control={
                                        <Checkbox
                                            checked={this.props.index && this.props.index.ttc === 1}
                                            onChange={(e) => this.handleChange({ price: e.target.checked ? 1 : 0 })}
                                            name="TTC"
                                            color="primary"
                                        />
                                    }
                                    label="Avec TTC"
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

                                <div className='table-index-no_margin mt-1 mb-3'>
                                    <Select
                                        name="Emplacement"
                                        placeholder="Emplacement"
                                        value={multiLocation}
                                        options={multiLocationSelect}
                                        onChange={this.handleLocationMultiChange}
                                    />
                                </div>

                                <div className='table-index-no_margin mb-3'>
                                    <Select
                                        name="Managed_by"
                                        placeholder="Dirigé parà"
                                        value={multiValue}
                                        options={multiValueSelect}
                                        onChange={this.handleMultiChange}
                                    />
                                </div>
                                <div className='table-index-no_margin mb-3'>
                                    <Select
                                        name="process_enum"
                                        placeholder="Etat d'avancement"
                                        value={process_enumValue}
                                        options={State_of_progressConst}
                                        onChange={this.handleProcessChange}
                                    />
                                </div>
                                <div className='table-index-no_margin mb-3'>
                                    <CreatableSelect
                                        isClearable
                                        isMulti
                                        isDisabled={isLoading}
                                        isLoading={isLoading}
                                        onChange={this.handlemultiLocatedBrigadesChange}
                                        onCreateOption={this.handleCreate}
                                        options={multiLocatedBrigadesSelect}
                                        value={multiLocatedBrigades}
                                    />

                                </div>


                                <TextField
                                    defaultValue={this.props.index && this.props.index.Execution_phase}
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
                                    defaultValue={this.props.index && this.props.index.observation}
                                    onChange={(e) =>
                                        this.handleChange({ observation: e.target.value })
                                    }
                                    className={classes.inputField}
                                    margin="dense"
                                    id="observation"
                                    label="observation"
                                    type="text"
                                    name="observation"
                                    fullWidth
                                    error={errors.observation}
                                    helperText={errors.observation}
                                />

                                <div className="my-2">

                                    <MuiPickersUtilsProvider utils={MomentUtils} locale={localeEn}>
                                        <KeyboardDatePicker
                                            label="date de réception"
                                            variant="inline"
                                            format="DD/MM/YYYY"
                                            autoOk
                                            inputVariant="outlined"
                                            InputAdornmentProps={{ position: "start" }}
                                            placeholder={this.props.index && this.props.index.date_of_receipt}
                                            value={this.props.index && this.props.index.date_of_receipt}
                                            onChange={date => this.setState(
                                                {
                                                    date_of_receipt: date
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
                                            InputAdornmentProps={{ position: "start" }}
                                            placeholder={this.props.index && this.props.index.DATE_LAI}
                                            value={this.props.index && this.props.index.DATE_LAI}
                                            onChange={date => this.setState(
                                                {
                                                    DATE_LAI: date
                                                }
                                            )}

                                        />

                                    </MuiPickersUtilsProvider>

                                </div>
                                <div>
                                    <Button onClick={this.handleClass_serviceOpen.bind(this)}>
                                        Service de classe
                                    </Button>
                                    <DropzoneDialog
                                        open={this.props.index && this.props.index.openDropZoneClass_service}
                                        onSave={this.handleClass_serviceSave.bind(this)}
                                        showPreviews={true}
                                        maxFileSize={5000000}
                                        onClose={this.handleClass_serviceClose.bind(this)}
                                    />
                                </div>
                                <div>
                                    <Button onClick={this.handleExecution_reportOpen.bind(this)}>
                                        Choisire un Rapport d'exécution
                                    </Button>
                                    <DropzoneDialog
                                        open={this.props.index && this.props.index.openDropZoneExecution_report}
                                        onSave={this.handleExecution_reportSave.bind(this)}
                                        showPreviews={true}
                                        maxFileSize={5000000}
                                        onClose={this.handleExecution_reportClose.bind(this)}
                                    />
                                </div>
                                <div>
                                    <Button onClick={this.handleOpen.bind(this)}>
                                        Choisire un fichiers
                                    </Button>
                                    <DropzoneDialog
                                        open={this.props.index && this.props.index.openDropZone}
                                        onSave={this.handleSave.bind(this)}
                                        showPreviews={true}
                                        maxFileSize={5000000}
                                        onClose={this.handleClose.bind(this)}
                                    />
                                </div>

                                <div className={classes.controlButtons}>
                                    <Button onClick={this.handleClick} color="primary">
                                        Cancel
                                    </Button>
                                    <Button color="primary" onClick={this.handleSubmit} type="submit">Submit

                                    </Button>
                                </div>
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
    updateGreatConstructionSitesAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        related_to: state.select.related_to,
        locatedBrigades: state.select.locatedBrigades,
        locationsBy_Id: state.select.locationsBy_Id,
        error: state.select.error,

    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'UpdateGreatConstructions',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(UpdateGreatConstructions);
//export default connect(mapStateToProps, mapDispatchToProps)(UpdateGreatConstructions);
