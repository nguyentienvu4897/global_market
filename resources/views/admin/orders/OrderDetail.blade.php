<script>
    class OrderDetail extends BaseClass {
        before(form) {

        }

        after(form) {

        }

        set attributes(value) {
            this._attributes = JSON.parse(value) || [];
        }

        get attributes() {
            return this._attributes;
        }

        get submit_data() {
            return {
                attributes: this.attributes,
            }
        }
    }
</script>
