<html>
    <head>
        <title>My Blog</title>
    </head>
    <body>
        <h1>My Blog Posts</h1>
        <?php foreach ($posts as $post): ?>
        <article>
            <h2>
                <a href="/post/<?= $post['id'] ?>">
                    <?= $post['title'] ?>
                </a>
            </h2>
            <p><?= $post['content'] ?></p>
        </article>
        <?php endforeach ?>
    </body>
</html>
