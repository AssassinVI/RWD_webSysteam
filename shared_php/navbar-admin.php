<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <!-- 使用者名稱 -->
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION['name'] ?></strong>
                             </span>  </span> </a>
                    </div>
                    <div class="logo-element">
                        RWD
                    </div>
                </li>
                <li id="admin_user" >
                    <a href="admin_user.php"><i class="fa fa-user"></i> <span class="nav-label">管理者介面</span></a>
                </li>
                <li id="admin_ga" >
                    <a href="google_analytics_set.php"><i class="fa fa-folder-open"></i> <span class="nav-label">GOOGLE分析更新</span> </a>
                </li>
            </ul>

        </div>
    </nav>