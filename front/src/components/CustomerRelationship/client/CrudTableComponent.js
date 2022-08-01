import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import CustomToolbar from "./CustomToolbar";

import UpdateBusinessNatures from "./UpdateBusinessNatures";
import {
  getFolderTechNaturesAction,
  updateFolderTechNaturesAction
} from "../../../actions/folderTechActions";

class CrudTableComponent extends Component {
  render() {
    const columns = [
      {
        name: "name",
        label: "Nom"
      }, {
        name: "ICE",
        label: "Nom"
      }, {
        name: "RC",
        label: "Rc"
      }, {
        name: "Cour",
        label: "Cour"
      }, {
        name: "city",
        label: "Ville"
      }, {
        name: "ZIP code",
        label: "Code postal"
      }, {
        name: "Street",
        label: "Rue"
      }, {
        name: "Street2",
        label: "Rue 2"
      }, {
        name: "Country",
        label: "Pays"
      }, {
        name: "tel",
        label: "Téléphone"
      },
      {
        name: "Actions",
        options: {
          filter: false,
          sort: false,
          empty: true,
          customBodyRender: (value, tableMeta, updateValue) => {
            return (
              <UpdateBusinessNatures
                index={clients[tableMeta.rowIndex]}
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
    const { clients } = this.props;

    return (
      <div className="row">
        <div className="col col-12 ">
          {clients && (
            <MUIDataTable
              title={"Clients"}
              data={clients}
              columns={columns}
              options={options}
            />
          )}
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = {
  getFolderTechNaturesAction,
  updateFolderTechNaturesAction
};

function mapStateToProps(state) {
  return {
    clients: state.clients.clients
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
