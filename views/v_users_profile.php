<h2>Hello, <?=$user->first_name?> <?=$user->last_name?></h2>

    <!-- Print this users info -->
        <p><strong>Account Created:</strong> <?=Time::display($user->created)?></p>

<h3>Your Posts:</h3>
<ul>
        <?php foreach($posts as $post): ?>
            <li>
                    <?=$post['content']?>
                    <br>
                    <span class = "date"><?=Time::display($post['modified'])?></span>
                    <br>
                    <a href='/posts/edit/<?=$post['post_id']?>'>Edit</a> <a href='/posts/p_delete/<?=$post['post_id']?>'>Delete</a>
            </li>
        <?php endforeach; ?>
</ul>