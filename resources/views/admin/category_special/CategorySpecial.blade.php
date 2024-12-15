<script>
    class CategorySpecial extends BaseClass {
        no_set = [];

        before(form) {
            this.image = {};
        }

        after(form) {

        }

        get end_date() {
            return this._end_date ? moment(this._end_date).toDate() : '';
        }

        set end_date(value) {
            this._end_date = value ? moment(value).format('YYYY-MM-DD') : '';
        }

        // Ảnh đại diện
        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);

        }

        clearImage() {
            if (this.image) this.image.clear();
        }


        get submit_data() {
            let data = {
                name: this.name,
                code: this.code,
                type: this.type,
                order_number: this.order_number,
                show_home_page: this.show_home_page,
                end_date: this._end_date,
            }
            data = jsonToFormData(data);

            let image = this.image.submit_data;

            if (image) data.append('image', image);

            return data;
        }
    }
</script>
