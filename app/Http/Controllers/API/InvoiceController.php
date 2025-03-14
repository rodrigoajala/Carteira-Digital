<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
class InvoiceController extends Controller
{
    public function register(InvoiceRequest $request)
    {
        $user_id = auth()->id();
        $invoice = Invoice::create([

            'title' => $request['title'],
            'description' => $request['description'],
            'status' => $request['status'],
            'value' => $request['value'],
            'user_id' => $user_id

        ]);
        return response()->json([
            'message' => 'Cobrança criado com sucesso!',
            'invoice' => $invoice
        ]);
    }

    public function payInvoice($invoiceId)
    {
        $user = auth()->user();

        if ($user->role !== 'employee') {
            return response()->json(['message' => 'Somente funcionários podem pagar faturas']);
        }

        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            return response()->json(['message' => 'Fatura não encontrada']);
        }


        if ($invoice->user_id !== $user->id) {
            return response()->json(['message' => 'Esta fatura não pertence ao usuario logado']);
        }

        if ($user->credits < $invoice->value) {
            return response()->json(['message' => 'Créditos insuficientes para pagar esta fatura']);
        }

        $user->credits -= $invoice->value;
        $user->save();

        $invoice->status = 'approved';
        $invoice->save();

        return response()->json([
            'message' => 'Fatura paga com sucesso!',
            'user' => $user,
            'invoice' => $invoice
        ]);
    }

    public function listInvoices()
    {
        $user = auth()->user();

        if ($user->role !== 'employee') {
            return response()->json(['message' => 'Somente funcionários podem visualizar suas faturas']);
        }

        $invoices = Invoice::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'canceled'])
            ->get();


        if ($invoices->isEmpty()) {
            return response()->json(['message' => 'Você não tem faturas pendentes ou canceladas']);
        }

        return response()->json([
            'message' => 'Faturas encontradas',
            'invoices' => $invoices
        ]);
    }
}
