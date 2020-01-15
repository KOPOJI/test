<?php

use Koj\Base\Uri;
use Koj\Base\UserHelper;

require_once TEMPLATES_PATH . '/chunks/header.php'; ?>

<?php
/**
 * @var int $currentPageNumber
 * @var int $pagesCount
 * @var array $sort
 * @var array $tasks
 */
$curSort = $_GET['sort'] ?? null;
$curSortOrder = $_GET['sort_order'] ?? null;

$canEdit = UserHelper::canEdit();

?>
<?php if(!empty($tasks)): ?>
    <?php if(!empty($sort)): ?>
        <div class="row">
            <div class="container">
                <form method="get" class="form-inline">
                    <b>Сортировка: &nbsp;</b>
                    <select name="sort" class="form-control m-1">
                        <?php foreach($sort as $key => $title): ?>
                            <option value="<?php echo $key; ?>"<?php if($key == $curSort){ ?> selected<?php } ?>><?php echo $title; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select name="sort_order" class="form-control m-1">
                        <option value="asc"<?php if('asc' == $curSortOrder){ ?> selected<?php } ?>>По возрастанию</option>
                        <option value="desc"<?php if('desc' == $curSortOrder){ ?> selected<?php } ?>>По убыванию</option>
                    </select>
                    <input type="hidden" name="page" value="<?php echo (int) $currentPageNumber;?>">
                    <input type="submit" class="btn btn-outline-primary m-1" value="Сортировать">
                </form>
            </div>
        </div>
        <br>
    <?php endif; ?>
    <?php foreach($tasks as $item): ?>
        <div class="row">
            <div class="container">
                Name: <b><?php echo h($item->getName()); ?></b><br>
                E-mail: <b><?php echo h($item->getEmail()); ?></b><br>
                Text: <b><?php echo h($item->getText()); ?></b><br>
                Status:
                <small>
                    <i class="fa fa-<?php echo $item->isDone() ? 'check' : 'times'; ?>"></i>
                    <?php if($item->isEditedByAdmin()):?>
                        <i>Отредактировано администратором</i>
                    <?php endif;?>
                </small>
                <br>
                <?php if($canEdit):?>
                    <a href="/tasks/edit/<?php echo (int) $item->getId();?>">Редактировать задачу</a>
                <?php endif;?>
                <br><br>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if($pagesCount > 1): ?>
        <nav class="nav nav-pills">
            <?php for($i = 1; $i <= $pagesCount; ++$i):
                $class = $i === $currentPageNumber ? 'active' : '' ?>
                <a class="nav-link <?php echo $class; ?>"
                   href="<?php echo Uri::getUri('page=' . $i, ['page']); ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?php require_once TEMPLATES_PATH . '/chunks/footer.php'; ?>