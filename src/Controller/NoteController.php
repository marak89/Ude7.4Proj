<?php

declare(strict_types=1);

namespace App\Controller;

class NoteController extends AbstractController
{
    private const PAGE_SIZE = 10;
    private const PAGE = 1;

    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            if ($this->database->create([
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ])) {
                $this->redirect('./', ['before' => 'created']);
            } else {
                $this->redirect('./', ['error' => 'creationError']);
            }
        }
        $this->view->render('create');
    }

    public function showAction(): void
    {
        $this->view->render('show', [
            'note' => $this->getNote(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam("error")
        ]);
    }

    public function listAction(): void
    {
        $phrase = $this->request->getParam('phrase', null);
        $pageNumber = (int)$this->request->getParam('page', self::PAGE);
        $pageSize = (int)$this->request->getParam('pagesize', self::PAGE_SIZE);
        $sortBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder', 'desc');

        if (!in_array($pageSize, [1, 5, 10, 25])) {
            $pageSize = self::PAGE_SIZE;
        }

        $notes = $this->database->list($pageNumber, $pageSize, $sortBy, $sortOrder, $phrase);
        $notesCount = $this->database->count($phrase);

        $this->view->render(
            'list',
            [
                'page' =>
                    [
                        'number' => $pageNumber,
                        'size' => $pageSize,
                        'pages' => (int)ceil($notesCount / $pageSize)
                    ],
                'phrase' => $phrase,
                'sort' => ['by' => $sortBy, 'order' => $sortOrder],
                'notes' => $notes,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ]
        );
    }

    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int)$this->request->postParam('id');
            if ($noteId) {
                $noteData = [
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ];
                if ($this->database->edit($noteId, $noteData)) {
                    $this->redirect('./', ['action' => 'show', 'id' => (string)$noteId, 'before' => 'saved']);
                } else {
                    $this->redirect('./', ['error' => 'noSaved']);
                }

            } else {
                $this->redirect('./', ['error' => 'missingNoteId']);
            }
        } else {

            $this->view->render('edit', [
                'note' => $this->getNote(),
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam("error")
            ]);
        }
    }

    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $id = (int)$this->request->postParam('id');
            $this->database->delete($id);
            $this->redirect('./', ['before' => 'deleted']);
        }
        $this->view->render('delete', [
            'note' => $this->getNote()
        ]);
    }

    final private function getNote(): array
    {
        $noteId = (int)$this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('./', ['error' => 'missingNoteId']);
        }
        return $this->database->get($noteId);
    }
}