<div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">

        <?php 
          if ($_SESSION['competence']=="admin") {
  
            $info="<li>";
            $info.="<a href='admin_user.php'>";
            $info.="<i class='fa fa-sign-out'></i> 返回管理者介面";
            $info.="</a>";
           $info.="</li>";
              echo $info;
          }
        ?>
                    <li>
                        <a href="login.php?logout=1">
                            <i class="fa fa-sign-out"></i> 登出
                        </a>
                    </li>
        
                </ul>

            </nav>
        </div>