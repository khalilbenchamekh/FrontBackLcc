<template>
    <div class="col-lg-4 col-md-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Organisations</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
                <li>
                    <div id="sparklinedash"><canvas width="67" height="30"
                                                    style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                    </div>
                </li>
                <li class="ms-auto"><span class="counter text-success">{{this.totalOrganisation?this.totalOrganisation:null}}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Total Users</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
                <li>
                    <div id="sparklinedash2"><canvas width="67" height="30"
                                                     style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                    </div>
                </li>
                <li class="ms-auto"><span class="counter text-purple">{{count}}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">Unique Visitor</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
                <li>
                    <div id="sparklinedash3"><canvas width="67" height="30"
                                                     style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                    </div>
                </li>
                <li class="ms-auto"><span class="counter text-info">911</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {getCountUsers} from "../../utils/users";

export default {
    name: "Static",
    data(){
      return{
          totalOrganisation:null,
          count:null
      }
    },
    async created() {
        const response =await getCountUsers();
        if(response.status===200){
            this.count=response.data.count
            console.log(this.count)
        }
        console.log(response)
        const organisations =  this.$store.state.organisations.totalOrganisation
        if (organisations!==null && organisations!==undefined) {
            this.totalOrganisation =await this.$store.state.organisations.totalOrganisation
        }
    }
}
</script>

<style scoped>

</style>
