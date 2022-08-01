<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\MoneyValidation;
use App\Http\Requests\ConfirmValidation;
use App\Models\Historic;

class BalanceController extends Controller
{
    private $totalPage = 2;

    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view('admin.balance.index',compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidation $request)
    {
        //pego os dados do usuário logado
        $balance = auth()->user()->balance()->firstOrCreate([]);

        $resposta = $balance->deposit($request->value);

        if ($resposta['success']) {
            return redirect()
                ->route('balance')
                ->with('success',$resposta['message']);
        }

        return redirect()
            ->back()//volta de onde veio
            ->with('error', $resposta['message']);
    }

    public function withdraw()
    {
        return view('admin.balance.withdraw');
    }

    public function withdrawStore(MoneyValidation $request)
    {
        //pego os dados do usuário logado
        $balance = auth()->user()->balance()->firstOrCreate([]);

        $resposta = $balance->withdraw($request->value);

        if ($resposta['success']) {
            return redirect()
                ->route('balance')
                ->with('success', $resposta['message']);
        }

        return redirect()
            ->back() //volta de onde veio
            ->with('error', $resposta['message']);
    }

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(ConfirmValidation $request, User $user)
    {
        $sender = $user->getSender($request->sender);

        if (!$sender) {
            return redirect()->back()
                ->with('error', 'Usuário informado não encontrado!');
        }
        if($sender->id === auth()->user()->id){
            return redirect()->back()
                ->with('error', 'Usuário não pode transferir para si mesmo!');
        }

        $balance = auth()->user()->balance;
        return view('admin.balance.transferConfirm',compact('sender', 'balance'));
    }

    public function transferStore(MoneyValidation $request, User $user)
    {
        $sender = $user->find($request->sender_id);
        if (!$sender) {
            return redirect()
                ->route('balance.transfer')
                ->with('success', 'Recebedor não encontrado!');
        }
        //pego os dados do usuário logado
        $balance = auth()->user()->balance()->firstOrCreate([]);

        $resposta = $balance->transfer($request->value, $sender);

        if ($resposta['success']) {
            return redirect()
                ->route('balance')
                ->with('success', $resposta['message']);
        }

        return redirect()
            ->route('balance.transfer')
            ->with('error', $resposta['message']);
    }

    //Acesso o historico do usuário logado e mando para a view de histórico
    public function historic(Historic $historic)
    {
        $historics = auth()->user()
            ->historics()
            ->with(['userSender'])
            ->paginate($this->totalPage);//divide a quantidade de resgistros passados
        $types = $historic->type();

        return view('admin.balance.historic', compact('historics','types'));
    }

    public function searchHistoric(Request $request, Historic $historic)
    {
        //pego dos os dados exceto o token
        $dataForm = $request->except('_token');
        $historics = $historic->search($dataForm, $this->totalPage);

        $types = $historic->type();

        return view('admin.balance.historic', compact('historics', 'types', 'dataForm'));
    }
}
