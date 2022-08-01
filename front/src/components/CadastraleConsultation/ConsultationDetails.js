import { withStyles, DialogTitle, DialogContent } from "@material-ui/core";
import 'react-confirm-alert/src/react-confirm-alert.css';
import 'react-toastify/dist/ReactToastify.min.css';
import Dialog from "@material-ui/core/Dialog";
import IconButton from "@material-ui/core/IconButton";
import Tooltip from "@material-ui/core/Tooltip";
import { AttachFile } from "@material-ui/icons";
import AttachFileIcon from '@material-ui/icons/AttachFile';
import PropTypes from 'prop-types';
import React from "react";
import { compose } from "recompose";

const defaultToolbarStyles = {
  root: {
    width: 500,
    minHeight: 250,
    overflowY: 'auto',
  },
  list: {
    listStyle: "none",
    paddingLeft: 0,
  }
};

class ConsultationDetails extends React.Component {
  static propTypes = {
    files: PropTypes.array.isRequired,
  };
  constructor() {
    super();
    this.state = {
      open: false
    }
  }
  handleClick = () => {

    this.setState({
      open: !this.state.open
    });

  };
  render() {
    const { classes, files } = this.props;
    const { open } = this.state;
    return (
      <>
        <Dialog open={open} onClose={() => console.log("hello")} aria-labelledby="form-dialog-title-update">
          <DialogTitle className={classes.title} id="form-dialog-title">
            Pièces jointes
          </DialogTitle>
          <DialogContent className={classes.root} >
            <ul className={classes.list}>
              {
                files && files.map((file, index) => (
                  <li key={index}><a target="_blanc" href={file.link}><AttachFile />{file.content}</a></li>
                ))
              }
            </ul>
          </DialogContent>
        </Dialog>
        <Tooltip title={files && files.length > 0 ? "Pièces joints" : "Aucun pièces joints"}>
          <IconButton className={classes.iconButton} onClick={files && files.length > 0 ? this.handleClick : () => { }}>
            <AttachFileIcon color={files && files.length > 0 ? "primary" : "disabled"} />
          </IconButton>
        </Tooltip>
      </>
    );
  }

}

export default compose(
  withStyles(defaultToolbarStyles, {
    name: 'ConsultationDetails',
  })
)(ConsultationDetails);
//export default connect(mapStateToProps, mapDispatchToProps)(ConsultationDetails);
