<?php require_once TEMPLATES_PATH . '/chunks/header.php'; ?>

    <h1>Вход на сайт</h1>
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

<?php if(empty($status)):?>
    <form method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="username">Логин</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Авторизация</button>
    </form>
<?php endif; ?>

<?php require_once TEMPLATES_PATH . '/chunks/footer.php'; ?>