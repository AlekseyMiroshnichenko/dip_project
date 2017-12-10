<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Магістерська робота</title>
    <link rel="stylesheet" href="<?=base_url();?>app/css/login-style.css" media="screen" type="text/css" />
    <link rel="icon" href="<?=base_url();?>favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="<?=base_url();?>favicon.ico" type="image/x-icon">
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <div class="login-title">
        <h3>МІНІСТЕРСТВО ОСВІТИ І НАУКИ УКРАЇНИ</h3>
        <h4>Київський національний університет технологій та дизайну</h4>
        <h4>Факультет мехатроніки та комп'ютерних технологій</h4>
        <h4>Кафедра інформаційних технологій проектування</h4>
    </div>
    <div id="login-form">
        <h1>Авторизація на сайті</h1>

        <fieldset>
            <form action="" method="post">
                <input name="email" type="email" required value="Логін" onBlur="if(this.value=='')this.value='Логін'" onFocus="if(this.value=='Логін')this.value='' ">
                <input name="password" type="password" required value="Пароль" onBlur="if(this.value=='')this.value='Пароль'" onFocus="if(this.value=='Пароль')this.value='' ">
                <input type="submit" value="Увійти">
                <!-- <footer class="clearfix">
                    <p><span class="info">?</span><a href="#">Забули пароль?</a></p>
                </footer> -->
            </form>
        </fieldset>
    </div>
    <div class="login-title">
        <h4>Дипломна магістерська робота на тему:</h4>
        <h4>Розробка програмного забезпечення для визначення термодинамічної стабільності рідких полімерних струменів</h4>
        <h4>Виконав: Мірошниченко О.В.</h4>
    </div>
</body>
</html>