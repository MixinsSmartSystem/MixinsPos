<!DOCTYPE html>
<html lang="en" dir="rtl">
@include('header.header')
<body id="page-top">
<div id="app">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
            @include('layouts.topbar')

            <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <router-view></router-view>
                    <!---Container Fluid-->
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer.footer')
</body>

</html>
