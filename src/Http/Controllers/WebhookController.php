<?php 

namespace Tylercd100\Laravel\Webhooks\Http\Controllers;

use Illuminate\Routing\Controller;
use Tylercd100\Laravel\Webhooks\Models\Webhook;
use Illuminate\Support\Facades\Auth;

class WebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $owner_id = request()->owner_id;
        $options = $owner_id ? ["owner_id" => $owner_id] : [];
        return Webhook::where($options)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return Webhook::create(request()->only(["target_url", "event", "owner_id"]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Webhook::where([
            "id" => $id
        ])->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $model = Webhook::where([
            "id" => $id
        ])->firstOrFail();
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
        return Webhook::where([
            "id" => $id
        ])->firstOrFail()->delete();
    }
}