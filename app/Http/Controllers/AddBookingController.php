<?php

namespace App\Http\Controllers;

use App\Models\AddBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class AddBookingController extends Controller
{
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "page" => "required",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "error",
                "error" => $validate->errors()
            ]);
        }
        $currentTime = microtime(true) * 1000;
        $data = AddBooking::where('page', $request->page)
            ->where('payment_status', 'approved')
            ->where('from_time', '<=', $currentTime)
            ->where('to_time', '>=', $currentTime)
            ->get();


        $data->each(function (AddBooking $booking) {
            $booking->advertisiment = $booking->advertisiment()->get();
        });
        return response()->json([
            "status" => "success",
            "message" => $data
        ]);
    }

    public function store_booking(Request $request)
    {
        $validate = Validator::make($request->all(), [
            '*.user_id' => 'required|exists:users,id',
            '*.advertisiment_id' => 'required|exists:advertisiments,id',
            '*.page' => 'required',
            '*.section' => 'required',
            '*.from_time' => 'required',
            '*.to_time' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validate->errors()
            ]);
        }


        $bookings = [];
        foreach ($request->all() as $bookingData) {

            $oldData = AddBooking::
                where('page', $bookingData['page'])
                ->where('section', $bookingData['section'])
                ->where('from_time', '<=', $bookingData['from_time'])
                ->where('to_time', '>=', $bookingData['to_time'])
                ->count();

            if ($oldData >= 6) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Booking limit reached'
                ]);
            }
            $booking = new AddBooking();
            $booking->user_id = $bookingData['user_id'];
            $booking->advertisiment_id = $bookingData['advertisiment_id'];
            $booking->page = $bookingData['page'];
            $booking->section = $bookingData['section'];
            $booking->price = "5";
            $booking->from_time = $bookingData['from_time'];
            $booking->to_time = $bookingData['to_time'];
            $booking->save();
            $bookings[] = $booking;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Bookings created successfully',
            'data' => $bookings
        ]);
    }

    public function check_aveliable(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'page' => 'required',
            'section' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validate->errors()
            ]);
        }

        $oldData = AddBooking::
        where('page', $request->page)
        ->where('section', $request->section)
        ->where('from_time', '<=', $request->from_time)
        ->where('to_time', '>=', $request->to_time)
        ->count();
        if ($oldData >= 6) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking limit reached'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Booking available'
        ]);
    }
}
