<template>
<div>
    {{this.$route.params.id}}
</div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-12">
                <div class="white-box">
                    <div class="user-bg"> <img width="100%" alt="user" :src="image">
                        <div class="overlay-box">
                            <div class="user-content">
                                <a href="javascript:void(0)"><img :src="image"
                                                                  class="thumb-lg img-circle" alt="img"></a>
                                <h4 class="text-white mt-2">{{user.name}}</h4>
                                <h5 class="text-white mt-2">{{user.email}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="user-btm-box mt-5 d-md-flex">
                        <div class="col-md-4 col-sm-4 text-center">
                            <h1>258</h1>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center">
                            <h1>125</h1>
                        </div>
                        <div class="col-md-4 col-sm-4 text-center">
                            <h1>556</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material">
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Full Name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <h4>{{user.name}}</h4>
                                     </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Email</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <h4>{{user.email}}</h4>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Status</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <h4>{{user.activer===1?"actif":"desactif"}}</h4>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Block</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <h4>{{user.blocked===1?"blocked":"No Block"}}</h4>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>

    </div>
</template>

<script>
import {getImage, getUser} from "../../../utils/users";

export default {
    data(){
      return{
          user:{},
          image:null,
      }
    },
    async created() {
        let id = this.$route.params.id
        const response = await getUser(id)
        if(response.status===200){
            this.user=response.data
        }
        const image = await getImage(id)
        if(image!==null){

            this.image=image
        console.log(this.image)
        }
    }
}
</script>

<style scoped>

</style>
