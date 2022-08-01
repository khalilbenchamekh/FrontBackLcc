import React, { Component } from 'react';
import { withStyles } from '@material-ui/styles';

const styles = {
    sep: {
        margin: "0 6%",
        borderBottom: "solid thin #33333333"
    }
};

const Separator = ({ classes }) => {
    return (
        <div className={classes.sep} />
    )
}

export default withStyles(styles)(Separator);