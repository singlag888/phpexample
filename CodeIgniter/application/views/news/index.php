<h2><?php echo $title; ?></h2>

<?php

foreach ($news as $newsItem) {
    ?>
    <h3><?php echo $newsItem['title']; ?></h3>
    <div class="main">
        <?php echo $newsItem['text'] ?>
    </div>
    <p>
<!--        <a href="--><?php //echo site_url('news/' . $newsItem['slug']); ?><!--">View Article</a>-->
        <a href="<?php echo site_url('news/view?slug=' . $newsItem['slug']); ?>">View Article</a>
    </p>
    <?php
}
?>