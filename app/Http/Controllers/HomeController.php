<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $countOfOrders = Order::count();
        $countOfOrdersAccepted = Order::where('state', 'accepted')->count();
        $countOfOrdersDelivered = Order::where('state', 'delivered')->count();
        $countOfOrdersRejected = Order::where('state', 'rejected')->count();
        $countOfOrdersPending = Order::where('state', 'pending')->count();

        $accepted = round($countOfOrdersAccepted/$countOfOrders*100, 2);
        $delivered = round($countOfOrdersDelivered/$countOfOrders*100, 2);
        $rejected = round($countOfOrdersRejected/$countOfOrders*100, 2);
        $pending = round($countOfOrdersPending/$countOfOrders*100, 2);


        // Bar Chart
        $chartjs = app()->chartjs
                 ->name('barChartTest')
                 ->type('bar')
                 ->size(['width' => 450, 'height' => 300])
                 ->labels(['طلبات مقبولة', 'طلبات ناحجة','طلبات مرفوضة','طلبات جديدة'])
                 ->datasets([
                     [
                         "label" => "نسبة الطلبات ",
                         'backgroundColor' => ['#8C1915','#18D911','#FF5E07','063B76'],
                         'data' => [$accepted,$delivered,$rejected,$pending]
                     ]
                 ])
                 ->options([]);


        //  Pie Chart / Doughnut Chart
        $chartjs2 = app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 450, 'height' => 300])
                ->labels(['طلبات مقبولة', 'طلبات ناحجة','طلبات مرفوضة','طلبات جديدة'])
                ->datasets([
                    [
                // 'backgroundColor' => ['#8C1915','#18D911','#FF5E07','D3757D'],
                // 'hoverBackgroundColor' => ['#FF6384','#6E2F20','#B7BDCA','rgba(54, 162, 235, 0.3)'],
                'backgroundColor' => ['#8C1915','#18D911','#FF5E07','063B76'],
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => [$accepted,$delivered,$rejected,$pending]
                    ]
                ])
                ->options([]);

        return view('home', ['chartjs'=>$chartjs,'chartjs2'=>$chartjs2]);
    }// index



    public function changePassword()
    {
         return view('users.change-paaword');
    }


    public function updatePassword(Request $request)
    {
            # Validation
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);

            $user = auth()->user();

            #Match The Old Password
            if(!Hash::check($request->old_password, $user->password)){
                return back()->with("error", "Old Password Doesn't match!");
            }

            #Update the new Password
            $user->whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            toastr()->warning('تم تغيير كلمة المرور بنجاح');
            return back();
    }




}
