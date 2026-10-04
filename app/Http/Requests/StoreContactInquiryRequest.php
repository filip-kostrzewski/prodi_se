<?php

namespace App\Http\Requests;

use App\Package;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->singleLine('name'),
            'company' => $this->optionalSingleLine('company'),
            'email' => $this->string('email')->trim()->lower()->toString(),
            'phone' => $this->optionalSingleLine('phone'),
            'message' => $this->string('message')->trim()->toString(),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'package' => ['required', Rule::enum(Package::class)],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('site.form.errors.name_required'),
            'name.max' => __('site.form.errors.name_max'),
            'company.max' => __('site.form.errors.company_max'),
            'email.required' => __('site.form.errors.email_required'),
            'email.email' => __('site.form.errors.email_invalid'),
            'email.max' => __('site.form.errors.email_max'),
            'phone.max' => __('site.form.errors.phone_max'),
            'package.required' => __('site.form.errors.package_required'),
            'package.enum' => __('site.form.errors.package_invalid'),
            'message.required' => __('site.form.errors.message_required'),
            'message.max' => __('site.form.errors.message_max'),
        ];
    }

    private function singleLine(string $key): string
    {
        return str_replace(["\r", "\n"], '', $this->string($key)->trim()->toString());
    }

    private function optionalSingleLine(string $key): ?string
    {
        if (! $this->filled($key)) {
            return null;
        }

        $value = $this->singleLine($key);

        return $value === '' ? null : $value;
    }
}
