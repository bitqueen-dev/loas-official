<?php
foreach ($infos as $k => $info) {
	if ($k=='nickname') {
		$k = "ニックネーム";
	} elseif ($k=='subject') {
		$k = "お問い合わせ項目";
	} elseif ($k=='server') {
		$k = "サーバー";
	} elseif ($k=='email') {
		$k = "メールアドレス";
	} elseif ($k=='emailConfirm') {
		continue;
	} elseif ($k=='time') {
		$k = "発生日時";
	} elseif ($k=='content') {
		$k = "お問い合わせ内容";
	} elseif ($k=='userId') {
		$k = "ユーザーID";
	}
	echo $k . ': ' . $info . "<br /><br />";
}
echo "HTTP_USER_AGENT: " . $_SERVER['HTTP_USER_AGENT'] . '<br /><br />';
?>