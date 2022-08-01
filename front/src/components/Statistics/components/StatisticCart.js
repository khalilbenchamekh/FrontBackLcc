import React, { Component } from "react";
import Radio from '@material-ui/core/Radio';
import RadioGroup from '@material-ui/core/RadioGroup';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import FormControl from '@material-ui/core/FormControl';
import FormLabel from '@material-ui/core/FormLabel';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import { Button, MenuItem } from "@material-ui/core";
import { NavLink, Link } from "react-router-dom";
const styles = {
    root: {
        display: 'flex',
        flexFlow: "column",
        backgroundColor: "#ffffff",
        padding: "5px",
        width: "250px",
        height: "150px",
        margin: "10px 10px",
        borderRadius: "10px",
        cursor: "pointer",
        textDecoration: "none",
        color: "#444",
        "&:focus, &:hover, &:visited, &:link, &:active": {
            color: "#444"
        }
    },
    name: {
        alignSelf: "center",
        flexGrow: "1",
        display: "flex",
        alignItems: "center",
        fontSize: "1.7em",
        fontWeight: "500",
    },
    count: {
        alignSelf: "flex-end",
        fontSize: "1.7em",
        fontWeight: "400",
        margin: "0 13px 10px 0"
    },
};
class StatisticCart extends Component {

    render() {
        const { name, count, to, onClick, classes } = this.props;
        return (
            <MenuItem component={Link} to={to}>
                <div className={classes.root} onClick={onClick}>
                    <div className={classes.name}>
                        {name}
                    </div>
                    <div className={classes.count}>
                        {count}
                    </div>
                </div>
            </MenuItem>
        );
    }
}

StatisticCart.defaultProps = {
    name: "Titre",
    count: "*",
    to: "#",
    onClick: () => { },
}
function mapStateToProps(state) {
    return {
        statistics: state.locations.adr,
    };
}
export default compose(
    withStyles(styles),
    connect(mapStateToProps, null),
)(StatisticCart);

