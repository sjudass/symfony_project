<?php $view->extend('base.html.php') ?>

<?php $view['slots']->set('title', 'Welcome to the main page') ?>

<?php $view['slots']->start('body')?>
    <?php foreach ($main_entries as $entry): ?>
<!--        <h2>--><?php //echo entry->getTitle() ?><!--</h2>-->
<!--        <p>--><?php //echo entry->getBody() ?><!--</p>-->
    <?php endforeach; ?>
<?php $view['slots']->stop() ?>

