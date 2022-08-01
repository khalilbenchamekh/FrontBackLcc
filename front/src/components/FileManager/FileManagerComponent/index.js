import React from 'react';
import FileManager, { Permissions } from 'devextreme-react/file-manager';
import RemoteFileProvider from 'devextreme/ui/file_manager/file_provider/remote';
import { Popup } from 'devextreme-react/popup';
import {connect} from "react-redux";

const remoteFileProvider = new RemoteFileProvider({
    endpointUrl: 'https://js.devexpress.com/Demos/Mvc/api/file-manager-file-system-images'
});

class FileManagerComponent extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            currentPath: 'Widescreen',
            popupVisible: false,
            imageItemToDisplay: {}
        };

        this.displayImagePopup = this.displayImagePopup.bind(this);
        this.hideImagePopup = this.hideImagePopup.bind(this);
        this.directoryChanged = this.directoryChanged.bind(this);
    }
    componentDidMount() {
        alert("eeeee");

    }

    displayImagePopup(e) {
        this.setState({
            popupVisible: true,
            imageItemToDisplay: {
                name: e.fileItem.name,
                url: e.fileItem.dataItem.url
            }
        });
    }

    hideImagePopup() {
        this.setState({
            popupVisible: false
        });
    }

    directoryChanged(e) {
        this.setState({
            currentPath: e.component.option('currentPath')
        });
    }

    render() {
        return (
            <div>
                <FileManager
                    currentPath={this.state.currentPath}
                    fileProvider={remoteFileProvider}
                    onSelectedFileOpened={this.displayImagePopup}
                    onCurrentDirectoryChanged={this.directoryChanged}>
                    <Permissions
                        create={true}
                        copy={true}
                        move={true}
                        remove={true}
                        rename={true}
                        upload={true}
                        download={true}>
                    </Permissions>
                </FileManager>

                <Popup
                    maxHeight={600}
                    closeOnOutsideClick={true}
                    title={this.state.imageItemToDisplay.name}
                    visible={this.state.popupVisible}
                    onHiding={this.hideImagePopup}
                    className="photo-popup-content">

                    <img src={this.state.imageItemToDisplay.url} className="photo-popup-image"  alt="/"/>
                </Popup>
            </div>
        );
    }
}
const mapDispatchToProps = {

};
function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(FileManagerComponent);

