<?php

use App\Model\Admin\Product;
use Illuminate\Database\Seeder;

class UpdateShortDesToProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::where('status', 1)->where('type', Product::TYPE_AFFILIATE)->get();
        foreach ($products as $product) {
            $product->short_des = '<p style="text-align:justify"><span style="font-size:14pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif">- Sản phẩm thuộc s&agrave;n TMĐT Shopee, gi&aacute; hiển thị tr&ecirc;n Globalmarket ch&iacute;nh l&agrave; gi&aacute; b&aacute;n tr&ecirc;n s&agrave;n Shopee. Qu&yacute; kh&aacute;ch sẽ tiến h&agrave;nh mua sản phẩm trực tiếp tr&ecirc;n s&agrave;n Shopee sau khi ấn v&agrave;o n&uacute;t “Mua h&agrave;ng”.</span></span></span></p>

<p style="text-align:justify"><span style="font-size:14pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif">- Khi mua h&agrave;ng th&ocirc;ng qua globalmarket.com.vn, ngo&agrave;i việc đảm bảo giữ nguy&ecirc;n c&aacute;c ch&iacute;nh s&aacute;ch ưu đ&atilde;i, voucher từ Shopee th&igrave; qu&yacute; kh&aacute;ch c&ograve;n được tr&iacute;ch thưởng hoa hồng tại s&agrave;n Globalmarket.</span></span></span></p>

<p style="text-align:justify"><span style="font-size:14pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif">- C&aacute;c loại hoa hồng được hiển thị c&ocirc;ng khai tr&ecirc;n website, ngay ph&iacute;a dưới của từng sản phẩm. Chi tiết c&aacute;c loại hoa hồng, qu&yacute; kh&aacute;ch vui l&ograve;ng tham khảo tại <u><strong><a href="https://globalmarket.com.vn/gioi-thieu.html">đ&acirc;y</a></strong></u></span></span></span></p>

<p style="text-align:justify"><span style="font-size:14pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><strong><em>* <u>Lưu &yacute;:</u></em></strong> Để nhận được hoa hồng, qu&yacute; kh&aacute;ch cần mua đ&uacute;ng sản phẩm được gắn link tr&ecirc;n website globalmarket.com.vn v&agrave; tiến h&agrave;nh đối so&aacute;t sau khi mua h&agrave;ng <em>(chi tiết hướng dẫn tại <u><strong><a href="https://globalmarket.com.vn/tin-tuc/huong-dan.html">đ&acirc;y</a></strong></u> )</em></span></span></span></p>
';
            $product->save();
        }
    }
}
