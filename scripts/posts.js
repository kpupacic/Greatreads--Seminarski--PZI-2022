const heartIcons = document.querySelectorAll('.post .heart-icon');
for (let i = 0; i < heartIcons.length; i++) {
	const heartIcon = heartIcons[i];
	heartIcon.addEventListener('click', handleHeartIconClick);
}

async function handleHeartIconClick(e) {
	const heartIcon = e.currentTarget;

	const post = heartIcon.closest('.post');
	const postId = post.getAttribute('data-post-id');

	const isCurrentlyLiked = heartIcon.classList.contains('fa-heart');
	try {
		const serverResponse = await fetch(
			`API.php?action=togglePostLike&id=${postId}&liked=${isCurrentlyLiked ? 0 : 1}`
		);
		const responseData = await serverResponse.json();

		if (!responseData.success) {
			throw new Error(`Error liking post: ${responseData.reason}`);
		}

		if (!isCurrentlyLiked) {
			heartIcon.classList.remove('fa-heart-o');
			heartIcon.classList.add('fa-heart');
		} else {
			heartIcon.classList.remove('fa-heart');
			heartIcon.classList.add('fa-heart-o');
		}

		const likeCount = post.querySelector('.post .like-count');
    	likeCount.innerText = isCurrentlyLiked ? parseInt(likeCount.innerText) - 1 : parseInt(likeCount.innerText) + 1;

	} catch (error) {
		throw new Error(error.message || error);
	}
}

const deletePostIcons = document.querySelectorAll('.post .delete-button');
for (let i = 0; i < deletePostIcons.length; i++) {
	const deletePostIcon = deletePostIcons[i];
	deletePostIcon.addEventListener('click', handleDeletePostClick);
}

async function handleDeletePostClick(e) {
	const deletePostIcon = e.currentTarget;
	const post = deletePostIcon.parentElement;
	const postTitle = post.querySelector('h3');

	if (confirm(`Izbrisati karticu: ${postTitle.textContent}?`)) {
		const postId = post.getAttribute('data-post-id');

		try{
			const serverResponse = await fetch(`API.php?action=deletePost&id=${postId}`)
			const responseData = await serverResponse.json()

			if(!responseData.success){
				throw new Error(`Error while deleting post: ${responseData.reason}`);
			}

			post.remove();
		}
		catch(error){
			throw new Error(error.message || error)
		}
	}
}

const bookmarkIcons = document.querySelectorAll('.post .bookmark-icon');
for(let i = 0; i < bookmarkIcons.length; i++){
    const bookmarkIcon = bookmarkIcons[i];
    bookmarkIcon.addEventListener("click", handleBookmarkIconClick);
}

async function handleBookmarkIconClick(e){

    const bookmarkIcon = e.currentTarget;
    const post = bookmarkIcon.closest('.post');
    const postId = post.getAttribute('data-post-id');
    const isCurrentlyBookmarked = bookmarkIcon.classList.contains('fa-bookmark');
    try {
        const serverResponse = await fetch(`API.php?action=togglePostBookmark&id=${postId}&bookmarked=${isCurrentlyBookmarked ? 0 : 1}`);
        const responseData = await serverResponse.json();

        if(!responseData.success){
            throw new Error(`Error while bookmarking post: ${responseData.reason}`)
        }
    }catch(error) {
        throw new Error(error.message || error)
    }

    if(bookmarkIcon.classList.contains("fa-bookmark-o")){
        bookmarkIcon.classList.remove("fa-bookmark-o");
        bookmarkIcon.classList.add("fa-bookmark");
    }
    else {
        bookmarkIcon.classList.remove("fa-bookmark");
        bookmarkIcon.classList.add("fa-bookmark-o");
    }

    const bookmarkCount = post.querySelector('.bookmark-count');
    bookmarkCount.innerText = isCurrentlyBookmarked ? parseInt(bookmarkCount.innerText) - 1 : parseInt(bookmarkCount.innerText) + 1;

}

const commentIcons = document.querySelectorAll('.post .add-comment-icon');
for(let i = 0; i < commentIcons.length; i++){
    const commentIcon = commentIcons[i];
    commentIcon.addEventListener("click", handleCommentIconClick);
}

async function handleCommentIconClick(e){
    const commentIcon = e.currentTarget;
    const post = commentIcon.closest('.post');
    const postId = post.getAttribute('data-post-id');
	const user = prompt('Korisnicko ime:', 'PupacicK');
    const text = prompt('Komentar:', '...');

    if((text != null) && (user != null))
    {
        try {
            const serverResponse = await fetch(`API.php?action=proccessAddComment&user=${user}&text=${text}&postId=${postId}`);
            const responseData = await serverResponse.json();
    
            if(!responseData.success){
                throw new Error(`Error while commenting post: ${responseData.reason}`)
            }

        }catch(error) {
            throw new Error(error.message || error)
        }
        window.location.reload();

    }

}

const addPostButton = document.querySelector('#add-post-button');

addPostButton.addEventListener('click', async (e) => {
	const title = prompt('Unesite naslov knjige', 'naslov');
	if (!title) {
		return;
	}

	const author = prompt('Unesite ime autora', 'autor');
	if (!author) {
		return;
	}

	const imageUrl = prompt('Unesite URL slike', '(...).jpg');
	if (!imageUrl) {
		return;
	}

	const review = prompt('Unesite osvrt na knjigu', 'osvrt');
	if (!review) {
		return;
	}

	try{

		const serverResponse = await fetch(`API.php?action=addPost&title=${title}&author=${author}&imageUrl=${imageUrl}&review=${review}`);
		const responseData = await serverResponse.json();

		if(!responseData.success){
			throw new Error(`Error while adding post: ${responseData.reason}`);
		}

		const postTemplate = document.querySelector('#post-template');
		const postElement = document.importNode(postTemplate.content, true);
	
		postElement.querySelector('.post-title-label').textContent = title;
		postElement.querySelector('.post-author-label').textContent = author;
		postElement.querySelector('img').src = imageUrl;
		postElement.querySelector('p').textContent = review;

		postElement.querySelector('.heart-icon').addEventListener('click', handleHeartIconClick);
		postElement.querySelector('.delete-button').addEventListener('click', handleDeletePostClick);
		postElement.querySelector('.add-comment-icon').addEventListener('click', handleCommentIconClick);
	
		const postsContainer = document.querySelector('#posts-container');
	
		postsContainer.appendChild(postElement);

	} catch(error){
		throw new Error(error.message || error);
	}
});