<html>
<head>
<title>vista_categorias</title>
</head>
<body>
<form action="/categoria" method="post">
        {{csrf_field ()}}
        <input type="text" name="name">

        <button type="submit" name="button">guardar</button>
        </form>
    </body>
</html>



