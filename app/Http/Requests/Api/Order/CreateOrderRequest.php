<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer.id' => 'required',
            'customer.mobile' => 'required',
            'customer.email' => 'required|email',
            'receiver.phone' => 'required',
            'delivery_method' => 'required',
            'branch_id' => 'required',
            'courier_id' => 'required',
            'ship_to.country' => 'required',
            'ship_to.city' => 'required',
            'ship_to.block' => 'required',
            'ship_to.street_number' => 'required',
            'ship_to.address' => 'required',
            'payment.status' => 'required',
            'payment.method' => 'required',
            'products' => 'required|array',
            'products.*.identifier_type' => 'required',
            'products.*.identifier' => 'required',
            'products.*.quantity' => 'required',
        ];
    }
}
