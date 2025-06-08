<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'category_id',
        'detail'
    ];

    /**
     * Category モデルとのリレーションを定義します。
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 性別で問い合わせを検索するスコープ。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $gender
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }
        return $query; // チェーンメソッドのために$queryを返す
    }

    /**
     * カテゴリIDで問い合わせを検索するスコープ。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|null  $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategorySearch($query, $categoryId)
    {
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * お問い合わせ日で問い合わせを検索するスコープ（指定日以降）。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $dateFrom
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateSearchFrom($query, $dateFrom)
    {
        if (!empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        return $query;
    }

    /**
     * お問い合わせ日で問い合わせを検索するスコープ（指定日以前）。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $dateTo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateSearchTo($query, $dateTo)
    {
        if (!empty($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        return $query;
    }

    /**
     * 名前（first_name, last_name）またはメールアドレスで問い合わせを検索するスコープ。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNameEmailSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', '%' . $keyword . '%')
                  ->orWhere('last_name', 'like', '%' . $keyword . '%')
                  ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }
}
