      $(document).ready(function() {
        var i=1;
         $(".tool_box_btn").click(function(event) {

          var in_name='bounceInUp';
          var out_name='fadeOutDown';
           
           if (i%2==1) {
           // $(".tool_lay").show();
           fadein_class(in_name,out_name);
           }
           else{

           fadeOut_class(in_name,out_name);
           $(".other_div").slideUp('500');
           }

           i+=1;
         });

      });


      function fadein_class(in_name,out_name) {
        
          $("#gm_phl_btn").removeClass(out_name);
           $("#gm_home_btn").removeClass(out_name);
           $("#gm_work_btn").removeClass(out_name);
           $("#gm_food_btn").removeClass(out_name);
           $("#gm_school_btn").removeClass(out_name);
           $("#gm_fun_btn").removeClass(out_name);

           var t1=setTimeout('$("#gm_phl_btn").show().addClass("'+in_name+' animated")',200);
           var t2=setTimeout('$("#gm_home_btn").show().addClass("'+in_name+' animated")',400);
           var t3=setTimeout('$("#gm_work_btn").show().addClass("'+in_name+' animated")',600);
           var t4=setTimeout('$("#gm_food_btn").show().addClass("'+in_name+' animated")',0);
           var t5=setTimeout('$("#gm_school_btn").show().addClass("'+in_name+' animated")',800);
           var t6=setTimeout('$("#gm_fun_btn").show().addClass("'+in_name+' animated")',1000);
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