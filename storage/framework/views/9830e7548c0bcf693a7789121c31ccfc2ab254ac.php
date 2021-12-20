<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar  my-0 py-0 static-top" v-show="$route.path==='/'?false:true">
    <a id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 text-light">
        <i class="fa fa-bars"></i>
    </a>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <router-link class="nav-link" to="/menu">
                <span class="ml-2 d-none d-lg-inline text-white ">الرئيسية</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/newBill">
                <span class="ml-2 d-none d-lg-inline text-white ">فاتورة بيع</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/bills">
                <span class="ml-2 d-none d-lg-inline text-white ">فواتير البيع </span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/purchase-bills">
                <span class="ml-2 d-none d-lg-inline text-white "> فاتورة شراء </span>
            </router-link>
        </li>
        <li class="nav-item active ">
            <router-link class="nav-link" to="/allPurchaseBills">
                <span class="ml-2 d-none d-lg-inline text-white ">فواتير الشراء </span>
            </router-link>
        </li>

        <li class="nav-item active">
            <router-link class="nav-link" to="/report">
                <span class="ml-2 d-none d-lg-inline text-white ">التقارير</span>
            </router-link>
        </li>

        <li class="nav-item position-absolute" style="left: 50px">
            <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                
                <span class="ml-2 d-none d-lg-inline text-white  userName"></span>
            </a>
        </li>
        <li class="nav-item active position-absolute " style="left: 0">
            <router-link class="nav-link" to="/logout">
                <span class="ml-2 d-none d-lg-inline text-white "> خروج</span>

            </router-link>
        </li>
    </ul>
</nav>


<!-- Topbar -->
<?php /**PATH C:\AppServ\www\Mixinis\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>