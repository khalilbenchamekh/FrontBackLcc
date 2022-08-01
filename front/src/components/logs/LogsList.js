import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";

class LogsList extends Component {

  constructor() {
    super();
    this.state = {
      loadingDates: undefined,
      popupVisibleDate: false
    };

  }


  render() {

    const columns = [
      {
        name: "date",
        label: "Date"
      }, {
        name: "user",
        label: "Utilisateur"
      }, {
        name: "entity",
        label: "Entité"
      }, {
        name: "action",
        label: "Action"
      }
    ];

    const options = {
      filterType: 'dropdown',
      responsive: 'stacked',
    };
    const {
      content
    } = this.props;

    return (

      <div className='row'>
        <div className="col col-12 ">
          <MUIDataTable
            title={"Historique"}
            data={content}
            columns={columns}
            options={options}
          />
        </div>

      </div>
    )
      ;
  }
}

const mapDispatchToProps = {
};


function mapStateToProps(state) {
  return {
    log: state.logs,
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(LogsList);
