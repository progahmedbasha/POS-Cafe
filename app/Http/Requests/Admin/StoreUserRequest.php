<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Request;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
   public function rules(): array
    {
        $rules = [
            'name' => 'required|max:100',
            'type_id' => 'required',
        ];

        // التحقق من نوع الطلب لتحديد قواعد البريد الإلكتروني وكلمة المرور
        if ($this->isMethod('POST')) {
            // --- هذه هي قواعد الإضافة (Create) ---
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];

        } elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // --- هذه هي قواعد التحديث (Update) ---
            
            // احصل على ID المستخدم من الرابط
            $userId = $this->route('admin'); // أو 'client' حسب اسم الـ parameter

            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ];
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }
}