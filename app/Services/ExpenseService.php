<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Mail\MailerMailable;
use Illuminate\Support\Facades\Mail;
use App\Models\Expense;
use App\Models\User;


class ExpenseService
{

    protected $maxDescriptionLenght = 191;

    public function validateExpenseSchema($data){
        
        $validator = Validator::make($data, [
            'description' => ['string','max:'.$this->maxDescriptionLenght],
            'date' => ['date_format:Y-m-d H:i:s'],
            'amount' => ['numeric', 'min:0']
        ]);
        
        $validator->after(function ($validator) use ($data){

            if(isset($data['user_id'])){
                $user = User::find($data['user_id']);

                if (!$user) {
                    $validator->errors()->add('user_id', 'User not exists');
                }
            }
            
            if(isset($data['date']) && $data['date'] > date('Y-m-d H:i:s')){
                $validator->errors()->add('date', 'Data in the future is not accepted');
            }    
    
        });

       return $validator;
    }

    public function getAll()
    {
        return Expense::all()->where('user_id', auth()->user()->id)->values();
    }

    public function create($data)
    {
       $valid = $this->validateExpenseSchema($data);

       if($valid->fails())
            return array("errors" => $valid->errors());


        return Expense::create([
            "description" => $data['description'],
            "date" => isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s'),
            "amount" => $data['amount'],
            "user_id" => $data['user_id']
        ]);
    }

    public function getById($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return array('errors' =>[
                'expense'=> 'Expense not found'
            ]);
        }

        return $expense;
    }

    public function save($data)
    {
        $valid = $this->validateExpenseSchema($data);

        if($valid->fails())
            return array("errors" => $valid->errors());

        $expense = Expense::find($data['id']);

        $expense->description = $data['description'];
        $expense->amount = $data['amount'];

        if($expense->save()){
            return $expense;
        }
    }

    public function delete($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return array("errors" => 'Expense not found');
        }

        return $expense->delete();
    }
}
