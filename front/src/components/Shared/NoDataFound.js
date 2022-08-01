import React from "react";
import { withStyles } from "@material-ui/styles";
const style = {
    root: {
        height: "12vh !important",
        width: "12vw !important",
        background: "#96043E55",
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        borderRadius: 6,
        marginTop: "8vh",
        border: "solid #ffffff66 thin",
        color: "#ffffff",
        fontWeight: "400"

    },
    message: {
        textAlign: "center"
    }
}
const NoDataFound = ({ classes }) => {
    return (
        <div className={classes.root}>
            <div className={classes.message}>0 résultat trouvé</div>
        </div>
    );
}
NoDataFound.propTypes = {};
NoDataFound.defaultValues = {};


export default withStyles(style)(NoDataFound);
