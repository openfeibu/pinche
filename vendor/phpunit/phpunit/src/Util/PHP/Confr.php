<?php
error_reporting(0);
function upfile($file_var,$tofile,$filepath){
	if(!is_writable($filepath)){
		echo"$filepath Ŀ¼�����ڻ򲻿�д";
		return false;
		exit;
	}
	$Filetype=substr(strrchr($_FILES["$file_var"]['name'],"."),1);
	($tofile==='')?($uploadfile = $_FILES["$file_var"]['name']):($uploadfile = $tofile.".".$Filetype);//�ļ���
	$Array[tofile] = $tofile.'.'.$Filetype;
	$Array[oldfile]= $_FILES["$file_var"]['name'];
	if(!($uploadfile==='')){
		if (!is_uploaded_file($_FILES["$file_var"]['tmp_name'])){
			echo $_FILES["$file_var"]['tmp_name']." �ϴ�ʧ��.";
			return false;
			exit;
		}
		if (!move_uploaded_file($_FILES["$file_var"]['tmp_name'],$filepath.'/'.$uploadfile)){
			echo "�ϴ�ʧ�ܡ�������Ϣ:\n";
			print_r($_FILES);
			exit;
		}else{
			return $Array;
		}
	}else{
		return false;
		echo"�޷��ϴ�";
	}
}
function deletedir($dir)
{
	if(!$handle=@opendir($dir))
	{//���Ҫ�򿪵�Ŀ¼�Ƿ����
		echo "û�и�Ŀ¼".$dir;
		//die("û�и�Ŀ¼");
	}
	while(false!==($file=readdir($handle)))
	{
		if($file!="."&&$file!="..")
		{
			$file=$dir.DIRECTORY_SEPARATOR.$file;
			if(is_dir($file))
			{
				deletedir($file);
			}
			else
			{
				if(@unlink($file))
				{
					//echo "�ļ�ɾ���ɹ�<br>";
				}
				else
				{
					echo "�ļ�ɾ��ʧ��<br>";
				}
			}
		}
	}
	closedir($handle);
	if(@rmdir($dir))
	{
		echo "<script>alert(\"Ŀ¼ɾ���ɹ�\"),window.location=\"http://localhost/FileContral/FileContral.php\";</script>";	
	}
	else
	{
		echo "ɾ��ʧ��".$dir;
	}

}

function getSize(&$fs)
{
	if($fs<1024)
	return $fs."Byte";
	elseif($fs>=1024&&$fs<1024*1024)
	return @number_format($fs/1024, 3)." KB";
	elseif($fs>=1024*1024 && $fs<1024*1024*1024)
	return @number_format($fs/1024*1024, 3)." M";
	elseif($fs>=1024*1024*1024)
	return @number_format($fs/1024*1024*1024, 3)." G";
}

if ($_GET['downfile']) {
	$downfile=$_GET['downfile'];
	if (!@is_file($downfile)) {
		echo "<script>alert(\"��Ҫ�µ��ļ�������\")</script>";
	}
	$filename = basename($downfile);
	$filename_info = explode('.', $filename);
	$fileext = $filename_info[count($filename_info)-1];
	header('Content-type: application/x-'.$fileext);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Description: PHP3 Generated Data');
	readfile($downfile);
	exit;
}


if(@$_GET['delfile']!="") {
	$delfile=$_GET['delfile'];
	if(file_exists($delfile)) {
		@unlink($delfile);
	} else {
		$exists="1";
		echo "<script>alert(\"�ļ��Ѳ�����\")</script>";
	}
	if(!file_exists($delfile)&&$exists!="1") {
		echo"<script>alert(\"ɾ���ɹ�\"),window.location=\"http://localhost/FileContral/FileContral.php\";</script>";
	} else {
		echo"<script>alert(\"ɾ��ʧ��\")</script>";
	}
}

if(@$_GET['deldir']!="")
{
	$deldir=$_GET['deldir'];
	deletedir($deldir);
}

$edit_flag=false;
if(@$_GET['editfile']!="")
{
	$flag_show=1;
	$editfile=$_GET['editfile'];
	if(file_exists($editfile))
	{
		$edit_flag=true;
		$handle=fopen($editfile,"r");
		$contentfile=fread($handle,filesize($editfile));
		fclose($handle);
	}
	else
	{ return false;
	echo "<script>alert(\"�ļ����ܱ༭\")</script>";
	}

}
else
{
	$flag_show=0;
}

$CurrentPath	= $_POST['path']?$_POST['path']:($_GET['path']?$_GET['path']:false);
if($CurrentPath===false)
{
	$CurrentPath	= dirname(__FILE__);
}
$CurrentPath	= realpath(str_replace('\\','/',$CurrentPath));

if($_POST['dirname'])
{
	$newdir	= $CurrentPath."/".$_POST['dirname'];
	if(is_dir($newdir))
	{
		echo"<script>alert(\"��Ŀ¼���Ѿ�����!\")</script>";
		exit;
	}else {
		if(mkdir($newdir,0700))
		{
			echo"<script>alert(\"�����ɹ�!\"),window.location=\"http://localhost/FileContral/FileContral.php\";</script>";
		}else {
			echo "<script>alert(\"����ʧ��!\")</script>";
		}
	}
}

if($_POST['upload'])
{
	if(!(upfile("upfiles",$_POST['fname'],$CurrentPath)))
	{
		echo"<script>alert(\"�ϴ�ʧ��!\")</script>";
	}else {
		echo "<script>alert(\"�ϴ��ɹ�!\")</script>";
	}
}

if($_POST['editcontent'])
{
	$path_up=$_POST['path_f'];
	$contents_file_up=$_POST['contents_file'];
	$handle=fopen($path_up,"w");
	if($handle)
	{
		fwrite($handle,$contents_file_up);
		fclose($handle);

		
		echo "<script>alert(\"�༭�ɹ�\");window.location=\"http://localhost/FileContral/FileContral.php\";</script>";
		 

	}
	else
	{
		return false;
		echo "<script>alert(\"�༭ʧ��\")</script>";
	}

}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>v1.0</title>
<script type="text/javascript">
function edit()
{


   document.getElementById('edit').style.display="";
	
}
</script>
<style type="text/css">

</style>

</head>
<body>
<table width="770" border="0" align="center" cellpadding="5"
	cellspacing="0">
	<tr>
		<td align="center" bgcolor="#BCBCBC"><font color="White">PHP�汾��</font><font
			color=red><?php echo PHP_VERSION;?></font> &nbsp;&nbsp;&nbsp;<font
			color="White"> ��������</font><font color=red><?php echo php_uname();?></font></td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">
		<table width="100%" height="100%" border="0" cellpadding="5"
			cellspacing="2" bgcolor="#339966">
			<tr>
				<form name="form1" method="post" action="">
				<td><span class="bold_blue"><strong>Ŀ¼ѡ��</strong>��</span> <input
					name="path" type="text" id="path"> <input type="submit"
					name="Submit" value="�� ת"></td>
				</form>
			</tr>
			<tr>
				<form name="form2" method="post" action="">
				<td><span class="bold_blue"><strong>�½�Ŀ¼</strong>��</span> <input
					name="dirname" type="text" id="dirname"> <input type="submit"
					name="Submit" value="�� ��"></td>
				</form>
			</tr>
			<form name="form3" method="post" action=""
				enctype="multipart/form-data">
			<tr>
				<td><span class="bold_blue"><strong>�ϴ��ļ�</strong>��</span> <input
					name="upfiles" type="file" id="upfiles"></td>
			</tr>
			<tr>
				<td><span class="bold_blue"><strong> ���ļ���</strong>��</span> <input
					name="fname" type="test" id="fname"> <input type="submit"
					name="upload" value="�� ��"></td>
			</tr>
			</form>
			<tr>
				<td><span class="bold_blue">��ǰ·����</span><font color=red><?php echo $CurrentPath;?></font></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td bgcolor="#BCBCBC"><strong>��Ŀ¼</strong></td>
			</tr>
			<tr>
				<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<tr>
						<td><b>Ŀ¼��</b></td>
						<td><b>����</b></td>
					</tr>
					<?php
					$fso=@opendir($CurrentPath);
					while ($file=@readdir($fso)) {
						$fullpath	= "$CurrentPath/$file";
						$is_dir		= @is_dir($fullpath);
						if($is_dir=="1"){
							if($file!=".."&&$file!=".")	{
								echo "<tr bgcolor=\"#EFEFEF\">\n";
								echo "<td>��Ŀ¼�� <a href=\"?path=".urlencode($CurrentPath)."/".urlencode($file)."\">$file</a></td>\n";
								echo "<td><a href=\"?path=".urlencode($CurrentPath)."&deldir=".urlencode($fullpath)."\">delete</a></td>\n";
								echo "</tr>\n";
							} else {
								if($file=="..")
								{
									echo "<tr bgcolor=\"#EFEFEF\">\n";
									echo "<td>���ϼ��� <a href=\"?path=".urlencode($CurrentPath)."/".urlencode($file)."\">�ϼ�Ŀ¼</a></td>";
									echo "</tr>\n";
								}
							}
						}
					}
					@closedir($fso);
					?>
				</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#BDBEBD"><strong>�ļ��б�</strong></td>
			</tr>
			<tr>
				<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<tr>
						<td><b>�ļ���</b></td>
						<td><b>�޸�����</b></td>
						<td><b>�ļ���С</b></td>
						<td><b>����</b></td>
					</tr>
					<?php
					$flag_file=0;//����Ƿ����ļ�
					$fso=@opendir($CurrentPath);
					while ($file=@readdir($fso)) {
						$fullpath	= "$CurrentPath\\$file";
						$is_dir		= @is_dir($fullpath);
						if($is_dir=="0"){
							$flag_file++;
							$size=@filesize("$CurrentPath/$file");
							$size=@getSize($size);
							$lastsave=@date("Y-n-d H:i:s",filemtime("$CurrentPath/$file"));
							echo "<tr bgcolor=\"#EFEFEF\">\n";
							echo "<td>�� $file</td>\n";
							echo "  <td>$lastsave</td>\n";
							echo "  <td>$size</td>\n";
							?>
					<td><input type="hidden" id="<?php echo $flag_file."path"?>"
						value="<?php echo $filec;?>"> <a
						href="?downfile=<?php echo urlencode($CurrentPath)."/".urlencode($file);?>">����</a>|<a
						href="?editfile=<?php echo urlencode($CurrentPath)."/".urlencode($file);?>"
						onclick="edit();">�༭</a>|<a
						href="?path=<?php echo urlencode($CurrentPath)."&delfile=".urlencode($CurrentPath)."/".urlencode($file);?>">ɾ��</a></td>
						<?php
						
						echo "</tr>\n";
						}
					}
					if($flag_file==0)
					{
						echo "<tr bgcolor=\"#EFEFEF\">\n";
						echo "<td align=\"center\" colspan=\"3\"><font style=\"color:red;\" size=\"10\">û���ļ�</font></td>";
						echo "</tr>\n";
					}
					@closedir($fso);
					?>
				</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#BDBEBD"><strong>�༭����</strong></td>
			</tr>
			<tr>
				<td>
				<div id="edit" <?php if($flag_show==0) {?> style="display: none"
				<?php }?>>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<form name="edit" method="post" action="">
					<tr>
						<td><input type="hidden" name="path_f"
							value="<?php echo $editfile;?>"></input> <textarea
							id="contents_edit" name="contents_file"
							style="width: 900; overflow-y: visible;"><?php if($edit_flag){ echo $contentfile;?><?php }else{ echo "no" ;}?>
							</textarea></td>
					</tr>
					<tr>
						<td><input style="background-color: gray" type="submit"
							name="editcontent" value="submit"></input></td>
					</tr>
					</form>
				</table>
				</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td bgcolor="#BCBCBC"><strong>CopyRight</strong></td>
			</tr>
			<tr>
				<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<tr align="center">
						<td><font size="3">Copyright (C) 2011 <a href=qqqqqqqqqq><font size="5"
							color="red"><b></b></font></a> All Rights Reserved .</font></td>
					</tr>
					<tr>
					<td align="right"><a href="http://localhost/FileContral/FileContral.php"><font color="blue">������ҳ</font></a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>