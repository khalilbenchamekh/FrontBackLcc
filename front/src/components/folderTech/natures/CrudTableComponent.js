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
      "Nom",
      {
        name: "Name",
        label: "Nom"
      }, {
        name: "Abr_v",
        label: "Abbreviation"
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
                index={folderTechNatures[tableMeta.rowIndex]}
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
    const { folderTechNatures } = this.props;

    return (
      <div className="row">
        <div className="col col-12 ">
          {folderTechNatures && (
            <MUIDataTable
              title={"Nature des dossiers Techniques"}
              data={folderTechNatures}
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
    folderTechNatures: state.folderTechNatures.folderTechNatures
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
