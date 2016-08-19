<div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">

        <?php 

          require_once 'check_phone.php';

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
                        <a id="logout_btn" href="#">
                            <i class="fa fa-sign-out"></i> 登出
                        </a>
                    </li>
            
            <?php

              if (check_mobile()) {
                  
                  $back='<li style=" float: right; margin-right: 10px;">';
                 $back.=   '<a href="javascript:history.back()">'; 
                 $back.=      '<i class="fa fa-reply"></i> 返回'; 
                 $back.=   '</a>'; 
                 $back.='</li>';
                 echo $back;
              }
            ?>
        
                </ul>

            </nav>
        </div>
        <script type="text/javascript">
            $("#logout_btn").click(function(event) {
               event.preventDefault();
               if (confirm("是否要登出??")) {
                   location.replace('login.php?logout=1');
               }
            });
        </script>
    