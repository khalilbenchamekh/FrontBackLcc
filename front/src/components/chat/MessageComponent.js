import React, {Component} from 'react';
import {connect} from "react-redux";
import moment from "moment";

class MessageComponent extends Component {
    render() {
        const {
            message,isMe,nom,ago
        } = this.props;

        return (
            <div className="row">
                <div className={isMe ? 'col  col-md-10 offset-md-2 text-right' : 'col  col-md-10'}>
                    <p><strong><br/>
                        {nom}
                    </strong>{ago}<br/>
                        {message.content}
                    </p>

                </div>

            </div>
    )
    }
    }


    const mapDispatchToProps = {
    };
function mapStateToProps(state,props) {

        return {
            token: state.login.token,
            isMe:props.message.from_id===props.user || false,
            nom:this.isMe ? 'Moi' : props.message.from ? props.message.from.name : 'Moi' ,
            ago: moment(props.message.created_at).fromNow(),
    };
    };
 export default connect(mapStateToProps, mapDispatchToProps)(MessageComponent);




