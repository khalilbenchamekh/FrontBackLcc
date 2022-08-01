const mutations={
    ALL_ORGAS(state,payload){
        state.organisations=payload
    },
    POP_UP(state,payload){
        state.popUp=payload
    },
    DETAILS_POP_UP(state,payload){
        state.detailsPop=payload
    },
    CTO_UPDATE_POP_UP(state,payload){
        state.updateCto=payload
    },
    CHANGE_ORGANISATION(state,payload){
        const index = state.organisations.organisations.findIndex(item => item.id === payload.id);
        if (index > -1) {
            state.organisations.organisations[index] = payload;
        }
    },
    BLOCK_ORGANISATION(state,payload){
        const index = state.organisations.organisations.findIndex(item => item.id === payload.id);
        if (index > -1) {
            state.organisations.organisations[index].blocked = payload.blocked;
        }
    },
    ADD_USERS_ORGANISATION(state,payload){
        state.usersOrganisation=payload
    },
    UPDATE_CTO_NAME_ORGANISATION(state,payload){
        const index = state.organisations.organisations.findIndex(item => item.id === payload.orga.id);
        if (index > -1) {
            state.organisations.organisations[index] = payload.cto;
        }
    },
    GET_ALL_USERS(state,payload){
        state.allUsers=payload
    },
    CHANGE_USER(state,payload){
        const index=state.allUsers.users.users.findIndex(item=>item.id===payload.id)
        if(index>-1){
            state.allUsers.users.users[index]=payload
        }
    },
    CREATE_ORGANISATION(state,payload){
        state.organisations.organisations.unshift(payload.organisation)
    },
    ADD_USER_ORGANISATION(state,payload){
        state.usersOrganisation.users.users.unshift(payload)
    },
    AUTH_USER(state){
        state.authUser
    }
}
export default mutations
