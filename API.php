<?php
require_once("php/posts.php");

function processRequest(){
  $action = getRequestParameter("action");

    switch ($action) {
      case 'deletePost':
        processDeletePost();
        break;
      case 'addPost':
        processAddPost();
        break;
      case 'togglePostLike':
        processTogglePostLike();
        break;
      case 'togglePostBookmark':
        processTogglePostBookmark();
        break;
      case 'proccessAddComment':
        proccessAddComment();
        break;
      default:
      echo(json_encode(array(
         "success" => false,
         "reason" => "Unknown action: $action"
      )));
      break;
    }
}

function getRequestParameter($key) {
   return isset($_REQUEST[$key]) ? $_REQUEST[$key] : "";
}

function processTogglePostLike(){
  $success = false;
  $reason = "";

  $id = getRequestParameter("id");
  $liked = getRequestParameter("liked");

  if (is_numeric($id) && is_numeric($liked)) {
    togglePostLike($id, $liked);
    $success = true;
  } 
  else {
    $success = false;
    $reason = "Needs id:number; like:number";
  }

  echo(json_encode(array(
  "success" => $success,
  "reason" => $reason
  )));
}

function processTogglePostBookmark(){
  $success = false;
  $reason = "";

  $id = getRequestParameter("id");
  $bookmarked = getRequestParameter("bookmarked");

  if (is_numeric($id) && is_numeric($bookmarked)) {
    togglePostBookmark($id, $bookmarked);
    $success = true;
  } 
  else {
    $success = false;
    $reason = "Needs id:number; bookmarked:number";
  }

  echo(json_encode(array(
  "success" => $success,
  "reason" => $reason
  )));
}

function processDeletePost(){
  $success = false;
  $reason = "";

  $id = getRequestParameter('id');

  if(is_numeric($id)){
    deletePost($id);
    $success = true;
  }
  else{
    $success = false;
    $reason = "Needs id:number;";
  }

  echo(json_encode(array(
    "success" => $success,
    "reason" => $reason
    )));
}

function processAddPost(){
  $success = false;
  $reason = "";

  $title = getRequestParameter('title');
  $author = getRequestParameter('author');
  $imageUrl = getRequestParameter('imageUrl');
  $review = getRequestParameter('review');

  if($title != "" && $author != "" && $imageUrl != "" && $review != ""){
    addPost($title, $author, $imageUrl, $review);
    $success = true;
  }
  else{
    $success = false;
    $reason = "Title, author, imageUrl and review must be non-empty strings";
  }
  echo(json_encode(array(
    "success" => $success,
    "reason" => $reason
  )));
}

function proccessAddComment(){

  $user = getRequestParameter("user");
  $text = getRequestParameter("text");
  $postId = getRequestParameter("postId");
  
  if(is_numeric($postId)){
    addComment($user, $text, $postId);
  }
}

processRequest();