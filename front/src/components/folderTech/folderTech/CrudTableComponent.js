import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import CustomToolbar from "./CustomToolbar";

import UpdateFolderTech from "./UpdateFolderTech";
import { createMuiTheme, MuiThemeProvider } from "@material-ui/core";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";

const defaultCrudComponent = {
  table: {
    padding: 10
  }
};
class CrudTableComponent extends Component {
  render() {
    const columns = [
      {
        name: "REF",
        label: "Réference"
      },
      {
        name: "PTE_KNOWN",
        label: "PTE_KNOWN"
      },
      {
        name: "TIT_REQ",
        label: "TIT_REQ"
      },
      {
        name: "Endroit",
        label: "Endroit"
      },
      {
        name: "Date d'entrée",
        label: "Date d'entrée"
      },
      {
        name: "DATE_LAI",
        label: "DATE LAI"
      },
      {
        name: "Unité",
        label: "Unité"
      },
      {
        name: "Prix",
        label: "Prix"
      },
      {
        name: "Inter_id",
        label: "Inter_id"
      },
      {
        name: "fold_tech_sit_id",
        label: "Situation"
      },
      {
        name: "Id Client",
        label: "Id Client"
      },
      {
        name: "Id Résponsable",
        label: "Id Résponsable"
      },
      {
        name: "nom de la nature",
        label: "nom de la nature"
      },
      {
        name: "Actions",
        options: {
          filter: false,
          sort: false,
          empty: true,
          customBodyRender: (value, tableMeta, updateValue) => {
            return (
              <UpdateFolderTech
                index={folderTech[tableMeta.rowIndex]}
                id={tableMeta.rowIndex}
              />
            );
          }
        }
      }
    ];

    const options = {
      filterType: "dropdown",

      responsive: "stacked",

      customToolbar: () => <CustomToolbar />
    };
    const { folderTech, classes } = this.props;
    const theme = createMuiTheme({
      palette: { type: "light" }
    });
    return (
      <div className="">
        <div className="">
          {folderTech && (
            <MuiThemeProvider theme={theme}>
              <MUIDataTable
                className={classes.table}
                title={"Dossiers Techniques"}
                data={folderTech}
                columns={columns}
                options={options}
              />
            </MuiThemeProvider>
          )}
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = {};

function mapStateToProps(state) {
  return {
    folderTech: state.folderTech.folderTech
  };
}
export default compose(
  withStyles(defaultCrudComponent, {
    name: "CustomCrudTable"
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(CrudTableComponent);
