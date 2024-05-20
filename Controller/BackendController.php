<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EventManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Controller;

use Modules\EventManagement\Models\EventMapper;
use Modules\EventManagement\Models\ProgressType;
use phpOMS\Asset\AssetType;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\OrderType;
use phpOMS\Math\Number\Numbers;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Event Management controller class.
 *
 * @package Modules\EventManagement
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEventManagementList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/EventManagement/Theme/Backend/eventmanagement-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1004201001, $request, $response);

        $view->data['events'] = EventMapper::getAll()
            ->sort('id', OrderType::DESC)
            ->limit(25)->executeGetArray();

        // Evaluate progress
        $view->data['progress'] = [];

        $taskProgress = [];

        $now = new \DateTime('now');

        /** @var \Modules\EventManagement\Models\Event $event */
        foreach ($view->data['events'] as $event) {
            if ($event->progressType === ProgressType::TASKS) {
                $taskProgress[] = $event->id;
            } elseif ($event->progressType === ProgressType::LINEAR) {
                $duration = (int) $event->start->diff($event->end)->format('%a');
                $progress = (int) $event->start->diff($now)->format('%a');

                $view->data['progress'][$event->id] = (int) \min(100, $duration / $progress * 100);
            } elseif ($event->progressType === ProgressType::EXPONENTIAL) {
                $duration = (int) $event->start->diff($event->end)->format('%a');
                $progress = (int) $event->start->diff($now)->format('%a');

                $view->data['progress'][$event->id] = (int) Numbers::remapRangeExponentially($progress, $duration);
            } elseif ($event->progressType === ProgressType::LOG) {
                $duration = (int) $event->start->diff($event->end)->format('%a');
                $progress = (int) $event->start->diff($now)->format('%a');

                $view->data['progress'][$event->id] = (int) Numbers::remapRangeLog($progress, $duration);
            } else {
                $view->data['progress'][$event->id] = $event->progress;
            }
        }

        // Count tasks per event where tasks are used as progress indication
        $eventIds = \implode(',', $taskProgress);

        $sql = <<<SQL
        SELECT eventmanagement_task_relation_dst as id,
            COUNT(eventmanagement_task_relation_src) as total_tasks,
            SUM(task.task_status = 1 OR task.task_status = 2) AS open_tasks
        FROM eventmanagement_task_relation
        LEFT JOIN task ON eventmanagement_task_relation.eventmanagement_task_relation_src = task.task_id
        WHERE eventmanagement_task_relation_dst IN ({$eventIds});
        SQL;

        $query   = new Builder($this->app->dbPool->get());
        $results = $query->raw($sql)->execute()?->fetchAll(\PDO::FETCH_ASSOC) ?? [];
        foreach ($results as $result) {
            $view->data['progress'][$result['id']] = (int) (($result['total_tasks'] - $result['open_tasks']) / $result['total_tasks']);
        }

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEventManagementCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/EventManagement/Theme/Backend/eventmanagement-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1004201001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEventManagementView(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        /** @var \phpOMS\Model\Html\Head $head */
        $head = $response->data['Content']->head;
        $head->addAsset(AssetType::CSS, '/Modules/Calendar/Theme/Backend/css/styles.css?v=' . self::VERSION);

        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/EventManagement/Theme/Backend/eventmanagement-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1004201001, $request, $response);

        $taskListView = new \Modules\Tasks\Theme\Backend\Components\Tasks\ListView($this->app->l11nManager, $request, $response);
        $taskListView->setTemplate('/Modules/Tasks/Theme/Backend/Components/Tasks/list');
        $view->data['tasklist'] = $taskListView;

        $calendarView = new \Modules\Calendar\Theme\Backend\Components\Calendar\BaseView($this->app->l11nManager, $request, $response);
        $calendarView->setTemplate('/Modules/Calendar/Theme/Backend/Components/Calendar/mini');
        $view->data['calendar'] = $calendarView;

        $mediaListView = new \Modules\Media\Views\MediaView($this->app->l11nManager, $request, $response);
        $mediaListView->setTemplate('/Modules/Media/Theme/Backend/Components/Media/list');
        $view->data['medialist'] = $mediaListView;

        /** @var \Modules\EventManagement\Models\Event $event */
        $event               = EventMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $view->data['event'] = $event;

        return $view;
    }
}
