<?php
	$str=$_SERVER['QUERY_STRING'];
        if($str==""){
                Header("Location: README_JUMP");
                return;
        }
	$url=$_GET['url'];
	$referer=$_GET['referer'];
	$type=$_GET['type'];
	$adid=$_GET['adid'];

	$url=urldecode($url);
	$referer=urldecode($referer);


	$today=date("Ymd");
	$data_path="new_$today";
	if(file_exists($data_path)){
        }else{
                mkdir($data_path);
        }


	$referer1=str_replace("/", "", $referer);

	if( $type == 1 ){ 
		$data=shell_exec("sudo /bin/phantomjs fake-referrer.js \"$url\" \"$referer\" 1 \"$adid\" 2>>err");
		$status=check_status($data,$referer1);
		if( $status == false ){
			$data=shell_exec("sudo /bin/phantomjs fake-referrer.js \"$url\" \"$referer\" 1 \"$adid\" 2>>err");
			$status=check_status($data,$referer1);
			if( $status == true ){
				echo $data;
			}
			else{
                                $data=post_process($data, $referer1);
                                echo $data;
                        }
		}
		else
			echo $data;
	}else if ( $type == 2 ){
		$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 2 \"$adid\" 2>>err");
		$arr = split("\n", $data);
		$status=check_status($arr[0],$referer1);
		if( $status == true ){
			unset($arr[0]);
			$data=implode("\n",$arr);

			echo $data;
		}else{
			$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 2 \"$adid\" 2>>err");
			$arr = split("\n", $data);
			$status=check_status($arr[0],$referer1);
			if( $status == true ){
				unset($arr[0]);
				$data=implode("\n",$arr);
				echo $data;
			}
		}
	}else if ( $type == 3 ){
		$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 3 \"$adid\" 2>>err");
		$status=check_status($data,$referer1);
		if( $status == true ){
			echo $data;
		}else{
			$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 3 \"$type\" 2>>err");
			$status=check_status($data,$referer1);
			if( $status == true ){
				echo $data;
			}
			else{
				$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 3 \"$type\" 2>>err");
				$status=check_status($data,$referer1);
				if( $status == true ){
					echo $data;
				}
				else{
					$data=post_process($data, $referer1);
					echo $data;
				}
			}
		}
	}else if ( $type == 4 ){
		$data=shell_exec("sudo /bin/phantomjs fake-referrer.js \"$url\" \"$referer\" 4 \"$adid\" 2>>err");
                $status=check_status($data,$referer1);
                if( $status == false ){
                        $data=shell_exec("sudo /bin/phantomjs fake-referrer.js \"$url\" \"$referer\" 4 \"$adid\" 2>>err");
                        $status=check_status($data,$referer1);
                        if( $status == true ){
				$fullPath="$data_path/".$adid.".jpg";
				header("Content-type:image/jpeg");
				header("Content-Disposition:attachment;filename=$adid.jpg");
		                $getCon=file_get_contents($fullPath);
				echo $getCon;
                        }
                }
                else{
			$fullPath="$data_path/".$adid.".jpg";
			header("Content-type:image/jpeg");
			header("Content-Disposition:attachment;filename=$adid.jpg");
		        $getCon=file_get_contents($fullPath);
			echo $getCon;
		}
	}else if ( $type == 5 ){
		$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 3 \"$adid\" 2>>err");
		$status=check_status($data,$referer1);
		if( $status == true ){
		}else{
			$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 3 \"$type\" 2>>err");
			$status=check_status($data,$referer1);
			if( $status == true ){
			}
		}
		$data=str_replace("\n", "", $data);
		$data1=shell_exec("sudo sh bad_url.sh \"$url\" 2>>err");
		$data=$data."\t".$data1;
		echo $data;
	}else if ( $type == 6 ){
		$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 2 \"$adid\" 2>>err");
		$arr = split("\n", $data);
		$status=check_status($arr[0],$referer1);
		if( $status == true ){
			//echo $data;
		}else{
			$data=shell_exec("sudo /bin/phantomjs --load-images=false fake-referrer.js \"$url\" \"$referer\" 2 \"$adid\" 2>>err");
			$arr = split("\n", $data);
			$status=check_status($arr[0],$referer1);
			if( $status == true ){
				//echo $data;
			}
		}
		$arr = split("\n", $data);
		$arr[0]=post_process($arr[0],$referer1);
		$data=implode("\n",$arr);
		echo $data;
	}else if ( $type == 7 ){
		$data=shell_exec("sudo sh bad_url.sh \"$url\" 2>>err");
		echo $data;
	}else if ( $type == 8 ){
		shell_exec("sudo sh kill.sh 1>>err 2>>err");
		shell_exec("sudo sh kill.sh 1>>err 2>>err");
		shell_exec("sudo sh kill.sh 1>>err 2>>err");
	}

	function check_status( $data , $referer1 )
	{
		if( $data == "" ){
			return false;
		}
		$data=str_replace("\n","",$data);

		$data1=str_replace("/","",$data);

		$arr = split("\t", $data1);
		
		if( count($arr) > 1 ){
			if( $arr[1] == $referer1 || $arr[1] == "about:blank" ){
				return false;
			}
		}
		return true;
	}
	function post_process( $data, $referer1 )
	{
		$data=str_replace("\n","",$data);
		$arr = split("\t", $data);
		$url1 = $arr[0];
		$url2 = $arr[1];

		$url1_1=str_replace("/","",$url1);
		$url2_1=str_replace("/","",$url2);

		if( $url2_1 == $referer1 || $url2_1 == "about:blank" ){
			return $url1."\t".$url1;
		}
		else
			return $data;
	}
?>
