<?php
$sort = $params['sort'] ?? [];
$by = $sort['by'] ?? 'title';
$order = $sort['order'] ?? 'desc';
?>
<div class="list">
    <div>
        <form class="settings-form" action="./" method="GET">
            <div>
                <div>Sortuj po:</div>
                <label>Tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
                <label>Dacie: <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
            </div>
            <div>
                <div>Kierunek sortowania</div>
                <label>Rosnąco: <input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
                <label>Malejąco: <input name="sortorder" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
            </div>
            <input type="submit" value="Wyślij" />
        </form>
    </div>
<section>

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
                    <td><?php echo $note['id'] ?></td>
                    <td><?php echo $note['title'] ?></td>
                    <td><?php echo $note['created'] ?></td>
                    <td>
                        <a href="./?action=show&id=<?php echo $note['id'] ?>">
                            <button>Szczegóły</button>
                        </a>
<!--                        <a href="./?action=edit&id=--><?php //echo $note['id'] ?><!--">-->
<!--                            <button>Edytuj</button>-->
<!--                        </a>-->
                        <a href="./?action=delete&id=<?php echo $note['id'] ?>">
                            <button>Usuń</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
</div>