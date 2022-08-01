import React, {Component, useState} from 'react';
import PropTypes from 'prop-types';
import {withStyles} from '@material-ui/styles';
import {TextArea} from 'devextreme-react';
import {Send} from '@material-ui/icons';
import AttachFileIcon from '@material-ui/icons/AttachFile';
import {getCookie, getUser} from "../../utils/cookies";
import {connect} from "react-redux";
import {compose} from 'recompose';
import {
    loadMessagesAction,
    loadPreviousMessagesAction,
    sendMessageAction
} from "../../actions/messagerie/messagerieActions";
import * as selectors from "../../selectors/messagerie";
import {getIdFromRoute} from "../../utils/messagerie/helperMessagerie";
import Button from "@material-ui/core/Button";
import {DropzoneDialog} from "material-ui-dropzone";

const styles = {
    root: {
        display: "flex",
        flexDirection: "row",
        justifyContent: "center",
        padding: "4px 5px",
        flexGrow: 1,
    },
    send: {
        justifyContent: "center",
        flexBasis: "8%",
        alignSelf: "center",
        cursor: "pointer",
        display: "flex",
    },
    message: {
        flexGrow: 1,
        paddingLeft: 10,
        resize: "none"
    },
    sendButton: {
        "&:hover": {
            backgroundColor: "#007bff",
        }, "&:active": {
            border: "solid thin #ffffff",
        },
        border: "solid thin #007bff66",
        padding: "8px",
        paddingLeft: "10px",
        borderRadius: "100px",
        backgroundColor: "#007bffaa",
        color: "white",
    }
};

class NewMessage extends Component {
    constructor(props) {
        super(props);
        this.state = {
            content: '',
            files: [],
            openDropZone: false,
            errors: {}, loading: false,
        };
        this.sendAction = this.sendAction.bind(this);

    }

    handleSave(files) {
        this.setState({
            files: files,
            openDropZone: false
        });
    }

    handleOpen() {
        this.setState({
            openDropZone: true,
        });
    }

    handleClose() {
        this.setState({
            openDropZone: false
        });
    }


    sendAction() {
        try {
            const {id} = this.props;
            const {content, files} = this.state;

            let token = this.props.token === '' ? getCookie('token') : this.props.token;
            if (token && (content !== '' || files)) {
                if (id) {
                    let formdata = new FormData();
                    if (files) {
                        files.forEach(file => {
                            formdata.append('filenames[]', file);
                        });
                    }
                    formdata.append('content', content);
                    this.props.sendMessageAction(token, formdata, id)
                }
            }
            this.setState({
                content: ''
            });

        } catch (e) {
            if (e.errors) {
                this.setState({
                    errors: e.errors
                });

            } else {
                console.error(e)
            }
        }

    }

    render() {
        const {
            classes,
        } = this.props;
        const {
            content, files
        } = this.state;
        let disabled = content !== '' || files.length;
        return (

            <div className={classes.root}>
<textarea
    value={content} onChange={e => this.setState({
    content: e.target.value
})
}
    className={classes.message}
    autoCapitalize
>
</textarea>
                <Button
                    disabled={!disabled}
                    className={classes.send}
                    onClick={() => this.sendAction()}>
                    <span

                        className={classes.sendButton}><Send/></span>

                </Button>
                <div className={classes.send}>
                    <div>
                        <span onClick={this.handleOpen.bind(this)}
                              className={classes.sendButton}><AttachFileIcon/></span>

                        <DropzoneDialog
                            open={this.state.openDropZone}
                            onSave={this.handleSave.bind(this)}
                            showPreviews={true}
                            maxFileSize={5000000}
                            onClose={this.handleClose.bind(this)}
                        />
                    </div>
                </div>
            </div>
        )
    }

}

const mapDispatchToProps = {
    sendMessageAction,
};

function mapStateToProps(state, ownProps) {
    const id = ownProps.id;
    const messages = id ? selectors.messages(state, id) : undefined;
    const count = id ? selectors.conversation(state, id).count : 0;
    const name = id ? selectors.conversation(state, id).name : "";
    return {
        token: state.login.token,
        messages: messages,
        count: count,
        name: name,
        conversations: state.conversations.conversations,
        LastMessages: this.messages && this.messages[this.messages.length - 1],
        id: getIdFromRoute(id, state.conversations.conversations),

    };
}

export default compose(
    withStyles(styles, {
        name: "messengerStyle"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(NewMessage);

