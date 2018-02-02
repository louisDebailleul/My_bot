<?php

use RecastAI\Client;

require_once 'config.php';
require 'db.php';
require 'app.php';


function sayhello($id){

}
/*
* message.js
* This file contains your bot code
*/
function replyMessage ($message) {

$db = App::getDatabase();
$user = $db->query('SELECT * FROM user where user_id = 1')->fetch();
  /*
  * Instantiate Recast.AI SDK, just for connect service
  */
  $request = Client::Request($_ENV["REQUEST_TOKEN"]);
  /*

  * Get text from message received
  */
  $text = $message->content;
  /*
  * Get senderId to catch unique conversation_token
  */
  $senderId = $message->senderId;

  /*
  * Call Recast.AI SDK, through /converse route
  */
  $response = $request->analyseText($text);

  $intent = null;
  if (count($response->intents) > 0) {
	  $intent = $response->intents[0];
  }
  $intent_slug = null;
  if ($intent) {
    $intent_slug = $intent->slug;
  }

  $reply = "Désolé. Je n'ai pas compris. :o";
  if ($intent_slug !== null) {
    if($intent_slug == "greetings"){
      $reply = "Bonjour. Je suis un bot à votre service !";
    }else if($intent_slug == "goodbye-1" or $intent_slug == "goodbye" ){
      $reply = "A bientôt. ;)";
    }else if($intent_slug == "ask-feeling"){
      $reply= "Je n'ai pas compris. :o";
    }else if($intent_slug == "identifient"){
      $number = preg_match([0-9]{8},$text);
      $reply= "Vous étez ".$number ;
    }else{
      $reply = "I understand that you talk about " .$intent_slug;
    }
  }

  /*
  * Here, you can add your own process.
  * Ex: You can call any external API
  * Or: Update your DB
  * etc...
  */

  /*
  * Add each replies received from API to replies stack
  */
  $message->addReply([(object)['type' => 'text', 'content' => $reply]]);

  $message->reply();
}
