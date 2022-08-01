<template>
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item pt-2 dach">
                    <router-link :to="{ name: 'Dashboard'}">
                    <a class="sidebar-link  sidebar-link"
                       aria-expanded="false">
                        <i class="far fa-clock" aria-hidden="true"></i>

                            <span class="hide-menu">Dashboard</span>

                    </a>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link :to="{ name: 'Users'}">
                    <a class="sidebar-link  sidebar-link"
                       aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>

                            <span class="hide-menu">Users</span>

                    </a>
                    </router-link>
                </li>


            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
</template>

<script>
export default {
    name: "LeftSideBar"
}
</script>

<style scoped>

</style>
