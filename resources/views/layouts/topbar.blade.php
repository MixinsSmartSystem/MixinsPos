<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar d-none  my-0 py-0 static-top" v-show="$route.path==='/'?false:true">
    <a id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 text-light">
        <i class="fa fa-bars"></i>
    </a>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <router-link class="nav-link" to="/home">
                <span class="ml-2 d-none d-lg-inline text-white ">الرئيسية</span>
            </router-link>
        </li>

        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===1">
            <router-link class="nav-link" to="/bill">
                <span class="ml-2 d-none d-lg-inline text-white ">فاتورة جديدة</span>
            </router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===2">
            <router-link class="nav-link" to="/alert">
                <span class="ml-2 d-none d-lg-inline text-white ">فاتورة جديدة</span>
            </router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===3">
            <router-link class="nav-link" to="/billWithUnits">
                <span class="ml-2 d-none d-lg-inline text-white ">فاتورة جديدة</span>
            </router-link>
        </li>
        <li class="nav-item active" v-show="$root.$data.mixins.bill_type===4">
            <router-link class="nav-link" to="/billWithUnitsAndAlert">
                <span class="ml-2 d-none d-lg-inline text-white ">فاتورة جديدة</span>
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
        <li class="nav-item active ">
            <router-link class="nav-link" to="/types">
                <span class="ml-2 d-none d-lg-inline text-white ">الأصناف</span>
            </router-link>
        </li>
        <li class="nav-item active ">
            <router-link class="nav-link" to="/mainTypes">
                <span class="ml-2 d-none d-lg-inline text-white ">التصنيفات</span>
            </router-link>
        </li>
        <li class="nav-item active ">
            <router-link class="nav-link" to="/customers">
                <span class="ml-2 d-none d-lg-inline text-white ">العملاء</span>
            </router-link>
        </li>
        <li class="nav-item active ">
            <router-link class="nav-link" to="/users">
                <span class="ml-2 d-none d-lg-inline text-white ">المستخدمون</span>
            </router-link>
        </li>
        <li class="nav-item active ">
            <router-link class="nav-link" to="/suppliers">
                <span class="ml-2 d-none d-lg-inline text-white ">الموردون</span>
            </router-link>
        </li>
        <li class="nav-item active ">
            <router-link class="nav-link" to="/workers">
                <span class="ml-2 d-none d-lg-inline text-white ">الموظفون</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/report">
                <span class="ml-2 d-none d-lg-inline text-white ">التقارير</span>
            </router-link>
        </li>
        <li class="nav-item active">
            <router-link class="nav-link" to="/mixins">
                <span class="ml-2 d-none d-lg-inline text-white ">الاعدادات</span>
            </router-link>
        </li>
        <li class="nav-item position-absolute" style="left: 50px">
            <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                {{--                <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">--}}
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
<div class="fixed-bottom footer">
    <div class="dock">
        <ul class="dock-container">
            <li>
                <router-link to="/home">
                    <div class="name">الرئيسية</div>
                    <img class="ico" src="{{asset('backend/img/footer/home.png')}}" alt="">
                </router-link>
            </li>
            <li>
                <router-link to="/report">
                    <div class="name">الرئيسية</div>
                    <img class="ico" src="{{asset('backend/img/reports/report.png')}}" alt="">
                </router-link>
            </li>
        </ul>
    </div>
</div>

<!-- Topbar -->
