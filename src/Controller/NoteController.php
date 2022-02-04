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
        $this->view->render('show', [
            'note' => $note,
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam("error")
        ]);
    }
    public function listAction():void
    {
        $this->view->render('list', [
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam("error"),
                'notes' =>  $this->database->getNotes()
            ]);

    }

    public function editAction():void
    {
        if($this->request->isPost()){
            $noteId = (int) $this->request->postParam('id');
            if($noteId){
                $noteData = [
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ];
                if(!$this->database->editNote($noteId,$noteData)){
                    $this->redirect('./',['action'=>'show','id'=>(string) $noteId,'before'=>'saved']);
                } else {
                    $this->redirect('./',['error'=>'noSaved']);
                }

            } else {
                $this->redirect('./',['error'=>'missingNoteId']);
            }
        } else {
            $noteId = (int) $this->request->getParam('id');
            if(!$noteId){
                $this->redirect('./',['error'=>'missingNoteId']);
            }
            try {
                $note = $this->database->getNote($noteId);
            } catch (NotFoundException $e){
                $this->redirect('./',['error'=>'noteNotFound']);
            }
            $this->view->render('edit', [
                'note' => $note,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam("error")
            ]);
        }
    }
}