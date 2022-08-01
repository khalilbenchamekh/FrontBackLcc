<template>
        <div class="center">
            <p>{{message}}</p>
            <button @click="closeDialog" class="btn">No</button>
            <button @click="acceptDialog" class="btn">Ok</button>
        </div>
</template>

<script>

import {activerOrganisation, blockOrganisation, disactiverOrganisation} from "../../../utils/organisations";
import {BLOCKed, BLOCKED_USER, Status, STATUS_USER} from "../../Constants/actions";
import {activerUser, blockUser, desactiverUser} from "../../../utils/users";

export default {
    props: ['element','action','message'],
    data(){
      return{
          actions:[Status,BLOCKed,STATUS_USER,BLOCKED_USER],
      }
    },
    created() {
        console.log(this.element)
    },
    methods:{
        closeDialog() {
            const popUp = this.$store.state.popUp
            this.$store.commit("POP_UP", !popUp)
        },
        async acceptDialog() {
            const popUp = this.$store.state.popUp
            console.log(this.element)
            switch (this.action) {
                case this.actions[0]:
                    if (this.element.activer === 1) {
                        const orga = await disactiverOrganisation(this.element.id)
                        console.log(orga)
                        this.$store.commit("CHANGE_ORGANISATION", orga.data)
                    }
                    if (this.element.activer === 0) {
                        const orga = await activerOrganisation(this.element.id)
                        console.log(orga)
                        this.$store.commit("CHANGE_ORGANISATION", orga.data)
                    }
                    this.$store.commit("POP_UP", !popUp)
                    break;
                case this.actions[1]:
                    const orga= await blockOrganisation(this.element.id)
                    console.log(orga.data)
                    this.$store.commit("BLOCK_ORGANISATION", orga.data)
                    this.$store.commit("POP_UP", !popUp)
                    break;
                case STATUS_USER:
                    if (this.element.activer === 1) {
                        const user = await desactiverUser(this.element.id)
                        if(user.status===200){
                            this.$store.commit('CHANGE_USER',user.data)
                        }
                    }
                    if (this.element.activer === 0) {
                        const user = await activerUser(this.element.id)
                        if(user.status===200){
                            console.log(user.data)
                            this.$store.commit('CHANGE_USER',user.data)
                        }
                    }
                    this.$store.commit("POP_UP", !popUp)
                    break;
                case BLOCKED_USER:
                    const user =await blockUser(this.element.id)
                    if(user.status===200){
                        this.$store.commit('CHANGE_USER',user.data)
                    }
                    this.$store.commit("POP_UP", !popUp)
                    break;
                default:
                    console.log('rein')
                    this.$store.commit("POP_UP", !popUp)
                    break
            }

        }
    }

};
</script>

<style scoped>
.dialog {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
}

.center {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
}

.btn {
    margin: 10px;
}
</style>
