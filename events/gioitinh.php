<?php
$choice = $payload['choice'];

if($choice == "option_nam"){
	$conn->query("UPDATE `users` SET `genpairs`= 1 WHERE `mess_id` = '$userId'");
	$firstButton = $builder->createButton("postback", "Xác nhận", json_encode(array(
			"event" => "main_menu",
			"choice" => "option_nam"
		)));
		$menu = $builder->createButtonTemplate("❗Vui lòng nhấn xác nhận", [
		$firstButton,
	]);
			$bot->sendMessage($userId, $menu);
} else if ($choice == "option_nu"){
	$conn->query("UPDATE `users` SET `genpairs`= 0 WHERE `mess_id` = '$userId'");
	$firstButton = $builder->createButton("postback", "Xác nhận", json_encode(array(
			"event" => "main_menu",
			"choice" => "option_nam"
		)));
		$menu = $builder->createButtonTemplate("❗Vui lòng nhấn xác nhận", [
		$firstButton,
	]);
			$bot->sendMessage($userId, $menu);
} else {

}




?>