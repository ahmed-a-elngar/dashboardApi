<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CompanyStoreRequest;
use App\Http\Requests\Api\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends BaseController
{
    public function __construct()
    {
        parent::__construct(Company::class, CompanyResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website
        ]);

        if ($request->has('note_title')) {
            $company->note()->create([
                'title' => $request->note_title,
                'body' => $request->note_body
            ]);
        }

        return $this->sendResponse('Company successfully created', new CompanyResource($company));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, int $id)
    {

        $company = Company::find($id);

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website
        ]);

        if ($request->has('note_title')) {
            if ($company->note) {
                $company->note()->update([
                    'title' => $request->note_title,
                    'body' => $request->note_body
                ]);
            } else {
                $company->note()->create([
                    'title' => $request->note_title,
                    'body' => $request->note_body
                ]);
            }
        }

        return $this->sendResponse('Company successfully updated', new CompanyResource($company));
    }
}
