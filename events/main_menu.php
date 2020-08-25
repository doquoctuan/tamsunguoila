<?php
$choice = $payload['choice'];

if($choice == "cancel_find_friend" ){
	$bot->sendTextMessage($userId, "💔 Bạn đã rời khỏi cuộc trò chuyện. Gõ 'tâm sự' để bắt đầu ghép cặp.");
	$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$userId'");
	$conn->query("DELETE FROM `pairs` WHERE `p1` = '$userId' AND `p2` = ''");
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
	$conn->query("DELETE FROM `pairs` WHERE `p1` = '$userId' AND `p2` = ''");
} else if ($choice == "option_nam" || $choice == "option_nu"){
	if($user['gender'] == $user['genpairs']){
		$checkingQueryNam = $conn->query("SELECT * FROM `pairs`, `users` WHERE `p1` = '' OR `p2` = '' AND NOT (`p1` = '$userId' OR `p2` = '$userId') AND mess_id = p1 
AND gender = genpairs AND gender = {$user['gender']} LIMIT 1");
		if(!$checkingQueryNam){
			$bot->sendTextMessage($userId, "Lỗi!");
		}
		if($user['state'] == '0'){
			if($checkingQueryNam->num_rows == 0){
				// create new pair
			if ($conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')")) {
				$pairId = $conn->insert_id;
				$bot->sendTextMessage($userId, "🕹 Đang tìm kiếm đối tượng");
				$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `mess_id` = '$userId'");
			} else {
				// failed to create new pair
			}
			} else {
				$pair = $checkingQueryNam->fetch_assoc();				
				$oldParticipant = $pair['p1'];
				if ($conn->query("UPDATE `pairs` SET `p1` = '$oldParticipant', `p2` = '$userId' WHERE `id` = '{$pair['id']}'")) {
				$bot->sendTextMessage($userId, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
				$conn->query("UPDATE `users` SET `state`='2', `joined_pair`={$pair['id']} WHERE `mess_id` = '$userId'");
				$conn->query("UPDATE `users` SET `state`='2' WHERE `mess_id` = '$oldParticipant'");
				$bot->sendTextMessage($oldParticipant, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
				} 		
			}
		}
	} else if ($user['gender'] != $user['genpairs']) {
		$checkingQueryKhac = $conn->query("SELECT * FROM `pairs`, `users` WHERE `p1` = '' OR `p2` = '' AND NOT (`p1` = '$userId' OR `p2` = '$userId') AND mess_id = p1 
AND gender != genpairs AND gender != {$user['gender']} LIMIT 1");
		if(!$checkingQueryKhac){
			$bot->sendTextMessage($userId, "Lỗi!");
		}
		if($user['state'] == '0'){
			if($checkingQueryKhac->num_rows == 0){
				// create new pair
			if ($conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')")) {
				$pairId = $conn->insert_id;
				$bot->sendTextMessage($userId, "🕹 Đang tìm kiếm đối tượng");
				$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `mess_id` = '$userId'");
			} else {
				// failed to create new pair
			}
			} else {
				$pair = $checkingQueryKhac->fetch_assoc();				
				$oldParticipant = $pair['p1'];
				if ($conn->query("UPDATE `pairs` SET `p1` = '$oldParticipant', `p2` = '$userId' WHERE `id` = '{$pair['id']}'")) {
				$bot->sendTextMessage($userId, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
				$conn->query("UPDATE `users` SET `state`='2', `joined_pair`={$pair['id']} WHERE `mess_id` = '$userId'");
				$conn->query("UPDATE `users` SET `state`='2' WHERE `mess_id` = '$oldParticipant'");
				$bot->sendTextMessage($oldParticipant, "💌 Ghép thành công! Bắt đầu thả thính đi nào");
				} 		
			}
		}
	} else {
		$bot->sendTextMessage($userId, "Nhanh quá!");
	}
	
} else {
	$bot->sendTextMessage($userId, "Test!");
}	
?>