<?php  
         /*ini_set('display_errors', 1);
         ini_set('display_startup_errors', 1);
         error_reporting(E_ALL);*/
         require_once 'login.php';
         
         global $array;

           function getFile($n,$m) //return the string at the given position
           {
               $file = fopen("Files/posts.CSV", "r") or die("Unable to open file");
               $i = 0;
               $array = [];
                               
               while (($data = fgetcsv($file)) !== FALSE)
               {
               array_push($array,array("Key$i" => $data));//creating a mutil-dimensional array and pushing each array(line) from the csv file into it
           
               //$array = array("Key$i" => $data);
               
               $i++;
               $result = $array[$n]["Key$n"][$m];
               }      
               return $result;          
           }
            function getFirstThreeLines($text)//prints the first three sentences of a text file
            {
                $array1 = explode(".", $text);
                $i = 0;
                while ($i <= 3) 
                {
                echo $array1[$i] . ".";
                $i++;
                }
            }

           


           

                  

?>
