<?php


namespace Koj\Controllers;


use InvalidArgumentException;
use Koj\Base\Controller;
use Koj\Base\HttpNotFoundException;
use Koj\Base\UserHelper;
use Koj\Base\View;
use Koj\Task;
use Koj\User;

class TaskController extends Controller
{
    /**
     * @return string|void
     */
    public function index()
    {
        $task = new Task();
        $tasks = $task->findAllWithPaginate();

        $sort = $task->getSortableFields();
        $pagesCount = $task->getPagesCount();
        $currentPageNumber = $task->getCurrentPageNumber();

        return View::render('tasks/index', compact('tasks', 'sort', 'pagesCount', 'currentPageNumber'));
    }

    /**
     * @param $id
     * @return string|void
     */
    public function edit($id)
    {
        $this->checkAccess();

        $task = new Task();
        $task->loadFromData((array) $this->findTask((int) $id));

        $users = (new User())->getAllForSelect();

        $status = null;
        if(!empty($_POST))
            $status = $this->saveTask($task, $_POST, true);

        $errors = $task->getErrors();

        return View::render('tasks/edit', compact('task', 'users', 'errors', 'status'));
    }

    /**
     * @return string|void
     */
    public function create()
    {
        $task = new Task();

        $users = (new User())->getAllForSelect();

        $status = null;
        if(!empty($_POST))
            $status = $this->saveTask($task, $_POST);

        $errors = $task->getErrors();

        return View::render('tasks/create', compact('task', 'users', 'errors', 'status'));
    }

    /**
     * @param Task $task
     * @param array $data
     * @param bool $actionEdit
     * @return bool|mixed|void
     */
    private function saveTask(Task $task, array $data, bool $actionEdit = false)
    {
        if(empty($data))
            return false;

        if(isset($data['edited_by_admin']))
            unset($data['edited_by_admin']);

        if($actionEdit && isset($data['text']) && $task->getText() != $data['text'])
            $task->setEditedByAdmin();

        $task->loadFromData($data);

        $task->setStatus($data);

        return $task->save();
    }

    /**
     *
     */
    private function checkAccess()
    {
        if(!UserHelper::canEdit())
            throw new \LogicException('You cannot do this action. Try to log in as administrator');
    }

    /**
     * @param int $id
     * @return mixed
     * @throws HttpNotFoundException
     */
    private function findTask(int $id)
    {
        $taskData = (new Task())->findById($id);
        if(empty($taskData))
            throw new HttpNotFoundException('Task is not found.');
        return $taskData;
    }
}