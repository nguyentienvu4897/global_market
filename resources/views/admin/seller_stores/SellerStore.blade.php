<script>
    class SellerStore extends BaseClass {
        no_set = [];

        before(form) {
            this.logo = {};
            this.banner = {};
        }

        after(form) {
        }

        get logo() {
            return this._logo;
        }

        set logo(value) {
            this._logo = new Image(value, this);
        }

        get banner() {
            return this._banner;
        }

        set banner(value) {
            this._banner = new Image(value, this);
        }

        get submit_data() {
            let data = {
                shop_name: this.shop_name,
                company_name: this.company_name,
                hotline: this.hotline,
                phone: this.phone,
                address: this.address,
                facebook: this.facebook,
                instagram: this.instagram,
                tiktok: this.tiktok,
                zalo: this.zalo,
                youtube: this.youtube,
                status: this.status,
            }

            data = jsonToFormData(data);
            let logo = this.logo.submit_data;
            if (logo) data.append('logo', logo);
            let banner = this.banner.submit_data;
            if (banner) data.append('banner', banner);
            return data;
        }
    }
</script>
