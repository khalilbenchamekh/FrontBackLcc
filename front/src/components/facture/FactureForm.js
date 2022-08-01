import React, { Component } from "react";
import { connect } from "react-redux";
import Paper from "@material-ui/core/Paper";
import Grid from "@material-ui/core/Grid";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import Autocomplete from "@material-ui/lab/Autocomplete";
import DeleteForeverIcon from "@material-ui/icons/DeleteForever";
import { TextField, TableCell, TableRow, Button ,Box} from "@material-ui/core";
import PropTypes from "prop-types";
import { getCookie } from "../../utils/cookies";
import { getBillAction } from "../../actions/billActions";
import {getClientsAction} from "../../actions/clientActions";
import _ from 'underscore';
const defaultToolbarStyles = {
    root: {
        flexGrow: 1,
    },
    paper: {
        padding: 10,
        textAlign: "center",
        color: "green",
        height: "80vh",
        overflowY: "auto",
    },
    icon: {
        cursor: "pointer",
    },
};

class FactureForm extends Component {
    constructor() {
        super();
        this.state = {
            prestationCounter: 0,
            type: "",
            client: "",
            objet: "",
            destination: "",
            date: "",
            reference: "",
            Prestations: [],
            formErrors: {
                type: "",
                client: "",
                objet: "",
                destination: "",
                date: "",
                reference: "",
                Prestations: [],
            },
        };
    }

    componentDidMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            this.props.getClientsAction(token);
        }
        
    }

    handleChange = (input) => {
        this.setState({ ...input });
    };

    handleTableChange = (index, input) => {
        const { Prestations } = this.state;
        this.setState({
            Prestations: Prestations.map((row) =>
                row.id === index ? { ...row, ...input } : row
            ),
        });
    };

    newPrestation = () => {
        const { prestationCounter } = this.state;
        const prst = {
            id: prestationCounter,
            nature: "",
            unity: "",
            price: "",
        };
        prst.error = {
            nature: "",
            unity: "",
            price: "",
        };
        this.setState({ prestationCounter: prestationCounter + 1 });
        return prst;
    };
    ajouterPrestation = () => {
        const { Prestations, formErrors } = this.state;
        const prset = this.newPrestation();
        this.setState({ Prestations: [...Prestations, prset] });
    };

    supprimerPrestation = (id) => {
        console.log("deleting id: " + id);
        const { Prestations } = this.state;
        this.setState({ Prestations: Prestations.filter((p) => p.id != id) });
    };

    validForm() {
        const {
            client,
            objet,
            destination,
            date,
            reference,
            Prestations,
        } = this.state;
        const errors = {};
        const errorsPrest = [];
        if (client === "") {
            errors.client = "Client est necessaire";
        }
        if (objet === "") {
            errors.objet = "Objet est necessaire";
        }
        if (reference === "") {
            errors.reference = "Reference est necessaire";
        }
        if (destination === "") {
            errors.destination = "destination est necessaire";
        }
        if (date === "") {
            errors.date = "date est necessaire";
        }
        let tt = 0;
        let tableDetails = [];
        Prestations.forEach((element, index) => {

            var err = {};
            if (element.nature == "") {
                err.nature = "nature est necessaire";
            }
            if (element.unity == "") {
                err.unity = "unité est necessaire";
            }
            if (element.price == "") {
                err.price = "price est necessaire";
            } if (element.qt == "") {
                err.qt = "Qunatité est necessaire";
            }
            if (_.size(err) !== 0) {
                let pt = element.qt * element.price;
                tt = tt + (pt * 0.2 + pt);
                let temp = {
                    Ds: element.nature,
                    Un: element.unity,
                    pt: pt,
                    pu: element.price,
                    qt: element.qt,
                    tt: tt
                };
                tableDetails.push(temp);
            }
            errorsPrest.push(err);
        });
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
         let obj = {
            'client_n': this.state.client_n,
         'client_ice': this.state.client_ice,
         'Etablissement': this.state.Etablissement,
         'details': this.state.details,
         tableDetails: {
            Ds: this.state.destination,
          Un: this.state.Un,
                pt: this.state.pt,
                 pu: this.state.pu,
                 qt: this.state.qt,
        
             },
        
             Market_title: client,
            location_name: objet,
             name:"",
             State_of_progress: date,
             reference: reference,
             Prestations: Prestations,
         };
         this.props.getBillAction(token, obj);


        this.setState({
            formErrors: { ...errors },
            Prestations: Prestations.map((row, index) => ({
                ...row,
                error: { ...errorsPrest[index] },
            })),
        });
    }

    handleSubmit = () => {
        this.validForm();
    };

    render() {
        const { classes, types ,clients} = this.props;
        const { Prestations, formErrors } = this.state;
        console.log(this.state);

        return (
            <div className={classes.root}>
                <Grid container spacing={3}>
                    <Grid item xs={12} sm={5}>
                        <Paper className={classes.paper}>
                            <Autocomplete
                                options={types}
                                getOptionLabel={(option) => option.title}
                                id="Type"
                                renderInput={(params) => (
                                    <TextField {...params} label="Type" margin="normal" />
                                )}
                                handleChange={(e) =>
                                    this.handleChange({ type: e.target.value })
                                }
                            />
                            <Autocomplete
                                options={clients}
                                getOptionLabel={(option) => option.name}
                                id="clients"
                                renderInput={(params) => (
                                    <TextField {...params} label="" 
                                    defaultValue={this.state.PTE_KNOWN}
                                    margin="normal" 
                                    label="Client"
                                    error={formErrors.client}
                                    helperText={formErrors.client}/>
                                )}
                                handleChange={(e) =>
                                    this.handleChange({ client: e.target.value })
                                }
                            />
                           
                            <TextField
                                defaultValue={this.state.PTE_KNOWN}
                                onChange={(e) => this.handleChange({ objet: e.target.value })}
                                autoFocus
                                margin="dense"
                                id="Objet"
                                label="Objet"
                                type="text"
                                name="Objet"
                                error={formErrors.objet}
                                helperText={formErrors.objet}
                                fullWidth
                            />
                            <TextField
                                defaultValue={this.state.PTE_KNOWN}
                                onChange={(e) =>
                                    this.handleChange({ destination: e.target.value })
                                }
                                autoFocus
                                margin="dense"
                                id="destinataire"
                                label="destinataire"
                                type="text"
                                name="destinataire"
                                error={formErrors.destination}
                                helperText={formErrors.destination}
                                fullWidth
                            />
                            <TextField
                                defaultValue={this.state.PTE_KNOWN}
                                onChange={(e) => this.handleChange({ date: e.target.value })}
                                autoFocus
                                margin="dense"
                                id="date"
                                type="date"
                                name="date"
                                error={formErrors.date}
                                helperText={formErrors.date}
                                fullWidth
                            />
                            <TextField
                                defaultValue={this.state.PTE_KNOWN}
                                onChange={(e) =>
                                    this.handleChange({ reference: e.target.value })
                                }
                                autoFocus
                                margin="dense"
                                id="reference"
                                label="Reference"
                                type="text"
                                name="reference"
                                error={formErrors.reference}
                                helperText={formErrors.reference}
                                fullWidth
                            />
                        </Paper>
                    </Grid>
                    <Grid item xs={12} sm={7}>
                        <Paper className={classes.paper}>
                            {Prestations.map((row) => (
                                <TableRow key={row.id}>
                                    <TableCell component="th" scope="row">
                                    <Box width={200}>
                                        <TextField
                                            onChange={(e) =>
                                                this.handleTableChange(row.id, {
                                                    nature: e.target.value,
                                                })
                                            }
                                            autoFocus
                                            margin="dense"
                                            id="Nature"
                                            label="Nom de la prestation"
                                            type="text"
                                            name="Nature"
                                            error={row.error.nature}
                                            helperText={row.error.nature}
                                            fullWidth
                                        /></Box>
                                    </TableCell>
                                    <TableCell align="right">
                                        <TextField
                                            onChange={(e) =>
                                                this.handleTableChange(row.id, {
                                                    unity: e.target.value,
                                                })
                                            }
                                            autoFocus
                                            margin="dense"
                                            id="Unité"
                                            label="Unité"
                                            type="text"
                                            name="Unité"
                                            error={row.error.unity}
                                            helperText={row.error.unity}
                                            fullWidth
                                        />
                                    </TableCell>
                                    <TableCell align="right">
                                        <TextField
                                            onChange={(e) =>
                                                this.handleTableChange(row.id, {
                                                    qt: e.target.value,
                                                })
                                            }
                                            autoFocus
                                            margin="dense"
                                            id="Quantité"
                                            label="Quantité"
                                            type="text"
                                            name="Quantité"
                                            error={row.error.qt}
                                            helperText={row.error.qt}
                                            fullWidth
                                        />
                                    </TableCell>
                                    <TableCell align="right">
                                        <TextField
                                            onChange={(e) =>
                                                this.handleTableChange(row.id, {
                                                    price: e.target.value,
                                                })
                                            }
                                            autoFocus
                                            margin="dense"
                                            id="Prix Unitaire"
                                            label="Prix Unitaire"
                                            type="text"
                                            name="Prix Unitaire"
                                            error={row.error.price}
                                            helperText={row.error.price}
                                            fullWidth
                                        />
                                    </TableCell>
                                    <TableCell align="right">
                                        <DeleteForeverIcon
                                            color="secondary"
                                            className={classes.icon}
                                            onClick={() => this.supprimerPrestation(row.id)}
                                        />
                                    </TableCell>
                                </TableRow>
                            ))}
                            <Button
                                variant="contained"
                                className="mt-2"
                                onClick={this.ajouterPrestation}
                                color="primary"
                            >
                                Ajouter Prestataire
                            </Button>
                        </Paper>
                    </Grid>
                    <Button
                        onClick={this.handleSubmit}
                        variant="contained"
                        className="ml-auto mr-2"
                        color="primary"
                    >
                        Ajouter
                    </Button>
                    <Button
                        variant="contained"
                        className="mr-2"
                        color="primary"
                        style={{ background: "#444" }}
                        onClick={() => {
                            window.location.href = "/admin/dashboard";
                        }}
                    >
                        Annuler
                    </Button>
                </Grid>
            </div>
        );
    }
}

FactureForm.propTypes = {
    types: PropTypes.array,
};
FactureForm.defaultProps = {
    types: [],
};

const mapDispatchToProps = {
    getBillAction,
    getClientsAction
};

function mapStateToProps(state) {
    return {
        routes: state.adminRes.routes,
        userPer: state.adminRes.uerPer,
        token: state.login.token,
        clients: state.clients.clients
    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: "CustomToolbar",
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(FactureForm);
