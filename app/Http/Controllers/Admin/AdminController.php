<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Models\Admin;
use App\Models\Bus;
use App\Models\BusImage;
use App\Models\BusSchedule;
use App\Models\City;
use App\Models\Faq;
use App\Models\ReportCategory;
use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
  
    public function index()
    {
        $buses = Bus::count();
        $routes = Route::count();
        $schedules = BusSchedule::count();

        return view('user.index', compact('buses', 'routes', 'schedules'));
    }

    public function viewBus(Request $request)
    {
        $buses = Bus::all();

        if ($request->ajax()) {
            $query = $request->input('query');

            $buses  = Bus::query();
            if ($query) {
                $buses = $buses->where('name', 'like', '%' . $query . '%');
            }
            $buses = $buses->get();
            return view('user.bus-ajax', compact('buses'));
        }
        return view('user.bus', compact('buses'));
    }
    public function addBus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bus_number' => 'required|unique:buses,bus_number|string|max:50',
            'seats' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $bus = new Bus();
        $bus->name = $request->name;
        $bus->bus_number = $request->bus_number;
        $bus->seats = $request->seats;
        $bus->save();
        return redirect()->back()->with('success' , 'Bus Added Successfully');
    }

    public function editBus(Request $request, $bus_id)
    {
        $bus = Bus::find($bus_id);
        $bus->name = $request->name;
        $bus->bus_number = $request->bus_number;
        $bus->seats = $request->seats;
        $bus->save();
        return redirect()->back()->with('success', 'Bus Edit Successfully');
    }

    public function deleteBus($bus_id)
    {
        $bus = Bus::find($bus_id);
        if ($bus) {
            $bus->delete();
            return redirect()->back()->with('delete', 'Bus Deleted');
        }
    }




    public function city(Request $request)
    {
        $cities = City::all();

        if ($request->ajax()) {
            $query = $request->input('query');

            $cities  = City::query();
            if ($query) {
                $cities = $cities->where('name', 'like', '%' . $query . '%');
            }
            $cities = $cities->get();
            return view('user.city-ajax', compact('cities'));
        }

        return view('user.city', compact('cities'));
    }
    public function addCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $city = new City();
        $city->name = $request->name;
        $city->save();
        return redirect()->back()->with('success', 'City Added Successfully');
    }
    public function editCity(Request $request, $city_id)
    {
        $city =  City::find($city_id);
        $city->name = $request->name;
        $city->save();
        return redirect()->back()->with('success', 'City Edit Successfully');
    }

    public function deleteCity($city_id)
    {

        $city = City::find($city_id);
        if ($city) {
            $city->delete();
            return redirect()->back()->with('delete', 'City Deleted Successfully');
        }
    }

    public function route(Request $request)
    {
        $cities = City::all();

        $routes = Route::all();
        if ($request->ajax()) {
            $query = $request->input('query');

            $routes  = Route::query();
            if ($query) {
                $cities = City::all();

                $routes = $routes->where('departure', 'like', '%' . $query . '%')->orWhere('arival', 'like', '%' . $query . '%');
            }
            $routes = $routes->get();
            return view('user.route-ajax', compact('routes', 'cities'));
        }
        return view('user.route', compact('routes', 'cities'));
    }

    public function addRoute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'departure' => 'required',
            'arrival'  => 'required|exists:cities,name'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->departure == $request->arrival) {
            return redirect()->back()->with('delete', 'Both City Are Same');
        } else {

            $route = Route::where('departure', $request->departure)->where('arival', $request->arrival)->first();
            if ($route) {
                return redirect()->back()->with('delete', 'Route already Exists');
            } else {
                $route = new Route();
                $route->departure = $request->departure;
                $route->arival = $request->arrival;
                $route->save();
                return redirect()->back()->with('success', 'Route Added Successfully');
            }
        }
    }

    public function editRoute(Request $request, $route_id)
    {
        $route = Route::find($route_id);
        if ($route) {
            $route->departure = $request->departure;
            $route->arival = $request->arrival;
        }
    }
    public function deleteRoute($rout_id)
    {
        $route = Route::find($rout_id);
        if ($route) {
            $route->delete();
            return redirect()->back()->with('delete', 'Route Deleted Successfully');
        }
    }




    public function schedules(Request $request)
    {
        $schedules = BusSchedule::all();
        // if ($request->ajax()) {
        //     $query = $request->input('query');

        //     $schedules  = BusSchedule::query();
        //     if ($query) {

        //         $schedules = $schedules->where('departure', 'like', '%' . $query . '%')->orWhere('arival', 'like', '%' . $query . '%');
        //     }
        //     $schedules = $schedules->get();
        //     return view('user.route-ajax', compact('routes','cities'));
        // }


        foreach ($schedules as $schedule) {
            $route = Route::find($schedule->route_id);
            $schedule->routes = $route;
            $buses = Bus::find($schedule->bus_id);
            $schedule->buses = $buses;
        }
        $buses = Bus::all();
        $routes = Route::all();

        return view('user.schedule', compact('schedules', 'routes', 'buses'));
    }
    public function  scheduleStatus($id)
    {
        $schedule = BusSchedule::find($id);
        if ($schedule) {
            if ($schedule->status == 1) {
                $schedule->status = 0;
                $schedule->save();
            } else {
                $schedule->status = 1;
                $schedule->save();
            }
        }
        return redirect()->back();
    }

    public function addSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'day' => 'required',
            'bus_id'  => 'required|exists:buses,id',
            'route_id'  => 'required|exists:routes,id',
            'departure_time'  => 'required|date_format:H:i',
            'arrival_time'  => 'required|date_format:H:i',
            'charges'  => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $departureTime = Carbon::createFromFormat('H:i', $request->departure_time)->format('h:i A');
        $arrivalTime = Carbon::createFromFormat('H:i', $request->arrival_time)->format('h:i A');
        $days = implode(',', $request->day);
        $schedule = new BusSchedule();
        $schedule->bus_id = $request->bus_id;
        $schedule->route_id = $request->route_id;
        $schedule->charge = $request->charges;
        $schedule->departure_time = $departureTime;
        $schedule->arrival_time = $arrivalTime;
        $schedule->days = $days;
        $schedule->save();
        return redirect()->back()->with('success', 'Schedule  Added Successfully');
    }

    public function scheduleDetail($id)
    {

        $schedule = BusSchedule::find($id);
        $route = Route::find($schedule->route_id);
        $bus = Bus::find($schedule->bus_id);
        $schedule->route = $route;
        $schedule->bus = $bus;

        $buses = Bus::all();
        $routes = Route::all();
        return view('user.scheduleDetail', compact('schedule', 'buses', 'routes'));
    }

    public function scheduleEdit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'day' => 'required',
            'bus_id'  => 'required|exists:buses,id',
            'route_id'  => 'required|exists:routes,id',
            'departure_time'  => 'required|date_format:H:i',
            'arrival_time'  => 'required|date_format:H:i',
            'charges'  => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $departureTime = Carbon::createFromFormat('H:i', $request->departure_time)->format('h:i A');
        $arrivalTime = Carbon::createFromFormat('H:i', $request->arrival_time)->format('h:i A');

        $schedule = BusSchedule::find($id);
        if ($schedule) {
            $days = implode(',', $request->day);
            $schedule->bus_id = $request->bus_id;
            $schedule->route_id = $request->route_id;
            $schedule->charge = $request->charges;
            $schedule->departure_time = $departureTime;
            $schedule->arrival_time = $arrivalTime;
            $schedule->days = $days;
            $schedule->save();
        }
        return redirect()->back()->with('success', 'Schedule  Edit Successfully');
    }


    public function scheduleDelete($id)
    {
        $schedule = BusSchedule::find($id);
        $schedule->delete();
        return redirect()->route('dashboard-schedules')->with('delete', 'Schedule  Deleted Successfully');
    }

    public function busImage()
    {
        $images = BusImage::all();
        return view('user.busImage', compact('images'));
    }

    public function addBusImage(Request $request)
    {
        $busImage = new BusImage();

        if ($image = $request->file('image')) {
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('bus'), $filename);

            $busImage->image = $filename;
            $busImage->save();
        }

        return redirect()->back();
    }

    public function deleteBusImage($id)
    {
        $image = BusImage::find($id);
        $imagePath = public_path('bus') . '/' . $image->image;
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $image->delete();
        return redirect()->back();
    }

    public function getCategory()
    {
        $categories = ReportCategory::all();

        return view('user.category', compact('categories'));
    }

    public function deleteCategory($id)
    {
        $category = ReportCategory::find($id);
        $category->delete();
        return redirect()->back()->with('delete', 'Category  Deleted');
    }

    public function addCategory(Request $request)
    {
        $category = new ReportCategory();
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('success', 'Category  Added Successfully');
    }


    public function users(Request $request)
    {
        $users = User::all();
        if ($request->ajax()) {
            $query = $request->input('query');

            $users  = User::query();
            if ($query) {

                $users = $users->where('name', 'like', '%' . $query . '%');
            }
            $users = $users->get();
            return view('user.user-ajax', compact('users'));
        }
        return view('user.user', compact('users'));
    }

    public function exportCSV()
    {

        $users = User::select('name', 'phone')->get()->toArray();

        // Define the CSV filename
        $filename = 'users.csv';

        // Define the headers for the CSV file
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        // Create a closure to write the data into the CSV file
        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Phone']); // Add headers to the CSV file
            foreach ($users as $user) {
                fputcsv($file, $user); // Write each user's data to the CSV file
            }
            fclose($file);
        };

        // Return the response with headers and the closure
        return Response::stream($callback, 200, $headers);
    }


    public function addUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone|string|max:50',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        $user->save();
        return redirect()->back()->with('success', 'User  Added Successfully');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('delete', 'User  Deleted');
    }

    public function faqs()
    {
        $faqs = Faq::all();

        return view('user.faq', compact('faqs'));
    }

    public function deleteFaq($id)
    {
        $faq  = Faq::find($id);
        $faq->delete();
        return redirect()->back()->with('delete', 'FAQ Deleted');
    }

    public function addFaq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        return redirect()->back()->with('success', 'FAQ  Added Successfully');
    }

    public function account()
    {
        return view('user.account');
    }
    public function accountUpdate(Request $request)
    {
        $id = auth()->user()->id;
        $admin = Admin::find($id);
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->save();
        return redirect()->back()->with('success' , 'Updated Successfully');
    }

    public function accountSecurity()
    {
        return view('user.security');
    }



    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
