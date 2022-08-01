<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value) : Array//tipo de retorno
    {
        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value,2,'.','');
        $deposito = $this->save();

        //criando o hisótico do usuário
        $historico = auth()->user()->historics()->create([
            'type'          => 'I',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd')
        ]);
        if ($deposito && $historico) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];
        }else{
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Falha ao recarregar'
            ];
        }
    }

    public function withdraw(float $value) : Array
    {
        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Você não tem saldo suficiente'
            ];
        }
        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $retirada = $this->save();

        //criando o hisótico do usuário
        $historico = auth()->user()->historics()->create([
            'type'          => 'O',
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Ymd')
        ]);
        if ($retirada && $historico) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao retirar'
            ];
        } else {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Falha ao retirar'
            ];
        }
    }

    public function transfer(float $value, User $sender): Array
    {
        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Você não tem saldo suficiente'
            ];
        }
        DB::beginTransaction();

        /** *********************************************************************
         * Atualiza o próprio saldo
         * **********************************************************************/
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $tranfer = $this->save();

        //criando o histórico do usuário
        $historico = auth()->user()->historics()->create([
            'type'                  => 'T',
            'amount'                => $value,
            'total_before'          => $totalBefore,
            'total_after'           => $this->amount,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => $sender->id
        ]);

        /** *********************************************************************
         * Atualiza o saldo do recebedor
         * **********************************************************************/
        //se não existir o registro, ele é criado
        $senderBalance = $sender->balance()->firstOrCreate([]);
        // dd($senderBalance->amount);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', '');
        $tranferSender = $senderBalance->save();

        //criando o histórico do usuário recebedor
        $historicoSender = $sender->historics()->create([
            'type'                  => 'I',
            'amount'                => $value,
            'total_before'          => $totalBeforeSender,
            'total_after'           => $senderBalance->amount,
            'date'                  => date('Ymd'),
            'user_id_transaction'   => auth()->user()->id,
        ]);



        if ($tranfer && $historico && $tranferSender && $historicoSender) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao transferir'
            ];
        }

        DB::rollBack();
        return [
            'success' => false,
            'message' => 'Falha ao transferir'
        ];

    }
}
