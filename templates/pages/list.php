<div class="list">
<section>
    <div class="message">
        <?php if(!empty($params['error'])){
                switch($params['error']) {
                    case "missingNoteId":
                        echo "Niepoprawny identyfikator notatki.";
                        break;
                    case "noteNotFound":
                        echo "Notatka nie została znaleziona.";
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
    <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tytuł</th>
                <th>Data</th>
                <th>Opcje</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tbl-content">
        <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <?php foreach ($params['notes'] ?? [] as $note) : ?>
                <tr>
                    <td><?php echo (int) $note['id'] ?></td>
                    <td><?php echo htmlentities($note['title']) ?></td>
                    <td><?php echo htmlentities($note['created']) ?></td>
                    <td>
                        <a href="/?action=show&id=<?php echo (int) $note['id'] ?>">
                            <button>Szczegóły</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
</div>