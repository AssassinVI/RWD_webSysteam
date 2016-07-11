<?php
  function create_dir($case_id)
  {
     mkdir($case_id);
     mkdir($case_id.'/assets');
     mkdir($case_id.'/assets/images');
     mkdir($case_id.'/music');
     mkdir($case_id.'/zip');

  }

/* ==================================== 複製資料夾 ======================================== */
      function copy_dir($from_dir,$to_dir){  
        if(!is_dir($from_dir)){   //判斷有無要複製的資料夾
            return false ;  
        } 
        
      //  echo "<br>From:",$from_dir,' --- To:',$to_dir;  
        $from_files = scandir($from_dir);   //讀取資料夾裡有的檔案，array顯示

        if(!file_exists($to_dir)){  //判斷有無要貼上的資料夾
            mkdir($to_dir);  //產生資夾    
        }  
        if( ! empty($from_files)){  

            foreach ($from_files as $file){   
                if($file == '.' || $file == '..' ){  //判別虛擬資料夾
                    continue;  
                }  
                  
                if(is_dir($from_dir.'/'.$file)){
                    copy_dir($from_dir.'/'.$file,$to_dir.'/'.$file);  
                }else{
                    copy($from_dir.'/'.$file,$to_dir.'/'.$file);  
                }  
            }  
        }
        return true ;
    }
?>