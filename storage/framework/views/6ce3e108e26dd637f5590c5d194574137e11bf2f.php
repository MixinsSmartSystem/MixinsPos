<!DOCTYPE html>
<html lang="en" dir="rtl">
<?php echo $__env->make('header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body id="page-top">
<div id="app">
    <div id="wrapper">
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
            <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <router-view></router-view>
                    <!---Container Fluid-->
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('footer.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH F:\AppServ\www\Mixinis\resources\views/index.blade.php ENDPATH**/ ?>