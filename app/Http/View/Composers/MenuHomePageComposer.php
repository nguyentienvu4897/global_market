<?php

namespace App\Http\View\Composers;

use App\Model\Admin\Banner;
use App\Model\Admin\Category;
use App\Model\Admin\PostCategory;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\OrderRevenueDetail;

class MenuHomePageComposer
{
    /**
     * Compose Settings Menu
     * @param View $view
     */
    public function compose(View $view)
    {
        $productCategories = Category::query()->with([
            'childs' => function ($query) {
                $query->with(['childs']);
            }
        ])
        ->where(['type' => 1, 'parent_id' => 0])
        ->orderBy('sort_order')
        ->get();

        $user = Auth::guard('client')->user();
        if ($user) {
            $quyet_toan_amount = OrderRevenueDetail::where('user_id', $user->id)->where(function($q) {
                $q->where('status', OrderRevenueDetail::STATUS_QUYET_TOAN)
                ->orWhere(function($query) {
                    $query->where('status', OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN)
                    ->where('settlement_amount', '>', 0);
                });
            })->sum('settlement_amount');
            $waiting_quyet_toan_amount = OrderRevenueDetail::where('user_id', $user->id)->where(function($q) {
                $q->where('status', OrderRevenueDetail::STATUS_WAIT_QUYET_TOAN)
                ->orWhere(function($query) {
                    $query->where('status', OrderRevenueDetail::STATUS_QUYET_TOAN)
                    ->where('settlement_amount', '>', 0);
                });
            })->sum('revenue_amount') - $quyet_toan_amount;
        } else {
            $waiting_quyet_toan_amount = 0;
        }

        $postCategories = PostCategory::query()->where(['parent_id' => 0, 'show_home_page' => 1])->latest()->get();

        $view->with(['productCategories' => $productCategories, 'postCategories' => $postCategories, 'waiting_quyet_toan_amount' => $waiting_quyet_toan_amount]);
    }
}
