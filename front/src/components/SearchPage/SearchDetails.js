import React, { Component } from "react";
import { withStyles } from "@material-ui/core/styles";
import { connect } from "react-redux";
import { compose } from "recompose";
import { TextField } from "@material-ui/core";
import ArrowBackIosIcon from '@material-ui/icons/ArrowBackIos';

import { findResultDetails } from "../../actions/searchActions";
import { NavLink } from "react-router-dom";

const styles = theme => ({
  root: {
    backgroundColor: theme.palette.background.default,
    borderRadius: 10,
    marginTop: 10
  },
  inputList: {
    padding: "0 20px 25px 20px",
  },
  backIcon: {
    padding: "0 10px 0 0",
  }
});

class SearchDetails extends Component {

    componentWillReceiveProps(nextProps, nextContext) {
/* ----------------------------- lappel tt dar 9bl --------------*/
      if(nextProps.match){
          if(nextProps.match.params){
              const { token,results } = nextProps;
              const { findResultDetails } = this.props;
              const { id, entity } = this.props.match.params;
              if(results && results.length > 0){
                  let key = results[id];
                  if(key){
                      key=key.id;
                      if(key){
                          findResultDetails(token, { id :id , entity: this.getEntity(entity) });
                      }
                  }
              }
          }
      }
}

    renderFolderTechInputs = (folder) => {
    const { classes } = this.props;
    return (
      <>
        <TextField
          defaultValue={folder && folder.PTE_KNOWN}
          className={classes.inputField}
          label="PTE_UNKNOWN"
          fullWidth
          disabled
        />
        <TextField
          defaultValue={folder && folder.TIT_REQ}
          disabled
          label="TIT_REQ"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.place}
          disabled
          label="place"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.DATE_ENTRY}
          disabled
          label="DATE_ENTRY"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.DATE_LAI}
          disabled
          label="DATE_LAI"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.UNITE}
          disabled
          label="UNITE"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.PRICE}
          disabled
          label="PRICE"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.Inter_id}

          disabled
          label="Inter_id"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.fold_tech_sit_id}

          disabled
          label="fold_tech_sit_id"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.client_id}

          disabled
          label="client_id"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.resp_id}

          disabled
          label="resp_id"
          fullWidth
        />
        <TextField
          defaultValue={folder && folder.nature_name}

          disabled
          label="nature_name"
          fullWidth
        />
        <div className="files">
        </div>
      </>
    )
  }

  renderBusinessInputs = (business) => {
    const { classes } = this.props;
    return (
      <>
        <TextField
          defaultValue={business && business.PTE_KNOWN}
          className={classes.inputField}
          disabled
          label="PTE_KNOWN"
          fullWidth
        />
        <TextField
          defaultValue={business && business.TIT_REQ}
          disabled
          label="TIT_REQ"
          fullWidth
        />
        <TextField
          defaultValue={business && business.place}
          disabled
          label="place"
          fullWidth
        />
        <TextField
          defaultValue={business && business.DATE_ENTRY}
          disabled
          label="DATE_ENTRY"
          fullWidth
        />
        <TextField
          defaultValue={business && business.DATE_LAI}
          disabled
          label="DATE_LAI"
          fullWidth
        />
        <TextField
          defaultValue={business && business.UNITE}
          disabled
          label="UNITE"
          fullWidth
        />
        <TextField
          defaultValue={business && business.PRICE}
          disabled
          label="PRICE"
          fullWidth
        />
        <TextField
          defaultValue={business && business.Inter_id}
          disabled
          label="Inter_id"
          fullWidth
        />
        <TextField
          defaultValue={business && business.aff_sit_id}
          disabled
          label="aff_sit_id"
          fullWidth
        />
        <TextField
          defaultValue={business && business.client_id}
          disabled
          label="client_id"
          fullWidth
        />
        <TextField
          defaultValue={business && business.resp_id}
          disabled
          label="resp_id"
          fullWidth
        />
        <TextField
          defaultValue={business && business.nature_name}
          disabled
          label="nature_name"
          fullWidth
        />
        <div className="files">
        </div>
      </>
    )
  }

  renderGreatConstructions = (grConstr) => {
    const { classes } = this.props;
    return (
      <>
        <TextField
          defaultValue={grConstr && grConstr.Market_title}
          className={classes.inputField}
          disabled
          label="Titre du marché"
          fullWidth
        />

        <TextField
          defaultValue={grConstr && grConstr.advanced}
          className={classes.inputField}
          disabled
          label="avances"
          fullWidth
        />

        <TextField
          defaultValue={grConstr && grConstr.price}
          className={classes.inputField}
          disabled
          label="Prix"
          fullWidth
        />

        <TextField
          defaultValue={grConstr && grConstr.multiLocation}
          className={classes.inputField}
          disabled
          label="Emplacement"
          fullWidth
        />

        <TextField
          defaultValue={grConstr && grConstr.multiValue}
          className={classes.inputField}
          disabled
          label="Dirigé parà"
          fullWidth
        />

        <TextField
          defaultValue={grConstr && grConstr.process_enumValue}
          className={classes.inputField}
          disabled
          label="Etat d'avancement"
          fullWidth
        />

        <TextField
          defaultValue={grConstr && grConstr.multiLocatedBrigades}
          className={classes.inputField}
          disabled
          label=""
          fullWidth
        />
        <TextField
          defaultValue={grConstr && grConstr.Execution_phase}
          className={classes.inputField}
          label="Phase d'exécution"
          disabled
          fullWidth
        />
        <TextField
          defaultValue={grConstr && grConstr.observation}
          className={classes.inputField}
          label="observation"
          disabled
          fullWidth
        />
      </>
    )
  }
  renderLoadInputs = (load) => {
    const { classes } = this.props;
    return (
      <>
        <TextField
          defaultValue={load && load.REF}
          disabled
          label="REF"
          fullWidth
        />
        <TextField
          defaultValue={load && load.amount}
          disabled
          label="Montant"
          fullWidth
        />
        <TextField
          defaultValue={load && load.TVA}
          disabled
          label="TVA"
          fullWidth
        />
        <TextField
          defaultValue={load && load.DATE_LOAD}
          disabled
          label="Date de facturation"
          fullWidth
        />
        <TextField
          defaultValue={load && load.multiValue}
          disabled
          label="Charge liée à"
          fullWidth
        />
        <TextField
          defaultValue={load && load.multiLoad}
          disabled
          label="Type de charge"
          fullWidth
        />
      </>
    )
  }
  getEntity = (entity) => {
    switch (entity) {
      case "0":
        return "dossiers Techniques";
      case "1":
        return "Affaires";
      case "2":
        return "Grand Chantiers";
      case "3":
        return "Charges";
      default:
        return "--- ---";
    }
  }
  renderInputs = (entity, details) => {
    switch (entity) {
      case "0":
        return this.renderFolderTechInputs(details);
      case "1":
        return this.renderBusinessInputs(details);
      case "2":
        return this.renderGreatConstructions(details);
      case "3":
        return this.renderLoadInputs(details);
      default:
        return <>Eentité Inconnue</>;
    }
  }
  render() {
    const { classes, details } = this.props;
    const { id, entity } = this.props.match.params;
    return (
      <div className={classes.root}>
        <h5 className="pt-3 pl-3 pb-3 border-bottom">
          <NavLink to="/search">
            <span className={classes.backIcon}>
              <ArrowBackIosIcon />
            </span>
          </NavLink>
          <span className="mx-auto">Affichage des detailles pour l'enitité
          <span className="font-weight-bold text-info text-uppercase"> {this.getEntity(entity)} </span>
           avec la réference: <span className="font-weight-bold font-italic text-primary">{id}</span>
          </span>
        </h5>
        <div className={classes.inputList}>
          {
            this.renderInputs(entity, details)
          }
        </div>
      </div>
    );
  }
}
function mapStateToProps(state) {
  return {
    details: state.search.details,
      results: state.search.results,
    token: state.login.token,
  };
}

const mapDispatchToProps = {
  findResultDetails
}
export default compose(
  withStyles(styles),
  connect(mapStateToProps, mapDispatchToProps),
)(SearchDetails);

