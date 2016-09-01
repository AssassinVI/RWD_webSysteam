      $(document).ready(function() {
        var i=1;
         $(".tool_box_btn").click(function(event) {

          var in_name='bounceInUp';
          var out_name='fadeOutDown';
           
           if (i%2==1) {
           // $(".tool_lay").show();
           fadein_class(in_name,out_name);
           $("#tool_btn_div").animate({'bottom': '0'}, '500');
           $(".tool_box_btn").animate({'bottom':'140'}, '500');
           }
           else{

           fadeOut_class(in_name,out_name);
           $(".other_div").slideUp('500');
           $("#tool_btn_div").animate({'bottom': '-150'}, '500');
           $(".tool_box_btn").animate({'bottom':'0'}, '500');
           }

           i+=1;
         });

      });

      $(window).load(function() {
            $(window).bind('scroll resize', function() {　　

                var $this = $(this);　　
                var $this_Top = $this.scrollTop();
                var $document_bottom = $(document).height() - $(window).height() - 100;
                if ($this_Top > $document_bottom) {

                    $(".tool_box").stop().animate({
                        bottom: 255
                    }, 500);
                    
                    if ($(window).width()<=768) {
                      $(".tool_box_btn").hide().animate({'bottom':'0'}, '500');
                      $(".tool_lay").hide();
                      $("#tool_btn_div").hide().animate({'bottom':'-150'}, '500');
                    }
                }

                if ($this_Top < $document_bottom) {
                    $(".tool_box").stop().animate({
                        bottom: 0
                    }, 500);

                    if ($(window).width()<=768) {
                      $(".tool_box_btn").show();
                      $("#tool_btn_div").show();
                    }
                }　
            }).scroll();　
        });


      function fadein_class(in_name,out_name) {
        
          $("#gm_phl_btn").removeClass(out_name);
           $("#gm_home_btn").removeClass(out_name);
           $("#gm_work_btn").removeClass(out_name);
           $("#gm_food_btn").removeClass(out_name);
           $("#gm_school_btn").removeClass(out_name);
           $("#gm_fun_btn").removeClass(out_name);

           var t1=setTimeout('$("#gm_phl_btn").css("display", "inline-block").addClass("'+in_name+' animated")',200);
           var t2=setTimeout('$("#gm_home_btn").css("display", "inline-block").addClass("'+in_name+' animated")',400);
           var t3=setTimeout('$("#gm_work_btn").css("display", "inline-block").addClass("'+in_name+' animated")',600);
           var t4=setTimeout('$("#gm_food_btn").css("display", "inline-block").addClass("'+in_name+' animated")',0);
           var t5=setTimeout('$("#gm_school_btn").css("display", "inline-block").addClass("'+in_name+' animated")',800);
           var t6=setTimeout('$("#gm_fun_btn").css("display", "inline-block").addClass("'+in_name+' animated")',1000);
      }

      function fadeOut_class(in_name,out_name) {
        
           $("#gm_phl_btn").removeClass(in_name);
           $("#gm_home_btn").removeClass(in_name);
           $("#gm_work_btn").removeClass(in_name);
           $("#gm_food_btn").removeClass(in_name);
           $("#gm_school_btn").removeClass(in_name);
           $("#gm_fun_btn").removeClass(in_name);

           $("#gm_phl_btn").addClass(out_name).fadeOut('700');
           $("#gm_home_btn").addClass(out_name).fadeOut('700');
           $("#gm_work_btn").addClass(out_name).fadeOut('700');
           $("#gm_food_btn").addClass(out_name).fadeOut('700');
           $("#gm_school_btn").addClass(out_name).fadeOut('700');
           $("#gm_fun_btn").addClass(out_name).fadeOut('700');
      }