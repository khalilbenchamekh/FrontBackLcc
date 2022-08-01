import React from "react";

import {connect} from "react-redux";

import 'react-toastify/dist/ReactToastify.min.css'
import {toast} from 'react-toastify';


import PropTypes from 'prop-types';
import {withStyles} from "@material-ui/core";
import {compose} from "recompose";
import Tooltip from "@material-ui/core/Tooltip";
import 'react-confirm-alert/src/react-confirm-alert.css';

import Checkbox from "@material-ui/core/Checkbox";
import FormControlLabel from "@material-ui/core/FormControlLabel";
import {setUsersWithPermissionsAction} from "../../../actions/adminActions";
import {getCookie} from "../../../utils/cookies";

const defaultToolbarStyles = {
    iconButton: {},
};

class UpdateBusinessNatures extends React.Component {
    static propTypes = {
        // businessNatures: PropTypes.string.isRequired,
        user: PropTypes.object.isRequired,
        id: PropTypes.number.isRequired,
    };

    constructor(props) {
        super(props);
        this.state = {
            create:false,
            delete:false,
            read:false,
            edit:false,
        };

    }
    componentDidMount() {
        if(this.props.user){
            let user =this.props.user;
            this.setState({
                create:user.create,
                delete:user.delete,
                read:user.read,
                edit:user.edit,
            });
        }
    }

    handleChange = (event) => {
         this.setState({
             [event.currentTarget.name]: event.target.checked
         });
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            let route_name =this.props.route_name;
            let user =this.props.user;
            let action =event.currentTarget.name;
            if(route_name && action){
                if(user){
                    let id =user.id;
                    this.props.setUsersWithPermissionsAction(token,route_name,action,id,event.target.checked);
                }
            }
        }
    };
    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.error) {
            toast.error(nextProps.error)
        }
    }

    render() {

        const {classes, user} = this.props;

        return (
            <React.Fragment>
                <Tooltip title={"delete"}>
                    <FormControlLabel
                        control={
                            <Checkbox
                                checked={this.state.delete}
                                name="delete"
                                color="primary"
                            onChange={this.handleChange}
                            />
                        }
                        label="delete"
                    />
                </Tooltip>
                <Tooltip title={"edit"}>
                    <FormControlLabel
                        control={
                            <Checkbox
                                checked={this.state.edit}
                                name="edit"
                                color="primary"
                            onChange={this.handleChange}
                            />
                        }
                        label="edit"
                    />
                </Tooltip> <Tooltip title={"create"}>
                <FormControlLabel
                    control={
                        <Checkbox
                            checked={this.state.create}
                            name="create"
                            color="primary"
                            onChange={this.handleChange}
                        />
                    }
                    label="create"
                />
            </Tooltip> <Tooltip title={"read"}>
                <FormControlLabel
                    control={
                        <Checkbox
                            checked={this.state.read}
                            name="read"
                            color="primary"
                            onChange={this.handleChange}
                        />
                    }
                    label="read"
                />
            </Tooltip>

            </React.Fragment>

        );
    }

}

const mapDispatchToProps = {
    setUsersWithPermissionsAction

};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        route_name: state.adminRes.route_name,
        userPer: state.adminRes.uerPer,

    };
}

export default compose(
    withStyles(defaultToolbarStyles, {
        name: 'UpdateBusinessNatures',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(UpdateBusinessNatures);
