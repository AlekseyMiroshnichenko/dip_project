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
</body>
</html>