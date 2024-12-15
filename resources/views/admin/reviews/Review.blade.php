<script>
    class Review extends BaseClass {
        no_set = [];

        before(form) {

        }

        after(form) {

        }

        get submit_data() {
            let data = {
                name: this.name,
                message: this.message,
            }

            return data;
        }
    }
</script>