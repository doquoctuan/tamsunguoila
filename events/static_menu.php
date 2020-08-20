<?php
$choice = $payload['choice'];
if ($choice == "show_menu") {
	if ($user['state'] == 0) {
		// currently have no action
				$firstButton = $builder->createButton("postback", "👨 Nam", json_encode(array(
		"event" => "main_menu",
		"choice" => "option_nam"
		)));
		$secondButton = $builder->createButton("postback", "👩 Nữ", json_encode(array(
		"event" => "main_menu",
		"choice" => "option_nu"
		)));
		$menu = $builder->createButtonTemplate("Chọn giới tính muốn ghép cặp", [
		$firstButton,
		$secondButton,
	]);
	$bot->sendMessage($userId, $menu);
	} else if ($user['state'] == 1) {
		// currently waiting for other participant
		$firstButton = $builder->createButton("postback", "Thoát hàng đợi", json_encode(array(
			"event" => "main_menu",
			"choice" => "cancel_find_friend"
		)));
		$menu = $builder->createButtonTemplate("❗ Đang trong hàng đợi! Bạn có muốn thoát hàng đợi không?", [
		$firstButton,
	]);
			$bot->sendMessage($userId, $menu);
	} else {
		// currently in conversation
		$firstButton = $builder->createButton("postback", "Thoát trò chuyện", json_encode(array(
			"event" => "main_menu",
			"choice" => "quit_conversation"
		)));
		$menu = $builder->createButtonTemplate("❗ Đang trong cuộc trò chuyện! Bạn có muốn thoát trò chuyện không?", [
		$firstButton,
	]);
	$bot->sendMessage($userId, $menu);
	}
} elseif ($choice == "show_about") {
		
} else {
	
}
?>