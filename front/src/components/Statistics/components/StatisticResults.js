import React, { Component } from "react";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import StatisticCart from "./StatisticCart";
import { SegmentInline } from "semantic-ui-react";
import { Grid } from "@material-ui/core";
import { searchSelectedStatistics, setRapportSelected } from "../../../actions/statisticsActions";
import { Redirect, Switch } from 'react-router-dom';

const styles = {
    root: {
        position: 'relative',
        display: 'inline',
        width: '100%',
        height: '100%',
        margin: "30px 0"
    },
    filter: {
        display: "inline",
        width: "fit-content"
    },
};
class StatisticResults extends Component {
    constructor() {
        super();
        this.state = {
            redirect: false
        }
    }
    handleCardClick = (item) => {
        const { setRapportSelected } = this.props;
        console.log(item);

        setRapportSelected(item);
    }
    render() {
        const { content } = this.props;
        console.log(content);

        const to = "statistics/details"
        if (content) {
            return (
                <div style={styles.root}>
                    <Grid container spacing={3}>
                        <StatisticCart
                            name="Dossiers en cours"
                            onClick={() => this.handleCardClick(content.inProgress)}
                            count={content.inProgress.count}
                            to={to}
                        />
                        <StatisticCart
                            name="Dossiers non livrés"
                            count={content.not_livered.count}
                            onClick={() => this.handleCardClick()}
                            to={to}
                        />
                        <StatisticCart
                            name="Dossiers payées"
                            count={content.paid.count}
                            onClick={() => this.handleCardClick()}
                            to={to}
                        />
                        <StatisticCart
                            name="Dossiers impayées"
                            count={content.not_paid.count}
                            onClick={() => this.handleCardClick()}
                            to={to}
                        />
                        <StatisticCart
                            name="Dossiers annulés"
                            count={content.notInProgress.count}
                            onClick={() => this.handleCardClick()}
                            to={to}
                        />
                    </Grid>
                </div>
            )
        }
        return (<></>)
    }
}

StatisticResults.defaultProps = {
    setRapportSelected: () => { }
}
function mapStateToProps(state) {
    return {
        content: state.statistics.content
    };
}

const mapDispatchToProps = {
    setRapportSelected,
};
export default compose(
    withStyles(styles),
    connect(mapStateToProps, mapDispatchToProps),
)(StatisticResults);

