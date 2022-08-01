<template>

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-12 image" >
                <ImageOrganisation :users="users.length"  :organisation="data" />
            </div>


            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="alert alert-success text-center" role="alert" v-if="success">
                    <div class="spinner-border text-success" role="status" v-if="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span v-if="successMessage!==null">{{successMessage}}</span>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" @submit.prevent="onsubmit">
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Name Organisation</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe"
                                           v-model="data.name"
                                           class="form-control p-0 border-0" :disabled="loading===true"> </div>
                                <li class="text-danger" v-if="errors.nameOrganisation!==null">{{errors.nameOrganisation}}</li>

                            </div>
                            <div class="form-group mb-4">
                                <label  class="col-md-12 p-0">Email Organisation</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="email"
                                           v-model="data.emailOrganisation"

                                           class="form-control p-0 border-0" name="example-email"
                                            :disabled="loading===true">
                                    <li class="text-danger" v-if="errors.emailOrganisation!==null">{{errors.emailOrganisation}}</li>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Name Resposable (CTO)</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe"
                                           v-model="cto.name"
                                           class="form-control p-0 border-0" :disabled="loading===true">
                                    <li class="text-danger" v-if="errors.nameCto!==null">{{errors.nameCto}}</li>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label  class="col-md-12 p-0">Email Responsable(CTO)</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="email"
                                           v-model="cto.email"

                                           class="form-control p-0 border-0" name="example-email"
                                           :disabled="loading===true">
                                    <li class="text-danger" v-if="errors.emailCto!==null">{{errors.emailCto}}</li>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Description</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea rows="5" class="form-control p-0 border-0" v-model="data.description" :disabled="loading===true"></textarea>
                                    <li class="text-danger" v-if="errors.description!==null">{{errors.description}}</li>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success" type="submit" :disabled="loading===true">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12 col-sm-12 ">
                <UsersOrganisation :users="users" :id="data.id"/>
            </div>
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
</template>

<script>
import {
    editOrganisation,
    getAllUserOrganisation,
    getCto,
    getImageOrganiastion,
    getOrganisation
} from "../../utils/organisations";
import CtoUpdate from "../components/PopUp/CtoUpdate";
import UsersOrganisation from "../components/Organisation/UsersOrganisation";
import ImageOrganisation from "../components/Organisation/ImageOrganisation";

export default {
    name: "Organisation",
    components: {ImageOrganisation, UsersOrganisation, CtoUpdate},
    data(){
      return{
          image:null,
          data:{},
          users:[],
          cto:{},
          lastPage:null,
          page:1,
          limit:5,
          errors:{emailOrganisation:null,emailCto:null,nameOrganisation:null,nameCto:null,description:null},
          success:false,
          successMessage:null,
          loading:false,
      }
    },
    async created() {
        alert('ff')
        const data= {"limit":this.limit,"page":this.page}
        const id=this.$route.params.id
        const organisation= await getOrganisation(id)
        const usersOrganisation= await getAllUserOrganisation(id,data)
        this.data=organisation.organisation
        this.lastPage=this.$store.state.usersOrganisation.lastPage
        const cto= await getCto(this.data.cto)
        if(cto && usersOrganisation){
            this.$store.commit('ADD_USERS_ORGANISATION',usersOrganisation)
            const users=this.$store.state.usersOrganisation
            this.users=users.users.users
            if(cto.user){
                this.cto=cto.user
            }
        }
    },
    methods:{
        async onsubmit(e) {
            this.errors={emailOrganisation:null,emailCto:null,nameOrganisation:null,nameCto:null,description:null}
            this.success=false
            this.successMessage=null
            const orga = this.data;
            const cto = this.cto;
            console.log(this.checkEmail(orga.emailOrganisation))
            if(this.checkEmail(orga.emailOrganisation)){
                console.log("1")
                if(this.checkEmail(cto.email)){
                    console.log("1")
                    if(cto.name.length>= 3){
                        console.log(cto.name.length )
                        if(orga.description.length >= 3){
                            console.log("1")
                            if(orga.name.length>=3){
                                this.success=true
                                this.loading=true
                                const organisation = await editOrganisation(orga.id,orga)
                                if(organisation.organisation){
                                    const data={orga:organisation.organisation,cto:cto.name}
                                    this.$store.commit('CHANGE_ORGANISATION',organisation.organisation)
                                    this.$store.commit('UPDATE_CTO_NAME_ORGANISATION',data)
                                    this.loading=false
                                    this.successMessage='Organisation Updated'
                                }
                            }else {
                                this.errors.nameOrganisation="required Description"
                            }

                        }else {
                            this.errors.description="required Description"
                        }
                    }else {
                        this.errors.nameCto="required Name Cto"
                    }
                }else {
                    this.errors.emailCto="required email Cto"
                }
            }else {
                this.errors.emailOrganisation="required email Organisation"
            }
            e.preventDefault()
        },
        checkEmail(email){
                let re = /\S+@\S+\.\S+/;
                return re.test(email);
        }
    }
}
</script>

<style scoped>
.image{
    position: relative;
}
.update{
    position: absolute;
    top: 20%;
    right: 10%;
}
</style>
