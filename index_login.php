<?

echo "<pre>";
var_dump($_SERVER);
//session_start();
//if(isset($_COOKIES['logged']) && $_SESSION['logged'] === 'DSFn()DFb(D_FB#&$BFDOF&^D dsFDS(DS*F^BSDF#BF*DSF(') {
//	Header('Location: http://' . $_SERVER['HTTP_HOST']);
//	die;
//}
if(isset($_POST['username']) && $_POST['username'] === 'test' &&
	isset($_POST['password']) && $_POST['password'] === 'J3f_65pdr()ak') {
//	$_SESSION['logged'] = 'DSFn()DFb(D_FB#&$BFDOF&^D dsFDS(DS*F^BSDF#BF*DSF(';
	setcookie('romaksenia', 'DSFn()DFb(D_FB#&$BFDOF&^D dsFDS(DS*F^BSDF#BF*DSF(', time() + 3600 * 24 * 30);
	Header('Location: http://' . $_SERVER['HTTP_HOST'] );
	return;
}
?>

<form method="post">
	%username%: <input type="text" name="username" /><br />
	%password%: <input type="password" name="password" /><br />
	<input type="submit" name="login">

</form>
