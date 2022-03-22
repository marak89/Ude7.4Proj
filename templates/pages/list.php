<?php
$sort = $params['sort'] ?? [];
$by = $sort['by'] ?? 'title';
$order = $sort['order'] ?? 'desc';

$page = $params['page'] ?? [];
$size = $page['size'] ?? 10;
$number = $page['number'] ?? 1;
$pages = $page['pages'] ?? 1;

$phrase = $params['phrase'] ?? null;
?>
<div class="list">
    <div>
        <form class="settings-form" action="./" method="GET">
            <div>
                <div>
                    <label>Wyszukaj: <input type="text" name="phrase" value="<?php echo $phrase; ?>"></label>
                </div>

                <div>Sortuj po:</div>
                <label>Tytule: <input name="sortby" type="radio"
                                      value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
                <label>Dacie: <input name="sortby" type="radio"
                                     value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
            </div>
            <div>
                <div>Kierunek sortowania</div>
                <label>Rosnąco: <input name="sortorder" type="radio"
                                       value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
                <label>Malejąco: <input name="sortorder" type="radio"
                                        value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
            </div>
            <div>Rozmiar paczki:<br>
                <label>1<input type="radio" name="pagesize"
                               value="1" <?php echo $size === 1 ? 'checked' : ''; ?>></label>
                <label>5<input type="radio" name="pagesize"
                               value="5" <?php echo $size === 5 ? 'checked' : ''; ?>></label>
                <label>10<input type="radio" name="pagesize"
                                value="10" <?php echo $size === 10 ? 'checked' : ''; ?>></label>
                <label>25<input type="radio" name="pagesize"
                                value="25" <?php echo $size === 25 ? 'checked' : ''; ?>></label>
            </div>
            <input type="submit" value="Wyślij"/>
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

                            <a href="./?action=delete&id=<?php echo $note['id'] ?>">
                                <button>Usuń</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                <li>
                    <a href="./?sortby=<?php echo $by; ?>&sortorder=<?php echo $order ?>&pagesize=<?php echo $size ?>&page=<?php echo $i ?><?php echo $phrase ? "&phrase=$phrase":'' ?>"

                    >
                        <button <?php echo $i === $number ? 'class=current' : ''; ?> ><?php echo $i; ?></button>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>
</div>