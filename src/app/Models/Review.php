<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_id',
        'score_a',
        'score_b',
        'score_c',
    ];

    protected $casts = [
        'score_a' => 'int',
        'score_b' => 'int',
        'score_c' => 'int',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * レビューの平均値を取得
     *
     * @return float
     */
    public function getAvgScore(): float
    {
        return round(($this->score_a + $this->score_b + $this->score_c) / 3, 1);
    }
}
