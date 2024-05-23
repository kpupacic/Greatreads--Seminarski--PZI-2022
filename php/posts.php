<?php
require_once("DatabaseAccess.php");

function getPostsFromDb(){
	 return getDbAccess()->executeQuery("SELECT * FROM Posts;");
}

function getCommentsFromDb($postId){
    return getDbAccess()->executeQuery("SELECT * FROM Comments WHERE postId = $postId");
}

function generatePostsHtml(){
    $html = "";

    $posts = getPostsFromDb();

    foreach($posts as $post){

        $id = $post[0];
        $title = $post[1];
        $author = $post[2];
        $imageUrl = $post[3];
        $review = $post[4];
        $liked = $post[5];
        $bookmarked = $post[6];

        $likedClass = $liked == '1' ? "fa-heart" : "fa-heart-o";
        $bookmarkClass = $bookmarked == '1' ? "fa-bookmark" : "fa-bookmark-o";
     
        $html .= "<article class='post' data-post-id='$id'>
                    <i class='fa fa-times delete-button clickable-icon'></i> <img src='$imageUrl' alt='$title'>
                    <h3><span class='post-title-label'> $title</span> by <span class='post-author-label'>$author</span></h3>
                    <i class='fa $likedClass heart-icon clickable-icon'></i><span class='like-count'>6</span>
                    <i class='fa $bookmarkClass bookmark-icon clickable-icon'></i><span class='bookmark-count'>7</span>
                    <p>$review</p>
                    <h4><i class='fa fa-times add-comment-icon clickable-icon'></i> Komentari:</h4>";

        $comments = getCommentsFromDb($id);
        foreach($comments as $comment){
            $user = $comment[0];
            $text = $comment[1];
            $html .= "<p>$user:</b><br> $text</p>";
        }
        $html .= "</article>";
    }

    return $html;
}

function addPost($title, $author, $imageUrl, $review){
    getDbAccess()->executeInsertQuery("INSERT INTO Posts values ('0', '$title', '$author', '$imageUrl', '$review', '6', '7')");
}

function addComment($user, $text, $postId){
    getDbAccess()->executeInsertQuery("INSERT INTO Comments values ('$user', '$text', '$postId')");
}

function deletePost($id){
    getDbAccess()->executeQuery("DELETE FROM Posts WHERE ID='$id'");
}

function togglePostLike($id, $liked){
    getDbAccess()->executeQuery("UPDATE Posts SET Liked='$liked' WHERE ID='$id';");
}

function togglePostBookmark($id, $bookmarked){
    getDbAccess()->executeQuery("UPDATE Posts SET Bookmarked='$bookmarked' WHERE ID='$id';");
}