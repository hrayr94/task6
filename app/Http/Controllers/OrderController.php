<?php

namespace App\Http\Controllers;

use App\Models\Database;
use App\Models\Order;
use App\Models\Customer;
use App\RMVC\View\View;

class OrderController extends Controller
{
    private Order $orderModel;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $this->orderModel = new Order($db);
    }

    public function index()
    {
        $orders = $this->orderModel->all();
        return View::view('orders.index', ['orders' => $orders]);
    }

    public function details($customerId)
    {
        $customerModel = new Customer(Database::getInstance()->getConnection());
        $customer = $customerModel->getById($customerId);

        if ($customer) {
            return View::view('orders.details', ['customer' => $customer]);
        } else {
            return "Customer not found";
        }
    }
}
