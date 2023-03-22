<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\EmployeeStoreRequest;
use App\Http\Requests\Api\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

class EmployeeController extends BaseController
{
    public function __construct()
    {
        parent::__construct(Employee::class, EmployeeResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($request->has('note_title')) {
            $employee->note()->create([
                'title' => $request->note_title,
                'body' => $request->note_body
            ]);
        }

        return $this->sendResponse('Employee successfully created', new EmployeeResource($employee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, int $id)
    {
        $employee = Employee::find($id);

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($request->has('note_title')) {
            if ($employee->note) {
                $employee->note()->update([
                    'title' => $request->note_title,
                    'body' => $request->note_body
                ]);
            } else {
                $employee->note()->create([
                    'title' => $request->note_title,
                    'body' => $request->note_body
                ]);
            }
        }

        return $this->sendResponse('Employee successfully updated', new EmployeeResource($employee));
    }
}
