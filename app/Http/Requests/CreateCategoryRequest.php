<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,NULL,id,user_id,' . $this->user()->id],
            'description' => ['nullable', 'string'],
            'color' => ['string', 'max:10'],
            'icon' => ['string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('name') || !$this->input('name')) {
            return;
        }

        $this->merge([
            'slug' => $this->generateUniqueSlug($this->input('name')),
        ]);
    }

    protected function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $userId = $this->user()->id;

        $existingSlugs = Category::query()
            ->where('user_id', $userId)
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('slug', 'LIKE', "{$slug}-%");
            })
            ->pluck('slug');

        if (!$existingSlugs->contains($slug)) {
            return $slug;
        }

        $count = 1;
        while ($existingSlugs->contains("{$slug}-{$count}")) {
            $count++;
        }

        return "{$slug}-{$count}";
    }
}
