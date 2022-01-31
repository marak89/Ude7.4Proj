<html>
<head>
<body>
<div class="header">
    Nagłówek
</div>
<div class="container">
    <div class="menu">
        <ul>
            <li>
                <a href="./">Lista notatek</a>
            </li>
            <li>
                <a href="./?action=create">Nowa notatka</a>
            </li>
        </ul>
    </div>
    <div class="content">
        <?php include_once ("templates/pages/$page.php");?>
    </div>
</div>
<div class="footer">
STOPKA
</div>
</body>
</head>
</html>