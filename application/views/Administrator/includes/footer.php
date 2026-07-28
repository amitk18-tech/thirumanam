   <!-- Loader Code Start-->
    <div class="ajax_loader">
        <img src="<?php echo base_url(); ?>assets/admin/images/loader.gif"/>
    </div>
    <!-- <div class="spinner-border text-success ajax_loader" role="status">
        <span class="sr-only">Loading...</span>
    </div> -->
    <style type="text/css">
    .ajax_loader {
    background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999999;
    display: none;
    }
    .ajax_loader img {
    left: 47%;
    position: absolute;
    top: 30%;
    }
    </style>
<!-- Loader Code End-->




           </div>
       </div>

        <footer class="footer" style="position: fixed; margin-top: 10px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © <?php echo getSettings()->site_title; ?>.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by <a href="http://iclient.tech/" target="_blank">iCLIENTECH</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->