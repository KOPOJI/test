<?php require_once TEMPLATES_PATH . '/chunks/header.php'; ?>
<?php
/**
 * @var Task $task
 * @var $users
 */
?>
<h1>Редактирование задачи <?php echo h($task->getName());?></h1>
<br>
<?php if(!empty($errors)):?>
    <div class="text-danger" style="border: 2px solid red;margin: 15px 0;padding: 7px">
        <?php foreach($errors as $error):?>
            <?php echo $error; ?>
            <br>
        <?php endforeach;?>
    </div>
<?php endif;?>
<?php if(isset($status)):?>
    <?php if($status):?>
        <div class="text-success">Операция выполнена успешно.</div>
    <?php else:?>
        <div class="text-danger">Произошла ошибка при выполнении операции.</div>
    <?php endif;?>
    <br>
<?php endif;?>

<form method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Название задачи</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo h($task->getName());?>" placeholder="" >
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo h($task->getEmail());?>" placeholder="" >
            </div>
            <div class="form-group">
                <label for="user_id">Пользователь</label>
                <?php if(empty($users)):?>
                    <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo h($task->getUserId());?>" placeholder="" >
                <?php else:?>
                    <select name="user_id" class="form-control">
                        <?php foreach($users as $userId => $name):?>
                            <option value="<?php echo $userId;?>"<?php if($task->getUserId() == $userId){?> selected<?php }?>>
                                <?php echo $name;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group ace-editor-block">
                <label for="text">Описание задачи</label>
                <textarea name="text" class="form-control" id="text" style="min-height: 200px"><?php echo h($task->getText());?></textarea>
            </div>
        </div>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="status" value="1"<?php if($task->isDone()){?> checked<?php } ?>>
            Задача выполнена
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<?php require_once TEMPLATES_PATH . '/chunks/footer.php'; ?>