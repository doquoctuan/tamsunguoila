<?php
include "ChatFramework/dist/ChatFramework.php";
include "ChatFramework/dist/MessageBuilder.php";
include "config.php";

header("Content-type: text/html; charset=utf-8");
mysqli_set_charset($conn, 'UTF8');

$isHubChallenge = true;
$bot = new \NorthStudio\ChatFramework($accessToken, $isHubChallenge);
$builder = new \NorthStudio\MessageBuilder();

// now we will get the sender's id
$userId = $bot->getSenderId();

$user = array(
	"name" => "",
	"mess_id" => "",
	"state" => "0",
	"joined_pair" => "0"
);

$checkUserQuery = $conn->query("SELECT * FROM `users` WHERE `mess_id` = '$userId'");
if ($checkUserQuery->num_rows == 0) {
	$userInfo = $bot->getUserData($userId);
	$userGen = $bot->getGender($userId);
	$addUserQuery = $conn->query("INSERT INTO `users` (`name`, `mess_id`, `state`) VALUES ('{$userInfo['name']}', '$userId', '0')");
	if($userGen['gender'] == 'male'){
		$conn->query("UPDATE `users` SET `gender`= 1 WHERE `mess_id` = '$userId'");
	}
	if ($addUserQuery) {
		$bot->sendTextMessage($userId, "Hello Mrs");
	} else {
		$bot->sendTextMessage($userId, "Hệ thống bận! Hãy thử lại sau");
	}
} else {
	$user = $checkUserQuery->fetch_assoc();
}

if ($bot->isPostBack) {
	$payload = json_decode($bot->getPayload(), true);
	if ($payload['event'] == "static_menu") {
		include "./events/static_menu.php";
	} else if ($payload['event'] == "main_menu") {
		include "./events/main_menu.php";
	} else {
		// invalid event
	}
} else {
	if ($user['state'] == '2') {
		$pairQuery = $conn->query("SELECT * FROM `pairs` WHERE `id` = {$user['joined_pair']}");
		if ($pairQuery && $pairQuery->num_rows == 1) {
			$pair = $pairQuery->fetch_assoc();
			$otherParticipant = $pair['p1'] == $userId ? $pair['p2'] : $pair['p1'];		
		}
	} else if ($user['state'] == '1' && $bot->getMessageText() != 'End'){
		$bot->sendTextMessage($userId, "❗ Bạn đang trong hàng chờ tìm kiếm, vui lòng đợi. Gõ 'End' để thoát hàng chờ.");	
	} else if ($user['state'] == '1' && $bot->getMessageText() == 'End'){
		$conn->query("DELETE FROM `pairs` WHERE `p1` = '$userId' AND `p2` = ''");
		$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$userId'");
		$bot->sendTextMessage($userId, "💔 Bạn đã thoát hàng chờ. Gõ 'tâm sự' để bắt đầu ghép cặp.");
	}
	if($bot->getMessageText() != 'End'){
		$bot->sendTextMessage($otherParticipant, $bot->getMessageText());
	} else if ($user['state'] == '2' && $bot->getMessageText() == 'End'){
		$bot->sendTextMessage($userId, "💔 Bạn đã rời khỏi cuộc trò chuyện. Gõ 'tâm sự' để bắt đầu ghép cặp.");
		$bot->sendTextMessage($otherParticipant, "💔 Người lạ đã rời khỏi cuộc trò chuyện. Gõ 'tâm sự' để bắt đầu ghép cặp.");
		$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$userId'");
		$conn->query("UPDATE `users` SET `state`='0', `joined_pair`='0' WHERE `mess_id` = '$otherParticipant'");
		$conn->query("DELETE FROM `pairs` WHERE `p1` = '$userId' AND `p2` = ''");
	} 
}
if($bot->getMessageText() == 'Tâm sự' || $bot->getMessageText() == 'tâm sự'){
	$firstButton = $builder->createButton("postback", "Tâm sự người lạ", json_encode(array(
			"event" => "static_menu",
			"choice" => "show_menu"
		)));
		$menu = $builder->createButtonTemplate("Welcome to Nguyễn Du Confessions! Nhấn vào nút bên dưới để ghép cặp", [
		$firstButton,
	]);
		$bot->sendMessage($userId, $menu);
}
?>










