<!-- Login Modal -->
<div class="modal fade" id="popUpWindow">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="display-4"><?php echo lang('HEADER_LOGIN'); ?></h3>

            </div>
            <!-- Body -->
            <div class="modal-header">
                <form role="form" id="login_form">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="<?php echo lang('HEADER_EMAIL'); ?>" name="email" id="emailField" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="<?php echo lang('HEADER_PASSWORD'); ?>" name="password" id="passwordField" required>
                    </div>

                    <div class="modal-header">
                        <button class="btn btn-primary" name="submit" id="submit_action"><?php echo lang('HEADER_LOGIN'); ?></button>
                    </div>
                </form>
            </div>
            <div id="loginErrors">
                <!-- Footer (Buttton) -->
            </div>
        </div>
    </div>
</div>

<script>
    loginController.init();
</script>