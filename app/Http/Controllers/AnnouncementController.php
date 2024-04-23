<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\BuildSimulationDTO;
use App\Services\AnnouncementService;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use Response;

    public function __construct(
        private readonly AnnouncementService $announcementService,
    )
    {
    }

    public function getList(Request $request): JsonResponse
    {
        $searchParam = $request->query('search', null);

        $announcements = $this->announcementService
            ->getList($searchParam);

        return $this->responseSuccess(
            resource: $announcements->toSelectListResponse()
        );

    }

    public function calculateSimulation(Request $request): JsonResponse
    {
        $inputValue = $request->input('input_value');
        $carId = $request->route('announcementId');
        $installments = $request->input('installments');

        $simulationDTO = new BuildSimulationDTO($carId, $inputValue, $installments);

        $announcementResult = $this->announcementService->doSimulation($simulationDTO);

        return $this->responseSuccess(
            resource: $announcementResult->toArray()
        );
    }
}
