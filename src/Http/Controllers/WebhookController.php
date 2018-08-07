<?php 

namespace Tylercd100\Laravel\Webhooks\Http\Controllers;

use Illuminate\Routing\Controller;
use Tylercd100\Laravel\Webhooks\Models\Webhook;

class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Webhook::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return Webhook::create(request()->only(["target_url", "event"]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Webhook::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $model = Webhook::findOrFail($id);
        $model->update(request()->only(["target_url", "event"]));
        $model->save();
        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return Webhook::findOrFail($id)->delete();
    }
}