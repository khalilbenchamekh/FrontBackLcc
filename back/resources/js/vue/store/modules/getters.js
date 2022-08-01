const getters={
    getOrganisations:(state)=>{
        if(state.organisations.length>0){
            return state.organisations
        }else {
            return []
        }
    },
    getUsers: (state) => {
        if (state.usersOrganisation.length > 0) {
            return this.state.usersOrganisation;
        }
    },
    getOrganisationById:(state)=>(id)=>{
        return state.organisations.find(organisation=>organisation.id===id)
    }
}
export default getters;
