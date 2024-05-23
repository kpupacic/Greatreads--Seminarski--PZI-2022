<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <title>Greatreads</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/style.css"/>
        <link rel="stylesheet" href="styles/font-awesome.min.css"/>
        <template id='post-template'>
            <article class='post' data-post-id=''>
                <i class='fa fa-times delete-button clickable-icon'></i> <img src='' alt=''>
                <h3><span class='post-title-label'></span> by <span class='post-author-label'></span></h3>
                <i class='fa $likedClass heart-icon clickable-icon'></i><span class='like-count'>6</span>
                <i class='fa $bookmarkClass bookmark-icon clickable-icon'></i><span class='bookmark-count'>7</span>
                <p></p>
                <h4><i class='fa fa-times add-comment-icon clickable-icon'></i> Komentari:</h4>
                <p><b></b></p>
            </article>

        </template>
    </head>

    <body>
        <div id="wrapper">
            <header>
                <p>GREATREADS</p>
            </header>
    
            <nav>
                <div id="search-container">
                    <input type="text" id="search-box" placeholder="Search for books, authors..."/>
                </div>
                <a href="">link 1</a>
                <a href="">link 2</a>
                <a href="">link 3</a>
            </nav>
        </div>

        <div id="profile-info" style="margin-top: 330px">
            <img src="pics/profile_pic.jpg"/><br>
            <p id="personal-shorts">@username | name | misc.</p>
            <button id="add-post-button">Add new review</button>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum dui vitae urna ullamcorper, eu tempor leo tincidunt. Suspendisse et sollicitudin felis, ac vestibulum est. Cras eu faucibus ante. Sed vitae iaculis arcu. Morbi imperdiet turpis fringilla lacinia venenatis. Sed mattis at mi ut elementum.</p>
        </div>

        <div id="posts-container" style="margin-top: 250px">
            <?php 
                require_once("php/posts.php");
                echo(generatePostsHtml());
            ?>
        </div>
        <script src="scripts/posts.js"></script>
    </body>
</html>