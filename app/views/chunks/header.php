<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tasks</title>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
</head>
<body>
<div id="wrapper">

    <div class="container">
        <div class="row">
            <div class="col text-center">
                <b class="navbar-brand">Tasks</b>
                <br><br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <nav class="nav flex-column">
                    <a class="nav-link" href="/">Главная</a>
                    <a class="nav-link" href="/tasks/create">Добавить задачу</a>
                    <?php if(\Koj\Base\UserHelper::isGuest()): ?>
                        <a class="nav-link" href="/login">Авторизация</a>
                    <?php else: ?>
                        <a class="nav-link" href="/logout">Выйти</a>
                    <?php endif; ?>
                </nav>
            </div>
            <div class="col-10">

