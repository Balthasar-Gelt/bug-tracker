<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Traits\UpdateStageSerialNumberTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StageSerialNumberController extends Controller
{
    use UpdateStageSerialNumberTrait;

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project, Stage $stages_serial_number)
    {
        $this->updatePosition($project, $stages_serial_number, $request->operator);

        return Redirect::back();
    }
}
