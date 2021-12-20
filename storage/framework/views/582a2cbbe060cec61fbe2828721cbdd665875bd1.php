<!-- Sidebar -->

<nav id="navbar" v-show="$route.path==='/'?false:true" style="display: none">
    <ul class="navbar-nav sidebar d-none sidebar-light accordion toggled hideMeInPrint" id="accordionSidebar">
        <li class="nav-item mt-5 active">
            <router-link class="nav-link" to="/home">
                <i class="fa fa-home"></i>
                <span>الرئيسية</span>
            </router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===1">
            <router-link class="nav-link" to="/bill">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>فاتورة جديدة </span></router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===2">
            <router-link class="nav-link" to="/alert">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>فاتورة جديدة </span></router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===3">
            <router-link class="nav-link" to="/billWithUnits">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>فاتورة جديدة </span></router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===4">
            <router-link class="nav-link" to="/billWithUnitsAndAlert">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>فاتورة جديدة </span></router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/bills">
                <i class="fa fa-wallet"></i>
                <span>فواتير البيع</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/users">
                <i class="fa fa-users"></i>
                <span>المستخدمون</span>
            </router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.roles.includes(10)">
            <router-link class="nav-link" to="/customers">
                <i class="fa fa-users-cog"></i>
                <span>العملاء</span>
            </router-link>
        </li>

        <li class="nav-item active" >
            <router-link class="nav-link" to="/purchase-bills">
                <i class="fa fa-receipt"></i>
                <span>فاتورة شراء</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/allPurchaseBills">
                <i class="fa fa-landmark"></i>
                <span>فواتير الشراء</span>
            </router-link>
        </li>
        <li class="nav-item active" >
            <router-link class="nav-link" to="/suppliers">
                <i class="fa fa-truck"></i>
                <span>الموردون</span>
            </router-link>
        </li>

        <li class="nav-item active">
            <router-link class="nav-link" to="/types">
                <i class="fa fa-list"></i>
                <span>الأصناف</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/workers">
                <i class="fa fa-user-circle"></i>
                <span>الموظفون</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/mainTypes">
                <i class="fa fa-th"></i>
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
            <router-link class="nav-link" to="/mixins">
                <i class="fa fa-cog"></i>
                <span>الإعدادات</span>
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







<?php /**PATH F:\AppServ\www\Mixinis\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>