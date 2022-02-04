<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note) : ?>
        <ul>
            <li>Id: <?php echo (int) $note['id'] ?></li>
            <li>Tytuł: <?php echo ($note['title']) ?></li>
            <li>
                <pre><?php echo ($note['description']) ?></pre>
            </li>
            <li>Zapisano: <?php echo ($note['created']) ?></li>
        </ul>
    <?php else : ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="./">
        <button>Powrót do listy notatek</button>
    </a>
</div>
