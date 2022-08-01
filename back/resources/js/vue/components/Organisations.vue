<template>

    <div class="dialog" v-if="this.$store.state.popUp===true && message" style=" z-index: 99;
    height: 100%;
    width: 100%;
    position: fixed;
    background-color: currentColor;
    opacity: 1;">
       <ConfirmDialog :message="message" :element="organisation" :action="sendAction"/>
    </div>
    <div class="details" v-if="this.$store.state.detailsPop===true && organisation" style="
    z-index: 30;
    height: 100%;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: currentColor;
    opacity: 1;">
        <Details :organisation="organisation" />
    </div>


        <div class="white-box">
            <div class="table-responsive">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <router-link :to="{name: 'CreateOrganisation'}">
                            <button class="btn btn-success text-white rounded">Create Organisation</button>
                        </router-link>
                    </div>
                </div>
                <table class="table no-wrap" >
                    <thead>
                    <tr >
                        <th class="border-top-0">Name</th>
                        <th class="border-top-0">Description</th>
                        <th class="border-top-0">Email</th>
                        <th class="border-top-0">Cto</th>
                        <th class="border-top-0">Statue</th>
                        <th class="border-top-0">Block</th>
                        <th class="border-top-0">Details</th>
                        <th class="border-top-0">Update</th>
                    </tr>
                    </thead>
                    <div class="d-flex justify-content-center" style="position: absolute;
                        left: 50%;
                        "
                         v-if="loading===true"
                    >
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <tbody >
                    <tr v-for="(organisation,index) in organisations" :key="index" v-if="organisations.length>0">
                        <td>{{organisation.name}}</td>
                        <td>{{organisation.description}}</td>
                        <td class="txt-oflo">{{organisation.emailOrganisation}}</td>
                        <td class="txt-oflo">{{organisation.cto}}</td>
                        <td class="txt-oflo">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="statue" @click="open(organisation,action[0])" :checked="organisation.activer==1?true:null">
                                <label class="form-check-label" for="statue">{{organisation.activer===1?"Actif":"Desactif"}}</label>
                            </div>
                        </td>
                        <td class="txt-oflo">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="block" @click="open(organisation,action[1])" :checked="organisation.blocked==1?true:null">
                                <label class="form-check-label" for="block">Checked switch checkbox input</label>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" @click="openDetails(organisation)">
                                Details
                            </button>
                        </td>
                        <td>
                            <router-link :to="{ name: 'Organisation', params: { id: organisation.id }}">
                                <button type="button" class="btn btn-outline-primary">Updates</button>
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
</template>

<script>



import {BLOCKed, Status} from "../Constants/actions";
import ConfirmDialog from "./PopUp/ConfirmDialog";
import Details from "./PopUp/Details";
import {getOrganisations} from "../../utils/organisations";
import {isLoggedIn} from "../../utils/auth";

export default {
    name: "Organisations",
    components: {Details, ConfirmDialog},
    data(){
      return{
          organisation:null,
          limit:5,
          page:1,
          organisations:[],
          lastPage:null,
          loading:false,
          sendAction:null,
          action:[Status,BLOCKed],
          message:null,
          details:false
      }
    },
    async created() {
        console.log(isLoggedIn())
        this.loading=true
        const storeOrganisation=await this.$store.state.organisations;
        let organisations=storeOrganisation.organisations;
        console.log("ff");
        if(organisations !==null && organisations!==undefined){
            this.organisations=organisations
            this.lastPage=storeOrganisation.lastPage
            this.loading=false
        }
      this.loading=false
    },
    methods:{
        async changePage(page) {
            if(page <= this.lastPage){
                this.loading=true
                this.page = page
                let data = {'limit': this.limit, 'page': this.page}
                const fetCtOrganisations = await getOrganisations(data)
                this.$store.commit('ALL_ORGAS',fetCtOrganisations)
                this.organisations=this.$store.state.organisations.organisations
                this.lastPage=this.$store.state.organisations.lastPage
                this.loading=false
            }
        },
         open(data,action) {
             const popUp=this.$store.state.popUp
             this.$store.commit("POP_UP",!popUp)
             this.sendAction=action
             this.organisation=data
             switch (action) {
                case this.action[0]:
                    this.message="Are you sure to change status of organisation"
                     break
                case this.action[1]:
                    this.message="Are you sure to block organisation"
                     break
                default:
                    break
             }
        },
        openDetails(data){
            const detailsPop=this.$store.state.detailsPop
            this.$store.commit("DETAILS_POP_UP",!detailsPop)
            this.organisation=data
        },
         closeDialog() {
            const popUp = this.$store.state.popUp
                //this.action = null,
                // this.organisation = null
                this.$store.commit("POP_UP", !popUp)
        },
         acceptDialog() {
             const popUp = this.$store.state.popUp
             this.$store.commit("POP_UP", !popUp)
        }
    },


}
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
</style>>
