<?php
include("simple_html_dom.php");

$array = $fields = array();
$i = 0;


$html = file_get_html('https://www.barnesandnoble.com/b/coming-soon/books/_/N-1oyfZ29Z8q8');

if($html){
    
    print("Yes");
    
    
    print(count(@$html->find(".product-shelf-tile")));
    
    foreach(@$html->find(".product-shelf-tile") as $element)  { 
       
       if($element->find('.product-shelf-title',0))
       {
            echo "Project name: ",$element->find('.product-shelf-title',0)->innertext,"<br/>\n";
       }
       
       //echo "Image source: ",$element->find('img',0)->src,"<br/>\n";
       //echo "Link: ",$element->find('a',0)->href,"<br/>\n";
}
}


/*


$handle = @fopen("a.txt", "r");
if ($handle) 
{
    while (($row = fgetcsv($handle, 4096)) !== false) 
    {
        if (empty($fields)) 
        {
            $fields = $row;
            continue;
        }

        foreach ($row as $k=>$value) 
        {
            if($k==0){
                $html = file_get_html('https://www.amazon.com/s?k='.$value.'');
                
                $img_src=" ";

                if((@$html->find('a[class=a-link-normal] img')))
                {
                    $img_src = $html->find('a[class=a-link-normal] img', 0)->src;

                    $img_file_name =  substr($img_src, strrpos($img_src, '.' )+1);
                    $path = "image/";
                    $img = $path.$value.'.'.$img_file_name;

                   copy(''.$img_src.'', ''.$img.'');
                       
                }


                else
               {
                   $html = file_get_html('https://www.ebay.com/sch/i.html?_nkw='.$value.'');
                   if(@$html->find('li[class=s-item] img', 0)->src)
                   {
                    
                   $img_src = $html->find('li[class=s-item] img', 0)->src;
                   $img_file_name =  substr($img_src, strrpos($img_src, '.' )+1);
                   $path = "image/";
                   $img = $path.$value.'.'.$img_file_name;

                   copy(''.$img_src.'', ''.$img.'');
                   }
                   else{
                    $img = 'Not Available';
                   }
               }
			   
			   
			   echo '<pre>';
			   echo $value.'-------'.$img;
        }


            $key_val = str_replace(' ' , '_' , strtolower(trim($fields[$k])));

            if($key_val=='image'){

                 $array[$i][$key_val] = $img_src;
            }

            else{
                
                $array[$i][$key_val] = $value;
            }
        }

        $i++;
    }

    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

echo "<pre>";
#print_r($array['image']);
echo "</pre>";
*/
?>