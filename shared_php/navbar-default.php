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

             require_once 'shared_php/check_phone.php'; //判斷手機媒體

               function admin_com($href)
               {
                   $admin_com='<li id="admin_com" >';
                   $admin_com.=  '<a href="'.$href.'"><i class="fa fa-hospital-o"></i> <span class="nav-label">公司管理介面</span> </a>';
                   $admin_com.='</li>';
                   echo $admin_com;
               }
                
               function admin_project($href)
               {
                $admin_project='<li id="admin_project" >';
                $admin_project.=  '<a href="'.$href.'"><i class="fa fa-folder-open"></i> <span class="nav-label">專案管理介面</span> </a>';
                $admin_project.='</li>';
                echo $admin_project;
               }
                
            
            //==================================== 權限判斷 ========================================
              if (($_SESSION['competence']=='admin') OR $_SESSION['competence']=='user' ) {


                   if (check_mobile() AND $_SESSION['competence']!='admin' ) {//手機
                    
                       admin_com('admin_project_ph.php');
                      // admin_project('admin_project_phcs.php');

                  }else{


                        admin_com('admin_com.php');
                        admin_project('admin_project.php');
                    }
                
              }
              elseif($_SESSION['competence']=='company'){

                  if (check_mobile()){

                    admin_project('admin_project_phcs.php');
                  }else{
                    
                    admin_project('admin_project.php');
                  }
                
              }
            



            ?>
                
            </ul>

        </div>
    </nav>
