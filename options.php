<?php
include "ChatFramework/dist/ChatFramework.php";
include "ChatFramework/dist/MessageBuilder.php";
include "config.php";

$bot = new \NorthStudio\ChatFramework($accessToken, $isHubChallenge);
$builder = new \NorthStudio\MessageBuilder();

echo $bot->setupGettingStarted(json_encode(array(
	"event" => "start"
)));

echo $bot->setupGreetingMessage("Welcome to Nguyễn Du Confession! Nhấn bắt đầu để cùng khám phá nha.");

echo $bot->setupPersistentMenu(array(
	$builder->createButton("postback", "Tâm sự người lạ", json_encode(array(
		"event" => "static_menu",
		"choice" => "show_menu"
	))),
	$builder->createButton("web_url", "Gửi Confessions", "", "https://bit.ly/nguyenducfs"),
	// $builder->createButton("postback", "Gửi Confessions", json_encode(array(
	// 	"event" => "static_menu",
	// 	"choice" => "show_about"
	// ))),
));

?>
