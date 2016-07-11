      $(document).ready(function() {
        var i=1;
         $(".tool_box_btn").click(function(event) {
           
           if (i%2==1) {
            $(".tool_lay").show();

           $("#gm_phl_btn").animate({left: "18%", bottom: "74px"}, 500);
           $("#gm_home_btn").animate({left: "22%", bottom: "127px"}, 500);
           $("#gm_work_btn").animate({left: "36%", bottom: "164px"}, 500);
           $("#gm_food_btn").animate({left: "52%", bottom: "164px"}, 500);
           $("#gm_school_btn").animate({left: "66%", bottom: "127px"}, 500);
           $("#gm_fun_btn").animate({left: "70%", bottom: "74px"}, 500);

           $("#gm_phl_btn").addClass('rotate');
           $("#gm_home_btn").addClass('rotate');
           $("#gm_work_btn").addClass('rotate');
           $("#gm_food_btn").addClass('rotate');
           $("#gm_school_btn").addClass('rotate');
           $("#gm_fun_btn").addClass('rotate');
           }
           else{

           $("#gm_phl_btn").animate({left: "44%", bottom: "0px"}, 500);
           $("#gm_home_btn").animate({left: "44%", bottom: "0px"}, 500);
           $("#gm_school_btn").animate({left: "44%", bottom: "0px"}, 500);
           $("#gm_fun_btn").animate({left: "44%", bottom: "0px"}, 500);
           $("#gm_food_btn").animate({left: "44%", bottom: "0px"}, 500);
           $("#gm_work_btn").animate({left: "44%", bottom: "0px"}, 500);


           $("#gm_phl_btn").removeClass('rotate');
           $("#gm_home_btn").removeClass('rotate');
           $("#gm_work_btn").removeClass('rotate');
           $("#gm_food_btn").removeClass('rotate');
           $("#gm_school_btn").removeClass('rotate');
           $("#gm_fun_btn").removeClass('rotate');
           $(".other_div").slideUp('500');
           }

           i+=1;
         });

      });