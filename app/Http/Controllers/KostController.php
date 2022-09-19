<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenPermissionException;
use App\Exceptions\InsufficientCreditException;
use App\Http\Requests\KostRequest;
use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->validate([
            'name' => ['string'],
            'location' => ['string'],
            'price' => ['numeric'],
        ]);
        $kosts = Kost::orderBy('price')->get();

        foreach ($query as $key => $value) {
            $kosts = $kosts->where($key, $value);
        }

        $response = $kosts;
        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_OK);
    }

    public function getKostsByOwner()
    {
        $kosts = Kost::where('user_id', auth()->id())->orderBy('created_at')->get();
        $kosts->makeVisible(['description', 'is_available']);
        $response = $kosts;
        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_OK);
    }

    public function store(KostRequest $request)
    {
        $payload = $request->validated();
        $kost = auth()->user()->kosts()->create([
            'name' => $payload['name'],
            'location' => $payload['location'],
            'price' => $payload['price'],
            'description' => $payload['description'],
        ]);
        $response = Kost::where('id', $kost->id)->with('owner')->first()->makeVisible(['description', 'is_available']);
        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_CREATED);
    }

    public function show(Kost $kost)
    {
        $kost->makeVisible(['description']);
        $kost->load('owner');
        return response()->json([
            'success' => true,
            'data' => $kost
        ], Response::HTTP_OK);
    }

    public function update(KostRequest $request, Kost $kost)
    {
        $payload = $request->validated();
        if ($kost->user_id !== auth()->id()) {
            throw new ForbiddenPermissionException('The requested action require resource owner authentication.');
        }
        $kost->update([
            'name' => $payload['name'],
            'location' => $payload['location'],
            'price' => $payload['price'],
            'description' => $payload['description'],
            'is_available' => $payload['is_available'],
        ]);
        $response = Kost::where('id', $kost->id)->with('owner')->first()->makeVisible(['description', 'is_available']);
        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_OK);
    }

    public function destroy(Kost $kost)
    {
        if ($kost->user_id !== auth()->id()) {
            throw new ForbiddenPermissionException('The requested action require resource owner authentication.');
        }
        $kost->delete();
        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function checkAvailability(Kost $kost)
    {
        $userCredit = auth()->user()->load('credit')->credit->credit;
        $checkPrice = config('credit.deduction.check_availability');

        if ($userCredit < $checkPrice) {
            throw new InsufficientCreditException('The request cannot be processed because of insufficient user credit.');
        }

        auth()->user()->credit()->update([
            'credit' => $userCredit - $checkPrice
        ]);

        $response = [
            'id' => $kost->id,
            'name' => $kost->name,
            'price' => $kost->price,
            'is_available' => $kost->is_available,
        ];

        return response()->json([
            'success' => true,
            'data' => $response
        ], Response::HTTP_OK);
    }
}
