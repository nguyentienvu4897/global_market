@include('admin.orders.OrderDetail')
<script>
    class Order extends BaseClass {
        no_set = [];

        before(form) {

        }

        after(form) {

        }

        // Ảnh đại diện
        // get image() {
        //     return this._image;
        // }
        //
        // set image(value) {
        //     this._image = new Image(value, this);
        // }

        set details(value) {
            this._details = (value || []).map(val => new OrderDetail(val, this));
        }

        get details() {
            return this._details;
        }

    }
</script>
