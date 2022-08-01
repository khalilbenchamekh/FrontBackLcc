<template>
    <div class="dialog" v-if="this.$store.state.popUp===true && message" style=" z-index: 99;
    height: 100%;
    width: 100%;
    position: fixed;
    background-color: currentColor;
    opacity: 1;">
        <ConfirmDialog :message="message" :element="user" :action="sendAction"/>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <div class="d-md-flex mb-3">
                    <h3 class="box-title mb-0">All Users</h3>
                    <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">
                        <select class="form-select shadow-none row border-top">
                            <option>March 2021</option>
                            <option>April 2021</option>
                            <option>May 2021</option>
                            <option>June 2021</option>
                            <option>July 2021</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table no-wrap">
                        <thead>
                        <tr>
                            <th class="border-top-0">#</th>
                            <th class="border-top-0">Name</th>
                            <th class="border-top-0">email</th>
                            <th class="border-top-0">Status</th>
                            <th class="border-top-0">Block</th>
                            <th class="border-top-0">Details</th>
                            <th class="border-top-0">Update</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="users.length>0" v-for="user in users" :key="user.id">
                            <td>1</td>
                            <td class="txt-oflo">{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td class="txt-oflo">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" @click="open(user,action[0])"  :checked="user.activer===1">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">{{user.activer===1?"actif":"disactif"}}</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="block" @click="open(user,action[1])" :checked="user.blocked===1">
                                    <label class="form-check-label" for="block">{{user.blocked===1?"blocked":"block"}}</label>
                                </div>
                            </td>
                            <td>
                                <router-link :to="{ name: 'UserDetails', params: { id: user.id }}">
                                    <button type="button" class="btn btn-outline-primary" >
                                        Details
                                    </button>
                                </router-link>

                            </td>
                            <td>
                                <router-link :to="{ name: 'UserUpdate', params: { id: user.id }}">
                                    <button type="button" class="btn btn-outline-primary">
                                        Update
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-center">
                        <li :class="page<=1?'page-item disabled':'page-item'" @click="changePage(page-1)" >
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"  >Previous</a>
                        </li>
                        <li class="page-item" v-for="index in lastPage" @click="changePage(index)"><a class="page-link" href="#" >{{index}}</a></li>
                        <li :class="page>=lastPage?'page-item disabled':'page-item'" @click="changePage(page+1)">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getAllUsers} from "../../utils/users";
import {BLOCKED_USER, STATUS_USER} from "../Constants/actions";
import ConfirmDialog from "../components/PopUp/ConfirmDialog";

export default {
    name: "Users",
    components: {ConfirmDialog},
    data(){
        return{
          limit:5,
          page:1,
          sendAction:null,
          user:{},
          message:null,
          lastPage:null,
          action:[STATUS_USER,BLOCKED_USER],
          users:[]
        }
    },
    async created() {
        const data = {'limit': this.limit, 'page': this.page}
        const response = await getAllUsers(data)
        if(response.status===200){
            this.$store.commit("GET_ALL_USERS",response.data)
            this.users=this.$store.state.allUsers.users.users
            this.lastPage=this.$store.state.allUsers.lastPage
            console.log(this.users)
        }
    },
    methods:{
        async changePage(page) {
            if(page <= this.lastPage){
                this.loading=true
                this.page = page
                let data = {'limit': this.limit, 'page': this.page}
                const response = await getAllUsers(data)
                if(response.status===200){
                    this.$store.commit("GET_ALL_USERS",response.data)
                    this.users=this.$store.state.allUsers.users.users
                    this.lastPage=this.$store.state.allUsers.lastPage
                    console.log(this.users)
                }
            }
        },
        open(data,action) {
            const popUp=this.$store.state.popUp
            this.$store.commit("POP_UP",!popUp)
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

</style>
