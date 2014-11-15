<?php
namespace TypiCMS\Controllers;

use Illuminate\Database\Eloquent\Model;
use Input;
use Redirect;
use Request;
use Response;
use View;

abstract class AdminSimpleController extends BaseAdminController
{

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $this->layout->content = View::make('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = $this->repository->getModel();
        $this->layout->content = View::make('admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Model    $model
     * @return Response
     */
    public function edit(Model $model)
    {
        $this->layout->content = View::make('admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show(Model $model)
    {
        return Redirect::to($model->editUrl());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Model    $model
     * @return Response
     */
    public function store()
    {
        if ($model = $this->form->save(Input::all())) {
            $redirectUrl = Input::get('exit') ? $model->indexUrl() : $model->editUrl() ;
            return Redirect::to($redirectUrl);
        }

        return Redirect::route('admin.' . $this->repository->getTable() . '.create')
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Model    $model
     * @return Response
     */
    public function update(Model $model)
    {

        if (Request::ajax()) {
            return Response::json($this->repository->update(Input::all()));
        }

        if ($this->form->update(Input::all())) {
            $redirectUrl = Input::get('exit') ? $model->indexUrl() : $model->editUrl() ;
            return Redirect::to($redirectUrl);
        }

        return Redirect::to($model->editUrl())
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model    $model
     * @return Response
     */
    public function destroy(Model $model)
    {
        if ($this->repository->delete($model)) {
            if (! Request::ajax()) {
                return Redirect::back();
            }
        }
    }
}
