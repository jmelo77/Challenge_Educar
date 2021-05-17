<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Recharge;
use App\Models\Transfer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditoresController extends Controller
{

    public function index()
    {
        $list = Employee::select('employees.id', 'employees.document', 'positions.name', 'employees.name',  'employees.surname', 'employees.balance')
            ->join('positions', 'employees.id_position', '=', 'positions.id')
            ->get();

        return response()->json([$list]);
        
    }

    public function show(Request $request)
    {
        $document = $request->post('document');

        $list = Employee::select('employees.id', 'employees.document', 'positions.name', 'employees.name', 'employees.surname', 'employees.balance')
            ->join('positions', 'employees.id_position', '=', 'positions.id')
            ->where('employees.document', $document)
            ->get();

        if (count($list) == 0) {
            return 'There is no registered employee with this document number';
        }
        
        return response()->json([$list]);
    }


    public function recharge(Request $request)
    {
        $document = $request->post('document');
        $recharge   = $request->post('recharge');

        $validator = Validator::make($request->all(), [
            'document' => 'required|max:20|min:5',
            'recharge' => 'required|numeric|gt:0'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
            die;

        } else {
            
            $employee = $this->current_balance($document);
            if (count($employee) == 0) {
                return 'There is no registered employee with this document number';
                die;
            }
            
            Recharge::create([
                'id_employee' => $employee[0]['id'],
                'recharge'    => $recharge
            ]);
            
            $new_balance = $employee[0]['balance'] + $recharge;
            Employee::where('id', $employee[0]['id'])
                ->update(['balance' => $new_balance]);

            return '¡Successful reload! the employee new balance ' . $employee[0]['name'] . ' ' . $employee[0]['surname'] . ' is ' . $new_balance;

        }
    }


    public function transfer(Request $request)
    {
        $id_employee_transfers = $request->post('id_employee_transfers');
        $id_employee_receives  = $request->post('id_employee_receives');
        $transfer              = $request->post('transfer');

        $validator = $validator = Validator::make($request->all(), [
            'id_employee_transfers' => 'required|max:20|min:5',
            'id_employee_receives'  => 'required|max:20|min:5',
            'transfer'              => 'required|numeric|gt:0'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
            die;
        } else {
            if ($id_employee_receives === $id_employee_transfers) {
                return 'The document number of the receiving and transferring employee is the same';
                die;
            }

            $employee_transfers = $this->current_balance($id_employee_transfers);
            if (count($employee_transfers) == 0) {
                return 'The document number of the transferring employee is not registered';
                die;
            } else if ($employee_transfers[0]['balance'] < $transfer) {
                return 'The employee transferring money has insufficient balance, your current balance is ' . $employee_transfers[0]['saldo'];
                die;
            }

            $employee_receives = $this->current_balance($id_employee_receives);
            if (count($employee_receives) == 0) {
                return 'The document number of the employee you receive is not registered';
                die;
            }

            Transfer::create([
                'id_employee_transfers' => $employee_transfers[0]['id'],
                'id_employee_receives'  => $employee_receives[0]['id'],
                'transfer'              => $transfer
            ]);

            $total_employee_receives = $employee_receives[0]['balance'] + $transfer;
            Employee::where('document', $id_employee_receives)->update(['balance' => $total_employee_receives]);

            $total_employee_transfers = $employee_transfers[0]['balance'] - $transfer;
            Employee::where('document', $id_employee_transfers)->update(['balance' => $total_employee_transfers]);

            return 'Successful transfer, the current balance of the receiving employee (' . $employee_receives[0]['name'] . ' ' . $employee_receives[0]['surname'] . ') is ' . $total_employee_receives. 
            ' and the current balance of the transferring employee (' . $employee_transfers[0]['name'] . ' ' . $employee_transfers[0]['surname'] . ') is ' . $total_employee_transfers;
        }
    }
 

    private function current_balance($document)
    {
        $data = Employee::select('*')->where('document', $document)->get();
        return $data;
    }
    
}
