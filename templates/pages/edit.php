<div>
    <h3> Edycja notatki  </h3>
    <div>
        <?php if(!empty($params['note'])): ?>
        <?php dump($params);
        $note = $params['note'];?>
        <h3>Edytujesz notatkę #<?php echo $note['id']; ?></h3>
        <form class="note-form" action="./?action=edit" method="post" >
            <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
            <ul>
                <li>
                    <label>Tytuł: <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" value="<?php echo $note['title'] ?>" />
                </li>
                <li>
                    <label>Treść</label>
                    <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit" />
                </li>
            </ul>
        </form>
        <?php else: ?>
        <h2>Brak danych do wyświetlenia!</h2>
        <?php endif; ?>
    </div>
</div>