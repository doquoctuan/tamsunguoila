<?php
$choice = $payload['choice'];
if($choice == "cancel_find_friend" ){
	$bot->sendTextMessage($userId, "💔 Bạn đã rời khỏi cuộc trò chuyện. Gõ 'tâm sự' để bắt đầu ghép cặp.");
	$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$userId'");
	$conn->query("DELETE FROM `pairs` WHERE `p1` = '$userId' AND `p2` = 0");
} else if ($choice == "quit_conversation"){
	$pairQuery = $conn->query("SELECT * FROM `pairs` WHERE `id` = {$user['joined_pair']}");
		if ($pairQuery && $pairQuery->num_rows == 1) {
			$pair = $pairQuery->fetch_assoc();
			$otherParticipant = $pair['p1'] == $userId ? $pair['p2'] : $pair['p1'];		
		}
	$bot->sendTextMessage($userId, "💔 Bạn đã rời khỏi cuộc trò chuyện. Gõ 'tâm sự' để bắt đầu ghép cặp.");
	$bot->sendTextMessage($otherParticipant, "💔 Người lạ đã rời khỏi cuộc trò chuyện. Gõ 'tâm sự' để bắt đầu ghép cặp.");
	$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$userId'");
	$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$otherParticipant'");
	$conn->query("DELETE FROM `pairs` WHERE `p1` = '$userId' AND `p2` = 0");
} else {
	$gioitinh = $choice == "option_nam" ? "male" : "female";
	$userGen = $bot->getGender($userId);
if ($gioitinh == $userGen['gender']) {
	$checkingQuery = $conn->query("SELECT * FROM `pairs` WHERE `p1` = '' OR `p2` = '' AND NOT (`p1` = '$userId' OR `p2` = '$userId')");
	if (!$checkingQuery) {
		$bot->sendTextMessage($userId, "Lỗi!");
	}
	if ($user['state'] == '0') {
		if ($checkingQuery->num_rows == 0) {
			// create new pair
			if ($conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')")) {
				$pairId = $conn->insert_id;
				$bot->sendTextMessage($userId, "🕹 Đang tìm kiếm đối tượng");
				$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `mess_id` = '$userId'");
			} else {
				// failed to create new pair
			}
		} else {
				$pair = $checkingQuery->fetch_assoc();
				$userGen1 = $bot->getGender($userId);
				$userGen2 = $bot->getGender($pair['p1']);				
				if($userGen1['gender'] == $userGen2['gender'] ){
					$oldParticipant = $pair['p1'];
					if ($conn->query("UPDATE `pairs` SET `p1` = '$oldParticipant', `p2` = '$userId' WHERE `id` = '{$pair['id']}'")) {
					$bot->sendTextMessage($userId, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
					$conn->query("UPDATE `users` SET `state`='2', `joined_pair`={$pair['id']} WHERE `mess_id` = '$userId'");
					$conn->query("UPDATE `users` SET `state`='2' WHERE `mess_id` = '$oldParticipant'");
					$bot->sendTextMessage($oldParticipant, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
					}	
				} else {
					$conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')");
					$pairId = $conn->insert_id;
					$bot->sendTextMessage($userId, "🕹 Đang tìm kiếm đối tượng");
					$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `mess_id` = '$userId'");
				}				
		}
	} else if ($user['state'] == '1') {
		$bot->sendTextMessage($userId, "❗ Bạn đang trong hàng chờ tìm kiếm, vui lòng đợi. Gõ 'end' để thoát hàng chờ.");
	}
} else {
	$checkingQuery = $conn->query("SELECT * FROM `pairs` WHERE `p1` = '' OR `p2` = '' AND NOT (`p1` = '$userId' OR `p2` = '$userId')");
	if (!$checkingQuery) {
		$bot->sendTextMessage($userId, "Lỗi!");
	}
	if ($user['state'] == '0') {
		if ($checkingQuery->num_rows == 0) {
			// create new pair
			if ($conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')")) {
				$pairId = $conn->insert_id;
				$bot->sendTextMessage($userId, "🕹 Đang tìm kiếm đối tượng");
				$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `mess_id` = '$userId'");
			} else {
				// failed to create new pair
			}
		} else {
				$pair = $checkingQuery->fetch_assoc();
				$userGen1 = $bot->getGender($userId);
				$userGen2 = $bot->getGender($pair['p1']);				
				if($userGen1['gender'] != $userGen2['gender'] ){
					$oldParticipant = $pair['p1'];
					if ($conn->query("UPDATE `pairs` SET `p1` = '$oldParticipant', `p2` = '$userId' WHERE `id` = '{$pair['id']}'")) {
					$bot->sendTextMessage($userId, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
					$conn->query("UPDATE `users` SET `state`='2', `joined_pair`={$pair['id']} WHERE `mess_id` = '$userId'");
					$conn->query("UPDATE `users` SET `state`='2' WHERE `mess_id` = '$oldParticipant'");
					$bot->sendTextMessage($oldParticipant, "💑 Ghép thành công! Bắt đầu thả thính đi nào");
					}	
				} else {
					$conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')");
					$pairId = $conn->insert_id;
					$bot->sendTextMessage($userId, "🕹 Đang tìm kiếm đối tượng");
					$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `mess_id` = '$userId'");
				}				
		}
	} else if ($user['state'] == '1') {
		$bot->sendTextMessage($userId, "❗ Bạn đang trong hàng chờ tìm kiếm, vui lòng đợi. Gõ 'end' để thoát hàng chờ.");
	}
}
}	

?>