<template>



            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Three charts -->
                <!-- ============================================================== -->
                <div class="row justify-content-center">
                    <Static />
                </div>
                <!-- ============================================================== -->
                <!-- RECENT SALES -->
                <!-- ============================================================== -->
                <div class="row">
                    <Organisations />
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

</template>
<script>
import Header from "../components/Header";
import UnderHeader from "../components/UnderHeader";
import Static from "../components/Static";
import axios from "axios";
import Organisations from "../components/Organisations";
import LeftSideBar from "../components/LeftSideBar";
import RightSideBar from "../components/RightSideBar";
import {getOrganisations} from "../../utils/organisations";

export default {
    name: "App.vue",
    components: {RightSideBar, LeftSideBar, Organisations, Static, Header,UnderHeader},
    data(){
        return {

        }
    },
    async created() {
        let data={'limit':5,'page':1}
            const fetCtOrganisations = await getOrganisations(data)
            this.$store.commit('ALL_ORGAS',fetCtOrganisations)
    },

}
</script>

<style scoped>

</style>
