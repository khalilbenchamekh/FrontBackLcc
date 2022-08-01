<template>
    <div class="dialog" v-if="this.$store.state.popUp===true && message" style=" z-index: 99;
    height: 100%;
    width: 100%;
    position: fixed;
    background-color: currentColor;
    opacity: 1;">
        <ConfirmDialog :message="message" :element="user" :action="sendAction"/>
    </div>
            <div class="card white-box p-0">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"> <h3 class="box-title mb-0">User Organisation</h3></div>
                        <div class="col-md-6 d-flex justify-content-sm-end"><router-link :to="{name:'CreateUser',params:{id:id}}"><button class="btn btn-success text-white ">Create User</button></router-link></div>
                    </div>
                </div>
                <div class="comment-widgets">
                    <table class="table no-wrap" >
                        <thead>
                        <tr >
                            <th class="border-top-0">Name</th>
                            <th class="border-top-0">Email</th><th class="border-top-0">Statue</th>
                            <th class="border-top-0">Block</th>
                            <th class="border-top-0">Details</th>
                            <th class="border-top-0">Update</th>
                        </tr>
                        </thead>
                        <tbody >
                        <tr v-for="(user,index) in users" :key="index" >
                            <td>{{user.name}}</td>
                            <td class="txt-oflo">{{user.email}}</td>
                            <td class="txt-oflo">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="statue" @click="open(user,action[0])" :checked="user.activer===1">
                                    <label class="form-check-label" for="statue">{{user.activer===1?"Actif":"Desactif"}}</label>
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="block" @click="open(user,action[1])" :checked="user.blocked===1">
                                    <label class="form-check-label" for="block">Checked switch checkbox input</label>
                                </div>
                            </td>
                            <td>
                                <div class="txt-oflo">
                                    <router-link :to="{name:'UserDetails',params: { id: user.id }}">
                                        <button type="button" class="btn btn-outline-primary">
                                            Details
                                        </button>
                                    </router-link>
                                </div>

                            </td>
                            <td>
                                <div class="txt-oflo">
                                    <router-link :to="{ name:'UserUpdate',params: { id: user.id }}">
                                        <button type="button" class="btn btn-outline-primary">Updates</button>
                                    </router-link>
                                </div>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</template>

<script>
import {BLOCKED_USER, STATUS_USER} from "../../Constants/actions";
import ConfirmDialog from "../PopUp/ConfirmDialog";
export default {
    components: {ConfirmDialog},
    props:["users","id"],
    name: "UsersOrganisation",
    data(){
        return{
            page:1,
            limit:5,
            sendAction:null,
            user:{},
            message:null,
            action:[STATUS_USER,BLOCKED_USER],
        }
    },

    methods:{
        open(data,action) {
            this.$store.commit("POP_UP",true)
            this.sendAction=action
            this.user=data
            switch (action) {
                case this.action[0]:
                    this.message="Are you sure to change status of user"
                    break
                case this.action[1]:
                    this.message="Are you sure to block user"
                    break
                default:
                    break
            }
        },
    }
}
</script>

<style scoped>
.btn{
    margin-left: 5px;
}
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
