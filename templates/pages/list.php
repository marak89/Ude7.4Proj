<div>
    <div class="message">
        <?php if(!empty($params['before'])){ ?>
            <?php
                switch($params['before']) {
                    case "created":
                        echo "Notatka zapisana poprawnie.";
                        break;
                    case "creationError":
                        echo "Wystąpił błąd podczas zapisywania notatki.";
                        break;
                    default:
                        echo"Wystapił nieoczekiwany wyjątek.";
                        break;


                }
            ?>
        <?php } ?>
    </div>
  <h4>list noatek</h4>
    <b><?php echo $params['before'] ?? "" ?></b>
  <b><?php echo $params['resultList'] ?? "" ?></b>
</div>