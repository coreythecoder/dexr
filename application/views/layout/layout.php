
    <body>
        
            <div class="row">
                <div class='user_sidebar_outer'>
                    <?php
                    if (isset($_GET['admin']) && $_GET['admin'] == '3314'  && $this->user->loggedin && isset($this->user->info->user_role_id) &&
                            ($this->user->info->admin || $this->user->info->admin_settings || $this->user->info->admin_members || $this->user->info->admin_payment)
                    ) :
                        ?>
                        <div class="col-sm-3 col-md-2 sidebar animated slideInLeft" style="z-index:1;">
                            <?php if (isset($sidebar)) : ?>
                                <?php echo $sidebar ?>
                            <?php endif; ?>

                            <ul class="newnav nav nav-sidebar">

                                <li id="admin_sb">
                                    <a data-toggle="collapse" data-parent="#admin_sb" href="#admin_sb_c" class="collapsed <?php if (isset($activeLink['admin'])) echo "active" ?>" >
                                        <span class="fa fa-wrench sidebar-icon"></span> <?php echo lang("ctn_157") ?>
                                        <span class="plus-sidebar"><span class="fa fa-plus"></span></span>
                                    </a>
                                    <div id="admin_sb_c" class="panel-collapse collapse sidebar-links-inner <?php if (isset($activeLink['admin'])) echo "in" ?>">
                                        <ul class="inner-sidebar-links">
                                            <?php if ($this->user->info->admin || $this->user->info->admin_settings) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['settings'])) echo "active" ?>"><a href="<?php echo site_url("admin/settings") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_158") ?></a></li>
                                                <li class="<?php if (isset($activeLink['admin']['social_settings'])) echo "active" ?>"><a href="<?php echo site_url("admin/social_settings") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_159") ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($this->user->info->admin || $this->user->info->admin_members) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['members'])) echo "active" ?>"><a href="<?php echo site_url("admin/members") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_160") ?></a></li>
                                                <li class="<?php if (isset($activeLink['admin']['custom_fields'])) echo "active" ?>"><a href="<?php echo site_url("admin/custom_fields") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_346") ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($this->user->info->admin) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['user_roles'])) echo "active" ?>"><a href="<?php echo site_url("admin/user_roles") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_316") ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($this->user->info->admin || $this->user->info->admin_members) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['user_groups'])) echo "active" ?>"><a href="<?php echo site_url("admin/user_groups") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_161") ?></a></li>
                                                <li class="<?php if (isset($activeLink['admin']['ipblock'])) echo "active" ?>"><a href="<?php echo site_url("admin/ipblock") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_162") ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($this->user->info->admin) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['email_templates'])) echo "active" ?>"><a href="<?php echo site_url("admin/email_templates") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_163") ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($this->user->info->admin || $this->user->info->admin_members) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['email_members'])) echo "active" ?>"><a href="<?php echo site_url("admin/email_members") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_164") ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($this->user->info->admin || $this->user->info->admin_payment) : ?>
                                                <li class="<?php if (isset($activeLink['admin']['payment_settings'])) echo "active" ?>"><a href="<?php echo site_url("admin/payment_settings") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_246") ?></a></li>
                                                <li class="<?php if (isset($activeLink['admin']['payment_plans'])) echo "active" ?>"><a href="<?php echo site_url("admin/payment_plans") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_258") ?></a></li>
                                                <li class="<?php if (isset($activeLink['admin']['payment_logs'])) echo "active" ?>"><a href="<?php echo site_url("admin/payment_logs") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_288") ?></a></li>
                                                <li class="<?php if (isset($activeLink['admin']['premium_users'])) echo "active" ?>"><a href="<?php echo site_url("admin/premium_users") ?>"><span class="glyphicon glyphicon-arrow-right admin-sb-link"></span> <?php echo lang("ctn_325") ?></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    <?php endif; ?>
                    <style>
                        .top-menu {
                            margin-bottom: 0px;
                        }
                        .top-menu a {
                            margin-top:2px;
                            margin-bottom:2px;
                        }
                    </style>
                    <?php
                    if (isset($_GET['admin']) && $_GET['admin'] == '3314' && $this->user->loggedin && isset($this->user->info->user_role_id) &&
                            ($this->user->info->admin || $this->user->info->admin_settings || $this->user->info->admin_members || $this->user->info->admin_payment)
                    ) {
                        ?>
                        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                        <?php } else { ?>
                            <div class="col-md-12 main">
                            <?php } ?>



                            <?php $gl = $this->session->flashdata('globalmsg'); ?>
                            <?php if (!empty($gl)) : ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php echo $content ?>
                        </div>
                    </div>
                </div>
            </div>


    </body>
</html>