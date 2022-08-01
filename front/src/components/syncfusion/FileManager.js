import * as React from 'react';
import { Component } from "react";
import './custom-thumbnail.css';
import { enableRipple } from '@syncfusion/ej2-base';
import { FileManagerComponent, Inject, NavigationPane, DetailsView, Toolbar } from '@syncfusion/ej2-react-filemanager';
import { connect } from "react-redux";

import { getCookie } from "../../utils/cookies";
import { fileExplorer, geoMapping } from "../../Env/env";
import { downloadFileAction } from "../../actions/syncfusion/fileManagerActions";


enableRipple(true);

export class index extends Component {

    constructor() {
        super(...arguments);
        this.hostUrl = fileExplorer;
    }

    beforeSend(args) {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            args.path = geoMapping;
            args.ajaxSettings.beforeSend = function (args) {
                if (args.action === 'download') {
                    this.props.downloadFileAction(token, args);
                }
                args.httpRequest.setRequestHeader("Authorization", "Bearer " + token);
                console.log(JSON.stringify(args));
            }
        }
    }

    beforeSendDownload(args) {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            args.cancel = true;
            if (args.data) {
                let data = args.data;
                let action = data.action;
                if (action === 'download') {

                    this.props.downloadFileAction(token, args);
                }
            }
        }
    }

    render() {
        return (<div>
            <div className="control-section">
                <FileManagerComponent id="Thumbnail_filemanager"
                    path="geoMapping"
                    beforeSend={(args) => this.beforeSend(args)}
                    ajaxSettings={{
                        url: this.hostUrl
                    }}
                    beforeDownload={(args) => this.beforeSendDownload(args)}
                    uploadSettings={{
                        allowedExtensions:
                            ".jpeg,.png,.gif,.svg,.doc,.pdf,.docx,.zip,.rar"
                    }}
                    toolbarSettings={{ items: ['NewFolder', 'Upload', 'Delete', 'Cut', 'Copy', 'Rename', 'SortBy', 'Refresh', 'Selection', 'View', 'Details'] }}
                    showThumbnail={false}>
                    <Inject
                        services={[NavigationPane, DetailsView, Toolbar]} />
                </FileManagerComponent>
            </div>
        </div>)
            ;
    }
}

const mapDispatchToProps = {
    downloadFileAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(index);
