<?php
class Func_Handler extends Connection
{
 public $db;
  function __construct()
  {
    $this->db=new Connection();
 
  }
  public function checkUser($userData = array())
    {   
        if (!empty($userData)) {
            
            $prevQuery = "SELECT * FROM tblssousers WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);
            if ($prevResult->num_rows > 0) {
               
                $query = "UPDATE tblssousers SET first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', modified = NOW() WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
            } else {
            
                $query = "INSERT INTO tblssousers SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', created = NOW(), modified = NOW()";
                $insert = $this->db->query($query);
                 
            }
             
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
			 
        }
         
        return $userData;
        
    } 
  public function getColumnData($tblname, $colname,$crcolname, $crvalue)
  {
		$columndata=$this->db->getRecord("SELECT ".$colname." FROM ". $tblname."  WHERE ".$crcolname." = '".$crvalue."' LIMIT 1 ");
		return $columndata;
  }

public  function rtw($amount)
{
 
$number =$amount;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred        :
            $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " "   . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  //$points = ($point) ? "." . $words[$point / 10] . " " .   $words[$point = $point % 10] : '';
  return $result . "Rupees  ";// . $points . " Paise";
 }
  
  function image($field_name,$action,$table_name,$sub_query,$t_h='',$t_w='')
	{
		$img_path="images/";
		$thumb_dir="";
		$thumb_path='images/thumb/';
		$image='';

		if($t_h!='' && $t_w!='')
		{
			$thumb_height=$t_h;
			$thumb_width=$t_w;

		}
		else
		{
			$thumb_height="120";
			$thumb_width="120";
		}

		if(isset($_FILES[$field_name]['name']) && $_FILES[$field_name]['name']!='')
		{
			$filename_err = explode(".",$_FILES[$field_name]['name']);
			$filename_err_count = count($filename_err);
			$file_ext = $filename_err[$filename_err_count-1];

			if(isset($action) && $action=="editsection")
			{
				$record = "select image from ".$table_name." where 1=1 ".$sub_query;

				$record=$this->db->getRecord($record);

				if ($action=="editsection" && file_exists($img_path.$record['image']))
				{
					@unlink($img_path.$record['image']);
					@unlink($thumb_path.$record['image']);
				}
			}
			$_POST['image'] = $image =$file_name= time().'_'.$_FILES[$field_name]['name'];
			if($file_name != '')
			{
				$fileName = $file_name;
			}
			else
			{
				$fileName = $_FILES[$field_name]['name'];
			}
				$tmpimage=$_FILES[$field_name]['tmp_name'];
				if(move_uploaded_file($tmpimage,$img_path.$image))
				{
					$thumbnail = $thumb_path.$fileName;
					list($width,$height) = getimagesize($img_path.$image);
					$upload_image=$img_path.$image;
					$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);

					switch($file_ext)
						{
							case 'jpg':
							$source = imagecreatefromjpeg($upload_image);
							break;
							case 'jpeg':
							$source = imagecreatefromjpeg($upload_image);
							break;
							case 'png':
							$source = imagecreatefrompng($upload_image);
							break;
							case 'gif':
							$source = imagecreatefromgif($upload_image);
							break;
							default:
							$source = imagecreatefromjpeg($upload_image);
						}

					imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);

					switch($file_ext)
						{
							case 'jpg' || 'jpeg':
							imagejpeg($thumb_create,$thumbnail,100);
							break;
							case 'png':
							imagepng($thumb_create,$thumbnail,100);
							break;
							case 'gif':
							imagegif($thumb_create,$thumbnail,100);
							break;
							default:
							imagejpeg($thumb_create,$thumbnail,100);
						}
				}

		}
		else if(isset($action) && $action == "editsection")
		{
			if(isset($_FILES[$field_name]['name']) && $_FILES[$field_name]['name']=='')
			{
				$image=$_POST['image_hidden'];
			}
		}
		return $image;
	}
 


}


 ?>
