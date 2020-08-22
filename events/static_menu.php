<?php
$choice = $payload['choice'];
if ($choice == "show_menu") {
	if ($user['state'] == 0) {
		// currently have no action
				$firstButton = $builder->createButton("postback", "👨 Male", json_encode(array(
		"event" => "main_menu",
		"choice" => "option_nam"
		)));
		$secondButton = $builder->createButton("postback", "👩 Female", json_encode(array(
		"event" => "main_menu",
		"choice" => "option_nu"
		)));
		$menu = $builder->createButtonTemplate("Choose the gender you want to connect:", [
		$firstButton,
		$secondButton,
	]);
	$bot->sendMessage($userId, $menu);
	} else if ($user['state'] == 1) {
		// currently waiting for other participant
		$firstButton = $builder->createButton("postback", "Exit", json_encode(array(
			"event" => "main_menu",
			"choice" => "cancel_find_friend"
		)));
		$menu = $builder->createButtonTemplate("❗ Looking for the right gender, do you want to exit?", [
		$firstButton,
	]);
			$bot->sendMessage($userId, $menu);
	} else {
		// currently in conversation
		$firstButton = $builder->createButton("postback", "Exit", json_encode(array(
			"event" => "main_menu",
			"choice" => "quit_conversation"
		)));
		$menu = $builder->createButtonTemplate("❗ During a chat, do you want to exit?", [
		$firstButton,
	]);
	$bot->sendMessage($userId, $menu);
	}
} elseif ($choice == "show_about") {
		
} else {
	
}
?>
