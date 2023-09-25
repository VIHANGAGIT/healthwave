<?php require APPROOT . '/views/const/header.php'; ?>

<h1><?php echo $data['title']; ?></h1>

<ul>
    <?php foreach($data['user'] as $user): ?>
        <li><?php echo $user->title ?></li>
    <?php  endforeach; ?>
</ul>

<?php require APPROOT . '/views/const/footer.php'; ?>