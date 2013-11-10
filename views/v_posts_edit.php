<h2>Edit Post</h2>
<h3>Your Original Post</h3>

<?php foreach($posts as $post): ?>
        <?=$post['content']?>
        <br>
        <span class = "date">
            <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
                <?=Time::display($post['created'])?>
            </time>
        </span>

    <!-- Display Form to Edit Post -->
        <form method='POST' action="/posts/p_edit/<?=$post['post_id']?>">

            <h3>Your Edited Post</h3>
            <textarea name='content' id='content'></textarea>

            <br><br>
            <input type='submit' value='Edit post'>

        </form> 
<?php endforeach; ?>