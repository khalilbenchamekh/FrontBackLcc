import React from "react";
import PropTypes from "prop-types";
import homeShortcuts from "./homeShortcuts.json";
import Shortcut from "./Shortcut";
import { Grid, Paper } from "@material-ui/core";
import DateRangePicker from "../Shared/DateRangePicker";
import moment from "moment";

import { getCookie } from "../../utils/cookies";
import SearchPage from "../SearchPage/SearchPage";

class HomeAdmin extends React.Component {
  constructor() {
    super();
    this.state = {
      table: ""
    };
  }

  handleChangeEntity = (entity) => {
    this.setState({ table: entity });
  };

  handleSearch = () => {
    const { date } = this.props;
    const { table } = this.state;
    if (table !== "") {
      let token = this.props.token === "" ? getCookie("token") : this.props.token;
      if (token) {
        let secondIso = moment(date.secondIso);
        secondIso = secondIso.utc().format('YYYY/MM/DD');
        let firstIso = moment(date.firstIso);
        firstIso = firstIso.utc().format('YYYY/MM/DD');
        let search = {
          table: table,
          to: secondIso || firstIso,
          from: firstIso
        };
        this.props.findResult(token, search);
      }
    }
  }

  render() {
    const { data } = homeShortcuts;
    return (
      <>
        <Grid container spacing={3}>
          {data.map((item, index) => (
            <Shortcut {...item} />
          ))}
        </Grid>
        <div className="my-3">
          <SearchPage />
        </div>
      </>
    );
  }
}

HomeAdmin.propTypes = {};
HomeAdmin.defaultValues = {};
export default HomeAdmin;
