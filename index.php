<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);


class Manage {
    public static function autoload($class) {

        include $class . '.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));


$obj = new main();


class main {

    public function __construct()
    {
        //print_r($_REQUEST);
        
        $pageRequest = 'homepage';
        
        if(isset($_REQUEST['page'])) {
        
            $pageRequest = $_REQUEST['page'];
        }
        
         $page = new $pageRequest;


        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $page->get();
        } else {
            $page->post();
        }

    }

}

abstract class page {
    protected $html;

    public function __construct()
    {
        $this->html .= '<html>';
        $this->html .= '<link rel="stylesheet" href="styles.css">';
        $this->html .= '<body>';
    }
    public function __destruct()
    {
        $this->html .= '</body></html>';
        stringFunctions::printThis($this->html);
    }

    public function get() {
        echo 'default get message';
    }

    public function post() {
        //print_r($_POST);
    }
}

class homepage extends page {

    public function get() {

        $form = '<form method="post" enctype="multipart/form-data">';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
        $form .= '<input type="submit" value="Upload Image" name="submit">';
        $form .= '</form> ';
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;
    }
    public function post(){
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $imageFileName = pathinfo($target_file,PATHINFO_BASENAME);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        header('Location: index.php?page=htmlTable&filename='.$imageFileName);
    
    }
}
class htmlTable extends page {

      public function get() {
      $tableDisplay="";
      $imageFileName = $_REQUEST['filename'];
       $file = fopen("uploads/".$imageFileName,"r");
       //fgetcsv($file));
       $tableDisplay .='<table style="width:100%">';
       while(! feof($file))
            {
                $table=(fgetcsv($file));
                 $arrlength = count($table);
                 $i=0;
                 
                /* w3 schools : echo "<table border='1'><br />";
                for ($row = 0; $row < 5; $row ++) 
                {
                    echo "<tr>";

                      for ($col = 1; $col <= 4; $col ++)
                       {
                          echo "<td>", ($col + ($row * 4)), "</td>";
                       }
                      echo "</tr>";
                }

                      echo "</table>";
                 
                

                //for($x = 0; $x < $arrlength; $x++)  
                //echo $table[$x];  
                //echo '';   */
                
	  
                    $tableDisplay .=  '<tr>';
                      for ($i=0;$i<$arrlength;$i++)
            	            {
                        $tableDisplay .='<td>'.$table[$i].'</td>';
	                        }
                     	$tableDisplay .='</tr>';
	
 	                   
               
       // $tableDisplay .='<tr><td>'.$table[$arrlength].'</td></tr>';//.'</td><td>'.$table[1].'</td><td>'.$table[2].'</td></tr>';
  
                
            }
            $tableDisplay .='</table>';
           print($tableDisplay);
       fclose($file);
       
      /* $output = '';
       $rowcount = 0;
 
       $output .= "<table class='table'>";
       foreach ($table as $row):{
           $output .= "<tr class='tablerow'>";
           $celltype = ($header && $rowcount == 0) ? "th" : "td";
                 foreach ($row as $col){
                      $output .= "<" . $celltype . " class='tablecell'>";
                      $output .= $col;
                      $output .= "</" . $celltype . ">";
                 endforeach;
                 }
           $output .= "</tr>";
           $rowcount++;
       endforeach;
       }
       $output .= "</table>";
 
       return $output;*/
       
          
    }
       
}

  class stringFunctions {
     static public function printThis($inputText) {
        return print($inputText);
     }
     static public function stringLength($text) {
        return strLen($text);
     }	
  }

 
?>

