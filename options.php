<?php
include "ChatFramework/dist/ChatFramework.php";
include "ChatFramework/dist/MessageBuilder.php";
include "config.php";
$isHubChallenge = true;
$bot = new \NorthStudio\ChatFramework($accessToken, $isHubChallenge);
$builder = new \NorthStudio\MessageBuilder();

echo $bot->setupGettingStarted(json_encode(array(
	"event" => "start"
)));

echo $bot->setupGreetingMessage("Welcome to Nguyễn Du Confession! Chúc bạn có những phút giây vui vẻ.");

echo $bot->setupPersistentMenu(array(
	// $builder->createButton("postback", "Tâm Sự Người Lạ", json_encode(array(
	// 	"event" => "static_menu",
	// 	"choice" => "show_menu"
    // ))),
    $builder->createButton("postback", "Tra Cứu GVCN", json_encode(array(
		"event" => "static_menu",
		"choice" => "tra_cuu"
	))),
	$builder->createButton("web_url", "Gửi Confessions", "", "https://bit.ly/nguyenducfs"),
));

?>
