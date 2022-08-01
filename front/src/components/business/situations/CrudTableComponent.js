import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import CustomToolbar from "./CustomToolbar";
import {
  getBusinessNaturesAction,
  updateBusinessNaturesAction
} from "../../../actions/businessActions";
import IconButton from "@material-ui/core/IconButton";
import EditIcon from "@material-ui/icons/EditOutlined";
import DoneIcon from "@material-ui/icons/DoneAllTwoTone";
import RevertIcon from "@material-ui/icons/NotInterestedOutlined";
import UpdateBusinessSituations from "./UpdateBusinessSituations";

class CrudTableComponent extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: undefined
    };
  }

  render() {
    const columns = [
      {
        name: "Name",
        label: "Nom"
      },
     {
        name: "orderChr",
        label: "orderChr"
      },
      {
        name: "Actions",
        options: {
          filter: false,
          sort: false,
          empty: true,
          customBodyRender: (value, tableMeta, updateValue) => {
            return (
              <UpdateBusinessSituations
                index={businessSituations[tableMeta.rowIndex]}
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
    const { businessSituations } = this.props;

    return (
      <div className="row">
        <div className="col col-12 ">
          {businessSituations && (
            <MUIDataTable
              title={"title"}
              data={businessSituations}
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
  getBusinessNaturesAction,
  updateBusinessNaturesAction
};

function mapStateToProps(state) {
  return {
    businessSituations: state.businessSituations.businessSituations
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(CrudTableComponent);
