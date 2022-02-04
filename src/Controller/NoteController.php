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
                $this->redirect('./',['before'=>'created']);
            } else {
                $this->redirect('./',['error'=>'creationError']);
            }
        }
        $this->view->render( 'create');
    }

    public function showAction():void
    {
        $id = (int) $this->request->getParam('id');
        if(!$id){
            $this->redirect('./',['error'=>'missingNoteId']);
        }
        try {
            $note = $this->database->getNote($id);
        } catch (NotFoundException $e){
            $this->redirect('./',['error'=>'noteNotFound']);
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

    public function editAction():void
    {
        $noteId = (int) $this->request->getParam('id');
        if(!$noteId){
            $this->redirect('./',['error'=>'missingNoteId']);
        }
        try {
            $note = $this->database->getNote($noteId);
        } catch (NotFoundException $e){
            $this->redirect('./',['error'=>'noteNotFound']);
        }
        $this->view->render('edit', ['note' => $note]);

    }


}