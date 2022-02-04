<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class NoteController extends AbstractController
{

    public function createAction(): void
    {
        if($this->request->hasPost()){
            if($this->database->createNote([
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ])){
                header("Location:./?before=created");
            } else {
                header("Location:./?error=creationError");
            }
            exit;
        }
        $this->view->render( 'create');
    }

    public function showAction():void
    {
        $id = (int) $this->request->getParam('id');
        if(!$id){
            header("Location:./?error=missingNoteId");
            exit;
        }
        try {
            $note = $this->database->getNote($id);
        } catch (NotFoundException $e){
            header("Location: ./?error=noteNotFound");
            exit;
        }
        $this->view->render('show', ['note' => $note]);
    }
    public function listAction():void
    {
        $this->view->render('list', [
                'before' => $this->request->getParam('message'),
                'error' => $this->request->getParam("error"),
                'notes' =>  $this->database->getNotes()
            ]);
    }

}