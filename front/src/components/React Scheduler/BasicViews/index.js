import React from 'react';

import Scheduler  from 'devextreme-react/scheduler';
import {connect} from "react-redux";

import {
    addMissionsAction,
    deleteMissionsAction,
    getMissionsAction,
    updateMissionsAction
} from "../../../actions/missionsActions";
import {getCookie} from "../../../utils/cookies";

const currentDate = new Date();
const views = [  'month'];

class BasicViews extends React.Component {
    constructor(props) {
        super(props);

        this.onAppointmentUpdated = this.onAppointmentUpdated.bind(this);
        this.onAppointmentAdding = this.onAppointmentAdding.bind(this);
        this.onAppointmentDeleted = this.onAppointmentDeleted.bind(this);
    }
    onAppointmentAdding(appointmentData) {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            let obj =appointmentData.appointmentData;
            console.log(obj);
            if(obj){
                this.props.addMissionsAction(token,obj);
            }
        }
    } onAppointmentDeleted(appointmentData) {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            let obj =appointmentData.appointmentData;
            if(obj){
                this.props.deleteMissionsAction(token,obj);
            }
        }
    }
    onAppointmentUpdated(appointmentData) {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            let obj =appointmentData.appointmentData;
            if(obj){
                this.props.updateMissionsAction(token,obj,obj.id);
            }
        }
    }
    componentDidMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            this.props.getMissionsAction(token);
        }
    }

    render() {
        const{
            data
        }=this.props;
        return (
            <Scheduler
                dataSource={data}
                views={views}
                defaultCurrentView="month"
                defaultCurrentDate={currentDate}
                height={600}
                onAppointmentAdding ={
                    this.onAppointmentAdding
                }
                onAppointmentUpdated ={
                    this.onAppointmentUpdated
                } onAppointmentDeleted ={
                    this.onAppointmentDeleted
                }
                allowDeleting={true}
                startDayHour={9} >
            </Scheduler>
        );
    }
}

const mapDispatchToProps = {
    getMissionsAction,updateMissionsAction,deleteMissionsAction,
    addMissionsAction
};
function mapStateToProps(state) {
    return {
        token: state.login.token,
        data: state.missions.missions,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(BasicViews);
