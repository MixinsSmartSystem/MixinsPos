<!-- Sidebar -->

<nav id="navbar" v-show="$route.path==='/'?false:true" style="display: none">
    <ul class="navbar-nav sidebar sidebar-light accordion toggled hideMeInPrint" id="accordionSidebar">

        <li class="nav-item active">
            <router-link class="nav-link" to="/newBill">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>فاتورة جديدة </span></router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/menu">
                <i class="fa fa-home"></i>
                <span>الرئيسية</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/customers">
                <i class="fa fa-users-cog"></i>
                <span>العملاء</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/customers">
                <i class="fa fa-user"></i>
                <span>المستخدمون</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/mainTypes">
                <i class="fa fa-list"></i>
                <span>التصنيفات</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/report">
                <i class="fa fa-chart-line"></i>
                <span>التقارير</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/logout">
                <i class="fas fa-sign-out-alt"></i>
                <span > خروج</span>

            </router-link>
        </li>
    </ul>

</nav>
<!-- Sidebar -->

<nav class="main-menu">


</nav>






<?php /**PATH C:\AppServ\www\Mixinis\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>