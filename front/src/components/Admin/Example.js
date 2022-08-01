import React, {Component} from "react";
import MUIDataTable from "mui-datatables";
import {connect} from "react-redux";
import CustomToolbar from "./CustomToolbar";
class Example extends Component{
    constructor(props){
        super(props);
        this.state = {};
    }
    render(){
        const columns = [
            "column 1",
            "column 2",
            "column 3",
        ];
        const data = [
            ["data", "data", "data"],
            ["data", "data", "data"]
        ];

        const options = {
            filterType: 'dropdown',
            responsive: 'stacked',
            customToolbar:  () => <CustomToolbar/>
        };
        return(
            <MUIDataTable
                title={"title"}
                data={data}
                columns={columns}
                options={options}
            />
        );
    }
}
const mapStateToProps = () => {
    return{};
};
const mapDispatchToProps = {};

export default connect(mapStateToProps, mapDispatchToProps)(Example)
