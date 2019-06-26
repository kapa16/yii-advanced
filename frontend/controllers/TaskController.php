<?php

namespace frontend\controllers;

use tasktracker\entities\task\Comments;
use tasktracker\entities\task\Images;
use tasktracker\forms\task\CommentForm;
use tasktracker\forms\task\ImageForm;
use tasktracker\forms\task\TaskForm;
use tasktracker\forms\task\TaskSearchForm;
use tasktracker\repositories\TaskRepository;
use tasktracker\services\TaskService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    private $service;
    private $request;
    private $tasks;
    private $comments;
    private $images;

    public function __construct(
        $id,
        $module,
        TaskRepository $tasks,
        TaskService $service,
        Request $request,
        Comments $comments,
        Images $images,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tasks = $tasks;
        $this->service = $service;
        $this->request = $request;
        $this->comments = $comments;
        $this->images = $images;
    }


    public function actionIndex(): string
    {
        $searchModel = new TaskSearchForm();
        $dataProvider = $searchModel->search($this->request->post());
        $this->service->cacheDataProvider($dataProvider);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'only' => [
//                    'index',
//                    'view',
//                    'create',
//                    'delete',
//                ],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['index'],
//                        'roles' => ['TaskCreate'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['view'],
//                        'roles' => ['TaskCreate'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['create'],
//                        'roles' => ['TaskCreate'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['delete'],
//                        'roles' => ['TaskDelete'],
//                    ],
//                ],
//            ],
        ];
    }

    public function actionView($id): string
    {
        $task = $this->tasks->get($id);

        return $this->render('view', [
            'task' => $task,
        ]);
    }

    public function actionCreate()
    {
        $form = new TaskForm();

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $task = $this->service->create($form);
                return $this->redirect(['view', 'id' => $task->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $task = $this->tasks->get($id);
//        if (!Yii::$app->user->can('TaskUpdate', ['task' => $task])) {
//            Yii::$app->session->setFlash('You are not allowed to update this task');
//            return $this->goBack();
//        }

        $form = new TaskForm();
        $form->loadData($task);

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($task->id, $form);
                return $this->redirect(['view', 'id' => $task->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'task' => $task,
            'imageForm' => new ImageForm(),
        ]);
    }

    public function actionDelete($id): Response
    {
        $task = $this->tasks->get($id);
        $task->delete();
        return $this->redirect(['index']);
    }

    public function actionComment($id): Response
    {
        $task = $this->tasks->get($id);
        $form = new CommentForm();

        if ($form->load($this->request->post()) && $form->validate()) {
            $this->comments->create($form->text, $task->id);
        }
        return $this->redirect(['update', 'id' => $task->id]);
    }

    public function actionUpload($id): Response
    {
        $task = $this->tasks->get($id);
        $form = new ImageForm();

        if ($form->load($this->request->post())) {
            $form->image = UploadedFile::getInstance($form, 'image');
            if ($form->upload()) {
                $this->images->create($form, $task->id);
            }
        }
        return $this->redirect(['update', 'id' => $task->id]);

    }

    public function actionFake(): Response
    {
        $this->service->createFakeData();
        return $this->redirect(['index']);
    }

}