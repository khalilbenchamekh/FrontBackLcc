import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import { Avatar } from '@material-ui/core';
import ListItem from "./MessagerieComponents";
import { NavLink } from "react-router-dom";
import moment from "moment";
const styles = {
  root: {
    display: "inline",
    flexDirection: "row",
    justifyContent: "left",
    padding: "10px",
    flexBasis: "30vh",
    cursor: "pointer",
    "&:hover": {
      backgroundColor: "#00000011",
    }
  },
  avatar: {
    display: "inline",
    marginTop:'20px',
    flexBasis: "40%",
    alignSelf: "center",
    position:'relative'
  },
  badge:{
    position:"absolute",
    top:'0',
    left:'0'
  },
  message: {  
    flexGrow: 1,
    paddingLeft: 10,
    color:'black',
    marginLeft:10,
  }
};

const Message = ({ classes, data }) => {
 
  return (
    <div className={classes.root} >
      <NavLink to={`/messaging/${data && data.id}`}>
        
        <div className='row'>
        <div className='col-2'>
        <div className={classes.avatar} >
        <button class="btn btn-light position-relative">
                 <Avatar 
                  colorFrom={data.id}
                  sx={{ width: 56, height: 56 }}>
                  {data.name && data.name.substring(0, data.name.length < 2 ? 1 : 1)}</Avatar>
                    {
                     data.unread ===0?
                     null:
                      <div className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {data.unread}
                      </div>
                    }  
        </button>              
        </div>
        </div>
        <div className='col-10 d-flex justify-content-end'>
        <div className={classes.message} style={{display:'inline'}}>
         
          <div className="font-weight-bold" style={{display:'inline',
        fontSize:"15px",
        fintWeight:"2"}}>{data.name.replace(/\s+/g, '')}</div>
          <div className="text-dark"> {moment(data.created_at).fromNow()}</div>
        </div>
        </div>

        </div>
         
        
      </NavLink>
    </div>
  )
}

Message.defaultProp = {
  data: {
    id: undefined,
    name: "anonymous",
    unread: false,
    created_at: null,
  }
}

export default withStyles(styles)(Message);
