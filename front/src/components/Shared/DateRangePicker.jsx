import React, { Component } from "react";
import DayPickerRangeControllerWrapper from "./DayPickerRangeControllerWrapper";
import { connect } from "react-redux";
import {
  InputLabel,
  FormControl,
  MenuItem,
  Select,
  makeStyles,
  Button,
  Menu,
} from "@material-ui/core";
import { compose } from "redux";
import { withStyles } from "@material-ui/styles";
import { Business, FolderTech, Load, Sites } from "../../Constansts/search";

const defaultToolbarStyles = {
  root: {
    border: "solid #ffffff66 thin",
    borderRadius: 6,
    display: "flex",
    position: "relative",
    width: "100%",
    padding: "0 9px 0px 0px",
    marginBottom: "15px",
    background: "#ffffff",
  },
  formControl: {
    margin: 10,
    minWidth: "18vw",
    background: "#ffffff",
    color: "white !important",
  },
  selectEmpty: {
    marginTop: 10,
  },
  datPicker: {
    position: "absolute",
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
  searchButton: {
    margin: "10px 0 10px auto",
    background: "#008489",
    color: "#ffffff",
    "&:hover": {
      background: "#C90035dd",
    },
  },
};
class DateRangePicker extends Component {
  constructor() {
    super();
    this.state = {
      showDateRangePicker: false,
      typeDate: null,
      entity: null,
      drpRef: null,
      dateRange: {
        //hada tatzido nta
      },
    };
  }
  handleClick = () => {
    const { showDateRangePicker } = this.state;
    this.setState({ showDateRangePicker: !showDateRangePicker });
  };

  handleDateRangePickerOpen = (event) => {
    this.setState({
      drpRef: event.currentTarget,
      showDateRangePicker: true,
    });
  };

  handleTypeDateChange = (e) => {
    const { onTypeChange } = this.props;
    onTypeChange && onTypeChange(e.target.value);
    this.setState({ typeDate: e.target.value });
  };

  handleEntityChange = (e) => {
    const { onEntityChange } = this.props;
    onEntityChange && onEntityChange(e.target.value);
    this.setState({ entity: e.target.value });
  };

  handleSearchClick = () => {
    const { typeDate, entity, dateRange } = this.state;
    const { onSearch } = this.props;
    onSearch(typeDate, entity, dateRange);
  };

  render() {
    const {
      showDateRangePicker,
      typeDate,
      entity,
      dateRange,
      drpRef,
    } = this.state;

    const { date, classes } = this.props;
    console.log(date);

    return (
      <>
        <div className={classes.root}>
          <FormControl className={classes.formControl}>
            <InputLabel id="demo-simple-select-label text-light">
              Type
            </InputLabel>
            <Select
              labelId="demo-simple-select-label"
              id="demo-simple-select"
              name="typeDate"
              value={typeDate}
              onChange={this.handleTypeDateChange}
            >
              <MenuItem value={10}>Année</MenuItem>
              <MenuItem value={20}>Mois</MenuItem>
            </Select>
          </FormControl>
          <FormControl className={classes.formControl}>
            <InputLabel id="demo-simple-select-label">Entité</InputLabel>
            <Select
              labelId="demo-simple-select-label"
              id="demo-simple-select"
              name="entity"
              value={entity}
              onChange={this.handleEntityChange}
            >
              <MenuItem value={2} />
              <MenuItem value={FolderTech}>Dossiers</MenuItem>
              <MenuItem value={Business}>Affaires</MenuItem>
              <MenuItem value={Sites}>Grand Chantiers</MenuItem>
              <MenuItem value={Load}>Charges</MenuItem>
            </Select>
          </FormControl>
          <Button
            type="button"
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
          <Button
            type="button"
            className={classes.searchButton}
            onClick={this.handleSearchClick}
          >
            Chercher
          </Button>
        </div>
        <Menu
          anchorEl={drpRef}
          anchorOrigin={{ vertical: "bottom", horizontal: "left" }}
          keepMounted
          open={showDateRangePicker}
          onClose={this.handleClick}
        >
          <DayPickerRangeControllerWrapper
            className={classes.datPicker}
            show={showDateRangePicker}
          />
        </Menu>
      </>
    );
  }
}

function mapStateToProps(state) {
  return {
    date: state.DatefilterReducer.date,
  };
}

const mapDispatchToProps = {};
export default compose(
  withStyles(defaultToolbarStyles, {
    name: "UpdateBusinessSituations",
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(DateRangePicker);
