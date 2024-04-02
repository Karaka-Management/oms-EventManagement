<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EventManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EventManagement\Controller;

use Modules\Admin\Models\NullAccount;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventMapper;
use Modules\EventManagement\Models\ProgressType;
use Modules\Media\Models\NullMedia;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Utils\Parser\Markdown\Markdown;

/**
 * EventManagement api controller class.
 *
 * @package Modules\EventManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEventCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEventCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $event = $this->createEventFromRequest($request);
        $this->createModel($request->header->account, $event, EventMapper::class, 'card', $request->getOrigin());

        $this->createStandardCreateResponse($request, $response, $event);
    }

    /**
     * Method to create card from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Event
     *
     * @since 1.0.0
     */
    public function createEventFromRequest(RequestAbstract $request) : Event
    {
        $event                     = new Event();
        $event->name               = $request->getDataString('name') ?? '';
        $event->descriptionRaw     = $request->getDataString('plain') ?? '';
        $event->description        = Markdown::parse($request->getDataString('plain') ?? '');
        $event->start              = $request->getDataDateTime('start') ?? $event->start;
        $event->end                = $request->getDataDateTime('end') ?? $event->end;
        $event->createdBy          = new NullAccount($request->header->account);
        $event->progressType       = ProgressType::tryFromValue($request->getDataInt('progresstype')) ?? ProgressType::MANUAL;
        $event->progress           = $request->getDataInt('progress') ?? 0;
        $event->budgetCosts->value = $request->getDataInt('budgetcosts') ?? 0;
        $event->actualCosts->value = $request->getDataInt('actualcosts') ?? 0;

        // @todo implement unit
        //$event->unit = $this->app->unitId;

        if (!empty($uploadedFiles = $request->files)) {
            $uploaded = $this->app->moduleManager->get('Media', 'Api')->uploadFiles(
                [],
                [],
                $uploadedFiles,
                $request->header->account,
                __DIR__ . '/../../../Modules/Media/Files/Modules/EventManagement',
                '/Modules/EventManagement',
            );

            foreach ($uploaded as $media) {
                $event->files[] = $media;
            }
        }

        $mediaFiles = $request->getDataJson('media');
        foreach ($mediaFiles as $media) {
            $event->files[] = new NullMedia($media);
        }

        return $event;
    }

    /**
     * Validate card create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEventCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))) {
            return $val;
        }

        return [];
    }
}
