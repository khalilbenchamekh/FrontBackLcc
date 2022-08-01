import React, { Component, useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import Message from './Message';
import Scrollbar from "react-scrollbars-custom";
import AddIcon from '@material-ui/icons/Add';
import { Dialog, DialogTitle, DialogContent, TextField, } from '@material-ui/core';
import Autocomplete from '@material-ui/lab/Autocomplete';
import FriendCard from './FriendCard';
import Select from 'react-select';

const style = {
    root: {
        display: "flex",
        flexDirection: "column",
        height: "70vh",
        width: "40vh",
        flexGrow: 1,
        borderRight: "solid #00000022 thin",
        position: "relative",
        overflowY: 'auto',
    },
    title: {
        width: "40vh",
    },
    card: {
        boxShadow: "3px 3px 6px 0 rgba(0,0,0,0.2)",
        transition: "0.3s",
        borderRadius: "10px",
        "&:hover": {
            boxShadow: "3px 6px 12px 0 rgba(0,0,0,0.2)",
            cursor: "pointer"
        },
        height: "75px",
        marginBottom: "10px",
    },
    flatAddMessage: {
        padding: "1px 4px 3px 3.5px",
        backgroundColor: "#00000022",
        height: 'fit-content',
        margin: 1,
        cursor: 'pointer',
        borderRadius: 500,
        '&:hover': {
            border: "solid thin #00000055",
            backgroundColor: "#00000044",
            margin: 0,
        },
        '&:active': {
            border: "solid thin #000000aa",
            backgroundColor: "#00000077",
            margin: 0,
        }
    },
    titleText: {
        flexGrow: 1,
    }
};

const FriendsList = ({ classes, friends, onSelect }) => {
    const [open, setOpen] = useState(false);
    const [filteredFriends, setFilteredFriends] = useState(friends);

    const filterFriends = (selectedOption) => {
        setFilteredFriends(selectedOption ? friends.filter(fr => fr.value && fr.value === selectedOption.value) : friends)
    }
    const handleClick = (friend) => {
        onSelect(friend)
        setOpen(false);
    }
    useEffect(() => {
        setFilteredFriends(friends);
    }, [friends]);
    return (
        <div>
            <div className={classes.flatAddMessage} onClick={() => setOpen(true)}>
                <AddIcon />
            </div>
            <Dialog open={open} onClose={() => setOpen(false)} aria-labelledby="form-dialog-title-update">
                <DialogTitle className={classes.title} className={classes.title} id="form-dialog-title">
                    <Select
                        onChange={filterFriends}
                        options={friends}
                    />
                </DialogTitle>
                <DialogContent className={classes.root} >
                    {
                        Array.isArray(filteredFriends) && filteredFriends.length > 0
                        && (
                            filteredFriends.map((friend, index) => (
                                <div key={friend.id + "-" + index} className={classes.card}>
                                    <FriendCard name={friend.label} onClick={() => handleClick(friend)} />
                                </div>
                            )
                            ))
                    }
                </DialogContent>
            </Dialog>
        </div>
    )
}

export default withStyles(style)(FriendsList);