<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Historic extends Model
{

    protected $fillable = ['type','amount','total_before','total_after', 'user_id_transaction', 'date'];

    //escopo local para filtrar por usuário
    public function scopeUserAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    //Convenção padrão (usando a classe carbon)
    //getDateAttribute -> get para buscar, Date -> o nome do atributo(banco) e o prefixo Attribute,
    //assim ,formata a data quando o dado é recuperado
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    //Retornar o qual o nome do tipo no histórico
    public function type($type = null)//parâmetro opcional
    {
        $types = [
            'I' => 'Entrada',
            'O' => 'Saque',
            'T' => 'Transferência',
        ];

        if (!$type) {
            return $types;
        }

        //$this -> próprio elemento em si, neste caso historic
        if ($this->user_id_transaction != null && $type == 'I') {
            return 'Entrada(Transferência)';
        }
        return $types[$type];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relacionamento muitos para um
    //retorna o usuário dos históricos
    public function userSender()
    {
        return $this->belongsTo(User::class,'user_id_transaction');
    }

    //função responsável por buscar os parametros enviados dos filtros
    public function search(Array $data, $totalPage)
    {
        $historics = $this->where(function ($query) use ($data,$totalPage){
            if (isset($data['id'])) {
                $query->where('id', $data['id']);
            }
            if (isset($data['date'])) {
                $query->where('date', $data['date']);
            }
            if (isset($data['type'])) {
                $query->where('type',$data['type']);
                // $query->where('type', 'like', '%' . $data['type'] . '%');
            }
        })->UserAuth()
        // ->where('user_id',auth()->user()->id)
        ->with(['userSender'])
        ->paginate($totalPage);
        // ->toSql();
        // dd($historics);
        return $historics;
    }
}
