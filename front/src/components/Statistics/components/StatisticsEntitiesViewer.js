import React, { Component } from "react";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import DeleteForeverIcon from '@material-ui/icons/DeleteForever';
import UpdateFolderTech from "../../folderTech/folderTech/UpdateFolderTech";
import UpdateBusinessNatures from "../../business/business/UpdateBusinessNatures";
import UpdateGreatConstructions from "../../GreatConstructionSites/UpdateGreatConstructions";
const styles = {
    root: {
        position: 'relative',
        display: 'flex',
        flexDirection: "column",
        width: '20vw',
        height: '100%',
        border: "solid #ffffff thin",
        height: "80vh",
        borderRadius: "6px",
        margin: "10px",
        backgroundColor: "#ffffff",
    },
    header: {
        backgroundColor: "#ffffff",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        height: "50px",
        fontSize: "1.3em",
        fontWeight: "500",
        color: "#444",
    },
    list: {
        position: 'relative',
        display: 'flex',
        flexDirection: "column",
        overflowY: "auto",
        flexGrow: 1,
        overflowX: "hidden",
        marginTop: 15,
    },
    listItem: {
        border: "solid #00000033 0.8px",
        borderRadius: "4px",
        height: "50px",
        backgroundColor: "#00000022",
        display: "flex",
        alignItems: "center",
        fontSize: "1.3em",
        fontWeight: "400",
        cursor: "pointer",
        padding: "0 5px",
        margin: "1px 5px"
    },
    itemText: {
        flexGrow: 1,
    },
    itemControls: {
        flexBasis: "97px",
    }
};
class StatisticsEntitiesViewer extends Component {

    render() {
        const { title, list } = this.props
        return (
            <div style={styles.root}>
                <div style={styles.header}>
                    {title} ({list.length})
                </div>
                <div style={styles.list}>
                    {
                        list.map((item) => (
                            <div style={styles.listItem}>
                                <span style={styles.itemText}>{item.REF}</span>
                                <div style={styles.itemControls}>
                                    {title == "Dossiers techniques" && (<UpdateFolderTech {...item} />)}
                                    {title == "Affaires" && (<UpdateBusinessNatures {...item} />)}
                                    {title == "Grande Chantier" && (<UpdateGreatConstructions {...item} />)}
                                </div>
                            </div>
                        ))
                    }

                </div>
            </div>
        );
    }
}

StatisticsEntitiesViewer.defaultProps = {
    title: "Title",
    list: [],
}
function mapStateToProps(state) {
    return {
        statistics: { ...state.statistics }
    };
}
export default compose(
    withStyles(styles),
    connect(mapStateToProps, null),
)(StatisticsEntitiesViewer);

