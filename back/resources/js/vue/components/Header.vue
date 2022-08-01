<template>
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="dashboard.html">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!-- Dark Logo icon -->
                    <img :src="'/vendor/plugins/images/logo-icon.png'" alt="homepage" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                            <!-- dark Logo text -->
                            <img :src="'/vendor/plugins/images/logo-text.png'" alt="homepage" />
                        </span>
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
               href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav ms-auto d-flex align-items-center">

                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class=" in">
                    <form role="search" class="app-search d-none d-md-block me-3">
                        <input type="text" placeholder="Search..." class="form-control mt-0">
                        <a href="" class="active">
                            <i class="fa fa-search"></i>
                        </a>
                    </form>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="dropstart">
                    <a class="profile-pic dropdown-toggle" href="#" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img :src="'/vendor/plugins/images/users/varun.jpg'" alt="user-img" width="36"
                             class="img-circle"><span class="text-white font-medium">Steave</span></a>
                    <ul class="dropdown-menu dropdown-menu-dark mt-5" aria-labelledby="dropdownMenuButton2">
                        <li class=" d-flex justify-content-sm-center">
                            <img :src="'/vendor/plugins/images/users/varun.jpg'" alt="user-img" width="36"
                                                                           class="img-circle rounded-circle mt-1">
                        </li>
                        <li class="d-flex justify-content-sm-center">
                            <p style="max-width: 30px" >text</p>
                        </li>

                        <li class="d-flex justify-content-sm-center"><button class="btn btn-success text-white p-2 rounded">Log Out</button></li>
                    </ul>

                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>

        </div>
    </nav>
</template>

<script>
export default {
    name: "Header"
}
</script>

<style scoped>

</style>
