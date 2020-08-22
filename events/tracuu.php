<?php
$choice = $payload['choice'];

if($choice == "option_nam"){
    $conn->query("UPDATE `users` SET `gender`= 1 WHERE `mess_id` = '$userId'");
    		$firstButton = $builder->createButton("postback", "Tâm sự người lạ", json_encode(array(
			"event" => "static_menu",
			"choice" => "show_menu"
		)));
		$menu = $builder->createButtonTemplate("Bạn đã chọn giới tính là Nam. Nhấn vào nút bên dưới để ghép cặp.", [
		$firstButton,
	]);
			$bot->sendMessage($userId, $menu);
} else if ($choice == "option_nu"){
    $conn->query("UPDATE `users` SET `gender`= 0 WHERE `mess_id` = '$userId'");
    $firstButton = $builder->createButton("postback", "Tâm sự người lạ", json_encode(array(
			"event" => "static_menu",
			"choice" => "show_menu"
		)));
		$menu = $builder->createButtonTemplate("Bạn đã chọn giới tính là Nữ. Nhấn vào nút bên dưới để ghép cặp.", [
		$firstButton,
	]);
			$bot->sendMessage($userId, $menu);
} else {

}

?>