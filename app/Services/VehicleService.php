<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{
    public function getAllVehicles()
    {
        return Vehicle::with('category')->get();
    }
    public function findVehicle($id)
    {
        return Vehicle::find($id);
    }
    public function createVehicle(array $data)
    {
        return Vehicle::create($data);
    }

    public function getVehicleById($id)
    {
        return Vehicle::with('category')->find($id);
    }

    public function updateVehicle($vehicle, array $data)
    {
        $vehicle->update($data);

        return $vehicle;
    }

    public function deleteVehicle($vehicle)
    {
        return $vehicle->delete();
    }
}