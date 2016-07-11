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
                <!--<li id="admin_user" >
                    <a href="admin_user.php"><i class="fa fa-user"></i> <span class="nav-label">管理者介面</span></a>
                </li>-->
            <?php 

                $admin_com='<li id="admin_com" >';
                $admin_com.=  '<a href="admin_com.php"><i class="fa fa-hospital-o"></i> <span class="nav-label">公司管理介面</span> </a>';
                $admin_com.='</li>';

                $admin_project='<li id="admin_project" >';
                $admin_project.=  '<a href="admin_project.php"><i class="fa fa-folder-open"></i> <span class="nav-label">專案管理介面</span> </a>';
                $admin_project.='</li>';
            
            //==================================== 權限判斷 ========================================
              if (($_SESSION['competence']=='admin') OR $_SESSION['competence']=='user' ) {
                  
                echo $admin_com;
                echo $admin_project;
              }
              elseif($_SESSION['competence']=='company'){
                echo $admin_project;
              }
            



            ?>
                
            </ul>

        </div>
    </nav>