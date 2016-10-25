<!-- Wrapper-->
<script src="<?=base_url('dist/js/apps/recovery-app.js')?>?HASH_CACHE=<?=HASH_CACHE?>"></script>
<div class="wrapper">
    <!-- Main content-->
    <section class="content">
        <div class="back-link">
            <a onclick="window.history.back()" class="btn btn-accent go-back">Go back</a>
        </div>
        <div class="container-center animated slideInDown">
            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-id"></i>
                </div>
                <div class="header-title">
                    <h3>Forgot username?</h3>
                    <small>
                        No problem! Just fill in the e-mail associated with your account to proceed
                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                    <form method="POST" id="recovery" novalidate>
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" placeholder="Please enter your e-mail" name="email" id="email" class="form-control" required autofocus>
                        </div>
                        <div>
                            <button class="btn btn-accent forgot-username">Submit</button>
                            <a class="btn btn-default" href="<?=base_url('main')?>">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->
</div>
<!-- End wrapper-->