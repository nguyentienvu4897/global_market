@include('admin.configs.ConfigGallery')

<script>
    class Config extends BaseClass {
        no_set = [];
        before(form) {
            this.image = {};
        }
        after(form) {
        }
        get image() {
            return this._image;
        }
        set image(value) {
            this._image = new Image(value, this);
        }
		clearImage() {
			if (this.image) this.image.clear();
		}

        get favicon() {
            return this._favicon;
        }

        set favicon(value) {
            this._favicon= new Image(value, this);
        }

        get revenue_percent_5() {
            return this._revenue_percent_5;
        }

        set revenue_percent_5(value) {
            this._revenue_percent_5= value || 0;
        }

        get revenue_percent_4() {
            return this._revenue_percent_4;
        }

        set revenue_percent_4(value) {
            this._revenue_percent_4= value || 0;
        }

        get revenue_percent_3() {
            return this._revenue_percent_3;
        }

        set revenue_percent_3(value) {
            this._revenue_percent_3= value || 0;
        }

        get revenue_percent_2() {
            return this._revenue_percent_2;
        }

        set revenue_percent_2(value) {
            this._revenue_percent_2= value || 0;
        }

        get revenue_percent_1() {
            return this._revenue_percent_1;
        }

        set revenue_percent_1(value) {
            this._revenue_percent_1= value || 0;
        }

        clearFavicon() {
            if (this.favicon) this.favicon.clear();
        }

        get galleries() {
            return this._galleries || [];
        }

        set galleries(value) {
            this._galleries = (value || []).map(val => new ConfigGallery(val, this));
        }

        addGallery(gallery) {
            if (!this._galleries) this._galleries = [];
            let new_gallery = new ConfigGallery(gallery, this);
            this._galleries.push(new_gallery);
            return new_gallery;
        }

        removeGallery(index) {
            this._galleries.splice(index, 1);
        }

        get submit_data() {
            let data = {
                web_title: this.web_title,
                web_des: this.web_des,
                short_name_company: this.short_name_company,
                email: this.email,
                twitter: this.twitter,
                instagram: this.instagram,
                youtube: this.youtube,
                facebook: this.facebook,
                hotline: this.hotline,
                address_company: this.address_company,
                address_center_insurance: this.address_center_insurance,
                zalo: this.zalo,
                location: this.location,
                click_call: this.click_call,
                facebook_chat: this.facebook_chat,
                zalo_chat: this.zalo_chat,
                phone_switchboard: this.phone_switchboard,
                introduction: this.introduction,
                tax_code: this.tax_code,
                revenue_percent_5: this.revenue_percent_5,
                revenue_percent_4: this.revenue_percent_4,
                revenue_percent_3: this.revenue_percent_3,
                revenue_percent_2: this.revenue_percent_2,
                revenue_percent_1: this.revenue_percent_1,
            }
            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);
            let favicon = this.favicon.submit_data;
            if (favicon) data.append('favicon', favicon);

            this.galleries.forEach((g, i) => {
                if (g.id) data.append(`galleries[${i}][id]`, g.id);
                let gallery = g.image.submit_data;
                if (gallery) data.append(`galleries[${i}][image]`, gallery);
                else data.append(`galleries[${i}][image_obj]`, g.id);
            })

            return data;
        }
    }
</script>
