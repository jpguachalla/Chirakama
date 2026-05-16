<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Services\VehicleService;

class VehicleController extends Controller
{
    protected $vehicleService;
    public function __construct(VehicleService $vehicleService)
{
    $this->vehicleService = $vehicleService;
}
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $vehicles = $this->vehicleService->getAllVehicles();

    return response()->json([
        'vehicles' => VehicleResource::collection($vehicles)
    ]);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(VehicleRequest $request)
{
    

   $vehicle = $this->vehicleService->createVehicle(
    $request->validated()
);

    return response()->json([
        'message' => 'Vehículo creado correctamente',
        'vehicle' => new VehicleResource($vehicle)
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $vehicle = $this->vehicleService->getVehicleById($id);

    if (!$vehicle) {
        return response()->json([
            'message' => 'Vehículo no encontrado'
        ], 404);
    }

    return response()->json([
        'vehicle' => new VehicleResource($vehicle)
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, $id)
{
    $vehicle = $this->vehicleService->findVehicle($id);

    if (!$vehicle) {
        return response()->json([
            'message' => 'Vehículo no encontrado'
        ], 404);
    }

   

   $this->vehicleService->updateVehicle(
    $vehicle,
    $request->validated()
);
    return response()->json([
        'message' => 'Vehículo actualizado correctamente',
        'vehicle' => new VehicleResource($vehicle)
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $vehicle = $this->vehicleService->findVehicle($id);

    if (!$vehicle) {
        return response()->json([
            'message' => 'Vehículo no encontrado'
        ], 404);
    }

   $this->vehicleService->deleteVehicle($vehicle);

    return response()->json([
        'message' => 'Vehículo eliminado correctamente'
    ]);
}
}
