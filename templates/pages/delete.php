<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
    <h2>Potwierdź usunięcie notatki!</h2>
        <ul>
            <li>Id: <?php echo $note['id'] ?></li>
            <li>Tytuł: <?php echo $note['title'] ?></li>
            <li>
                <pre><?php echo $note['description'] ?></pre>
            </li>
            <li>Zapisano: <?php echo $note['created'] ?></li>
        </ul>
        <form method="POST" action="./?action=delete">
            <input name="id" type="hidden" value="<?php echo $note['id'] ?>" />
            <input type="submit" value="Usuń" />
            <a href="./">
                <button>Anuluj</button>
            </a>
        </form>
    <?php else : ?>
        <div>Brak notatki do wyświetlenia</div>
        <a href="./">
            <button>Powrót do listy notatek</button>
        </a>
    <?php endif; ?>

</div>