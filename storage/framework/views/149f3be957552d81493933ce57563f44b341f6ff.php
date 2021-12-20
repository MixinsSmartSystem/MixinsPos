<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script src="<?php echo e(asset('js/table.js')); ?>"></script>

<script src="<?php echo e(asset('backend/vendor/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script type="text/javascript">
    let token = localStorage.getItem('token');
    if (token) {
        $("#sidebar").css("display","");
        $("#topbar").css("display","");

    }


        $(function($) {
            $(" tr").on('click', function () {
            $(this).addClass('selectedRow').siblings().removeClass('selectedRow')
        });
            $('.userName').text(localStorage.getItem('user'))

            $(".modal").draggable({
                handle: ".modal-header"
            });

        })

</script>

<script src="<?php echo e(asset('backend/vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/js/ruang-admin.min.js')); ?>"></script>

<script src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quickblox/2.11.0/quickblox.min.js"></script>
<?php /**PATH F:\AppServ\www\Mixinis\resources\views/footer/footer.blade.php ENDPATH**/ ?>