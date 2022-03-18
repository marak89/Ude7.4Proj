<html lang="pl">

<head>
  <title>Notatnik</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link href="./public/style.css" rel="stylesheet">
</head>

<body class="body">
  <div class="wrapper">
    <div class="header">
      <h1><i class="far fa-clipboard"></i>Moje notatki</h1>
    </div>

    <div class="container">
      <div class="menu">
        <ul>
          <li><a href="./">Strona główna</a></li>
          <li><a href="./?action=create">Nowa notatka</a></li>
        </ul>
      </div>

      <div class="page">
          <div class="message">
              <?php if(!empty($params['error'])){
                  switch($params['error']) {
                      case "missingNoteId":
                          echo "Niepoprawny identyfikator notatki.";
                          break;
                      case "noteNotFound":
                          echo "Notatka nie została znaleziona.";
                          break;
                      case "noSaved":
                          echo "Notatka nie została zaktualizowana.";
                          break;
                      default:
                          echo"Wystapił inny błąd.";
                          break;
                  }
                  ?>
              <?php } ?>
          </div>
          <div class="message">
              <?php if(!empty($params['before'])){
                  switch($params['before']) {
                      case "created":
                          echo "Notatka doana poprawnie.";
                          break;
                      case "saved":
                          echo "Notatka zapisana poprawnie.";
                          break;
                      case "creationError":
                          echo "Wystąpił błąd podczas zapisywania notatki.";
                          break;
                      case 'deleted':
                          echo "Notatka usunięta";
                          break;
                      default:
                          echo"Wystapił nieoczekiwany wyjątek.";
                          break;
                  }
                  ?>
              <?php } ?>
          </div>
        <?php require_once("templates/pages/$page.php"); ?>
      </div>
    </div>

    <div class="footer">
      <p>Notatki - projekt w kursie PHP</p>
    </div>
  </div>
</body>

</html>