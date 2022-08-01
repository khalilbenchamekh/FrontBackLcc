import React, { Component } from "react";
import Radio from '@material-ui/core/Radio';
import RadioGroup from '@material-ui/core/RadioGroup';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import FormControl from '@material-ui/core/FormControl';
import FormLabel from '@material-ui/core/FormLabel';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';
import CloseIcon from '@material-ui/icons/Close';
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import { Button, Menu } from "@material-ui/core";
import { getCookie } from "../../../utils/cookies";
import DayPickerRangeControllerWrapper from "../../Shared/DayPickerRangeControllerWrapper";
import { setRapportSelected, searchStatistics } from "../../../actions/statisticsActions";
const styles = {
  root: {
    position: 'relative',
    display: 'flex',
    flexFlow: "col",
    backgroundColor: "#ffffff",
    padding: "5px",
    width: "fit-content",
    margin: "0 auto 50px auto",
    borderRadius: "10px"
  },
  comboBox: {
    marginLeft: "auto",
    alignSelf: "center",
    marginRight: "60px",
  },
  searchDiv: {
    marginLeft: "auto",
    alignSelf: "center",
    marginRight: "10px",
  },
  searchButton: {
    height: "76px",
    backgroundColor: "#008489",
  },
  space: {
    width: "200px"
  },
  statistics: {
    margin: "10px 15px 10px 10px",
  },
  rangeButton: {
    margin: "10px 0 10px 10px",
    borderBottom: "#008489 solid thin",
    minWidth: "20vw",
    color: "#000000",
    borderRadius: 0,
    "&:hover": {
      background: "#ffffffdd",
    },
  },
  rapportDiv: {
    display: "flex",
    flexDirection: "column",
    alignItems: "center",
    justifyContent: "center",
    flexBasis: "300px"
  },
  rapportHeader: {
    display: "flex",
    flexDirection: "row",
  },
  rapportHeaderTitle: {
    flexGrow: 1
  },
  rapportHeaderClose: {
    cursor: "pointer",
    color: "#dd0000"
  }
};
class StatisticsFilter extends Component {

  constructor() {
    super();
    this.state = {
      entity: "0",
      employee: "",
      client: "",
      date: "",
      drpRef: null,
      showDateRangePicker: false,
      showRapport: false,
      rapport: undefined,
    }
  }
  handleChange = (event) => {
    this.setState({ ...event })
  };

  componentDidMount() {
    const { getClientsSelect, getEmployeesSelect } = this.props;
    getClientsSelect();
    getEmployeesSelect();
  }

  handleClick = () => {
    const { searchStatistics, setRapportSelected } = this.props;
    const { entity, client, employee, rapport } = this.state;
    let token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNTkyNjY4NTAzLCJleHAiOjE1OTMyNzMzMDMsIm5iZiI6MTU5MjY2ODUwMywianRpIjoia3RTaFVBVXlHT2w5dFJJcyIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSIsImlkIjoxLCJlbWFpbCI6ImpvdmVydEBleGFtcGxlLmNvbSIsIm5hbWUiOiJKb3ZlcnQgUGFsb25wb24iLCJyb2xlIjoib3duZXIifQ.RxdbcL1CRNOfi3KV2S7BwcRIUTbjnp2YqhGZvKTWqdU";

    const values = ["Rapport financier", "Rapport Tva", "Rapport Chiffre d'affaire"];
    try {
      const val = values[Number(rapport)];
      console.log(val);
      setRapportSelected(val);
    } catch (e) {
      console.error(e);

    }
    searchStatistics(token, { entity, client, employee, rapport })
  }

  handleDateRangePickerOpen = (event) => {
    this.setState({
      drpRef: event.currentTarget,
      showDateRangePicker: true,
    });
  };

  render() {
    const { entity, client, employee, date, drpRef, showDateRangePicker, showRapport, rapport } = this.state;
    const { clients, employees, classes } = this.props;

    return (
      <div style={styles.root}>

        <div style={styles.statistics}>
          <FormControl component="fieldset">
            <FormLabel component="legend">Statistiques</FormLabel>
            <RadioGroup
              aria-label="gender"
              name="gender1"
              value={entity}
              onChange={(e) => this.handleChange({ entity: e.target.value })}
            >
              <FormControlLabel value="0" control={<Radio />} label="statistiques globales" />
              <FormControlLabel value="1" control={<Radio />} label="statistiques par client" />
              <FormControlLabel value="2" control={<Radio />} label="statistiques par employée" />
            </RadioGroup>
          </FormControl>
        </div>

        {entity === "1" && (<div style={styles.comboBox}>
          <FormControl component="fieldset">
            <FormLabel component="legend">Client</FormLabel>
            <Autocomplete
              id="combo-box-demo"
              options={clients || []}
              getOptionLabel={(option) => option.title}
              style={{ width: 300 }}
              value={client}
              onChange={(e) => this.handleChange({ client: e.target.value })}
              renderInput={(params) => <TextField {...params} variant="outlined" />}
            />
          </FormControl>
        </div>)}
        {entity === "2" && (<div style={styles.comboBox}>
          <FormControl component="fieldset">
            <FormLabel component="legend">Employée</FormLabel>
            <Autocomplete
              id="combo-box-demo"
              options={employees || []}
              getOptionLabel={(option) => option.title}
              style={{ width: 300 }}
              value={employee}
              onChange={(e) => this.handleChange({ employee: e.target.value })}
              renderInput={(params) => <TextField {...params} variant="outlined" />}
            />
          </FormControl>
        </div>)}

        <div style={styles.comboBox}>
          <Button
            className={classes.rangeButton}
            onClick={this.handleDateRangePickerOpen}
            style={
              date.first && date.second
                ? {}
                : { color: "#00000055", marginTop: "20px" }
            }
          >
            <span id="b1-span-Date" className="span-Date">
              {date.first && date.second
                ? date.first + " - " + date.second
                : "Plage de dates"}{" "}
            </span>
          </Button>
        </div>

        <div style={styles.rapportDiv}>
          {!showRapport && (
            <Button
              style={styles.searchButton}
              onClick={() => this.handleChange({ showRapport: true })}
              variant="contained"
              color="primary">
              Ajouter Rapport
            </Button>
          )}
          {showRapport && (
            <FormControl component="fieldset">
              <div style={styles.rapportHeader}>
                <FormLabel component="legend" style={styles.rapportHeaderTitle}>Rapport</FormLabel>
                <CloseIcon
                  color="action"
                  style={styles.rapportHeaderClose}
                  onClick={() => this.handleChange({ showRapport: false, rapport: undefined })}
                />
              </div>
              <RadioGroup
                aria-label="gender"
                name="gender1"
                value={rapport}
                onChange={(e) => this.handleChange({ rapport: e.target.value })}
              >
                <FormControlLabel value="0" control={<Radio />} label="Rapport financier" />
                <FormControlLabel value="1" control={<Radio />} label="Rapport Tva" />
                <FormControlLabel value="2" control={<Radio />} label="Rapport Chiffre d'affaire" />
              </RadioGroup>
            </FormControl>
          )}
        </div>

        {entity === "0" && (<div style={styles.space}></div>)}
        <div style={styles.searchDiv}>
          <Button style={styles.searchButton} onClick={this.handleClick} variant="contained" color="primary">Chercher</Button>
        </div>

        <Menu
          anchorEl={drpRef}
          anchorOrigin={{ vertical: "bottom", horizontal: "left" }}
          keepMounted
          open={showDateRangePicker}
          onClose={() => this.handleChange({ showDateRangePicker: false })}
        >
          <DayPickerRangeControllerWrapper
            className={classes.datPicker}
            show={showDateRangePicker}
          />
        </Menu>
      </div>
    );
  }
}

StatisticsFilter.defaultProps = {
  searchStatistics: () => { },
  getClientsSelect: () => { },
  getEmployeesSelect: () => { },
  setRapportSelected: () => { }
}
function mapStateToProps(state) {
  return {
    statistics: state.locations.adr,
  };
}

const mapDispatchToProps = {
  // khalil : getClientsSelect, getEmployeesSelect
  searchStatistics,
  setRapportSelected,
};

export default compose(
  withStyles(styles),
  connect(mapStateToProps, mapDispatchToProps),
)(StatisticsFilter);

