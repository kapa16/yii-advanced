<?php

namespace frontend\controllers;

use tasktracker\entities\task\Comments;
use tasktracker\entities\task\Images;
use tasktracker\entities\task\Tasks;
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
use yii\web\Session;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    private $session;
    private $service;
    private $request;
    private $tasks;
    private $images;

    public function __construct(
        $id,
        $module,
        Session $session,
        TaskRepository $tasks,
        TaskService $service,
        Request $request,
        Images $images,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tasks = $tasks;
        $this->session = $session;
        $this->service = $service;
        $this->request = $request;
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
                $this->session->setFlash('success', 'Task created successfully');
                return $this->redirect(['view', 'id' => $task->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                $this->session->setFlash('error', $e->getMessage());
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
        $formImage = new ImageForm();

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $this->service->edit($task->id, $form);
                $this->session->setFlash('success', 'Task updated successfully');
//                return $this->render('_form', ['model' => $task]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                $this->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'task' => $task,
            'imageForm' => $formImage,
        ]);
    }

    public function actionDelete($id): Response
    {
        $task = $this->tasks->get($id);
        try {
            $task->delete();
            $this->session->setFlash('success', 'Task deleted successfully');
        } catch (\Throwable $e) {
            Yii::$app->errorHandler->logException($e);
            $this->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * @deprecated
     * @param $id
     * @return Response
     */
    public function actionComment($id): Response
    {
        $task = $this->tasks->get($id);
        $form = new CommentForm();

        if ($form->load($this->request->post()) && $form->validate()) {
            $this->service->createComment($form->text, $task->id, Yii::$app->user->id);
        }
        return $this->redirect(['update', 'id' => $task->id]);
    }

    public function actionUpload($id): ?string
    {
        $task = $this->tasks->get($id);
        $formImage = new ImageForm();

        if ($formImage->load($this->request->post())) {
            $formImage->image = UploadedFile::getInstance($formImage, 'image');
            if ($formImage->upload()) {
                $this->images->create($formImage, $task->id);
                return $this->renderAjax('images/_images', [
                    'task' => $task,
                    'model' => $formImage
                ]);
            }
        }
    }

    public function actionFake(): Response
    {
        $this->service->createFakeData();
        return $this->redirect(['index']);
    }

}